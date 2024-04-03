---
description: Create and configure custom Page blocks to add customized content to Pages.
---

# Create custom Page block

In addition to existing blocks which you can use in a Page, you can also create custom blocks.

To do this, add block configuration in a YAML file, under the `ezplatform_page_fieldtype` key,
for example in `config/packages/ezplatform_page_builder.yaml`.

The following example shows how to create a block that showcases an event.

## Configure block

First, add the following YAML configuration:

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 6) =]][[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 16, 47) =]]
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

Each attribute can have [validators](page_block_validators.md).
The `not_blank` validators in the example ensure that the user fills in the two block fields.
The `content_type` validator in the example ensure that the user choose a content item of the content type `event`.
The `regexp` validator ensure that the final value looks like a content ID.

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

Priority of templates indicates the order in which they are presented in Page Builder.
The template with the greatest priority is used as the default one.

## Add edit template

You can also customize the template for the block settings modal.
Do this under the `configuration_template` key:

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 0, 7) =]]
```

Place the edit template in `templates/themes/<your_theme>/blocks/event/config.html.twig`:

``` html+twig
[[= include_file('code_samples/page/custom_page_block/templates/themes/standard/blocks/event/config.html.twig') =]]
```

This example template overrides the `embed` attribute widget to customize the Universal Discovery Widget (UDW).
It adds itself to the `form_templates` and defines a `block_configuration_attribute_embed_widget` block.
The following UDW configuration is used so only an `event` typed content item can be selected:

``` yaml
[[= include_file('code_samples/page/custom_page_block/config/packages/page_blocks.yaml', 48, 57) =]]
```

For more information, see [UDW configuration](extending_udw.md#udw-configuration).

Your custom page block is now ready. 
Before you can use it in Page Builder, you must [enable it in Page field settings]([[= user_doc =]]/content_management/configure_ct_field_settings/#block-display).
