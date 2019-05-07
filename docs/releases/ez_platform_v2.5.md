# eZ Platform v2.5

**Version number**: v2.5

**Release date**: March 29, 2019

**Release type**: Long Term Supported

## Notable changes

### Content Tree

You can now navigate through your website with a Content Tree.
It will allow you to easily browse your content in the Back Office.
Each Content item has a unique icon that helps you identify it without opening.

![Content Tree in the menu](img/left_menu_tree.png "Content Tree in the menu")

For more information on custom configuration, see [Content Tree](../guide/config_back_office/#content-tree) in the developer documentation.

For full description of the interface, see [Content Tree](https://doc.ezplatform.com/projects/userguide/en/latest/content_model/#content-tree) in the user documentation.

### Webpack Encore

This release introduces [Webpack Encore](https://symfony.com/doc/3.4/frontend.html#webpack-encore)
as the preferred tool for asset management.
This leads to [changes in requirements](#requirements-changes).

Assetic is still in use, but it will be deprecated in a future version.

### PostgreSQL

This release enables you to [use PostgreSQL](../guide/databases.md#using-postgresql) for database instead of the default MySQL.

Database schema is now created based on [YAML configuration](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/config/storage/legacy/schema.yaml).

See [Using PostgreSQL](../cookbook/using_postgresql.md) for more information.

### GraphQL

You can now take advantage of [GraphQL](../api/graphql.md) to query and operate on content.
It uses a domain schema based on your content model.

See [GraphQL documentation](https://graphql.org/) for more information about GraphQL in general.

### Matrix Field Type

The new [Matrix Field Type](../api/field_type_reference.md#matrix-field-type) enables you to store a table of data.
Columns in the matrix are defined in the Field definition.

![Configuring a Matrix Field Type](img/2.5_matrix_ft.png)

#### Migration of legacy XML format

You can now migrate your content from legacy XML format to a new `ezmatrix` value with the following command:

```bash
bin/console ezplatform:migrate:legacy_matrix
```

### User bundle

The new [ezplatform-user](https://github.com/ezsystems/ezplatform-user) bundle now centralizes
all features related to user management, such as user accounts, registering, changing passwords, etc.

!!! enterprise

    ### Workflow improvements

    You can now preview a diagram of the configured workflows in the Admin Panel.

    ![Diagram of a workflow configuration](img/2.5_workflow_diagram.png)

    After selecting configured workflow administrator, the user is now able to see all Content items under review for it.

    ![Content under review](img/workflow_content_under_review.png)

### Online editor improvements

#### Anchors in Rich Text Field

You can now link fragments of text by adding Anchors in Rich Text Fields.

#### Inline custom tags

You can now create [inline custom tags](../guide/extending_online_editor.md#inline-custom-tags) in Rich Text Fields.

#### Custom CK Editor plugins

You can now easily use [custom CK Editor plugins](../guide/extending_online_editor.md#plugins-configuration) in AlloyEditor.

### Hiding and revealing content

You can now hide and reveal Content items from the Back Office.
Hidden content will be unavailable on the front page regardless of permissions or [Location visibility](../guide/content_management.md#location-visibility).

![Icon for hiding content](img/2.5_hide_content_icon.png)

### Product version preview

The Dashboard now shows the version of eZ Platform you are running.

![eZ Platform version](img/2.5_product_version.png)

### Expanded User Settings

The User Settings menu has been expanded with the following options:

- Preferred language of the Back Office
- Preferred date format
- Option to enable or disable a character counter for Rich Text Fields

![User settings screen with new settings](img/2.5_user_settings.png)

### Various Back Office improvements

This release introduced several Back Office improvements to facilitate editorial experience, including:

- [Icons for Content Types and the ability to define them](../guide/extending_ez_platform.md#custom-content-type-icons)
- Ability to collapse and expand content preview to have easier access to the Sub-items list
- Responsive Sub-items table with selectable column layout
- Simpler assigning of Object States to content


![Back Office improvements](img/2.5_back_office_improvements.png)

### Permissions

#### Content/Create policy for Users

You can now define a 'Content/Create' policy for a User or a User group.
It will enable or disable (if not set) the **Create** button in your dashboard.

#### Universal Discovery Widget

`allowed_content_types` can now limit selection in UDW search and browse sections to specified Content Types.

![Create button in Dashboard](img/2.5_create_button.png)

### API improvements

New API improvements include:

- `sudo()` exposed officially in API to make it more clear how you can skip permission checks when needed
- `AssignSectionToSubtreeSignal` to assign Sections to subtrees
- new `loadLanguageListByCode()` and `loadLanguageListById()` endpoints for bulk loading of languages
- new method `ContentService->loadContentInfoList()` for bulk loading Content information
    - it can be used with `ContentService->loadContentListByContentInfo()` to bulk load Content
    - v2.5 also takes advantage of it in e.g. `RelationList` and `ParameterProvider`
- now Persistence cache layer also caches selected metadata objects in-memory
- indexation of related objects in the full text search

## Requirements changes

Due to using Webpack Encore, you now need [Node.js and yarn](updating_ez_platform.md#3-update-the-app)
to install or update eZ Platform.

This release also changes support for versions of the following third-party software:

- Solr 4 is no longer supported. Use Solr 6 instead (Solr 6.6LTS recommended).
- Apache 2.2 is no longer supported. Use Apache 2.4 instead.
- Varnish 4 is no longer supported. Use Varnish 5.1 or higher (6.0LTS recommended).

For full list of supported versions, see [Requirements](../getting_started/requirements.md).

### Password requirements

This version introduces stricter default password quality requirements.

Passwords must be at least 10 characters long, and must include upper and lower case letters, and digits.
Existing passwords are not changed.

See [backwards compatibility changes](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/bc/changes-7.5.md)
for detailed information.

## Full changelog

| eZ Platform  | eZ Enterprise  |
|--------------|------------|
| [eZ Platform v2.5.0](https://github.com/ezsystems/ezplatform/releases/tag/v2.5.0) | [eZ Enterprise v2.5.0](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.5.0) |
| [eZ Platform v2.5.0-rc2](https://github.com/ezsystems/ezplatform/releases/tag/v2.5.0-rc2) | [eZ Enterprise v2.5.0-rc2](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.5.0-rc2) |
| [eZ Platform v2.5.0-rc1](https://github.com/ezsystems/ezplatform/releases/tag/v2.5.0-rc1) | [eZ Enterprise v2.5.0-rc1](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.5.0-rc1) |
| [eZ Platform v2.5.0-beta2](https://github.com/ezsystems/ezplatform/releases/tag/v2.5.0-beta2) | [eZ Enterprise v2.5.0-beta2](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.5.0-beta2) |
| [eZ Platform v2.5.0-beta1](https://github.com/ezsystems/ezplatform/releases/tag/v2.5.0-beta1) | [eZ Enterprise v2.5.0-beta1](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.5.0-beta1) |
