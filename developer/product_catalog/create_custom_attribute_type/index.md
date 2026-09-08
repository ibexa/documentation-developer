# Create custom attribute type

Enhance product catalog by creating a custom product attribute type to fit your specific needs.

Besides the [built-in attribute types](../products/index.md#product-attributes), you can also create custom ones.

The example below shows how to add a Percentage attribute type.

## Select attribute type class

First, you need to register the type class that the attribute uses:

```yaml
services:
    app.product_catalog.attribute_type.percent:
        class: Ibexa\ProductCatalog\Local\Repository\Attribute\AttributeType
        arguments:
            $identifier: 'percent'
        tags:
            -   name: ibexa.product_catalog.attribute_type
                alias: percent
```

Use the `ibexa.product_catalog.attribute_type` tag to indicate the use as a product attribute type. The custom attribute type has the identifier `percent`.

## Create value form mapper

A form mapper maps the data entered in an editing form into an attribute value.

The form mapper must implement `Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueFormMapperInterface`.

In this example, you can use the Symfony's built-in `PercentType` class (line 40).

```php
<?php

declare(strict_types=1);

namespace App\Attribute\Percent\Form;

use Ibexa\Bundle\ProductCatalog\Validator\Constraints\AttributeValue;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueFormMapperInterface;
use Ibexa\Contracts\ProductCatalog\Values\AttributeDefinitionAssignmentInterface;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class PercentValueFormMapper implements ValueFormMapperInterface
{
    public function createValueForm(
        string $name,
        FormBuilderInterface $builder,
        AttributeDefinitionAssignmentInterface $assignment,
        array $context = []
    ): void {
        $definition = $assignment->getAttributeDefinition();

        $options = [
            'disabled' => $context['translation_mode'] ?? false,
            'label' => $definition->getName(),
            'block_prefix' => 'percentage_attribute_value',
            'required' => $assignment->isRequired(),
            'constraints' => [
                new AttributeValue([
                    'definition' => $definition,
                ]),
            ],
        ];

        if ($assignment->isRequired()) {
            $options['constraints'][] = new Assert\NotBlank();
        }

        $builder->add($name, PercentType::class, $options);
    }
}
```

The `options` array contains additional options for the form, including options resulting from the selected form type.

Register the form mapper as a service and tag it with `ibexa.product_catalog.attribute.form_mapper.value`:

```yaml
    App\Attribute\Percent\Form\PercentValueFormMapper:
        tags:
            -   name: ibexa.product_catalog.attribute.form_mapper.value
                type: percent
```

## Create value formatter

A value formatter prepares the attribute value for rendering in the proper format.

In this example, you can use the `NumberFormatter` to ensure the number is rendered in the percentage form (line 22).

```php
<?php

declare(strict_types=1);

namespace App\Attribute\Percent;

use Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueFormatterInterface;
use Ibexa\Contracts\ProductCatalog\Values\AttributeInterface;
use NumberFormatter;

final class PercentValueFormatter implements ValueFormatterInterface
{
    public function formatValue(AttributeInterface $attribute, array $parameters = []): ?string
    {
        $value = $attribute->getValue();
        if ($value === null) {
            return null;
        }

        $formatter = $parameters['formatter'] ?? null;
        if ($formatter === null) {
            $formatter = new NumberFormatter('', NumberFormatter::PERCENT);
        }

        return $formatter->format($value);
    }
}
```

Register the value formatter as a service and tag it with `ibexa.product_catalog.attribute.formatter.value`:

```yaml
    App\Attribute\Percent\PercentValueFormatter:
        tags:
            -   name: ibexa.product_catalog.attribute.formatter.value
                type: percent
```

## Add attribute options

You can also add options specific for the attribute type that the user selects when creating an attribute.

In this example, you can set the minimum and maximum allowed percentage.

### Options type

First, create `PercentAttributeOptionsType` that defines two options, `min` and `max`. Both those options need to be of `PercentType`.

```php
<?php

declare(strict_types=1);

namespace App\Attribute\Percent;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PercentAttributeOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('min', PercentType::class, [
            'disabled' => $options['translation_mode'],
            'label' => 'Minimum Value',
            'required' => false,
        ]);

        $builder->add('max', PercentType::class, [
            'disabled' => $options['translation_mode'],
            'label' => 'Maximum Value',
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_mode' => false,
        ]);
        $resolver->setAllowedTypes('translation_mode', 'bool');
    }
}
```

### Options form mapper

Next, create a `PercentOptionsFormMapper` that maps the information that the user inputs in the form into attribute definition.

```php
<?php

declare(strict_types=1);

namespace App\Attribute\Percent;

use Ibexa\Bundle\ProductCatalog\Validator\Constraints\AttributeDefinitionOptions;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsFormMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class PercentOptionsFormMapper implements OptionsFormMapperInterface
{
    public function createOptionsForm(string $name, FormBuilderInterface $builder, array $context = []): void
    {
        $builder->add($name, PercentAttributeOptionsType::class, [
            'constraints' => [
                new AttributeDefinitionOptions(['type' => $context['type']]),
            ],
            'translation_mode' => $context['translation_mode'],
        ]);
    }
}
```

Register the options form mapper as a service and tag it with `ibexa.product_catalog.attribute.form_mapper.options`:

```yaml
    app.product_catalog.attribute.percent.form_mapper.options:
        class: App\Attribute\Percent\PercentOptionsFormMapper
        tags:
            -   name: ibexa.product_catalog.attribute.form_mapper.options
                type: percent
```

### Options validator

Create a `PercentOptionsValidator` that implements `Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsValidatorInterface`. It validates the options that the user sets while creating the attribute definition.

In this example, the validator verifies whether the minimum percentage is lower than the maximum.

```php
<?php

declare(strict_types=1);

namespace App\Attribute\Percent;

use Ibexa\Contracts\Core\Options\OptionsBag;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsValidatorError;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsValidatorInterface;

final class PercentOptionsValidator implements OptionsValidatorInterface
{
    public function validateOptions(OptionsBag $options): array
    {
        $min = $options->get('min');
        $max = $options->get('max');

        if ($min !== null && $max !== null && $min > $max) {
            return [
                new OptionsValidatorError('[max]', 'Maximum value should be greater than minimum value'),
            ];
        }

        return [];
    }
}
```

Register the options validator as a service and tag it with `ibexa.product_catalog.attribute.validator.options`:

```yaml
    app.product_catalog.attribute.options_validator.percent:
        class: App\Attribute\Percent\PercentOptionsValidator
        tags:
            -   name: ibexa.product_catalog.attribute.validator.options
                type: percent
```

### Value validator

Finally, make sure the data provided by the user is validated. To do that, create `PercentValueValidator` that checks the values against `min` and `max` and dispatches an error when needed.

```php
<?php

declare(strict_types=1);

namespace App\Attribute\Percent;

use Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueValidationError;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueValidatorInterface;
use Ibexa\Contracts\ProductCatalog\Values\AttributeDefinitionInterface;

final class PercentValueValidator implements ValueValidatorInterface
{
    public function validateValue(AttributeDefinitionInterface $attributeDefinition, $value): iterable
    {
        if ($value === null) {
            return [];
        }

        $errors = [];
        $options = $attributeDefinition->getOptions();

        $min = $options->get('min');
        if ($min !== null && $value < $min) {
            $errors[] = new ValueValidationError(null, 'Percentage should be greater or equal to %min%', [
                '%min%' => $min,
            ]);
        }

        $max = $options->get('max');
        if ($max !== null && $value > $max) {
            $errors[] = new ValueValidationError(null, 'Percentage should be lesser or equal to %max%', [
                '%max%' => $max,
            ]);
        }

        return $errors;
    }
}
```

Register the validator as a service and tag it with `ibexa.product_catalog.attribute.validator.value`:

```yaml
    app.product_catalog.attribute.value_validator.percent:
        class: App\Attribute\Percent\PercentValueValidator
        tags:
            -   name: ibexa.product_catalog.attribute.validator.value
                type: percent
```

## Storage

To ensure that values of the new attributes are stored correctly, you need to provide a storage converter and storage definition services.

### Database schema design

The values are going to be stored within a table named `app_product_specification_attribute_percent`, in a column named `value`.

**MySQL**

```sql
CREATE TABLE app_product_specification_attribute_percent (
    id INT NOT NULL,
    value DOUBLE PRECISION DEFAULT NULL,
    INDEX app_product_specification_attribute_percent_value_idx (value),
    PRIMARY KEY (id)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_520_ci` ENGINE = InnoDB;
```

**PostgreSQL**

```sql
CREATE TABLE app_product_specification_attribute_percent (id INT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id));
CREATE INDEX app_product_specification_attribute_percent_value_idx ON app_product_specification_attribute_percent (value);
ALTER TABLE app_product_specification_attribute_percent ADD CONSTRAINT app_product_specification_attribute_percent_fk FOREIGN KEY (id) REFERENCES ibexa_product_specification_attribute (id) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
```

### Storage converter

Start by creating a `PercentStorageConverter` class, which implements `Ibexa\Contracts\ProductCatalog\Local\Attribute\StorageConverterInterface`. This converter is responsible for converting database results into an attribute type instance:

```php
<?php

