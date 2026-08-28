# Page blocks

Use blocks to customize the content of a Page with dynamic content.

Editions: Experience

Page blocks are configured in YAML files, under the `ibexa_fieldtype_page` key. Keep in mind that Page block configuration isn't SiteAccess-aware.

Ibexa DXP ships with a number of page blocks. For a list of all page blocks that are available out-of-the-box, see [Page block reference](../../../../user/content_management/block_reference/index.md).

For information on how to create and configure new layouts for the Page, see [Page layouts](../../../templating/render_content/render_page/index.md#render-a-layout).

> **Caution: Clear the persistence cache**
>
> Persistence cache must be cleared after any modifications have been made to the block config in Page Builder, such as adding, removing or altering the page blocks, block attributes, validators or views configuration.
>
> To clear the persistence cache, run `php bin/console cache:pool:clear <cache-pool>` command. The default cache pool is named `cache.tagaware.filesystem`. The default cache pool when running Redis or Valkey is named `cache.redis`. If you have customized the [persistence cache configuration](../../../infrastructure_and_maintenance/cache/persistence_cache/index.md#what-is-cached), the name of your cache pool might be different.
>
> In prod mode, you also need to clear the symfony cache by running `./bin/console c:c`. In dev mode, the Symfony cache is rebuilt automatically.

## Block configuration

Each configured block has an identifier and the following settings:

| Setting                  | Description                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
| ------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `name`                   | Name of the block used in the Page Builder interface. Translatable using the `ibexa_page_fieldtype` translation domain. Also accepts a [`help` key](#block-name-and-help-text) that adds a helper text under the **Name** field in the block configuration form.                                                                                                                                                                                                                           |
| `category`               | Category in the Page Builder **Page blocks** toolbox that the block is shown in. Translatable using the `ibexa_page_fieldtype` translation domain.                                                                                                                                                                                                                                                                                                                                         |
| `thumbnail`              | Thumbnail used in the Page Builder **Page blocks** toolbox.                                                                                                                                                                                                                                                                                                                                                                                                                                |
| `views`                  | Available [templates for the block](#block-templates).                                                                                                                                                                                                                                                                                                                                                                                                                                     |
| `visible`                | (Optional) Toggles the block's visibility in the Page Builder **Page blocks** toolbox. Remove the block from the layout before you publish another version of the page.                                                                                                                                                                                                                                                                                                                    |
| `configuration_template` | (Optional) Template for the block settings modal.                                                                                                                                                                                                                                                                                                                                                                                                                                          |
| `attributes`             | (Optional) List of [block attributes](../page_block_attributes/index.md).                                                                                                                                                                                                                                                                                                                                                                |
| `cacheable_query_params` | (Optional) List of query parameters the block's [ESI HTTP cache](../../../infrastructure_and_maintenance/cache/http_cache/http_cache_configuration/index.md#when-to-use-esi) varies on. For example, if the block is paginated using `?page=ℕ` from the page URL, add `page` to this list. See [`ibexa_append_cacheable_query_params()`Twig function](../../../templating/twig_function_reference/page_twig_functions/index.md#ibexa_append_cacheable_query_params). |

For example:

```yaml
ibexa_fieldtype_page:
    blocks:
        event:
            name: event_block.name
            category: custom_category.name
            thumbnail: /bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#calendar
            configuration_template: '@ibexadesign/blocks/event/config.html.twig'
            views:
                default:
                    template: '@ibexadesign/blocks/event/template.html.twig'
                    name: event_block.view.default
                    priority: -255
            attributes:
# ...
```

> **Tip: Tip**
>
> For a full example of block configuration, see [Create custom Page block](../create_custom_page_block/index.md).

### Block name and help text

The `name` setting accepts either a single translation key, a hard coded string of text that won't be translated, or an object with `text` and `help` property keys. Both `text` and `help` are translatable using the `ibexa_page_fieldtype` translation domain.

Scalar form:

```yaml
ibexa_fieldtype_page:
    blocks:
        my_block:
            name: my_block.name.key
```

Structured form with a helper text:

```yaml
ibexa_fieldtype_page:
    blocks:
        my_block:
            name:
                text: my_block.name.key
                help: my_block.name.help.key
```

- `text` - corresponds to the block name.
- `help` - is an optional translation key whose translation is rendered as a helper text under the **Name** field in the block configuration form.

![Help text](https://doc.ibexa.co/en/5.0/content_management/img/help_text.png)

The same format is available for [React App blocks](../react_app_block/index.md).

### Overwriting existing blocks

You can overwrite the following properties in the existing blocks:

- `name`
- `category`
- `thumbnail`
- `views`

## Block templates

Page blocks can have multiple templates. This allows you to create different styles for each block and let the editor choose them when adding the block from the UI. They names are translatable using the `ibexa_page_builder_block_config` translation domain.

```yaml
ibexa_fieldtype_page:
    blocks:
        event:
            views:
                default:
                    template: '@ibexadesign/blocks/event/template.html.twig'
                    name: event_block.view.default
                    priority: -255
                featured:
                    template: '@ibexadesign/blocks/event/featured_template.html.twig'
                    name: event_block.view.featured
                    priority: 50
```

`priority` defines the order of block views on the block configuration screen. The highest number shows first on the list.

> **Tip: Tip**
>
> Default views have a `priority` of -255. It's good practice to keep the value between -255 and 255.

### Block modal template

The template for the configuration modal of built-in Page blocks is contained in `vendor/ibexa/page-builder/src/bundle/Resources/views/page_builder/block/config.html.twig`.

You can override it by using the `configuration_template` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa_fieldtype_page:
    blocks:
        event:
            name: event_block.name
            category: custom_category.name
            thumbnail: /bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#calendar
            configuration_template: '@ibexadesign/blocks/event/config.html.twig'
```

The template can extend the default `config.html.twig` and modify its blocks. Blocks `basic_tab_content` and `design_tab_content` correspond to the **Basic** and **Design** tabs in the modal.

The following example wraps all form fields for block attributes in an ordered list:

```html+twig
{% extends '@IbexaPageBuilder/page_builder/block/config.html.twig' %}

{% block basic_tab_content %}
    <div class="ibexa-block-config__fields">
        {{ form_row(form.name) }}
        {% if attributes_per_category['default'] is defined %}
            <ol>
                {% for identifier in attributes_per_category['default'] %}
                    {% block config_entry %}
                        <li>
                            {{ form_row(form.attributes[identifier]) }}
                        </li>
                    {% endblock %}
                {% endfor %}
            </ol>
        {% endif %}
    </div>
{% endblock %}
```

## Block events

To add functionalities to your block that go beyond the available attributes, you can use an event listener.

You can listen to events related to block definition and block rendering.

The following events are available:

- `BlockDefinitionEvents::getBlockDefinitionEventName` - dispatched when block definition is created
- `BlockDefinitionEvents::getBlockAttributeDefinitionEventName` - dispatched when block attribute definition is created
- `BlockRenderEvents::getBlockPreRenderEventName` - dispatched before a block is rendered
- `BlockRenderEvents::getBlockPostRenderEventName` - dispatched after a block is rendered

For example, to modify a block by adding a new parameter to it, you can create the following listener:

```php
<?php declare(strict_types=1);

namespace App\Block\Listener;

use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\BlockRenderEvents;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyBlockListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('event') => 'onBlockPreRender',
        ];
    }

    public function onBlockPreRender(PreRenderEvent $event): void
    {
        /** @var \Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Twig\TwigRenderRequest $renderRequest */
        $renderRequest = $event->getRenderRequest();

        $parameters = $event->getRenderRequest()->getParameters();

        $parameters['my_parameter'] = 'parameter_value';

        $renderRequest->setParameters($parameters);
    }
}
```

Before the block is rendered, the listener adds `my_parameter` to it with value `parameter_value`. You can use this parameter, for example, in block template:

```html+twig
<div>
    {{ my_parameter }}
</div>
```

### Exposing content relations from blocks

Page blocks, for example Embed block or Collection block, can embed other content items. Publishing a page with such blocks creates Relations to those content items.

When creating a custom block with embeds, you can ensure such Relations are created using the block Relation collection event.

The event is dispatched on content publication. You can hook your event listener to the `BlockRelationEvents::getCollectBlockRelationsEventName` event.

To expose relations, pass an array containing Content IDs to the `Ibexa\FieldTypePage\Event\CollectBlockRelationsEvent::setRelations()` method. If embedded Content changes, old Relations are removed automatically.

Providing Relations also invalidates HTTP cache for your block response in one of the related content items changes.
