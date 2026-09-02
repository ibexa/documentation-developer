# Importing data

Import data into your repository from prepared YAML files.

To import data from YAML migration files into repository, you run the `ibexa:migrations:migrate` command.

The `ibexa:migrations:import` command automatically places migration files in the correct folder.

Alternatively, you can place the files manually in the `src/Migrations/Ibexa/migrations` folder or in [a custom folder that you configure](../managing_migrations/index.md#migration-folders), and specify the file name within this folder as parameter. If you don't specify the file, all files within this directory are used.

```bash
php bin/console ibexa:migrations:migrate --file=my_data_export.yaml --siteaccess=admin
```

Migrations store execution metadata in the `ibexa_migrations` database table. This allows incremental upgrades: the `ibexa:migrations:migrate` command ignores files that it had previously executed.

The [`--siteaccess` option](../exporting_data/index.md#siteaccess) usage can be relevant when multiple languages or multiple repositories are used.

## Migration step

A data migration step is a single operation in data migration process that combines a mode (for example: `create`, `update`, `delete`) and a type (for example: `content`, `section`, `currency`), with optional additional information depending on the specific step.

In a migration file, a step is an array item starting with the mandatory properties `type` and `mode`, for example:

```yaml
-
    type: content
    mode: create
```

Then, the step is described by additional properties depending on its type and mode.

- See [Available migrations](#available-migrations) for the modes available for each type.
- See [Migration examples](#migration-examples) to explore what you can do with each type.
- For a custom migration step, see [Create data migration step](../create_data_migration_step/index.md).

## Available migrations

The following data migration step modes are available:

| `type`                 | `create` | `update` | `delete` | `swap` | `trash` |
| ---------------------- | -------- | -------- | -------- | ------ | ------- |
| `action_configuration` | Yes      | Yes      | Yes      |        |         |
| `attribute`            | Yes      | Yes      | Yes      |        |         |
| `attribute_group`      | Yes      | Yes      | Yes      |        |         |
| `company`              | Yes      |          |          |        |         |
| `content_type`         | Yes      | Yes      | Yes      |        |         |
| `content_type_group`   | Yes      | Yes      | Yes      |        |         |
| `content`              | Yes      | Yes      | Yes      |        |         |
| `currency`             | Yes      | Yes      | Yes      |        |         |
| `customer_group`       | Yes      | Yes      | Yes      |        |         |
| `discount`             | Yes      | Yes      |          |        |         |
| `discount_code`        | Yes      |          |          |        |         |
| `language`             | Yes      | Yes      |          |        |         |
| `location`             |          | Yes      |          | Yes    | Yes     |
| `object_state`         | Yes      |          |          |        |         |
| `object_state_group`   | Yes      |          |          |        |         |
| `payment_method`       | Yes      |          |          |        |         |
| `product_asset`        | Yes      |          |          |        |         |
| `product_availability` | Yes      |          |          |        |         |
| `product_price`        | Yes      |          |          |        |         |
| `product_variant`      | Yes      |          |          |        |         |
| `role`                 | Yes      | Yes      | Yes      |        |         |
| `section`              | Yes      | Yes      |          |        |         |
| `segment`              | Yes      | Yes      | Yes      |        |         |
| `segment_group`        | Yes      | Yes      | Yes      |        |         |
| `setting`              | Yes      | Yes      | Yes      |        |         |
| `shipping_method`      | Yes      |          |          |        |         |
| `user`                 | Yes      | Yes      |          |        |         |
| `user_group`           | Yes      | Yes      | Yes      |        |         |

Additionally, the following special migration types are available:

| `type`         | `mode`                        |
| -------------- | ----------------------------- |
| `reference`    | `load`, `save`, `set`, `list` |
| `repeatable`   | `create`                      |
| `service_call` | `execute`                     |
| `sql`          | `execute`                     |
| `try_catch`    | `execute`                     |

For more information about the `reference` type, see [References](../managing_migrations/index.md#references).

### Repeatable steps

You can run a set of one or more similar migration steps multiple times by using the special `repeatable` migration type.

A repeatable migration performs the defined migration steps as many times as specified:

- with an [iteration counter](#repeatable-steps-with-iteration-counter), mimicking the behavior of a [`for` loop](https://www.php.net/manual/en/control-structures.for.php)
- with a [list of items](#repeatable-steps-with-items), mimicking the behavior of a [`foreach` loop](https://www.php.net/manual/en/control-structures.foreach.php)

> **Tip: Tip**
>
> You can use repeatable migration steps, for example, to quickly generate large numbers of content items for testing purposes.

#### Repeatable steps with iteration counter

You can vary the operations with the iteration counter.

For example, to create five Folders, with names ranging from "Folder 0" to "Folder 4", you can run the following migration using the iteration counter `i`:

```yaml
-
    type: repeatable
    mode: create
    iterations: 5
    steps:
        -   type: content
            mode: create
            metadata:
                contentType: folder
                mainTranslation: eng-GB
            location:
                parentLocationId: 2
            fields:
                -   fieldDefIdentifier: name
                    languageCode: eng-GB
                    value: 'Folder ###XXX i XXX###'
```

To vary the content name, the migration above uses [Symfony expression syntax](#expression-syntax).

In the example above, the expression is enclosed in `###` and the repeated string `XXX`.

> **Note: Note**
>
> Iteration counter is assigned to `i` by default, but you can modify it in the `iteration_counter_name` setting. The counter starts at `0` by default. You can change this with the `iteration_counter_starting_value` setting.

#### Repeatable steps with items

By using the `items` key, you can provide an array of items to the `repeatable` step:

```yaml
-   type: repeatable
    mode: create
    steps:
        -   type: language
            mode: create
            metadata:
                languageCode: '###XXX code XXX###'
                name: '###XXX name XXX###'
                enabled: true
    items:
        - { code: afr-AF, name: Afrikaans }
        - { code: alb-SQ, name: Albanian }
        - { code: ara-AR, name: Arabic }
```

In the example above, the step runs for each entry declared in `items`. On each run, the values of `code` and `name` keys are available as variables.

The iteration counter variable (named `i` by default) is also available and holds the zero-based index of the current item. You can rename it with the `iteration_counter_name` setting and combine it with item properties as in the following example:

```yaml
-   type: repeatable
    mode: create
    iteration_counter_name: index
    steps:
        -   type: content
            mode: create
            metadata:
                contentType: folder
                mainTranslation: eng-GB
                remoteId: 'migration_folder_###XXX index XXX###'
            location:
                parentLocationId: 2
            fields:
                -   fieldDefIdentifier: name
                    languageCode: eng-GB
                    value: '###XXX title XXX###'
    items:
        - { title: 'Getting Started' }
        - { title: 'Advanced Configuration' }
        - { title: 'API Reference' }
```

This migration results in three new content items:

| Content item name      | Remote location ID    |
| ---------------------- | --------------------- |
| Getting started        | `migration_article_0` |
| Advanced Configuration | `migration_article_1` |
| API Reference          | `migration_article_2` |

#### Generating fake data

You can also generate fake data with the help of [`FakerPHP`](https://fakerphp.org/).

To use it, first install Faker on your system:

```bash
composer require fakerphp/faker
```

Then, you can use `faker()` in expressions, for example:

```yaml
                -   fieldDefIdentifier: short_name
                    languageCode: eng-GB
                    value: '### faker().name() ###'
```

This step generates field values with fake personal names.

### SQL migrations

You can execute raw SQL queries directly in migrations by using the `sql` migration type. Use it for custom database operations that don't fit into standard entity migrations, such as creating custom tables or performing bulk updates.

Each query requires a `driver` property that specifies which database system the query is for. The migration system automatically filters queries and executes only those matching your current database driver.

```yaml
-
    type: sql
    mode: execute
    query:
        -
            driver: mysql
            sql: 'INSERT INTO test_table (test_value) VALUES ("foo");'
        -
            driver: sqlite
            sql: 'INSERT INTO test_table (test_value) VALUES ("foo");'
        -
            driver: postgresql
            sql: "INSERT INTO test_table (test_value) VALUES ('foo');"
```

The supported database drivers are:

- `mysql` - MySQL/MariaDB
- `postgresql` - PostgreSQL
- `sqlite` - SQLite

You can define queries for multiple database drivers in a single migration step. The system executes only the queries that match your configured database platform. If no matching queries are found, the migration throws an error.

> **Caution: Caution**
>
> SQL migrations bypass the content model abstraction layer and directly modify the database. Use them with caution and ensure your queries are compatible with your target database system.

### Error handling with try-catch

You can wrap one or more migration steps with a `try_catch` step to handle exceptions gracefully.

Use it for migration steps that may fail under specific conditions but should not halt the entire migration process.

For example, you can ensure a language creation migration step succeeds even if the language already exists. If the migration step fails for this reason, the exception is suppressed, allowing the remaining migrations to proceed without interruption.

A `try_catch` migration requires the `steps` property and accepts optional `allowed_exceptions` and `stop_after_first_exception` settings.

Default values are:

- `allowed_exceptions`: empty list
- `stop_after_first_exception`: `true`

```yaml
-
    type: try_catch
    mode: execute
    allowed_exceptions:
        - Ibexa\Contracts\Core\Repository\Exceptions\InvalidArgumentException
    stop_after_first_exception: true
    steps:
        -
            type: language
            mode: create
            metadata:
                languageCode: ger-DE
                name: German
                enabled: true
```

When an exception is thrown within a `try_catch` step, it's compared against the list of `allowed_exceptions`. If the exception matches, it's caught and the migration step continues or stops depending on the `stop_after_first_exception` configuration setting. The migration step is marked as successful and the migration process continues. Non-matching exceptions throw immediately, halting the migration process and returning an error.

### Service calls

You can call a method of a service by using the `service_call` migration type. Use it when a migration requires custom logic that isn't covered by the built-in migration types.

A `service_call` migration requires the `service` and `method` properties, and accepts an optional `arguments` list passed to the method:

```yaml
-
    type: service_call
    mode: execute
    service: App\Migration\ContentImporter
    method: import
    arguments:
        - content.csv
        - 42
```

You can only call services that are explicitly listed under the `ibexa_migrations.callable_services` configuration key:

```yaml
ibexa_migrations:
    callable_services:
        - App\Migration\ContentImporter
```

### Expression syntax

You can use [Symfony expression syntax](https://symfony.com/doc/7.4/reference/formats/expression_language.html) in data migrations, like in [repeatable steps](#repeatable-steps), where you can use it to generate varied content in migration steps.

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

- `reference` - references a specific object or resource within your application or configuration. Learn more about [migration references](../managing_migrations/index.md#references).

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
        email: admin@example.com
        enabled: true
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

The required metadata keys are: `identifier`, `mainTranslation`, `contentTypeGroups` and `translations`. The example also shows the optional metadata keys: `nameSchema`, `urlAliasSchema`, `container`, `defaultAlwaysAvailable`, `defaultSortField`, `defaultSortOrder`, `remoteId`, and `creatorId`.

The default values of field definition properties mirror the underlying PHP API, for example:

- `translatable` defaults to `true`
- `required` defaults to `false`

```yaml
-
    type: content_type
    mode: create
    metadata:
        identifier: blog_post
        mainTranslation: eng-GB
        remoteId: blog_post_content_type
        creatorId: 14
        nameSchema: '<title>'
        urlAliasSchema: '<title>'
        container: true
        defaultAlwaysAvailable: true
        defaultSortField: 2 # Location::SORT_FIELD_PUBLISHED
        defaultSortOrder: 0 # Location::SORT_ORDER_DESC
        contentTypeGroups:
            - Content
        translations:
            eng-GB:
                name: Blog Post
    fields:
        -   identifier: title
            type: ibexa_string
            required: true
            translations:
                eng-GB:
                    name: 'Title'
        -   identifier: body
            type: ibexa_richtext
            required: false
            translations:
                eng-GB:
                    name: 'Body'
```

### Content items

The following example shows how to create two content items: a folder and an article inside it.

When creating a content item, three metadata keys are required: `contentType`, `parentLocationId`, and `mainTranslation`. The `mainTranslation` property sets content item's main language.

To use the location ID of the folder, which is created automatically by the system, you can use a [reference](../managing_migrations/index.md#references). In this case you assign the `parent_folder_location_id` reference name to the location ID, and then use it when creating the article.

```yaml
-
    type: content
    mode: create
    metadata:
        contentType: folder
        mainTranslation: eng-GB
    location:
        parentLocationId: 2
    fields:
        -   fieldDefIdentifier: name
            languageCode: eng-GB
            value: 'Parent folder'
    references:
        -
            name: parent_folder_location_id
            type: location_id

-
    type: content
    mode: create
    metadata:
        contentType: article
        mainTranslation: eng-GB
    location:
        parentLocationId: 'reference:parent_folder_location_id'
    fields:
        -   fieldDefIdentifier: title
            languageCode: eng-GB
            value: 'Child article'
        -   fieldDefIdentifier: intro
            languageCode: eng-GB
            value:
                xml: |
                    <?xml version="1.0" encoding="UTF-8"?>
                    <section xmlns="http://docbook.org/ns/docbook" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ezxhtml="http://ibexa.co/xmlns/dxp/docbook/xhtml" xmlns:ezcustom="http://ibexa.co/xmlns/dxp/docbook/custom" version="5.0-variant ezpublish-1.0"><para>This is <emphasis role="strong">article into</emphasis>.</para></section>
```

The following example shows the optional `metadata` and `location` properties that you can set when creating a content item. Instead of `parentLocationId`, you can identify the parent location with `parentLocationRemoteId`. `sortField` takes the numeric value of one of the `SORT_FIELD_*` constants from the [`Location` class](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Location.php), and `sortOrder` takes `ASC` or `DESC`, case insensitive:

```yaml
-
    type: content
    mode: create
    metadata:
        contentType: folder
        mainTranslation: eng-GB
        creatorId: 14
        modificationDate: '2025-06-01T10:00:00+00:00'
        publicationDate: '2025-06-01T10:00:00+00:00'
        remoteId: options_folder
        alwaysAvailable: true
        section:
            identifier: standard
    location:
        parentLocationId: 2
        # parentLocationRemoteId: root_location
        locationRemoteId: options_folder_location
        hidden: false
        priority: 10
        sortField: 9 # Location::SORT_FIELD_NAME
        sortOrder: ASC
    fields:
        -   fieldDefIdentifier: name
            languageCode: eng-GB
            value: 'Folder with all options'
```

Use the `update` mode to modify an existing content item. You can match the content item by `content_remote_id`, `location_id`, `parent_location_id`, or `content_type_identifier`. All `metadata` keys are optional: [`initialLanguageCode`](../../content_api/creating_content/index.md#translating-content), [`mainLanguageCode`](../../content_model/index.md#content-information), `creatorId`, `remoteId`, `alwaysAvailable`, `mainLocationId`, `modificationDate`, `publishedDate`, `name`, and `ownerId`.

```yaml
-
    type: content
    mode: update
    match:
        field: content_remote_id
        value: options_folder
    metadata:
        mainLanguageCode: eng-GB
        name: 'Updated folder'
        initialLanguageCode: eng-GB
        remoteId: f5c88a2209584891056f987fd965b0ba
        mainLocationId: 5
        creatorId: 14
        ownerId: 14
        publishedDate: '2002-10-06T15:19:56+00:00'
        alwaysAvailable: false
        modificationDate: '2025-06-15T10:00:00+00:00'
    fields:
        -   fieldDefIdentifier: name
            languageCode: eng-GB
            value: 'Updated folder'
```

Use the `delete` mode to delete content items:

```yaml
-
    type: content
    mode: delete
    match:
        field: content_remote_id
        value: __REMOTE_ID__
        only_visible_content: true # Optional, default: true. If set to true, only visible content will be deleted. 
    allow_no_delete: false # Optional, default: false. If set to true, the migration will not fail if no content is found using the specified criteria.
```

### Images

The following example shows how to migrate an `example-image.png` located in `public/var/site/storage/images/3/8/3/0/383-1-eng-GB` without manually placing it in the appropriate path.

To prevent the manual addition of images to specific DFS or local locations, such as `public/var/site/storage/images/` you can move image files to, for example `src/Migrations/images`. Adjust the migration file and configure the `image` field data as follows:

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

The following example shows how to create a role. A role requires the `identifier` metadata key.

For each policy assigned to the role, you select the module and function, with optional limitations.

The following example shows the creation of a `Contributor` role:

```yaml
-
    type: role
    mode: create
    metadata:
        identifier: Contributor
    policies:
        -
            module: content
            function: read
        -
            module: content
            function: create
            limitations:
                -
                    identifier: Class
                    values: [folder, article, blog_post]
                -
                    identifier: Section
                    values: [standard, media]
        -
            module: content
            function: edit
            limitations:
                -
                    identifier: Owner
                    values: ['1']
```

To update an existing role, two policies' modes are available:

- `replace`: (default) All existing policies are replaced by the ones from the migration.
- `append`: Migration policies are added while already existing ones are kept.

The following example shows how to replace the policies of the existing `Editor` role:

```yaml
-
    type: role
    mode: update
    match:
        field: identifier
        value: Editor
    policies:
        -   module: content
            function: '*'
        -   module: user
            function: login
            limitations:
                -   identifier: SiteAccess
                    values: [ admin ]
        -   module: url
            function: '*'
```

The following example shows the addition of a policy to the `Anonymous` role:

```yaml
    type: role
    mode: update
    match:
        field: identifier
        value: Anonymous
    policies:
        mode: append
        list:
            -
                module: user
                function: login
                limitations:
                    -   identifier: SiteAccess
                        values: [ new_siteaccess ]
```

The following example shows how to delete the `Contributor` role:

```yaml
-
    type: role
    mode: delete
    match:
        field: identifier
        value: Contributor
```

### Locations

The following example shows how to swap content items assigned to given locations.

```yaml
-
    type: location
    mode: swap
    match1:
        field: location_remote_id
        value: f3e90596361e31d496d4026eb624c983
    match2:
        field: location_id
        value: 5
```

The metadata keys for Location are optional.

The following example shows how to trash locations.

```yaml
-
    type: location
    mode: trash
    match:
        field: location_remote_id
        value: f3e90596361e31d496d4026eb624c983
-
    type: location
    mode: trash
    match:
        field: location_id
        value: 5
```

### Users

The following example shows how to create a user.

The required metadata keys are: `login`, `email`, `password`, `enabled`, `mainLanguage`, and `contentType`. You also need to provide the user group's remote content ID.

You can use an [action](../data_migration_actions/index.md) to assign a role to the user.

```yaml
-
    type: user
    mode: create
    metadata:
        login: janedoe
        email: johndoe@example.com
        password: Password123Password
        enabled: true
        mainLanguage: eng-GB
        contentType: user
    groups:
        - 3c160cca19fb135f83bd02d911f04db2
    fields:
        -
            fieldDefIdentifier: first_name
            languageCode: eng-GB
            value: John
        -
            fieldDefIdentifier: last_name
            languageCode: eng-GB
            value: Doe
    actions:
        - { action: assign_user_to_role, identifier: 'Member'}
```

You can also update the user's email, enabled status, and password. All `metadata` keys are optional:

```yaml
-
    type: user
    mode: update
    match:
        field: login
        value: admin
    metadata:
        email: admin@example.com
        enabled: true
        password: '###XXX env("ADMIN_PASSWORD") XXX###'
```

### Languages

The following example shows how to create a language.

The required metadata keys are: `languageCode`, `name`, and `enabled`.

```yaml
-
    type: language
    mode: create
    metadata:
        languageCode: ger-DE
        name: German
        enabled: true
```

You can also update an existing language to rename it or change its enabled state. Both `name` and `enabled` are optional, only the fields you provide are modified.

```yaml
-
    type: language
    mode: update
    languageCode: ger-DE
    metadata:
        name: 'German (Germany)'
        enabled: true
    references:
        -
            name: ref__ger_de__language_id
            type: language_id
```

The example above saves the ID of the updated language as a [reference](../managing_migrations/index.md#references) for further usage.

### Product catalog

#### Attributes and attribute groups

The following example shows how to create an attribute group with two attributes:

```yaml
-   type: attribute_group
    mode: create
    identifier: hat
    names:
        eng-GB: Hat

-   type: attribute
    mode: create
    identifier: size
    attribute_type_identifier: integer
    attribute_group_identifier: hat
    names:
        eng-GB: Size

-   type: attribute
    mode: create
    identifier: color
    attribute_type_identifier: selection
    attribute_group_identifier: hat
    names:
        eng-GB: Color
    options:
        choices:
            -    value: red
                 label:
                     "eng-GB": "Red"
            -    value: white
                 label:
                     "eng-GB": "White"
            -    value: black
                 label:
                     "eng-GB": "Black"
```

You can also update attributes, including changing which attribute group they belong to:

```yaml
-
    type: attribute
    mode: update
    criteria:
        type: field_value
        field: identifier
        value: width
        operator: '='
    identifier: new_width
    attribute_group_identifier: size
    names:
        eng-GB: New Width
```

You can't change the attribute type of an existing attribute.

##### Date and time attributes

You can manage the [date and time attribute type](../../../product_catalog/attributes/date_and_time/index.md) through the migrations, for example:

```yaml
-   type: attribute
    mode: create
    identifier: event_date
    attribute_group_identifier: example
    attribute_type_identifier: datetime
    position: 1
    names:
        eng-GB: 'Event date'
    options:
        accuracy: day # One of: second, minute, day, month, trimester, year
```

#### Product types

The following example shows how to create a product type.

The main part of the migration file is the same as when creating a regular content type.

A product type must also contain the definition for an `ibexa_product_specification` field. `fieldSettings` contains information about the product attributes.

```yaml
-   type: content_type
    mode: create
    metadata:
        identifier: hat
        mainTranslation: eng-GB
        contentTypeGroups:
            - product
        translations:
            eng-GB:
                name: Hat
    fields:
        -   identifier: name
            type: ibexa_string
            required: true
            translations:
                eng-GB:
                    name: Name
        -   identifier: specification
            type: ibexa_product_specification
            required: true
            translatable: false
            translations:
                eng-GB:
                    name: Specification
            fieldSettings:
                attributes_definitions:
                    dimensions:
                        - { attributeDefinition: size, required: true, discriminator: false }
                        - { attributeDefinition: color, required: true, discriminator: true }
```

#### Products

The following example shows how to create a product:

```yaml
-   type: content
    mode: create
    metadata:
        contentType: hat
        mainTranslation: eng-GB
    location:
        parentLocationId: 60
    fields:
        -   fieldDefIdentifier: name
            languageCode: eng-GB
            value: 'Top hat 58cm'
        -   fieldDefIdentifier: specification
            languageCode: eng-GB
            value:
                code: top_hat__58
                attributes:
                    size: 58
                is_virtual: false
```

#### Product variants

The following example shows how to create variants for a product identified by its code:

```yaml
-   type: product_variant
    mode: create
    base_product_code: top_hat__58
    variants:
        -   code: top_hat__58__white
            attributes:
                color: white
        -   code: top_hat__58__black
            attributes:
                color: black
```

#### Product assets

The following example creates an image [content item](#content-items) from a local image file, and then uses it as a product asset for a variant ([created in previous example](#product-variants)):

```yaml
-   type: content
    mode: create
    metadata:
        contentType: image
        mainTranslation: eng-GB
    location:
        parentLocationId: 51 # Media/Images
    fields:
        -   fieldDefIdentifier: name
            languageCode: eng-GB
            value: 'Top hat 58cm Black'
        -   fieldDefIdentifier: image
            languageCode: eng-GB
            value:
                alternativeText: 'Top hat 58cm Black'
                fileName: 'top_hat_58cm_black.jpg'
                path: top_hat_58cm_black.jpg
    references:
        -   name: top_hat_58cm_black_image_content_id
            type: content_id

-   type: product_asset
    mode: create
    product_code: top_hat__58__black
    uri: '### "ezcontent://"~reference("top_hat_58cm_black_image_content_id") ###'
    tags: []
```

This migration uses a [reference](../managing_migrations/index.md#references) to store the created image content ID, and then uses it while creating the asset. It uses an [expression syntax](#expression-syntax) to [concatenate (`~`)](https://symfony.com/doc/7.4/reference/formats/expression_language.html#string-operators) the mandatory scheme `ezcontent://` and the image content ID through the [`reference` function](#built-in-functions) used on the reference's name.

#### Product prices

The following example shows how to create a price for a product identified by its code:

```yaml
-   type: product_price
    mode: create
    product_code: top_hat__58
    currency_code: 'EUR'
    amount: 120
    custom_prices:
        -   customer_group: contractors
            base_amount: 120
            custom_amount: 100
```

#### Product availability

The following example shows how to define the availability and stock of a product identified by its code:

```yaml
-
    type: product_availability
    mode: create
    product_code: ergo_desk
    is_available: true
    is_infinite: false
    stock: 100
```

When `is_infinite` is set to `true`, `stock` must be `null`.

#### Customer groups

The following example shows how to create a customer group with a defined global price discount:

```yaml
-   type: customer_group
    mode: create
    identifier: contractors
    names:
        eng-GB: Contractors
    global_price_rate: -20.0
```

#### Currencies

The following example shows how to create a currency:

```yaml
-   type: currency
    mode: create
    code: TST
    subunits: 3
    enabled: true # default, optional
```

### Commerce (Commerce)

#### Payment methods

The following example shows how to create a payment method:

```yaml
-   type: payment_method
    mode: create
    paymentType: online
    name:
        -
            languageCode: eng-GB
            value: PaymentMethodName
        -
            languageCode: ger-DE
            value: PaymentMethodNameGerman
    identifier: PaymentMethodIdentifier
    enabled: true
    description:
        -
            languageCode: eng-GB
            value: PaymentMethodDescription
        -
            languageCode: ger-DE
            value: PaymentMethodDescriptionGerman
```

#### Shipping methods

The following example shows how to create a shipping method:

```yaml
- type: shipping_method
  mode: create
  name:
      -
          languageCode: eng-GB
          value: TestName
  description:
      -
          languageCode: eng-GB
          value: TestDescription
  vatCategory: standard
  identifier: TestIdentifier
  enabled: false
  shippingType: free
  options:
      currency: 1
      price: '12.34'
  regions:
      - germany

- type: shipping_method
  mode: create
  name:
      -
          languageCode: eng-GB
          value: TestName
      -
          languageCode: ger-DE
          value: TestNameGerman
  description:
      -
          languageCode: eng-GB
          value: TestDescription
      -
          languageCode: ger-DE
          value: TestDescriptionGerman
  vatCategory: standard
  identifier: TestIdentifier2
  shippingType: flat_rate
  options:
      price: '12.34'
      currency: 'PLN'
  regions:
      - germany
      - france
```

### Segments (Experience, Commerce)

The following example shows how to create a segment group and add segments in it:

```yaml
-
    type: segment_group
    mode: create
    name: 'Contractors'
    identifier: contractors
    references:
        -
            name: contractors_group_id
            type: segment_group_id

-
    type: segment
    mode: create
    name: 'Painter'
    identifier: painter
    group:
        identifier: contractors
```

When updating a segment group or segment, you can match the object to update by using its numerical ID or identifier:

```yaml
-
    type: segment
    mode: update
    name: 'Painter and Finish'
    matcher:
        identifier: painter
```

### Settings

The following example shows how you can create and update a setting stored in the database:

```yaml
- type: setting
  mode: create
  group: test
  identifier: my_setting
  value:
      first: first_value
      second: second_value

- type: setting
  mode: update
  group: test
  identifier: my_setting
  value:
    first: first_value_modified
```

### Taxonomies

The following example shows how you can create a "Car" tag in the main Taxonomy:

```yaml
-   type: content
    mode: create
    metadata:
        contentType: tag
        mainTranslation: eng-GB
        alwaysAvailable: true
        section:
            identifier: taxonomy
    location:
        parentLocationRemoteId: taxonomy_tags_folder
    fields:
        -   fieldDefIdentifier: name
            languageCode: eng-GB
            value: Car
        -   fieldDefIdentifier: identifier
            languageCode: eng-GB
            value: car
        -   fieldDefIdentifier: parent
            languageCode: eng-GB
            value:
                taxonomy_entry_identifier: root
```

The field identifiers must match the identifiers used in the `ibexa_taxonomy` configuration file.

If the content type associated with the tags is changed, the configuration should be adjusted when creating migrations.

> **Note: Note**
>
> If there are multiple taxonomies, the `taxonomy` field is then necessary here (line 21).

You can use the following example to assign tags to a Content (content type Article has an additional field):

```yaml
-   type: content
    mode: create
    metadata:
        contentType: article
        mainTranslation: eng-GB
        alwaysAvailable: false
        section:
            identifier: standard
    location:
        parentLocationId: 42
    fields:
        -   fieldDefIdentifier: title
            languageCode: eng-GB
            value: Test1
        -   fieldDefIdentifier: short_title
            languageCode: eng-GB
            value: test1
        -   fieldDefIdentifier: author
            languageCode: eng-GB
            value:
                -
                    id: '1'
                    name: 'Administrator User'
                    email: admin@link.invalid
        -   fieldDefIdentifier: intro
            languageCode: eng-GB
            value:
                xml: |
                    <?xml version="1.0" encoding="UTF-8"?>
                    <section xmlns="http://docbook.org/ns/docbook" xmlns:xlink="http://www.w3.org/1999/xlink" 
                    xmlns:ezxhtml="http://ibexa.co/xmlns/dxp/docbook/xhtml" xmlns:ezcustom="http://ibexa.co/xmlns/dxp/docbook/custom" 
                    version="5.0-variant ezpublish-1.0"><para>test</para></section>
        -   fieldDefIdentifier: enable_comments
            languageCode: eng-GB
            value: false
        -   fieldDefIdentifier: field_631b169ec8035
            languageCode: eng-GB
            value:
                taxonomy_entries_identifiers:
                    - car
                    - plane
                taxonomy: tags
```

When updating a content type, use:

```yaml
-   type: content_type
    mode: update
    match:
        field: content_type_identifier
        value: article
    fields:
        -   identifier: field_631b169ec8035
            type: ibexa_taxonomy_entry_assignment
            position: 7
            translations:
                eng-GB:
                    name: tag
                    description: 'Tagi'
            required: false
            searchable: true
            infoCollector: false
            translatable: true
            category: content
            defaultValue:
                taxonomy_entries: {  }
                taxonomy: null
            fieldSettings:
                taxonomy: tags
            validatorConfiguration: {  }
```

### AI action configurations

- The following example shows how you can create a new action configuration in your system:

```yaml
-   type: action_configuration
    mode: create
    identifier: foo_identifier
    enabled: false
    names:
        'eng-GB': 'foo_name_eng_gb'
        'ger-DE': 'foo_name_ger_de'

    descriptions:
        'ger-DE': 'foo_description_ger_de'

    action_handler_identifier: foo_handler
    action_handler_options:
        handler_option: foo

    action_type_identifier: generate_alt_text
    action_type_options:
        max_length: 130
```

- Use the `update` mode to modify an existing action configuration:

```yaml
-   type: action_configuration
    mode: update
    match:
        field: identifier
        value: foo_identifier

    enabled: false
    identifier: bar_identifier
    names:
        'eng-GB': 'bar_name_eng_gb'
        'ger-DE': 'bar_name_ger_de'

    descriptions:
        'ger-DE': 'bar_description_ger_de'

    action_handler_options:
        handler_option: bar

    action_type_options:
        max_length: 120
```

- Use the `delete` mode to delete an existing action configuration:

```yaml
-   type: action_configuration
    mode: delete
    match:
        field: identifier
        value: foo_identifier
```

### Discounts

The following example shows how you can create a new [discount](../../../discounts/discounts_guide/index.md) in your system:

```yaml
-   type: discount
    mode: create
    identifier: summer_sale_2025
    translations:
        -
            language_code: eng-GB
            name: "Summer Sale 2025"
            description: "-10% on laptops"
            label: "HOT DEAL: Summer Sale!"
            label_description: "Get 10% off on selected items!"
    discount_type: cart
    priority: 8
    enabled: true
    user: admin
    startDate: '2024-01-01T00:01:00+00:00'
    endDate: null
    createdAt: null
    updatedAt: null
    rule:
        type: percentage
        expressionValues:
            discount_percentage: 10
    conditions:
        -   
            identifier: is_in_currency
            expressionValues: 
                currency_code: EUR
        -
            identifier: is_product_in_array
            expressionValues:
                product_codes: 
                    - product_code_book_0
                    - product_code_book_1
        -
            identifier: is_product_in_quantity_in_cart
            expressionValues:
                quantity: 2
```

Use the `update` mode to modify an existing discount as in the example below. The provided conditions overwrite any already existing ones.

```yaml
-   type: discount
    mode: update
    match:
        field: identifier
        value: summer_sale_2025
    identifier: summer_sale_2025_updated
    translations:
        eng-GB:
            language_code: eng-GB
            name: Updated name
            description: Updated description
            label: Updated promotion label
            label_description: Updated promotion description
    priority: 5
    active: true
    user: admin
    startDate: '2024-01-01T00:00:00+00:00'
    endDate: null
    createdAt: null
    updatedAt: null
    rule:
        type: percentage
        expressionValues:
            discount_percentage: '10'
    conditions:
        -
            identifier: is_product_in_quantity_in_cart
            expressionValues:
                quantity: 2
```

For a list of available conditions, see [Discounts API](../../../discounts/discounts_api/index.md#conditions).

### Discount codes

You can create a discount code as in the following example:

```yaml
type: discount_code
mode: create
code: summer10
global_usage_limit: 100 # Optional
user_usage_limit: 5 # Optional
created_at: '2023-01-01T12:00:00+00:00' # Optional
creator_id: 42 # Optional
```

## Criteria

When using `update` or `delete` modes, you can use criteria to identify the objects to operate on.

> **Caution: Caution**
>
> Criteria only work with objects related to the product catalog.

```yaml
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

```yaml
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