declare(strict_types=1);

namespace App\Attribute\Percent\Storage;

use Ibexa\Contracts\ProductCatalog\Local\Attribute\StorageConverterInterface;
use Webmozart\Assert\Assert;

final class PercentStorageConverter implements StorageConverterInterface
{
    public function fromPersistence(array $data)
    {
        $value = $data['value'];
        Assert::nullOrNumeric($value);

        return $value;
    }

    public function toPersistence($value): array
    {
        Assert::nullOrNumeric($value);

        return [
            'value' => $value,
        ];
    }
}
```

Register the converter as a service and tag it with `ibexa.product_catalog.attribute.storage_converter`:

```yaml
    App\Attribute\Percent\Storage\PercentStorageConverter:
        tags:
            - { name: 'ibexa.product_catalog.attribute.storage_converter', type: 'percent' }
```

### Storage definition

You can either create a new storage definition or use an existing one.

To create a new storage definition, prepare a `PercentStorageDefinition` class, which implements `Ibexa\Contracts\ProductCatalog\Local\Attribute\StorageDefinitionInterface`.

```php
<?php declare(strict_types=1);

namespace App\Attribute\Percent\Storage;

use Doctrine\DBAL\Types\Types;
use Ibexa\Contracts\ProductCatalog\Local\Attribute\StorageDefinitionInterface;

