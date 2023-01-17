---
description: Create a matcher for handling data migrations.
---

# Create data migration matcher

[Matchers in data migrations](exporting_data.md#match-property) enable you to select which data from the Repository to export.

In addition to the built-in matchers, you can create custom matchers for content.

The following example creates a matcher for Section identifiers.

## Create normalizer

To do this, first add a normalizer which handles the conversion between objects and the YAML format used for data migration.

Matchers are instances of `FilteringCriterion`, so a custom normalizer needs to denormalize into an instance of `FilteringCriterion`.

!!! tip "Normalizers"

    To learn more about normalizers, refer to [Symfony documentation]([[= symfony_doc =]]/components/serializer.html).

Create the normalizer in `src/Migrations/Matcher/SectionIdentifierNormalizer.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Matcher/SectionIdentifierNormalizer.php') =]]
```

Register the normalizer as a service:

``` yaml
[[= include_file('code_samples/data_migration/config/custom_services.yaml', 10, 13) =]]
```

!!! note "Normalizer order"

    User-defined normalizers are always executed before the built-in ones.
    However, you can additionally set the priority of your normalizers.

    Check the priorities of all normalization services by using:

    ``` bash
    php bin/console debug:container --tag ibexa.migrations.serializer.normalizer
    ```

## Create generator

Additionally, if you want to export data using the `ibexa:migrations:generate` command, you need a generator.
Create the generator in `src/Migrations/Matcher/SectionIdentifierGenerator.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Matcher/SectionIdentifierGenerator.php') =]]
```

Register the generator as a service:

``` yaml
[[= include_file('code_samples/data_migration/config/custom_services.yaml', 14, 17) =]]
```
