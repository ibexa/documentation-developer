---
description: Export Repository data to use in future data migrations.
---

# Exporting data

To see an example of migrations in action, export data already present in your installation.

To export Repository content, use the `ibexa:migrations:generate` command.
This command generates a YAML file with the requested part of the Repository.
The file is located by default in the `src/Migrations/Ibexa/migrations` folder
or in [a custom folder that you configure](managing_migrations.md#migration-folders).
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

- Remove `references` if you don't intend to store IDs for future use (see [migration references](managing_migrations.md#references))
- Remove `publicationDate`, `modificationDate`, `locationRemoteId`,
  as those are generated if not passed (just like in PHP API)
- Add [`actions`](data_migration_actions.md)
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
    fields:
        -
            identifier: title
            type: ezstring
            position: 1
            translations:
                eng-GB:
                    name: Title
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

```

Note that you should test your migrations. See [Importing data](importing_data.md).

!!! tip

    Migration command can be executed with database rollback at the end with the `--dry-run` option.

## type

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
- `attribute_group`
- `attribute`
- `customer_group`
- `currency`

If you do not provide the `--type` option, the command asks you to select a type of data.

## mode

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
|`attribute_group`|&#10004;|&#10004;|&#10004;|
|`attribute`|&#10004;|&#10004;|&#10004;|
|`customer_group`|&#10004;|&#10004;|&#10004;|
|`currency`|&#10004;|&#10004;|&#10004;|

## match-property

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
- `user_group`
  - `id`
  - `remoteId`

You can extend the list of available matchers by creating [a custom one](add_data_migration_matcher.md).

## value

The optional `--value` option, together with `match-property`, filters the Repository content that the command exports.
`value` defines which values of the `match-property` should be included in the export.

For example, to export only Article Content items, use the `content_type_identifier` match property with `article` as the value:

``` bash
php bin/console ibexa:migrations:generate --type=content --mode=create --match-property=content_type_identifier --value=article
```

!!! note

    The same `match-property` and `value` is added to generated `update` and `delete` type migration files.

## file

The optional `--file` option defines the name of the YAML file to export to.

``` bash
php bin/console ibexa:migrations:generate --type=content --mode=create --file=my_data_export.yaml
```

!!! note

    When migrating multiple files at once (for example when calling `ibexa:migration:migrate` without options),
    they are executed in alphabetical order.

## user-context

The optional `--user-context` option enables you to run the export command as a specified User.
The command only exports Repository data that the selected User has access to.
By default the admin account is used, unless specifically overridden by this option or in
bundle configuration (`ibexa_migrations.default_user_login`).

``` bash
php bin/console ibexa:migrations:generate --type=content --mode=create --user-context=jessica_andaya
```
