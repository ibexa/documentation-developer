# Data migration

You can use migrations in projects that require the same data to be present across multiple instances.
They can be useful for project templates. Migrations are able to store shared data, so they can be applied for each new project you start,
or incrementally upgrade older projects to your new standard, if needed.
They are a developer-friendly tool that allows you to share data without writing code.


You can migrate your Repository data, that is Content items, as well as Content Types, languages, Object states, Sections, etc.,
between installations by using the migration command.

!!! tip "Public PHP API"

    You can also manage data migrations with the PHP API, see [Managing migrations](../api/public_php_api_managing_migrations.md).

!!! caution "Do not enable EzMigrationBundle2"

    If you are migrating your data either with [`kaliop-uk/ezmigrationbundle`](https://github.com/kaliop-uk/ezmigrationbundle) or [`ezsystems/ezmigrationbundle`](https://github.com/ezsystems/EzMigrationBundle), do not install the [`tanoconsulting/ezmigrationbundle2`](https://github.com/tanoconsulting/ezmigrationbundle2) package, or your application will stop working due to multiple duplicated classes.
    
    As of v3.3.3, the `ezmigrationbundle` package has been removed to mitigate this issue. 
    It is recommended that you use the default `ibexa/migrations` package to migrate your data.    

## Exporting data

To see an example of migrations in action, export data already present in your installation.

To export Repository content, use the `ibexa:migrations:generate` command.
This command generates a YAML file with the requested part of the Repository.
The file is located by default in the `src/Migrations/Ibexa/migrations` folder
or in [a custom folder that you configure](#migration-folders).
You can later use this file to import the data.

``` bash
php bin/console ibexa:migrations:generate --type=content --mode=create
```

This generates a file containing all Content items.
Below you can see part of the output of the default Ibexa DXP installation.

``` yaml
-
    type: content
    mode: create
    metadata:
        contentType: user_group
        mainTranslation: eng-GB
        creatorId: 14
        modificationDate: '2002-10-06T17:19:56+02:00'
        publicationDate: '2002-10-06T17:19:56+02:00'
        remoteId: f5c88a2209584891056f987fd965b0ba
        alwaysAvailable: true
        section:
            id: 2
            identifier: users
    location:
        parentLocationId: 1
        parentLocationRemoteId: null
        locationRemoteId: 3f6d92f8044aed134f32153517850f5a
        hidden: false
        sortField: 1
        sortOrder: 1
        priority: 0
    fields:
        -
            fieldDefIdentifier: name
            languageCode: eng-GB
            value: Users
        -
            fieldDefIdentifier: description
            languageCode: eng-GB
            value: 'Main group'
    references:
        -
            name: ref__content__user_group__users
            type: content_id
        -
            name: ref_location__user_group__users
            type: location_id
        -
            name: ref_path__user_group__users
            type: path
```

The output contains all the possible information for a future migration command.
Parts of it can be removed or modified.
You can treat it as a template for another Content item for user group.
For example, you could:

- Remove `references` if you don't intend to store IDs for future use (see [migration references](#references))
- Remove `publicationDate`, `modificationDate`, `locationRemoteId`,
  as those are generated if not passed (just like in PHP API)
- Add [`actions`](#actions)
- Add fields for other languages present in the system.

Similarly, you can create update and delete operations.
They are particularly useful combined with `match-property`.
This option is automatically added as part of `match` expression in the update/delete migration:

``` bash
php bin/console ibexa:migrations:generate --type=content_type --mode=update --match-property=content_type_identifier --value=article
```

```yaml
-
    type: content_type
    mode: update
    match:
        field: content_type_identifier
        value: article
    metadata:
        identifier: article
        mainTranslation: eng-GB
        modifierId: 14
        modificationDate: '2012-07-24T14:35:34+00:00'
        remoteId: c15b600eb9198b1924063b5a68758232
        urlAliasSchema: ''
        nameSchema: '<short_title|title>'
        container: true
        defaultAlwaysAvailable: false
        defaultSortField: 1
        defaultSortOrder: 1
        translations:
            eng-GB:
                name: Article
                description: ''
    fields:
        -
            identifier: title
            type: ezstring
            position: 1
            translations:
                eng-GB:
                    name: Title
                    description: ''
            required: true
            searchable: true
            infoCollector: false
            translatable: true
            category: ''
            defaultValue: 'New article'
            fieldSettings: {  }
            validatorConfiguration:
                StringLengthValidator:
                    maxStringLength: 255
                    minStringLength: null
        # - ...
    actions: {  }

```

Note that you should test your migrations. See [migrating data](#executing-migrations).

!!! tip

    Migration command can be executed with database rollback at the end with the `--dry-run` option.

### type

The mandatory `--type` option defines the type of Repository data to export.
The following types are available:

- `content`
- `content_type`
- `role`
- `content_type_group`
- `user`
- `user_group`
- `language`
- `object_state_group`
- `object_state`
- `section`
- `location`

If you do not provide the `--type` option, the command asks you to select a type of data.

### mode

The mandatory `--mode` option defines the action that importing the file performs.
The following modes are available:

- `create` - creates new items
- `update` - updates an existing item. Only covers specified fields and properties. If the item does not exist, causes an error.
- `delete` - deletes an existing item. If the item does not exist, causes an error.

If you do not provide the `--mode` option, the command asks you to select the mode.

The following combinations of types are modes are available:

||`create`|`update`|`delete`|
|---|:---:|:---:|:---:|
|`content`|&#10004;|&#10004;|&#10004;|
|`content_type`|&#10004;|&#10004;||
|`role`|&#10004;|&#10004;|&#10004;|
|`content_type_group`|&#10004;|&#10004;||
|`user`|&#10004;|&#10004;||
|`user_group`|&#10004;||&#10004;|
|`language`|&#10004;|||
|`object_state_group`|&#10004;|||
|`object_state`|&#10004;|||
|`section`|&#10004;|&#10004;||
|`location`||&#10004;||

### match-property

The optional `--match-property` option, together with `value`, enables you to select which data from the Repository to export.
`match-property` defines what property should be used as a criterion for selecting data.
The following properties are available (per type):

- `content`
    - `content_id`
    - `content_type_id`
    - `content_type_group_id`
    - `content_type_identifier`
    - `content_remote_id`
    - `location_id`
    - `location_remote_id`
    - `parent_location_id`
    - `user_id`
- `content_type`
    - `content_type_identifier`
- `content_type_group`
    - `content_type_group_id`
    - `content_type_group_identifier`
- `language`
    - `language_code`
- `location`
    - `location_remote_id`
    - `location_id`
- `object_state`
    - `object_state_id`
    - `object_state_identifier`
- `object_state_group`
    - `object_state_group_id`
    - `object_state_group_identifier`
- `role`
    - `identifier`
    - `id`
- `section`
    - `section_id`
    - `section_identifier`
- `user`
    - `login`
    - `email`

You can extend the list of available matchers by creating [a custom one]().

### value

The optional `--value` option, together with `match-property`, filters the Repository content that the command exports.
`value` defines which values of the `match-property` should be included in the export.

For example, to export only Article Content items, use the `content_type_identifier` match property with `article` as the value:

``` bash
php bin/console ibexa:migrations:generate --type=content --mode=create --match-property=content_type_identifier --value=article
```

!!! note

    The same `match-property` and `value` is added to generated `update` and `delete` type migration files.

### file

The optional `--file` option defines the name of the YAML file to export to.

``` bash
php bin/console ibexa:migrations:generate --type=content --mode=create --file=my_data_export.yaml
```

!!! note

    When migrating multiple files at once (for example when calling `ibexa:migration:migrate` without options),
    they are executed in alphabetical order.

### user-context

The optional `--user-context` option enables you to run the export command as a specified User.
The command only exports Repository data that the selected User has access to.
By default the admin account is used, unless specifically overridden by this option or in
[bundle configuration](#configuration-reference) (`ibexa_migrations.default_user_login`).

``` bash
php bin/console ibexa:migrations:generate --type=content --mode=create --user-context=jessica_andaya
```

## Executing migrations

To import Repository data from YAML files, run the `ibexa:migrations:migrate` command.

Place your import file in the `src/Migrations/Ibexa/migrations` folder
or in [a custom folder that you configure](#migration-folders).
The command takes the file name within this folder as parameter.
If file is not specified, all files within this directory are used.

``` bash
php bin/console ibexa:migrations:migrate --file=my_data_export.yaml
```

Ibexa Migrations store execution metadata in `ibexa_migrations` database table. This allows incremental upgrades:
the `ibexa:migration:migrate` command ignores files that it had previously executed.

## Converting migration files

If you want to convert a file from the format used by the
[Kaliop migration bundle](https://github.com/kaliop-uk/ezmigrationbundle)
to the current migration format, use the `ibexa:migrations:kaliop:convert` command.

The source file must use Kaliop mode and type combinations.
The converter handles Kaliop types that are different from Ibexa types.

``` bash
php bin/console ibexa:migrations:kaliop:convert --input=kaliop_format.yaml --output=ibexa_format.yaml
```

You can also convert multiple files using `ibexa:migrations:kaliop:bulk-convert`:

``` bash
php bin/console ibexa:migrations:kaliop:bulk-convert --recursive --input-directory=kaliop_files --output-directory=ibexa_files
```

If you do not specify the output folder, the command overwrites the input files.

## Adding migration files

Use the `ibexa:migrations:import` command to add files to the migration folder defined in configuration
(by default, `src/Migrations/Ibexa/migrations`).

``` bash
php bin/console ibexa:migrations:import my_data_export.yaml
```

## Checking migration status

To check the status of migration files in the migration folder defined in configuration,
run the following command:

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

## Actions

Some migration steps can contain a special `actions` property.
You can find which migration steps support actions in the table below:

||`create`|`update`|`delete`|
|---|:---:|:---:|:---:|
|`content`|&#10004;|&#10004;|&#10004;|
|`content_type`|&#10004;|&#10004;|&#10004;|
|`role`|&#10004;|&#10004;||
|`user`|&#10004;|&#10004;||
|`user_group`|&#10004;|||

Actions are optional operations that can be run after the main "body" of a migration has been executed
(that is, content has been created / updated, Object state has been added, and so on).
Their purpose is to allow additional operations to be performed as part of this particular migration.
They are executed inside the same transaction, so in the event of failure they cause database rollback to occur.

For example, when updating a Content Type object, some fields might be removed:
``` yaml
-
    type: content_type
    mode: update
    match:
        field: content_type_identifier
        value: article
    actions:
        - { action: assign_content_type_group, value: 'Media' }
        - { action: unassign_content_type_group, value: 'Content' }
        - { action: remove_field_by_identifier, value: 'short_title' }
        - { action: remove_drafts, value: null }
```

When executed, this migration:

- Finds Content Type using its identifier (`article`)
- Assigns Content Type Group "Media"
- Removes it from Content Type Group "Content"
- Removes the `short_title` Field
- Removes its existing drafts, if any.

### Available migration actions

The following migration actions are available out of the box:

- `assign_object_state` (Content Create)
- `assign_parent_location` (Content Create / Update)
- `assign_content_type_group` (Content Type Create / Update)
- `remove_drafts` (Content Type Update)
- `remove_field_by_identifier` (Content Type Update)
- `unassign_content_type_group` (Content Type Update)
- `assign_role_to_user` (Role Create / Update)
- `assign_role_to_user_group` (Role Create / Update)
- `assign_user_to_role` (User Create / Update)
- `assign_user_group_to_role` (User Group Create / Update)

In contrast with Kaliop migrations, actions provide you with ability to perform additional operations and extend
the migration functionality. 
See [creating your own Actions](#creating-your-own-actions).

## References

References are key-value pairs necessary when one migration depends on another.

Since some migrations generate object properties (like IDs) during their execution, which cannot be known in advance,
references provide migrations with the ability to use previously created object properties in further migrations.
They can be subsequently used by passing them in their desired place with `reference:` prefix.

The example below creates a Content item of type "folder", and stores its Location path as `"ref_path__folder__media"`.
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
        sortField: !php/const eZ\Publish\API\Repository\Values\Content\Location::SORT_FIELD_NAME
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

By default, reference files are located in a separate directory `src/Migrations/Ibexa/references`
(see [configuration reference](#configuration-reference)
`ibexa_migrations.migration_directory` and `ibexa_migrations.references_files_subdir` options).

Reference files are **NOT** loaded by default. A separate step (type: "reference", mode: "load", with filename as "value")
is required. Similarly, saving a reference file is done using type: "reference", mode: "save" step, with filename.

For example:
```yaml
-
    type: reference
    mode: load
    filename: 'references.yaml'

-
    type: reference
    mode: save
    # You can also use 'references.yaml', in this case it is overridden
    filename: 'new_references.yaml'
```

!!! note

    You don't need to save references if they are used in the same migration file.
    References are stored in memory during migration, whether they are used or not.

## Customizing migrations

### Creating your own actions

To create an action, you need:

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

## Configuration reference

You can get default configuration along with option descriptions by executing the following command:

```bash
bin/console config:dump-reference ibexa_migrations
```
