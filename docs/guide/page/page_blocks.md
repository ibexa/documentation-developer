---
description: Use blocks to customize the content of a Page with dynamic content.
---

# Page blocks

Page blocks are configured in YAML files, under the `ezplatform_page_fieldtype` key.

!!! caution

    Page block configuration is not SiteAccess-aware.

!!! tip

    For information on how to create and configure new layouts for the Page,
    see [Page layouts](../content_rendering/render_content/render_page.md#render-a-layout).

## Block configuration

Each configured block has an identifier and the following settings:

|Setting|Description|
|---|---|
| `name` | Name of the block used in the Page Builder interface. |
| `category` | Category in the Page Builder elements menu that the block is shown in. |
| `thumbnail` | Thumbnail used in the Page Builder elements menu. |
| `views` | Available [templates for the block](#block-templates). |
| `visible` | (Optional) Toggles the block's visibility in the Page Builder elements menu. Remove the block from the layout before you publish another version of the page. |
| `configuration_template` | (Optional) Template for the block settings modal. |
| `attributes` | (Optional) List of [block attributes](page_block_attributes.md). |

For example:

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 12) =]][[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 16, 17) =]]# ...
```

!!! tip

    For a full example of block configuration, see [Create custom Page block](create_custom_page_block.md).

### Overwriting existing blocks

You can overwrite the following properties in the existing blocks:

- `name`
- `category`
- `thumbnail`
- `views`

## Block templates

Page blocks can have multiple templates.
This allows you to create different styles for each block and let the editor choose them when adding the block from the UI.

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 3) =]][[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 7, 16) =]]
```

`priority` defines the order of block views on the block configuration screen.
The highest number shows first on the list.

!!! tip

    Default views have a `priority` of -255.
    It is good practice to keep the value between -255 and 255.

### Block modal template

The template for the configuration modal of built-in Page blocks is contained in
`vendor/ezsystems/ezplatform-page-builder/src/bundle/Resources/views/page_builder/block/config.html.twig`.

You can override it by using the `configuration_template` setting:

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 7) =]]
```

The template can extend the default `config.html.twig` and modify its blocks.
Blocks `basic_tab_content` and `design_tab_content` correspond to the **Basic** and **Design** tabs in the modal.

The following example wraps all form fields for block attributes in an ordered list:

``` html+twig
[[= include_file('code_samples/page/custom_page_block/templates/themes/standard/blocks/event/config.html.twig') =]]
```

## Block events

To add functionalities to your block that go beyond the available attributes,
you can use an event listener.

You can listen to events related to block definition and block rendering.

The following events are available:

- `BlockDefinitionEvents::getBlockDefinitionEventName` - dispatched when block definition is created
- `BlockDefinitionEvents::getBlockAttributeDefinitionEventName` - dispatched when block attribute definition is created
- `BlockRenderEvents::getBlockPreRenderEventName` - dispatched before a block is rendered
- `BlockRenderEvents::getBlockPostRenderEventName` - dispatched after a block is rendered

For example, to modify a block by adding a new parameter to it, you can create the following listener:

``` php
[[= include_file('code_samples/page/page_listener/src/Block/Listener/MyBlockListener.php') =]]
```

Before the block is rendered, the listener adds `my_parameter` to it with value `parameter_value`.
You can use this parameter, for example, in block template:

``` html+twig
[[= include_file('code_samples/page/page_listener/templates/my_block.html.twig') =]]
```

#### Exposing content relations from blocks

Page blocks, for example Embed block or Collection block, can embed other Content items.
Publishing a Page with such blocks creates Relations to those Content items.

When creating a custom block with embeds, you can ensure such Relations are created using the block Relation collection event.

The event is dispatched on content publication.
You can hook your event listener to the `BlockRelationEvents::getCollectBlockRelationsEventName` event.

To expose relations, pass an array containing Content IDs to the `\EzSystems\EzPlatformPageFieldType\Event\CollectBlockRelationsEvent::setRelations()` method.
If embedded Content changes, old Relations are removed automatically.

Providing Relations also invalidates HTTP cache for your block response in one of the related Content items changes.

## Customizing Universial Discovery Widged (UDW) when working with embed and locationlist attributes

Quite a few of the blocks that are shipped with Ibexa DXP gives the user the possibility to select content using the UDW.
Some of those blocks also uses UDW with different configurations. For instance, the UDW opened by the `Banner` block only
allows the user to select images, while the `Collection` block allows the user to select multiple Content objects in the
UDW. The examples below will illustrate how to customize the UDW configuration when creating new blocks that uses the
`embed` (used by `Banner` block) and the `locationlist` (used by 'Collection' block) attributes.

### The `embed` attribute type

This example demonstrates how to create a new block with the `embed` attribute where the user may only select folders
in the UDW.

In order to do this, these things are needed:
 - [Page Builder config](https://doc.ibexa.co/en/3.3/extending/extending_udw/#add-new-tabs-to-udw) for the new block.
 - New [UDW config](https://doc.ibexa.co/en/latest/administration/back_office/browser/browser/#udw-configuration).
 - [Event subscriber](https://doc.ibexa.co/en/3.3/guide/page/page_blocks/#block-events) that adds attributes to the view template.
 - Template code for the view template.
 - Template code for showing the UDW during [configuration of the block](https://doc.ibexa.co/en/3.3/guide/page/page_blocks/#block-configuration) in admin-ui.


#### Page Builder and UDW config

``` yaml
# config/packages/custom_page_blocks.yaml

