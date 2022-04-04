# Create data migration step

To create a migration step, you need:

- A step class, to store any additional data that you might require.
- A step denormalizer, to convert YAML definition into your step class.
- A step executor, to handle the step.

The following example shows how to create a step that replaces all fields of type "ezstring" with teapots.

First, create a step class, in `src/Migrations/Step/ImATeapotStep.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Step/ImATeapotStep.php') =]]
```

Then you need a denormalizer to convert data that comes from YAML into a step object,
in `src/Migrations/Step/ImATeapoStepNormalizer.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Step/ImATeapoStepNormalizer.php') =]]
```

Then, tag the step denormalizer, so it is recognized by the serializer used for migrations.

``` yaml
[[= include_file('code_samples/data_migration/config/custom_services.yaml', 19, 23) =]]
```

And finally, add an executor to perform the step, in `src/Migrations/Step/ImATeapotExecutor.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Step/ImATeapotExecutor.php') =]]
```

Tag the executor with `ibexa.migrations.step_executor` tag.

```yaml
[[= include_file('code_samples/data_migration/config/custom_services.yaml', 24, 27) =]]
```

Then you can create a migration file that will represent this step in your application:

```yaml
-   type: im_a
    mode: teapot
    replacement: '🫖 🫖 🫖' # as declared in normalizer, this is optional
```
