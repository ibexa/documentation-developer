# Add data migration matcher

[Matchers in data migrations](exporting_and_importing_data.md#match-property) enable you to select which data from the Repository to export.

In addition to the built-in matchers, you can create custom matchers for content.

The following example create a matcher for Section identifiers.

## Create normalizer

To do this, first create a normalizer in `src/Migrations/Matcher/SectionIdentifierNormalizer.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Matcher/SectionIdentifierNormalizer.php') =]]
```

Register the normalizer as a service:

``` yaml
[[= include_file('code_samples/data_migration/config/custom_services.yaml', 10, 13) =]]
```

## Create generator

Next, you need a generator that enables using the matcher with the `ibexa:migrations:generate` command.
Create the generator in `src/Migrations/Matcher/SectionIdentifierGenerator.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Matcher/SectionIdentifierGenerator.php') =]]
```

Register the generator as a service:

``` yaml
[[= include_file('code_samples/data_migration/config/custom_services.yaml', 14, 17) =]]
```
