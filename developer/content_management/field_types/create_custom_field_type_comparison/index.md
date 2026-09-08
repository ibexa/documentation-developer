# Create custom field type comparison

Enable comparison of content fields based on a custom field type.

In the back office, you can compare the contents of fields. Comparing is possible only between two versions of the same field that are in the same language.

You can add the possibility to compare custom and other unsupported field types.

> **Note: Note**
>
> The following task uses the [custom "Hello World" field type](../create_custom_generic_field_type/index.md). The configuration is based on the comparison mechanism created for the `ibexa_string` field type.

## Create Comparable class

First, create a `Comparable.php` class in `src/FieldType/HelloWorld/Comparison`.

This class implements the `Ibexa\Contracts\VersionComparison\FieldType\Comparable` interface with the `getDataToCompare()` method:

```php
<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use Ibexa\Contracts\Core\FieldType\Value as SPIValue;
use Ibexa\Contracts\VersionComparison\FieldType\Comparable as ComparableInterface;
use Ibexa\Contracts\VersionComparison\FieldType\FieldTypeComparisonValue;
use Ibexa\VersionComparison\ComparisonValue\StringComparisonValue;

final class Comparable implements ComparableInterface
{
    public function getDataToCompare(SPIValue $value): FieldTypeComparisonValue
    {
        return new Value([
            'name' => new StringComparisonValue([
                'value' => $value->getName(),
            ]),
        ]);
    }
}
```

The `getDataToCompare()` fetches the data to compare and determines which [comparison engines](#create-comparison-engine) should be used.

Register this class as a service:

```yaml
services:
    App\FieldType\HelloWorld\Comparison\Comparable:
        tags:
            - { name: ibexa.field_type.comparable, alias: hello_world }
```

## Create comparison value

Next, create a `src/FieldType/HelloWorld/Comparison/Value.php` file that holds the comparison value:

```php
<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use Ibexa\Contracts\VersionComparison\FieldType\FieldTypeComparisonValue;

class Value extends FieldTypeComparisonValue
{
    /** @var \Ibexa\VersionComparison\ComparisonValue\StringComparisonValue */
    public \Ibexa\VersionComparison\ComparisonValue\StringComparisonValue $name;
}
```

## Create comparison engine

The comparison engine handles the operations required for comparing the contents of fields. Each field type requires a separate comparison engine, which implements the `Ibexa\Contracts\VersionComparison\Engine\FieldTypeComparisonEngine` interface.

For the "Hello World" field type, create the following comparison engine based on the engine for the TextLine field type. Place it in `src/FieldType/HelloWorld/Comparison/HelloWorldComparisonEngine.php`:

```php
<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use Ibexa\Contracts\VersionComparison\Engine\FieldTypeComparisonEngine;
use Ibexa\Contracts\VersionComparison\FieldType\FieldTypeComparisonValue;
use Ibexa\Contracts\VersionComparison\Result\ComparisonResult;

final readonly class HelloWorldComparisonEngine implements FieldTypeComparisonEngine
{
    public function __construct(private \Ibexa\VersionComparison\Engine\Value\StringComparisonEngine $stringValueComparisonEngine)
    {
    }

    /**
     * @param \App\FieldType\HelloWorld\Comparison\Value $comparisonDataA
     * @param \App\FieldType\HelloWorld\Comparison\Value $comparisonDataB
     */
    public function compareFieldsTypeValues(FieldTypeComparisonValue $comparisonDataA, FieldTypeComparisonValue $comparisonDataB): ComparisonResult
    {
        return new HelloWorldComparisonResult(
            $this->stringValueComparisonEngine->compareValues($comparisonDataA->name, $comparisonDataB->name)
        );
    }

    /**
     * @param \App\FieldType\HelloWorld\Comparison\Value $comparisonDataA
     * @param \App\FieldType\HelloWorld\Comparison\Value $comparisonDataB
     */
    public function shouldRunComparison(FieldTypeComparisonValue $comparisonDataA, FieldTypeComparisonValue $comparisonDataB): bool
    {
        return $comparisonDataA->name->value !== $comparisonDataB->name->value;
    }
}
```

Register the comparison engine as a service:

```yaml
services:
    App\FieldType\HelloWorld\Comparison\HelloWorldComparisonEngine:
        tags:
            - { name: ibexa.field_type.comparable.engine, supported_type: App\FieldType\HelloWorld\Comparison\Value }
```

## Add comparison result

Next, create a comparison result class in `src/FieldType/HelloWorld/Comparison/HelloWorldComparisonResult.php`.

```php
<?php

declare(strict_types=1);

namespace App\FieldType\HelloWorld\Comparison;

use Ibexa\Contracts\VersionComparison\Result\ComparisonResult;
use Ibexa\VersionComparison\Result\Value\StringComparisonResult;

final readonly class HelloWorldComparisonResult implements ComparisonResult
{
    public function __construct(private \Ibexa\VersionComparison\Result\Value\StringComparisonResult $stringDiff)
    {
    }

    public function getHelloWorldDiff(): StringComparisonResult
    {
        return $this->stringDiff;
    }

    public function isChanged(): bool
    {
        return $this->stringDiff->isChanged();
    }
}
```

## Provide templates

Finally, create a template for the new comparison view in `templates/themes/admin/field_types/field_type_comparison.html.twig`:

```html+twig
{% extends '@ibexadesign/version_comparison/comparison_result_blocks.html.twig' %}

{% block hello_world_field_comparison %}
    {% apply spaceless %}
        <span {{ block( 'field_attributes' ) }}>
            {% with {
                'comparison_result': comparison_result.getHelloWorldDiff()
                } %}
                {{ block('string_diff_render') }}
            {% endwith %}
        </span>
    {% endapply %}
{% endblock %}
```

Add configuration for this template under the `ibexa.system.<scope>.field_comparison_templates` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    system:
        default:
            field_comparison_templates:
                - { template: '@ibexadesign/field_types/field_type_comparison.html.twig', priority: 10 }
```
