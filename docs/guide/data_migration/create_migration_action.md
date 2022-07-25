---
description: Create a custom action to use while performing data migration.
---

# Create data migration action

To create an [action](data_migration_actions.md) that is performed after a migration step, you need:

- An action class, to store any additional data that you might require.
- An action denormalizer, to convert YAML definition into your action class.
- An action executor, to handle the action.

The following example shows how to create an action that assigns a Content item to a Section.

First, create an action class, in `src/Migrations/Action/AssignSection.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Action/AssignSection.php') =]]
```

Then you need a denormalizer to convert data that comes from YAML into an action object,
in `src/Migrations/Action/AssignSectionDenormalizer.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Action/AssignSectionDenormalizer.php') =]]
```

Then, tag the action denormalizer so it is recognized by the serializer used for migrations.

``` yaml
[[= include_file('code_samples/data_migration/config/custom_services.yaml', 0, 5) =]]
```

And finally, add an executor to perform the action, in `src/Migrations/Action/AssignSectionExecutor.php`:

``` php
[[= include_file('code_samples/data_migration/src/Migrations/Action/AssignSectionExecutor.php') =]]
```

Tag the executor with `ibexa.migrations.executor.action.<type>` tag, where `<type>` is the "type" of the step
that executor works with (`content`, `content_type`, `location`, and so on).
The tag has to have a `key` property with the action type.

```yaml
[[= include_file('code_samples/data_migration/config/custom_services.yaml', 6, 9) =]]
```
