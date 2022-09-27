---
description: Prepare templates for Page layouts and render Page blocks.
edition: experience
---

# Render a Page

Page is a special Content Type that contains a [Page Field](pagefield.md).

A Page Field is a layout composed of zones. Each zone can contain multiple blocks.

## Render a layout

### Configure layout

The default, built-in Page layout has only one zone.
You can create other layouts in configuration, under the `ibexa_fieldtype_page.layouts` key.

To create a new layout called "Right sidebar", use the following configuration:

``` yaml
[[= include_file('code_samples/front/render_page/config/packages/ibexa_page_fieldtype.yaml', 0, 13) =]]
```

### Add layout template

A layout template renders all the zones of the layout.

Each zone must have a `data-ibexa-zone-id` attribute with the number of the zone.

The best way to display blocks in the zone is to iterate over a blocks array and render the blocks in a loop.
Each block must have the `landing-page__block block_{{ block.type }}` classes and the `data-ibexa-block-id="{{ block.id }}` attribute.

To render the "Right sidebar" layout, add the following template to `templates/themes/my_theme/layouts/sidebar.html.twig`:

``` html+twig hl_lines="5"
[[= include_file('code_samples/front/render_page/templates/themes/my_theme/layouts/sidebar.html.twig') =]]
```

## Render a block

Every built-in Page block has a default template, [which you can override](#override-default-block-templates).
Every Page block can also have multiple other templates.
The editor chooses a template when creating a block in the Page Builder.

### Block configuration

You can add new block templates by using configuration, for example, for the Content List block:

``` yaml
[[= include_file('code_samples/front/render_page/config/packages/ibexa_page_fieldtype.yaml', 0, 1) =]][[= include_file('code_samples/front/render_page/config/packages/ibexa_page_fieldtype.yaml', 13, 19) =]]
```

!!! tip

    Use the same configuration to provide a template for [custom blocks](create_custom_page_block.md) you create.

### Block template

Create the block template file in the provided path, for example, `templates/themes/my_theme/blocks/contentlist.html.twig`:

``` html+twig
[[= include_file('code_samples/front/render_page/templates/themes/my_theme/blocks/contentlist.html.twig') =]]
```

### Override default block templates

To override the default block template, create a new template.
Place it in a path that mirrors the original default template from the bundle folder.
For example:
`templates/bundles/IbexaFieldTypePageBundle/blocks/contentlist.html.twig`.

!!! tip

    To use a different file structure when overriding default templates,
    add an import statement to the template.

    For example, in `templates/bundles/IbexaFieldTypePageBundle/blocks/contentlist.html.twig`:

    ``` html+twig
    {% import 'templates/blocks/contentlist/new_default.html.twig'}
    ```

    Then, place the actual template in the imported file `templates/blocks/contentlist/new_default.html.twig`.
    
