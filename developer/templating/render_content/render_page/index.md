# Render a page

Prepare templates for page layouts and render page blocks.

Editions: Experience

Page is a special content type that contains a [page field](../../../content_management/field_types/field_type_reference/pagefield/index.md).

A page field is a layout composed of zones. Each zone can contain multiple blocks.

## Render a layout

### Configure layout

The default, built-in page layout has only one zone. You can create other layouts in configuration, under the `ibexa_fieldtype_page.layouts` key.

To create a new layout called "Right sidebar", use the following [configuration](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa_fieldtype_page:
    layouts:
        sidebar:
            identifier: sidebar
            name: Right sidebar
            description: Main section with sidebar on the right
            thumbnail: /assets/images/layouts/sidebar.png
            template: '@ibexadesign/layouts/sidebar.html.twig'
            zones:
                first:
                    name: First zone
                second:
                    name: Second zone
```

### Add layout template

A layout template renders all the zones of the layout.

Each zone must have a `data-ibexa-zone-id` attribute with the number of the zone.

The best way to display blocks in the zone is to iterate over a blocks array and render the blocks in a loop. Each block must have the `landing-page__block block_{{ block.type }}` classes and the `data-ibexa-block-id="{{ block.id }}` attribute.

To render the "Right sidebar" layout, add the following template to `templates/themes/my_theme/layouts/sidebar.html.twig`:

```html+twig
<div>
    <div data-ibexa-zone-id="{{ zones[0].id }}">
        {% if zones[0].blocks %}
            {% for block in zones[0].blocks %}
                <div class="landing-page__block block_{{ block.type }}" data-ibexa-block-id="{{ block.id }}">
                    {{ render_esi(controller('Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction', {
                        'contentId': contentInfo.id,
                        'blockId': block.id,
                        'versionNo': versionInfo.versionNo,
                        'languageCode': field.languageCode
                    }))
                    }}
                </div>
            {% endfor %}
        {% endif %}
    </div>
    <div data-ibexa-zone-id="{{ zones[1].id }}">
        {% if zones[1].blocks %}
            {% for block in zones[1].blocks %}
                <div class="landing-page__block block_{{ block.type }}" data-ibexa-block-id="{{ block.id }}">
                    {{ render_esi(controller('Ibexa\\Bundle\\FieldTypePage\\Controller\\BlockController::renderAction', {
                        'contentId': contentInfo.id,
                        'blockId': block.id,
                        'versionNo': versionInfo.versionNo,
                        'languageCode': field.languageCode
                    }))
                    }}
                </div>
            {% endfor %}
        {% endif %}
    </div>
</div>
```

## Render a block

Every built-in page block has a default template, [which you can override](#override-default-block-templates). Every page block can also have multiple other templates. The editor chooses a template when creating a block in the Page Builder.

> **Caution: Clear the persistence cache**
>
> Persistence cache must be cleared after any modifications have been made to the block config in Page Builder, such as adding, removing or altering the page blocks, block attributes, validators or views configuration.
>
> To clear the persistence cache, run `php bin/console cache:pool:clear <cache-pool>` command. The default cache pool is named `cache.tagaware.filesystem`. The default cache pool when running Redis or Valkey is named `cache.redis`. If you have customized the [persistence cache configuration](../../../infrastructure_and_maintenance/cache/persistence_cache/index.md#what-is-cached), the name of your cache pool might be different.
>
> In prod mode, you also need to clear the symfony cache by running `./bin/console c:c`. In dev mode, the Symfony cache is rebuilt automatically.

### Block configuration

You can add new block templates by using configuration, for example, for the Content List block:

```yaml
ibexa_fieldtype_page:
    blocks:
        contentlist:
            views:
                custom:
                    template: '@ibexadesign/blocks/contentlist.html.twig'
                    name: Custom content list
```

> **Tip: Tip**
>
> Use the same configuration to provide a template for [custom blocks](../../../content_management/pages/create_custom_page_block/index.md) you create.

### Block template

Create the block template file in the provided path, for example, `templates/themes/my_theme/blocks/contentlist.html.twig`:

```html+twig
<div class="block-contentlist {{ block_class }}">
    <h3>{{ parentName }}</h3>
    {% if contentArray|length > 0 %}
        <div class="block-contentlist-items">
            {% for content in contentArray %}
                <div class="block-contentlist-child">
                    <h4><a href="{{ path('ibexa.url.alias', {'locationId': content.location.id}) }}">{{ ibexa_content_name(content.content) }}</a></h4>
                </div>
            {% endfor %}
        </div>
    {% endif %}
</div>
```

### Override default block templates

To override the default block template, create a new template. Place it in a path that mirrors the original default template from the bundle folder. For example: `templates/bundles/IbexaFieldTypePageBundle/blocks/contentlist.html.twig`.

> **Tip: Tip**
>
> To use a different file structure when overriding default templates, add an import statement to the template.
>
> For example, in `templates/bundles/IbexaFieldTypePageBundle/blocks/contentlist.html.twig`:
>
> ```html+twig
> {% import 'templates/blocks/contentlist/new_default.html.twig'}
> ```
>
> Then, place the actual template in the imported file `templates/blocks/contentlist/new_default.html.twig`.
