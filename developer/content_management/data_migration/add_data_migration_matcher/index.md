# Create data migration matcher

Create a matcher for handling data migrations.

[Matchers in data migrations](../exporting_data/index.md#match-property) enable you to select which data from the repository to export. In addition to the built-in matchers, you can create custom matchers for content.

The following example creates a matcher for section identifiers.

## Create normalizer

To do this, first add a normalizer which handles the conversion between objects and the YAML format used for data migration. Matchers are instances of `FilteringCriterion`, so a custom normalizer needs to denormalize into an instance of `FilteringCriterion`.

> **Tip: Normalizers**
>
> To learn more about normalizers, refer to [Symfony documentation](https://symfony.com/doc/7.4/serializer.html).

Create the normalizer in `src/Migrations/Matcher/SectionIdentifierNormalizer.php`:

```php
<?php declare(strict_types=1);

namespace App\Migrations\Matcher;

use Ibexa\Bundle\Migration\Serializer\Normalizer\Criterion\AbstractCriterionNormalizer;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Filter\FilteringCriterion;
use Webmozart\Assert\Assert;

class SectionIdentifierNormalizer extends AbstractCriterionNormalizer
{
    public function __construct()
    {
        parent::__construct('section_identifier');
    }

    /**
     * @param array<mixed> $data
     * @param array<mixed> $context
     */
    protected function createCriterion(array $data, string $type, ?string $format, array $context): FilteringCriterion
    {
        Assert::keyExists($data, 'value');

        return new Criterion\SectionIdentifier($data['value']);
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Criterion\SectionIdentifier;
    }
}
```

Register the normalizer as a service:

```yaml
    App\Migrations\Matcher\SectionIdentifierNormalizer:
        tags:
            - { name: 'ibexa.migrations.serializer.normalizer' }
```

> **Note: Normalizer order**
>
> User-defined normalizers are always executed before the built-in ones. However, you can additionally set the priority of your normalizers.
>
> Check the priorities of all normalization services by using:
>
> ```bash
> php bin/console debug:container --tag ibexa.migrations.serializer.normalizer
> ```

## Create generator

Additionally, if you want to export data using the `ibexa:migrations:generate` command, you need a generator. Create the generator in `src/Migrations/Matcher/SectionIdentifierGenerator.php`:

```php
<?php

declare(strict_types=1);

namespace App\Migrations\Matcher;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Migration\Generator\CriterionGenerator\GeneratorInterface;

final class SectionIdentifierGenerator implements GeneratorInterface
{
    public static function getMatchProperty(): string
    {
        return 'section_identifier';
    }

    public function generate($value): Criterion
    {
        return new Criterion\SectionIdentifier($value);
    }
}
```

Register the generator as a service:

```yaml
    App\Migrations\Matcher\SectionIdentifierGenerator:
        tags:
            - { name: 'ibexa.migrations.generator.criterion_generator.content' }
```
