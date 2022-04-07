# Importing data

To import data from YAML migration files into Repository, you run the `ibexa:migrations:migrate` command.

The `ibexa:migrations:import` command automatically places migration files in the correct folder.

Alternatively, you can place the files manually in the `src/Migrations/Ibexa/migrations` folder
or in [a custom folder that you configure](migration_management.md#migration-folders), 
and specify the file name within this folder as parameter.
If you do not specify the file, all files within this directory are used.

``` bash
php bin/console ibexa:migrations:migrate --file=my_data_export.yaml
```

Migrations store execution metadata in the `ibexa_migrations` database table. 
This allows incremental upgrades:
the `ibexa:migration:migrate` command ignores files that it had previously executed.

## Available migrations

The following modes are available for specific objects:

|                      | `create` | `update` | `delete` |
|----------------------|:--------:|:--------:|:--------:|
| `content`            | &#10004; | &#10004; | &#10004; |
| `content_type`       | &#10004; | &#10004; |          |
| `role`               | &#10004; | &#10004; | &#10004; |
| `content_type_group` | &#10004; | &#10004; |          |
| `user`               | &#10004; | &#10004; |          |
| `user_group`         | &#10004; |          | &#10004; |
| `language`           | &#10004; |          |          |
| `object_state_group` | &#10004; |          |          |
| `object_state`       | &#10004; |          |          |
| `section`            | &#10004; | &#10004; |          |
| `location`           |          | &#10004; |          |
| `attribute_group`    | &#10004; |          |          |
| `attribute`          | &#10004; | &#10004; | &#10004; |
| `customer_group`     | &#10004; | &#10004; | &#10004; |
| `currency`           | &#10004; | &#10004; | &#10004; |
| `product_price`      | &#10004; |          |          |
| `segment_group`      | &#10004; | &#10004; | &#10004; |
| `segment`            | &#10004; | &#10004; | &#10004; |


## Migration examples

The following examples show what data you can import using data migrations.

### Content Types

The following example shows how to create a Content Type with two Field definitions.

The required metadata keys are: `identifier`, `mainTranslation`, `contentTypeGroups` and `translations`.

``` yaml
[[= include_file('code_samples/data_migration/examples/create_blog_post_ct.yaml') =]]
```

### Content items

The following example shows how to create two Content items: a folder and an article inside it.

When creating a Content item, two metadata keys are required: `contentType` and `mainTranslation`,
as well as `parentLocationId`.

To use the Location ID of the folder, which is created automatically by the system,
you can use a [reference](migration_management.md#references).
In this case you assign the `parent_folder_location_id` reference name to the Location ID,
and then use it when creating the article.

``` yaml hl_lines="15 24"
[[= include_file('code_samples/data_migration/examples/create_parent_and_child_content.yaml') =]]
```

### Roles

The following example shows how to create a Role.
A Role requires the `identifier` metadata key.

For each Policy assigned to the Role, you select the module and function, with optional Limitations.

``` yaml
[[= include_file('code_samples/data_migration/examples/create_role.yaml') =]]
```

### Users

The following example shows how to create a user.

The required metadata keys are: `login`, `email`, `password`, `enabled`, `mainLanguage`, and `contentType`.
You also need to provide the user group's remote content ID.

You can use an [action](data_migration_actions.md) to assign a Role to the user.

``` yaml hl_lines="22-23"
[[= include_file('code_samples/data_migration/examples/create_user.yaml') =]]
```

### Language

The following example shows how to create a language.

The required metadata keys are: `languageCode`, `name`, and `enabled`.

``` yaml
[[= include_file('code_samples/data_migration/examples/create_language.yaml') =]]
```

### Product catalog

The following example shows how to create an attribute group with two attributes:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_attribute_group.yaml') =]]
```

You can also update attributes, including changing which attribute group they belong to:

``` yaml
[[= include_file('code_samples/data_migration/examples/update_attribute.yaml') =]]
```

You cannot change the attribute type of an existing attribute.

#### Product type

The following example shows how to create a product type.

The main part of the migration file is the same as when creating a regular Content Type.

A product type must also contain the definition for an `ibexa_product_specification` Field.
`fieldSettings` contains information about the product attributes.

``` yaml
[[= include_file('code_samples/data_migration/examples/create_product_type.yaml') =]]
```

#### Customer groups

The following example shows how to create a customer group with a defined global price discount:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_customer_group.yaml') =]]
```

#### Currencies

The following example shows how to create a currency:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_currency.yaml') =]]
```

#### Prices

The following example shows how to create a price for a product identified by its code:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_price.yaml') =]]
```

### Segments

The following example shows how to create a segment group and add segments in it:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_segment.yaml', 0, 17) =]]
```

When updating a segment group or segment, you can match the object to update by using its numerical ID or identifier:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_segment.yaml', 18, 24) =]]
```

## Criteria

When using `update` or `delete` modes, you can use criteria to identify the objects to operate on.

!!! caution

    Criteria only work with objects related to the product catalog.

``` yaml
type: currency
mode: update
criteria:
    type: field_value
    field: code
    value: EUR
    operator: '=' # default
code: EEE
subunits: 3
enabled: false
```

Available operators are:

- `=`
- `<>`
- `<`
- `<=`
- `>`
- `>=`
- `IN`
- `NIN`
- `CONTAINS`
- `STARTS_WITH`
- `ENDS_WITH`.

You can combine criteria by using logical criteria `and` and `or`:

``` yaml
type: or
criteria:
    -   type: field_value
        field: code
        value: EUR
    -   type: field_value
        field: code
        value: X
        operator: STARTS_WITH
```

Criteria can be nested.

