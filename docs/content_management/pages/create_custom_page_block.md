---
description: Create and configure custom Page blocks to add customized content to Pages.
---

# Create custom Page block

In addition to existing blocks which you can use in a Page, you can also create custom blocks.

To do this, add block configuration in a YAML file, under the `ibexa_fieldtype_page` [configuration key](configuration.md#configuration-files).

[[% include 'snippets/page_block_cache_clear.md' %]]

The following example shows how to create a block that showcases an event.

## Configure block

First, add the following [YAML configuration](configuration.md#configuration-files):

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 6) =]][[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 16, 39) =]]
```

`event` is the internal name for the block, and `name` indicates the name under which the block is available in the interface.
You also set up the category in the Elements panel that the block appears in.
In this case, it doesn't show with the rest of the built-in blocks, but in a separate "Custom" category.
The thumbnail for the block can be one of the pre-existing icons, like in the example above,
or you can use a custom SVG file.

A block can have multiple attributes that you edit when adding it to a Page.
In this example, you configure three attributes: name of the event, category it belongs to,
and an event Content item that you select and embed.

For a list of all available attribute types, see [Page block attributes](page_block_attributes.md).

Each attribute can have [validators](page_block_validators.md). The `not_blank` validators in the example ensure that the user fills in the two block fields.

## Add block templates

A block can have different templates that you select when adding it to a Page.

To configure block templates, add them to block configuration:

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 3) =]][[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 7, 16) =]]
```

Provide the templates in the indicated folder, in this case in `templates/themes/<your_theme>/blocks/event`.

For example the `featured_template.html.twig` file can look like this:

``` html+twig
[[= include_file('code_samples/page/custom_page_block/templates/themes/standard/blocks/event/featured_template.html.twig') =]]
```

The templates have access to all block attributes, as you can see above in the `name`, `category` and `event` variables.

Priority of templates indicates the order in which they're presented in Page Builder.
The template with the greatest priority is used as the default one.

## Add block JavaScript

If your block is animated with JavaScript, you may have to take precaution to keep it working when previewed in Back Office's Page Builder.

If you use an event related to the page being loaded to trigger the initialisation of your custom block, a freshly added block doesn't work in the Page Builder preview.
For example, the [`DOMContentLoaded`](https://developer.mozilla.org/en-US/docs/Web/API/Document/DOMContentLoaded_event) event isn't fired when a block is dragged into the page as the DOM is already loaded.

The Page Builder fires `body` events that you can listen to initialize your block:

* `ibexa-render-block-preview` event is fired when the page is loaded in the Page Builder, when a block is added, when a block is deleted, and when a block setting modification is submitted.
* `ibexa-post-update-blocks-preview` event is fired when a block setting modification is submitted, this event has a `detail` property listing the reloaded modified block IDs and their configs.

In the following code, a same `initCustomBlocks` function is attached to two event listeners.
One listener to call the function when a page is loaded (as a regular front page or as a page edited in the Page Builder).
One to call it when a block is added or configured in the Page Builder.
This `initCustomBlocks` function finds the custom blocks to loop through them, initializes some JavaScript when the block isn't already initialized, and flag the block as initialized.
For example, it could initialize carousel blocks with the addition of event listeners to navigation arrows, and the start of an automatic sliding.

```javascript
document.addEventListener('DOMContentLoaded', function(event) {
    initCustomBlocks();
});
document.getElementsByTagName('body')[0].addEventListener('ibexa-render-block-preview', function(event) {
    initCustomBlocks();
});
```

## Add edit templates

You can also customize the template for the block settings modal.
Do this under the `configuration_template` [configuration key](configuration.md#configuration-files):

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 7) =]]
```

Place the edit template in `templates/themes/<your_theme>/blocks/event/config.html.twig'`:

``` html+twig
[[= include_file('code_samples/page/custom_page_block/templates/themes/standard/blocks/event/config.html.twig') =]]
```
