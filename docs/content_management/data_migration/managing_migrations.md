---
description: Manage data migrations by adding files, converting from Kaliop migration bundle, checking migration status, and setting up configuration.
month_change: false
---

# Managing migrations

## Converting migration files

If you want to convert a file from the format used by the [Kaliop migration bundle](https://github.com/kaliop-uk/ezmigrationbundle) to the current migration format, use the `ibexa:migrations:kaliop:convert` command.

The source file must use Kaliop mode and type combinations.
The converter handles Kaliop types that are different from [[= product_name_base =]] types.

``` bash
php bin/console ibexa:migrations:kaliop:convert --input=kaliop_format.yaml --output=ibexa_format.yaml
```

You can also convert multiple files using `ibexa:migrations:kaliop:bulk-convert`:

``` bash
php bin/console ibexa:migrations:kaliop:bulk-convert --recursive kaliop_files ibexa_files
```

If you don't specify the output folder, the command overwrites the input files.

## Adding migration files

Use the `ibexa:migrations:import` command to add files to the migration folder defined in configuration (by default, `src/Migrations/Ibexa/migrations`).

``` bash
php bin/console ibexa:migrations:import my_data_export.yaml
```

## Checking migration status

To check the status of migration files in the migration folder defined in configuration, run the following command:

``` bash
php bin/console ibexa:migrations:status
```

The command lists the migration files and indicates which of them have already been migrated.

## Migration folders

The default migration folder is `src/Migrations/Ibexa/migrations`.

You can configure a different folder by using the following settings:

``` yaml
ibexa_migrations:
    migration_directory: %kernel.project_dir%/src/Migrations/MyMigrations/
    migrations_files_subdir: migration_files
```

!!! note "Multi-repository scenario"

    In multi-repository environments, where data for different websites is stored in separate databases, you can migrate such databases separately, to prevent the migration processes from affecting each other.

    The `ibexa_migrations.migration_directory` setting accepts a placeholder within a path.
    The placeholder is dynamically replaced by a name of the repository that you want to migrate, based on the selected SiteAccess.

    ``` yaml
    ibexa_migrations:
        migration_directory: '%kernel.project_dir%/data/<repository>'
        ...
    ```

    Then, when you run the migration command, you must use the [`--siteaccess` option](exporting_data.md#siteaccess) and provide the name of the SiteAccess that you want to migrate.

## Preview configuration

You can get default configuration along with option descriptions by executing the following command:

```bash
bin/console config:dump-reference ibexa_migrations
```

## References

References are key-value pairs necessary when one migration depends on another.

Since some migrations generate object properties (like IDs) during their execution, which cannot be known in advance, references provide migrations with the ability to use previously created object properties in further migrations.
They can be subsequently used by passing them in their desired place with `reference:` prefix.

The example below creates a content item of type "folder", and stores its location path as `"ref_path__folder__media"`.
Then this reference is reused as part of a new role, as a limitation.

```yaml
-
    type: content
    mode: create
    metadata:
        contentType: folder
        mainTranslation: eng-US
        alwaysAvailable: true
        section: 3
        objectStates: {  }
    location:
        parentLocationId: 1
        hidden: false
        sortField: !php/const Ibexa\Contracts\Core\Repository\Values\Content\Location::SORT_FIELD_NAME
        sortOrder: 1
        priority: 0
    fields:
        -
            fieldDefIdentifier: name
            languageCode: eng-US
            value: Media
        # - ...
    actions: {  }
    references:
        -
            name: ref__content__folder__media
            type: content_id
        -
            name: ref_location__folder__media
            type: location_id
        -
            name: ref_path__folder__media
            type: path

-
    type: role
    mode: create
    metadata:
        identifier: foo
    policies:
        -
            module: content
            function: 'read'
            limitations:
                -
                    identifier: Subtree
                    values: ['reference:ref_path__folder__media']

```

By default, reference files are located in a separate directory `src/Migrations/Ibexa/references` (for more information, see [previewing reference](#preview-configuration) `ibexa_migrations.migration_directory` and `ibexa_migrations.references_files_subdir` options).

Reference files are **NOT** loaded by default. A separate step (type: "reference", mode: "load", with filename as "value") is required.
Similarly, saving a reference file is done using type: "reference", mode: "save" step, with filename.

For example:

```yaml
-
    type: reference
    mode: load
    filename: 'references.yaml'

-
    type: reference
    mode: save
    # You can also use 'references.yaml', in this case it's overridden
    filename: 'new_references.yaml'
```

!!! note

    You don't need to save references if they're used in the same migration file.
    References are stored in memory during migration, whether they're used or not.

## Available reference types

- `content`
    - content_id
    - location_id
    - path
- `content_type`
    - content_type_id
- `language`
    - language_id
- `role`
    - role_id
- `user_group`
    - user_group_id