final class PercentStorageDefinition implements StorageDefinitionInterface
{
    public function getColumns(): array
    {
        return [
            'value' => Types::FLOAT,
        ];
    }

    public function getTableName(): string
    {
        return 'app_product_specification_attribute_percent';
    }
}
```

Register the storage definition as a service and tag it with `ibexa.product_catalog.attribute.storage_definition`:

```yaml
    App\Attribute\Percent\Storage\PercentStorageDefinition:
        tags:
            - { name: 'ibexa.product_catalog.attribute.storage_definition', type: 'percent' }
```

If you prefer to use an existing storage definition, you need to create a Storage Definition Tag CompilerPass `src/DependencyInjection/AddFloatStorageDefinitionTag.php`:

```php
<?php
/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\DependencyInjection;

use Ibexa\ProductCatalog\Local\Persistence\Legacy\Attribute\Float\StorageDefinition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AddFloatStorageDefinitionTag implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $container->getDefinition(StorageDefinition::class)
            ->addTag('ibexa.product_catalog.attribute.storage_definition', ['type' => 'percent']);
    }
}
```

Add the CompilerPass to the container. Do it in a `src/Kernel.php` file or in your Bundle class:

```php
<?php declare(strict_types=1);

namespace App;

use App\DependencyInjection\AddFloatStorageDefinitionTag;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new AddFloatStorageDefinitionTag());
    }
}
```

## Use new attribute type

In the back office you can now add a new Percent attribute to your product type and create a product with it.

![Creating a product with a custom Percent attribute](https://doc.ibexa.co/en/5.0/product_catalog/img/catalog_custom_attribute_type.png)
