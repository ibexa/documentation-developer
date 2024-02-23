---
description: The Ibexa DXP PHPStorm plugin helps you speed up your development by providing file templates, autocompletion, a quick installation wizard, and more.
---

# Ibexa DXP plugin for PhpStorm

[[= product_name =]] plugin for PhpStorm helps you to work with [[= product_name =]] by speeding up installation
and providing file templates, intentions, autocompletion, and other features.

## Requirements

- PhpStorm 2021.2 or newer
- Enabled Symfony support plugin

## Install PhpStorm plugin

You can install the [[= product_name =]] plugin for PhpStorm from the JetBrains Marketplace,
or manually, from a downloaded .jar file.

### Install from JetBrains Marketplace

To install plugin from JetBrains marketplace:

Look for "[[= product_name =]]" in the plugin browser and click **Install**.

### Install from file

You can also install the plugin manually from a `.jar` file:

1\. Download the latest version of the plugin from [JetBrains Marketplace](https://plugins.jetbrains.com/plugin/17239-ibexa-dxp/versions).

2\. In PhpStorm settings/preferences (depending on your system), select **Plugins** > (gear icon) > **Install plugin from Disk...**
and select the downloaded file.

## Configuration

Plugin configuration is available in PhpStorm settings/preferences (depending on your system), 
under **PHP** > **Frameworks** > **Ibexa DXP**.

You can use it to:

- Enable and disable plugin features for the current project
- Change product edition and version by the current project

![Intention](img/phpstorm_plugin_settings.png)

!!! note

    Some plugin features depends on the selected product edition and version. 
    For example, "deprecated namespaces usage" inspection is enabled only if the project uses v4.x.  

Plugin configuration is automatically resolved when opening [[= product_name =]] project for the first time.
If detection is successful, a notification appears with an "Enable [[= product_name =]] support for this project" link.

If you created your project by using [[= product_name =]] project wizard, the plugin is automatically enabled and configured based 
on wizard data.

## Features

### Project wizard

The plugin enables creating a new [[= product_name =]] project directly from PhpStorm.
To do it, select **File** > **New Project...** > **Ibexa DXP**.

In project settings form you can choose:

- Location of the project
- Product edition: [[= product_name_oss =]],[[= product_name_content =]], [[= product_name_exp =]], [[= product_name_com =]]
- Authentication token (for Content, Experience and Commerce editions)
- Product version: Default (latest LTS version), Latest (fast track or LTS), Latest LTS and "Next 3.x" (unstable, based on the 3.x branch) and "Next 4.x" (unstable, based on the 4.x branch)
- Generate [Ibexa Cloud configuration](install_on_ibexa_cloud.md) 
- Composer settings

![Create a project](img/phpstorm_plugin_create_project.png)

If you do not provide credentials for https://updates.ibexa.co/, the plugin uses the installation key and token password stored in global Composer configuration. Otherwise, it creates an `auth.json` file.

You can find details of the installation procedure in Composer log window.

### File templates

The plugin provides the following built-in file templates:

| Name | Comment |
|---|---|
| Back Office tab | Class implementing `EzSystems\EzPlatformAdminUi\Tab\AbstractTab` |
| Block event subscriber | Event subscriber for `BlockRenderEvents::getBlockPreRenderEventName(...)` event |
| Command | Symfony command that uses content repository |
| Composite Criterion | Criterion class based on `\eZ\Publish\API\Repository\Values\Content\Query\Criterion\CompositeCriterion` |
| Field definition form mapper | Class implementing `EzSystems\EzPlatformAdminUi\FieldType\FieldDefinitionFormMapperInterface` |
| Field Type | Field Type class based on `eZ\Publish\SPI\FieldType\Generic\Type` |
| Field Type Comparable | Class implementing `EzSystems\EzPlatformVersionComparison\FieldType\Comparable` |
| Field Type Indexable | Class implementing `eZ\Publish\SPI\FieldType\Indexable` |
| Field value form mapper | Class implementing `EzSystems\EzPlatformContentForms\FieldType\FieldValueFormMapperInterface` |
| Field value object | Field Type value class |
| Menu configuration event subscriber | Event subscriber for `EzSystems\EzPlatformAdminUi\Menu\Event\ConfigureMenuEvent::MAIN_MENU`  |
| Policy provider | Class implementing `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\PolicyProviderInterface` |
| Policy provider (YAML) | Policy provider class based on `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider` |
| Query Type | Query Type class based on `eZ\Publish\Core\QueryType\OptionsResolverBasedQueryType` |
| Schema builder subscriber | Event subscriber for `EzSystems\DoctrineSchema\API\Event\SchemaBuilderEvent::BUILD_SCHEMA` event |
| SiteAccess-aware configuration | SiteAccess-aware configuration definition class based on `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\AbstractParser` |
| Value object input parser | REST input parser class based on `EzSystems\EzPlatformRest\Input\BaseParser` |
| Value object visitor | REST value visitor class based on `EzSystems\EzPlatformRest\Output\ValueObjectVisitor` |
| Workflow action listener | Workflow action listener class based on `EzSystems\EzPlatformWorkflow\Event\Action\AbstractTransitionWorkflowActionListener` |

The templates are available in, for example, the context menu in **Project window** > **New** > **Ibexa DXP**.

The list of available file templates depends on the [[= product_name =]] edition used by the project.

For all file templates you can customize:

- class name
- class namespace
- file name
- directory

![File template](img/phpstorm_plugin_file_template.png)

To customize file templates, go to **File** > **Settings**/**Preferences** > **Editor** > **File and Code templates**.

!!! tip

    For more information about file templates, see [JetBrains documentation](https://www.jetbrains.com/help/phpstorm/settings-file-and-code-templates.html).

### Live templates

The plugin provides the following built-in live templates in Twig files:

| Abbreviation | Comment |
|---|---|
| `ezcn` | `ez_content_name` |
| `ezfd` | `ez_field_description` |
| `ezfd?` | `ez_field_description` wrapped in an `ez_field_is_empty` check |
| `ezfn` | `ez_field_name` |
| `ezfn?` | `ez_field_name` wrapped in an `ez_field_is_empty` check |
| `ezrc` | `ez_render_content` |
| `ezrcq` | `ez_render_content_query` |
| `ezrf` | `ez_render_field` |
| `ezrf?` | `ez_render_field` wrapped in an `ez_field_is_empty` check |
| `ezrl` | `ez_render_location` |
| `ezrlq` | `ez_render_location_query` |

and in PHP files:

| Abbreviation | Comment |
|---|---|
| `ibx_create_c` | Create content |
| `ibx_create_cd` | Create content draft | 
| `ibx_create_ct` | Create content type |
| `ibx_find_c` | Create and execute content query | 
| `ibx_find_ci` | Create and execute content info query |
| `ibx_find_l` | Create and execute location query |
| `ibx_load_c` | Load content by ID |
| `ibx_load_ci` | Load content info by ID |
| `ibx_load_ct` | Load content type by identifier |
| `ibx_load_l` | Load location by ID |
| `ibx_param` | Get SiteAccess parameter value |
| `ibx_pub` | Publish content draft |
| `ibx_switch_user` | Switch  user context |
| `ibx_trans` | Repository transaction |
| `ibx_update_c` | Update content |
| `ibx_update_ct` | Update content type |

To customize live templates, go to **File** > **Settings**/**Preferences** > **Editor** > **Live Templates**.

!!! tip

    For more information about live templates, see [JetBrains documentation](https://www.jetbrains.com/help/idea/using-live-templates.html).

### Autocompletion in configuration files

Plugin provides autocompletion for [[= product_name =]] configuration structure in YAML files placed in `config/packages/`.

Besides configuration structure, for the following YAML keys addition suggestions are available:

- List of available view matchers, for:
    - `ezplatform.<scope>.content_view.<view_type>.<view_name>.match`
    - `ezplatform.<scope>.content_create_view.<view_type>.<view_name>.match`
    - `ezplatform.<scope>.content_edit_view.<view_type>.<view_name>.match`
    - `ezplatform.<scope>.content_translate_view.<view_type>.<view_name>.match`
- List of available SiteAccess matchers, for:
    - `ezplatform.siteaccess.match`
- List of available block attribute types, for:
    - `ezplatform_page_fieldtype.blocks.<block_name>.attributes.<attribute_name>.type`
- List of available configuration scopes, for:
    - `ezplatform`
- List of available siteaccess names, for:
    - `ezplatform.siteaccess.default_siteaccess`
    - `ezplatform.siteaccess.groups`
    - `ezplatform.system.<scope>.translation_siteaccesses$`
- List of available design names, for:
    - `ezdesign.design_list`
    - `ezplatform.system.<scope>.design`
- List of available repositories, for:
    - `ezplatform.system.<scope>.repository`
- List of available search engines, for:
    - `ezplatform.repositories.<repository>.search.engine`
- List of available custom tags, for:
    - `ezplatform.system.<scope>.fieldtypes.ezrichtext.custom_tags`
- List of available view types, for:
    - `ezplatform.<scope>.content_view`
    - `ezplatform.<scope>.content_create_view`
    - `ezplatform.<scope>.content_edit_view`
    - `ezplatform.<scope>.content_translate_view`

### Structure autocompletion in DBAL schema file

Autocompletion is also available for DBAL schema file structure.

To enable autocompletion, you must place the file in the `config` directory and name it `schema.yaml`.

### Dynamic settings autocompletion

Parameter names suggestions are available in `\eZ\Publish\Core\MVC\ConfigResolverInterface::{hasParameter,getParameter}` method calls.

Suggested results take into account namespace argument, if its value can be resolved without running interpreter
(for example, string literal or const reference).

### Query type name autocompletion

Query type name suggestions are available in `\eZ\Publish\Core\QueryType\QueryTypeRegistry::getQueryType` method calls.

Suggestions are based on service definitions tagged as `ezplatform.query_type`.

### Query type parameter autocompletion

Parameter name suggestions are available for Query types which implement the `eZ\Publish\Core\QueryType\QueryType` interface
or extend the `eZ\Publish\Core\QueryType\OptionsResolverBasedQueryType` class in the following places:

* `\eZ\Publish\Core\QueryType\QueryType::getQuery` method calls
* `\eZ\Publish\Core\QueryType\QueryType::getQuery` method definition
* `\eZ\Publish\Core\QueryType\OptionsResolverBasedQueryType::doGetQuery` method definition 

![Query Type parameter autocompletion](img/phpstorm_plugin_query_type_params.png)

### Intentions and inspections

The plugin also brings several new intentions and inspections (with related quick fixes where possible).

For example, when plugin detects deprecated configuration key usage, it marks the key as deprecated and suggests a replacement:

![Intention](img/phpstorm_plugin_intention.png)

## Known issues

It is not possible to create new project with Docker as PHP remote interpreter.
See [related JetBrains issue](https://youtrack.jetbrains.com/issue/WI-61330) for more details.

## Feedback

You can report bugs and feature suggestions on [https://issues.ibexa.co/](https://issues.ibexa.co/issues/?jql=project%20%3D%20IBX%20AND%20component%20%3D%20%22PHPStorm%20plugin%22) by
selecting the "PHPStorm plugin" component, or on the `#phpstorm-plugin` [[= product_name_base =]] Community Slack channel.