ezplatform_page_fieldtype:
    blocks:
        embed_udw:
            name: EmbedUDW
            category: default
            thumbnail: '/bundles/ibexaplatformicons/img/all-icons.svg#banner'
            configuration_template: '@ezdesign/blocks/config/embed_udw_config.html.twig'
            views:
                default: { name: 'Default block layout', template: '@ezdesign/full/block/embed_udw.html.twig', priority: -255 }
            attributes:
                contentId:
                    name: Folder
                    type: embed
                    validators:
                        content_type:
                            message: You must select a folder
                            options:
                                types: folder
                        regexp:
                            options:
                                pattern: '/[0-9]+/'
                            message: Choose a Content item

ezplatform:
    system:
        default:
            universal_discovery_widget_module:
                configuration:
                    block_embed_udw:
                        multiple: false
                        allowed_content_types: ['folder']

```

#### Event subscriber

The `embed` attribute will by default only expose one variable to the view template, `contentId`. Usually, an embed block
needs to show more than just this ID, so an event subscriber is also needed in order to pass additional variables to the
template. In this example, the event subscriber for the `Banner` block which will expose a `content` variable
(see `BannerBlockListener` class) in the view template which contains the Content object is reused:

``` php
<?php
// src/Block/Listener/EmbedUDWBlockListener.php

namespace App\Block\Listener;

use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Event\Listener\BannerBlockListener;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\BlockRenderEvents;

class EmbedUDWBlockListener extends BannerBlockListener
{
    public static function getSubscribedEvents()
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('embed_udw') => 'onBlockPreRender',
        ];
    }
}
```

#### Template code for the view template

The template for viewing the block is as usual defined using the `views` setting in the config. This simple template shows
the Content Name and it's id :

``` html+twig
{# templates/themes/standard/full/block/embed_udw.html.twig #}
<div>
{{ ez_http_tag_relation_ids(content.id) }}
Selected content : {{ content.name }}, contentId={{ contentId }}
</div>
```

#### Template code for the block edit modal

When showing the block's edit modal in admin-ui, there are several templates in play.
The various [attribute types](https://doc.ibexa.co/en/3.3/guide/page/page_block_attributes/#block-attribute-types) have
their own sets of default template code, see `vendor/ezsystems/ezplatform-page-builder/src/bundle/Resources/views/page_builder/block/form_fields.html.twig`
The default template code for the `embed` attribute is in the block named `block_configuration_attribute_embed_widget`
in that file.
Also, each block have a `configuration_template` setting in their yaml configuration which can be used to customize the
block's edit modal. The default template used by the block's edit modal will ensure that all the attribute templates defined
by the block are displayed.

The last step is to customize the embed attribute's template code so it opens the UDW with the custom UDW config named
`block_embed_udw` which was defined above.
In order to override the UDW configuration, this example will use the same approach as the `configuration_template` for
the build-in `Banner` block, see `vendor/ezsystems/ezplatform-page-builder/src/bundle/Resources/views/page_builder/block/config/banner.html.twig`

The template for the new `EmbedUDW` block will look like this:

``` html+twig
{% extends '@EzPlatformPageBuilder/page_builder/block/config.html.twig' %}

{% block body_class %}{{ parent() }} ez-block-config--embed-udw{% endblock %}

{% block content %}
    {% set form_templates = [_self] %}
    {{ parent() }}
{% endblock %}

{% block block_configuration_attribute_embed_widget %}
    {% set attr = attr|merge({'hidden': true}) %}
    {{ form_widget(form, {'attr': attr})}}
    <div class="ez-block-embed-field">
        {% include '@EzPlatformPageBuilder/page_builder/block/config/embed_button.html.twig' with {
            udw_config_name: 'block_embed_udw',
            data_open_udw: 'data-open-udw-embed'
        } %}
        {% include '@EzPlatformPageBuilder/page_builder/block/config/embed_preview.html.twig' %}
    </div>
{% endblock %}
```

In the `content` block in the template above, the template path to the template itself is added to the variable `form_templates`
This is done because the parent template (`@EzPlatformPageBuilder/page_builder/block/config.html.twig`) will use all
[form themes](https://symfony.com/doc/current/form/form_themes.html) that are listed in that variable when rendering the
block configuration modal. In this way it is possible to override the `locationlist` attribute's default template code
by adding a `block_configuration_attribute_embed_widget` block in this very template.

The only thing that is changed in the template above, compared to the template for the `Banner` block, is altering the
class name in the `body_class` block and the value for the `udw_config_name` setting.


### The `locationlist` attribute type

This example demonstrates how to create a new block with the `locationlist` attribute where the user may select multiple
folders only (not objects of any content type which is the default behaviour).

The steps needed are the same as the ones above when using the embed attribute, except that templates for the block edit
modal for the locationlist attribute is created slightly different.

#### Page Builder and UDW config

``` yaml
# config/packages/custom_page_blocks.yaml

ezplatform_page_fieldtype:
    blocks:
        locationlist_udw:
            name: LocationListUDW
            category: default
            thumbnail: '/bundles/ibexaplatformicons/img/all-icons.svg#contentlist'
            configuration_template: '@ezdesign/blocks/config/locationlist_udw_config.html.twig'
            views:
                #                default: { name: 'Default block layout', template: '@IbexaFieldTypePage/blocks/banner.html.twig', priority: -255 }
                default: { name: 'Default block layout', template: '@ezdesign/full/block/locationlist_udw.html.twig', priority: -255 }
            attributes:
                locationlist:
                    name: Location List
                    type: locationlist
                    validators:
                        not_blank:
                            message: Choose location items

ezplatform:
    system:
        default:
            universal_discovery_widget_module:
                configuration:
                    block_locationlist_udw:
                        multiple: true
                        allowed_content_types: ['folder']
```

#### Event subscriber

The `embed` attribute will by default only expose one variable in the view template, `contentId`. Usually, an embed block
needs to show more than just this ID, so a [event suscriber|todo: link to page event doc] is also needed in order to
pass additional variables to the template. In this example, the event subscriber for the `Collection` block is reused:

``` php
<?php
// src/Block/Listener/LocationListUDWBlockListener.php

namespace App\Block\Listener;

use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\BlockDefinitionEvents;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Event\Listener\CollectionBlockListener;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\BlockRenderEvents;

class LocationListUDWBlockListener extends CollectionBlockListener
{
    public static function getSubscribedEvents(): array
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('locationlist_udw') => 'onBlockPreRender',
            BlockDefinitionEvents::getBlockAttributeDefinitionEventName('locationlist_udw', 'locationlist') => 'onLocationListAttributeDefinition',
        ];
    }
}
```

#### Template code for the view template

In this example the view template for the `Collection` block is reused:

``` html+twig
{% include '@EzPlatformPageFieldType/blocks/collection.html.twig' %}
```

#### Template code for the block edit modal

The default template for the `locationlist` attribute ( the `block_configuration_attribute_location_list_widget` block
in `vendor/ezsystems/ezplatform-page-builder/src/bundle/Resources/views/page_builder/block/form_fields.html.twig`)
includes a second template ('collection_preview.html.twig'). The code for opening the UDW is in the latter template.
In this example, both the content of the widget block and 'collection_preview.html.twig' is copied to the same template
for simplicity:

``` html+twig
{% extends '@EzPlatformPageBuilder/page_builder/block/config.html.twig' %}

