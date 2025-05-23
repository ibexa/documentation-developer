---
description: Import data into your repository from prepared YAML files.
page_type: reference
month_change: false
---

# Importing data

To import data from YAML migration files into repository, you run the `ibexa:migrations:migrate` command.

The `ibexa:migrations:import` command automatically places migration files in the correct folder.

Alternatively, you can place the files manually in the `src/Migrations/Ibexa/migrations` folder or in [a custom folder that you configure](managing_migrations.md#migration-folders), and specify the file name within this folder as parameter.
If you don't specify the file, all files within this directory are used.

``` bash
php bin/console ibexa:migrations:migrate --file=my_data_export.yaml --siteaccess=admin
```

Migrations store execution metadata in the `ibexa_migrations` database table.
This allows incremental upgrades: the `ibexa:migrations:migrate` command ignores files that it had previously executed.

The [`--siteaccess` option](exporting_data.md#siteaccess) usage can be relevant when multiple languages or multiple repositories are used.

## Migration step

A data migration step is a single operation in data migration process that combines a mode (for example: `create`, `update`, `delete`)
and a type (for example: `content`, `section`, `currency`), with optional additional information depending on the specific step.

In a migration file, a step is an array item starting with the mandatory properties `type` and `mode`, for example:

```yaml
-
    type: content
    mode: create
```

Then, the step is described by additional properties depending on its type and mode.

* See [Available migrations](#available-migrations) for the modes available for each type.
* See [Migration examples](#migration-examples) to explore what you can do with each type.
* For a custom migration step, see [Create data migration step](create_data_migration_step.md).

## Available migrations

The following data migration step modes are available:

| `type`                 | `create` | `update` | `delete` | `swap`   |
|------------------------|:--------:|:--------:|:--------:|:--------:|
| `action_configuration` | &#10004; | &#10004; | &#10004; |          |
| `attribute`            | &#10004; | &#10004; | &#10004; |          |
| `attribute_group`      | &#10004; | &#10004; | &#10004; |          |
| `content_type`         | &#10004; | &#10004; | &#10004; |          |
| `content_type_group`   | &#10004; | &#10004; | &#10004; |          |
| `content`              | &#10004; | &#10004; | &#10004; |          |
| `currency`             | &#10004; | &#10004; | &#10004; |          |
| `customer_group`       | &#10004; | &#10004; | &#10004; |          |
| `language`             | &#10004; |          |          |          |
| `location`             |          | &#10004; |          | &#10004; |
| `object_state`         | &#10004; |          |          |          |
| `object_state_group`   | &#10004; |          |          |          |
| `payment_method`       | &#10004; |          |          |          |
| `product_asset`        | &#10004; |          |          |          |
| `product_availability` | &#10004; |          |          |          |
| `product_price`        | &#10004; |          |          |          |
| `product_variant`      | &#10004; |          |          |          |
| `role`                 | &#10004; | &#10004; | &#10004; |          |
| `section`              | &#10004; | &#10004; |          |          |
| `segment`              | &#10004; | &#10004; | &#10004; |          |
| `segment_group`        | &#10004; | &#10004; | &#10004; |          |
| `setting`              | &#10004; | &#10004; | &#10004; |          |
| `user`                 | &#10004; | &#10004; |          |          |
| `user_group`           | &#10004; | &#10004; | &#10004; |          |

### Repeatable steps

You can run a set of one or more similar migration steps multiple times by using the special `repeatable` migration type.

A repeatable migration performs the defined migration steps as many times as the `iterations` setting declares.

``` yaml hl_lines="4"
[[= include_file('code_samples/data_migration/examples/repeatable_step.yaml', 0, 5) =]]
```

!!! tip

    You can use repeatable migration steps, for example, to quickly generate large numbers of content items for testing purposes.

You can vary the operations using the iteration counter.

For example, to create five Folders, with names ranging from "Folder 0" to "Folder 4", you can run the following migration using the iteration counter `i`:

``` yaml hl_lines="16"
[[= include_file('code_samples/data_migration/examples/repeatable_step.yaml', 0, 16) =]]
```

To vary the content name, the migration above uses [Symfony expression syntax](#expression-syntax).

In the example above, the expression is enclosed in `###` and the repeated string `SSS`.

!!! note

    Iteration counter is assigned to `i` by default, but you can modify it in the `iteration_counter_name` setting.

#### Generating fake data

You can also generate fake data with the help of [`FakerPHP`](https://fakerphp.org/).

To use it, first install Faker on your system:

``` bash
composer require fakerphp/faker
```

Then, you can use `faker()` in expressions, for example:

``` yaml
[[= include_file('code_samples/data_migration/examples/repeatable_step.yaml', 16, 19) =]]
```

This step generates field values with fake personal names.

### Expression syntax

You can use [Symfony expression syntax]([[= symfony_doc =]]/reference/formats/expression_language.html) in data migrations, like in [repeatable steps](#repeatable-steps), where you can use it to generate varied content in migration steps.

The expression syntax uses the following structure: `###<IDENTIFIER> <EXPRESSION> <IDENTIFIER>###`

The `IDENTIFIER` can be any repeated string that encloses the actual expression.

#### Built-in functions

Built-in expression language functions that are tagged with `ibexa.migrations.template.expression_language.function`:

- `to_bool`, `to_int`, `to_float`, `to_string` - convert various data types by passing them into PHP casting functions (like `floatval`, `intval`, and others).

```yaml
                -   fieldDefIdentifier: show_children
                    languageCode: eng-US
                    value: '###XXX to_bool(i % 3) XXX###'

                -   fieldDefIdentifier: quantity
                    languageCode: eng-US
                    value: '###XXX to_int("42") XXX###'

                -   fieldDefIdentifier: price
                    languageCode: eng-US
                    value: '###XXX to_float("19.99") XXX###'

                -   fieldDefIdentifier: description
                    languageCode: eng-US
                    value: '###XXX to_string(123) XXX###'
```

- `reference` - references a specific object or resource within your application or configuration. Learn more about [migration references](managing_migrations.md#references).

```yaml
                -   fieldDefIdentifier: some_field
                    languageCode: eng-US
                    value: '###XXX reference("example_reference") XXX###'
```

- `project_dir` - retrieves the project's root directory path, for example to construct file paths or access project-specific resources.

```yaml
                -   fieldDefIdentifier: project_directory
                    languageCode: eng-US
                    value: '###XXX project_dir() XXX###'
```

- `env` - retrieves the value of an environmental variable.

```yaml
                -
                    type: user
                    mode: update
                    match:
                        field: login
                        value: admin
                    metadata:
                        password: '###XXX env("ADMIN_PASSWORD") XXX###'
```

#### Custom functions

To add custom functionality into Migration's expression language declare it as a service and tag it with `ibexa.migrations.template.expression_language.function`.

Example:

```yaml
ibexa.migrations.template.to_bool:
    class: Closure
    factory: [ Closure, fromCallable ]
    arguments:
        - 'boolval'
    tags:
        -   name: 'ibexa.migrations.template.expression_language.function'
            function: to_bool

ibexa.migrations.template.faker:
    class: Closure
    factory: [ Closure, fromCallable ]
    arguments:
        - 'Faker\Factory::create'
    tags:
        -   name: 'ibexa.migrations.template.expression_language.function'
            function: faker
```

Service-based functions can be also added, but they must be callable, requiring either an `__invoke` function or a wrapping service with one.

## Migration examples

The following examples show what data you can import using data migrations.

### Content types

The following example shows how to create a content type with two field definitions.

The required metadata keys are: `identifier`, `mainTranslation`, `contentTypeGroups` and `translations`.

The default values of field definition properties mirror the underlying PHP API, for example:

- `translatable` defaults to `true`
- `required` defaults to `false`

``` yaml
[[= include_file('code_samples/data_migration/examples/create_blog_post_ct.yaml') =]]
```

### Content items

The following example shows how to create two content items: a folder and an article inside it.

When creating a content item, three metadata keys are required: `contentType`, `mainTranslation`, and `parentLocationId`.

To use the location ID of the folder, which is created automatically by the system, you can use a [reference](managing_migrations.md#references).
In this case you assign the `parent_folder_location_id` reference name to the location ID, and then use it when creating the article.

``` yaml hl_lines="15 24"
[[= include_file('code_samples/data_migration/examples/create_parent_and_child_content.yaml') =]]
```

### Images

The following example shows how to migrate an `example-image.png` located in `public/var/site/storage/images/3/8/3/0/383-1-eng-GB` without manually placing it in the appropriate path.

To prevent the manual addition of images to specific DFS or local locations, such as `public/var/site/storage/images/` you can move image files to, for example `src/Migrations/images`.
Adjust the migration file and configure the `image` field data as follows:

```yaml
        -   fieldDefIdentifier: image
            languageCode: eng-GB
            value:
                alternativeText: ''
                fileName: example-image.png
                path: src/Migrations/images/example-image.png
```

This migration copies the image to the appropriate directory, in this case `public/var/site/storage/images/3/8/3/0/254-1-eng-GB/example-image.png`, enabling swift file migration regardless of storage (local, DFS).

### Roles

The following example shows how to create a role.
A role requires the `identifier` metadata key.

For each policy assigned to the role, you select the module and function, with optional limitations.

The following example shows the creation of a `Contributor` role:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_role.yaml') =]]
```

To update an existing role, two policies' modes are available:

- `replace`: (default) All existing policies are replaced by the ones from the migration.
- `append`: Migration policies are added while already existing ones are kept.

The following example shows how to replace the policies of the existing `Editor` role:

``` yaml
[[= include_file('code_samples/data_migration/examples/update_role.yaml', 0, 16) =]]
```

The following example shows the addition of a policy to the `Anonymous` role:

``` yaml hl_lines="7"
[[= include_file('code_samples/data_migration/examples/update_role.yaml', 18, 32) =]]
```

The following example shows how to delete the `Contributor` role:

``` yaml
[[= include_file('code_samples/data_migration/examples/delete_role.yaml') =]]
```

### Locations

The following example shows how to swap content items assigned to given locations.

``` yaml
[[= include_file('code_samples/data_migration/examples/swap_location.yaml') =]]
```

The metadata keys for Location are optional.

### Users

The following example shows how to create a user.

The required metadata keys are: `login`, `email`, `password`, `enabled`, `mainLanguage`, and `contentType`.
You also need to provide the user group's remote content ID.

You can use an [action](data_migration_actions.md) to assign a role to the user.

``` yaml hl_lines="22-23"
[[= include_file('code_samples/data_migration/examples/create_user.yaml') =]]
```

### Languages

The following example shows how to create a language.

The required metadata keys are: `languageCode`, `name`, and `enabled`.

``` yaml
[[= include_file('code_samples/data_migration/examples/create_language.yaml') =]]
```

### Product catalog

#### Attributes and attribute groups

The following example shows how to create an attribute group with two attributes:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_attribute_group.yaml') =]]
```

You can also update attributes, including changing which attribute group they belong to:

``` yaml
[[= include_file('code_samples/data_migration/examples/update_attribute.yaml') =]]
```

You can't change the attribute type of an existing attribute.

##### Date and time attributes

You can manage the [date and time attribute type](date_and_time.md) through the migrations, for example:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_datetime_attribute.yaml') =]]
```

#### Product types

The following example shows how to create a product type.

The main part of the migration file is the same as when creating a regular content type.

A product type must also contain the definition for an `ibexa_product_specification` field.
`fieldSettings` contains information about the product attributes.

``` yaml
[[= include_file('code_samples/data_migration/examples/create_product_type.yaml') =]]
```

#### Products

The following example shows how to create a product:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_product_variant.yaml', 0, 18) =]]
```

#### Product variants

The following example shows how to create variants for a product identified by its code:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_product_variant.yaml', 19, 29) =]]
```

#### Product assets

The following example creates an image [content item](#content-items) from a local image file, and then uses it as a product asset for a variant ([created in previous example](#product-variants)):

``` yaml
[[= include_file('code_samples/data_migration/examples/create_product_asset.yaml') =]]
```

This migration uses a [reference](managing_migrations.md#references) to store the created image content ID, and then uses it while creating the asset.
It uses an [expression syntax](#expression-syntax) to [concat (`~`)]([[= symfony_doc =]]/reference/formats/expression_language.html#string-operators)
the mandatory scheme `ezcontent://` and the image content ID through the [`reference` function](#built-in-functions) used on the reference's name.

#### Product prices

The following example shows how to create a price for a product identified by its code:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_product_price.yaml') =]]
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

### Commerce [[% include 'snippets/commerce_badge.md' %]]

#### Payment methods

The following example shows how to create a payment method:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_payment_method.yaml') =]]
```

#### Shipping methods

The following example shows how to create a shipping method:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_shipping_method.yaml') =]]
```

### Segments [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

The following example shows how to create a segment group and add segments in it:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_segment.yaml', 0, 17) =]]
```

When updating a segment group or segment, you can match the object to update by using its numerical ID or identifier:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_segment.yaml', 18, 24) =]]
```

### Settings

The following example shows how you can create and update a setting stored in the database:

``` yaml
[[= include_file('code_samples/data_migration/examples/create_update_setting.yaml') =]]
```

### Taxonomies

The following example shows how you can create a "Car" tag in the main Taxonomy:

``` yaml hl_lines="15 18 21"
[[= include_file('code_samples/data_migration/examples/create_tag.yaml') =]]
```

The field identifiers must match the identifiers used in the `ibexa_taxonomy` configuration file.

If the content type associated with the tags is changed, the configuration should be adjusted when creating migrations.

!!! note
    If there are multiple taxonomies, the `taxonomy` field is then necessary here (line 21).


You can use the following example to assign tags to a Content (content type Article has an additional field):

``` yaml
[[= include_file('code_samples/data_migration/examples/assign_tag.yaml') =]]
```

When updating a content type, use:

``` yaml
[[= include_file('code_samples/data_migration/examples/update_tag.yaml') =]]
```

### AI action configurations

- The following example shows how you can create a new action configuration in your system:

``` yaml
[[= include_file('code_samples/data_migration/examples/ai/action_configuration_create.yaml') =]]
```

- Use the `update` mode to modify an existing action configuration:

``` yaml
[[= include_file('code_samples/data_migration/examples/ai/action_configuration_update.yaml') =]]
```

- Use the `delete` mode to delete an existing action configuration:

``` yaml
[[= include_file('code_samples/data_migration/examples/ai/action_configuration_delete.yaml') =]]
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
- `ENDS_WITH`

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
