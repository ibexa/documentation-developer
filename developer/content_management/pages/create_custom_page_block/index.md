# Create custom Page block

Create and configure custom Page blocks to add customized content to Pages.

Editions: Experience

In addition to existing blocks which you can use in a Page, you can also create custom blocks.

To do this, add block configuration in a YAML file, under the `ibexa_fieldtype_page` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files).

> **Caution: Clear the persistence cache**
>
> Persistence cache must be cleared after any modifications have been made to the block config in Page Builder, such as adding, removing or altering the page blocks, block attributes, validators or views configuration.
>
> To clear the persistence cache, run `php bin/console cache:pool:clear <cache-pool>` command. The default cache pool is named `cache.tagaware.filesystem`. The default cache pool when running Redis or Valkey is named `cache.redis`. If you have customized the [persistence cache configuration](../../../infrastructure_and_maintenance/cache/persistence_cache/index.md#what-is-cached), the name of your cache pool might be different.
>
> In prod mode, you also need to clear the symfony cache by running `./bin/console c:c`. In dev mode, the Symfony cache is rebuilt automatically.

The following example shows how to create a block that showcases an event.

## Configure block

First, add the following [YAML configuration](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa_fieldtype_page:
    blocks:
        event:
            name: event_block.name
            category: custom_category.name
            thumbnail: /bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#calendar
            attributes:
                name:
                    type: text
                    name: event_block.name.name
                    validators:
                        not_blank:
                            message: validators.message.event_block.name.validator.not_blank
                category:
                    type: select
                    name: event_block.category.name
                    value: visual
                    options:
                        multiple: true
                        choices:
                            'Music': music
                            'Visual arts': visual
                            'Sports': sports
                event:
                    type: embed
                    name: event_block.event.name
                    options:
                        udw_config_name: block_event_embed
                    validators:
                        not_blank:
                            message: validators.message.event_block.embed.validator.not_blank
                        content_type:
                            message: validators.message.event_block.embed.validator.content_type
                            options:
                                types: ['event']
                        regexp:
                            message: validators.message.event_block.embed.validator.content_item
                            options:
                                pattern: '/[0-9]+/'
```

And provide the translations for the labels:

- in `translations/ibexa_page_builder_block_config.en.yaml`:

```yaml
event_block.view.default: Default
event_block.view.featured: Featured

event_block.name.name: Name
event_block.category.name: Category
event_block.event.name: Event
```

- in `translations/ibexa_page_fieldtype.en.yaml`:

```yaml
custom_category.name: Custom category
event_block.name: Event
```

- in `translations/validators.en.yaml`:

```yaml
validators.message.event_block.name.validator.not_blank: Event name should not be blank.
validators.message.event_block.embed.validator.not_blank: Event content should not be blank.
validators.message.event_block.embed.validator.content_type: Event content should be of type "event".
validators.message.event_block.embed.validator.content_item: Event content should have a numerical ID.
```

`event` is the internal name for the block, and `name` indicates the name under which the block is available in the interface. You also set up the category in the **Page blocks** toolbox that the block appears in. In this case, it doesn't show up with the rest of the built-in blocks, but in a separate "Custom category" category. The thumbnail for the block can be one of the pre-existing icons, like in the example above, or you can use a custom SVG file.

A block can have multiple attributes that you edit when adding it to a page. In this example, you configure three attributes: name of the event, category it belongs to, and an event content item that you select and embed.

For a list of all available attribute types, see [Page block attributes](../page_block_attributes/index.md).

Each attribute can have [validators](../page_block_validators/index.md). The `not_blank` validators in the example ensure that the user fills in the two block fields. The `content_type` validator in the example ensure that the user choose a content item of the content type `event`. The `regexp` validator ensure that the final value looks like a content ID.

The following UDW configuration is used with the `udw_config_name` key so only an event typed content item can be selected:

```yaml
ibexa:
    system:
        default:
            universal_discovery_widget_module:
                configuration:
                    block_event_embed:
                        multiple: false
                        allowed_content_types: ['event']
```

For more information, see [UDW configuration](../../../administration/back_office/browser/browser/index.md#udw-configuration).

## Add block templates

A block can have different templates that you select when adding it to a page.

To configure block templates, add them to block configuration:

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

Provide the templates in the indicated folder, in this case in `templates/themes/<your_theme>/blocks/event`.

For example the `featured_template.html.twig` file can look like this:

```html+twig
<h1>{{ name }}</h1>
<p>{{ category }}</p>
{{ render(controller('ibexa_content::viewAction', {
    'contentId': event,
    'viewType': 'embed'
})) }}
```

The templates have access to all block attributes, as you can see above in the `name`, `category` and `event` variables.

Priority of templates indicates the order in which they're presented in Page Builder. The template with the greatest priority is used as the default one.

## Add block JavaScript

If your block is animated with JavaScript, you may have to take precaution to keep it working when previewed in back office's Page Builder.

If you use an event related to the page being loaded to trigger the initialisation of your custom block, a freshly added block doesn't work in the Page Builder preview. For example, the [`DOMContentLoaded`](https://developer.mozilla.org/en-US/docs/Web/API/Document/DOMContentLoaded_event) event isn't fired when a block is dragged into the page as the DOM is already loaded.

The Page Builder fires `body` events that you can listen to initialize your block:

- `ibexa-render-block-preview` event is fired when the page is loaded in the Page Builder, when a block is added, when a block is deleted, and when a block setting modification is submitted.
- `ibexa-post-update-blocks-preview` event is fired when a block setting modification is submitted, this event has a `detail` property listing the reloaded modified block IDs and their configs.

In the following code, the same `initCustomBlocks` function is attached to two event listeners. One listener to call the function when a page is loaded (as a regular front page or as a page edited in the Page Builder). The other one to call it when a block is added or configured in the Page Builder. This `initCustomBlocks` function finds the custom blocks to loop through them, initializes some JavaScript when the block isn't already initialized, and flag the block as initialized. For example, it could initialize carousel blocks with the addition of event listeners to navigation arrows, and the start of an automatic sliding.

```javascript
document.addEventListener('DOMContentLoaded', function(event) {
    initCustomBlocks();
});
document.getElementsByTagName('body')[0].addEventListener('ibexa-render-block-preview', function(event) {
    initCustomBlocks();
});
```

> **Note: Note**
>
> For the addition of your custom block's JS and CSS files, see [Assets](../../../templating/assets/index.md).
>
> If you consider using React JavaScript library, see [React App block](../react_app_block/index.md).

## Add pre-render event listener

If you need to compute variables to pass to the template, you can listen or subscribe to the block pre-render event.

For example, the following event subscriber loads the `event` content item and passes it to the template as `event_content`:

```php
<?php declare(strict_types=1);

namespace App\Event\Subscriber;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\BlockRenderEvents;
use Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\PreRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BlockEmbedEventEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly ContentService $contentService)
    {
    }

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
        $parameters['event_content'] = $this->contentService->loadContent($parameters['event']);
        $renderRequest->setParameters($parameters);
    }
}
```

The block view template could now use `ibexa_render(event_content, {'viewType': 'embed'})` instead of `render(controller('ibexa_content::viewAction', {'contentId': event, 'viewType': 'embed'}))`, other [content Twig functions](../../../templating/twig_function_reference/content_twig_functions/index.md), or [field Twig functions](../../../templating/twig_function_reference/field_twig_functions/index.md).

For more information, see [Block events](../page_blocks/index.md#block-events).

## Add edit template

You can also customize the template for the block settings modal. Do this under the `configuration_template` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa_fieldtype_page:
    blocks:
        event:
            name: event_block.name
            category: custom_category.name
            thumbnail: /bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#calendar
            configuration_template: '@ibexadesign/blocks/event/config.html.twig'
```

Place the edit template in `templates/themes/<your_theme>/blocks/event/config.html.twig`:

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

Your custom page block is now registered in the system.

> **Caution: Caution**
>
> To use the new block in Page Builder, add it to the list of available blocks in a given content type's settings. This can be done manually in [Page field settings](../../../../user/content_management/configure_ct_field_settings/index.md#block-display) or by using the migration action [`add_block_to_available_blocks`](../../data_migration/data_migration_actions/index.md#content-types).