{% block body_class %}{{ parent() }} ez-block-config--locationlist-udw{% endblock %}

{% block content %}
    {% set form_templates = [_self] %}
    {{ parent() }}

{% endblock %}

{# Block is copied from vendor/ezsystems/ezplatform-page-builder/src/bundle/Resources/views/page_builder/block/form_fields.html.twig, line 183 #}
{% block block_configuration_attribute_location_list_widget %}
    {% set attr = attr|merge({'hidden': true, 'data-match': match|json_encode}) %}
    {{ form_widget(form, {'attr': attr})}}

    {#  The following code is copied from @EzPlatformPageBuilder/page_builder/block/config/collection_preview.html.twig #}
    {#  which is originally included by the widget block #}
    {% trans_default_domain 'ezplatform_page_builder_block_config' %}

    <div class="form-group ez-collection">
        <div>
            <button
                    type="button"
                    class="btn btn-secondary ez-btn--select-content"
                    data-udw-config="{{ ez_udw_config('block_locationlist_udw', {}) }}"
                    data-target="{{ form.vars.id }}">
                {{ 'block.collection.select.content'|trans|desc('Select content') }}
            </button>
        </div>
        <ol
                class="ez-collection__items"
                data-template="{{ include('@EzPlatformPageBuilder/page_builder/block/config/collection_item.html.twig', {
                    'content_name': '{{ content_name }}',
                    'content_type_name': '{{ content_type_name }}',
                    'id': '{{ id }}'
                })|e('html_attr')  }}"
                data-placeholder="{{ include('@EzPlatformPageBuilder/page_builder/block/config/collection_placeholder.html.twig', {
                })|e('html_attr')  }}">

            {% for location in locations %}
                {% set content_type_name = content_types[location.contentInfo.contentTypeId].getName() %}

                {{ include('@EzPlatformPageBuilder/page_builder/block/config/collection_item.html.twig', {
                    'content_name': ez_content_name(location.contentInfo),
                    'content_type_name': content_type_name,
                    'id': location.id
                }) }}
            {% endfor %}
        </ol>
    </div>

{% endblock %}
```
