---
description: Create a custom step for data migrations.
---

# Create data migration step

A data migration step is a single operation in data migration process
that combines a mode (for example: `create`, `update`, `delete`)
and a type (for example: `content`, `section`, `currency`),
with optional additional information depending on the specific step.

Besides the [built-in migrations steps](importing_data.md#available-migrations), you can also create custom ones.

To create a custom migration step, you need:

- A step class, to store any additional data that you might require.
- A step normalizer, to convert YAML definition into your step class.
- A step executor, to handle the step.

The following example shows how to create a step that replaces all `ezstring` Fields
that have an old company name with "New Company Name".

## Create step class

First, create a step class, in `src/Migrations/Step/ReplaceNameStep.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Step/ReplaceNameStep.php') =]]
```

## Create normalizer

Then you need a normalizer to convert data that comes from YAML into a step object,
in `src/Migrations/Step/ReplaceNameStepNormalizer.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Step/ReplaceNameStepNormalizer.php') =]]
```

Then, tag the step normalizer, so it is recognized by the serializer used for migrations.

``` yaml
[[= include_file('code_samples/data_migration/config/custom_services.yaml', 18, 23) =]]
```

## Create executor

And finally, create an executor to perform the step, in `src/Migrations/Step/ReplaceNameExecutor.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Step/ReplaceNameStepExecutor.php') =]]
```

Tag the executor with `ibexa.migrations.step_executor` tag.

```yaml
[[= include_file('code_samples/data_migration/config/custom_services.yaml', 23, 27) =]]
```

Then you can create a migration file that represents this step in your application:

```yaml
-   type: company_name
    mode: replace
    replacement: 'New Company Name' # as declared in normalizer, this is optional
```
