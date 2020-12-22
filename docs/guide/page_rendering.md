# Page rendering [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

### Page layouts

A Page has a customizable layout with multiple zones where you can place blocks with content.

A clean installation has only one default layout. You can preview more layouts in the Demo bundle.

A Page layout is composed of zones.

##### Zone structure

Each zone contains the following (required) parameters:

| Name             | Description                  |
|------------------|------------------------------|
| `zone_id` |  A unique zone ID |
| `name`     |  Zone name        |

#### Layout configuration

The layout is configured in YAML files:

``` yaml
ezplatform_page_fieldtype:
    layouts:
        sidebar:
            identifier: sidebar
            name: Right sidebar
            description: Main section with sidebar on the right
            thumbnail: /assets/images/layouts/sidebar.png
            template: layouts/sidebar.html.twig
            zones:
                first:
                    name: First zone
                second:
                    name: Second zone
```

The following parameters need to be included in the settings of the configuration:

|Parameter|Type|Description|Required|
|------|------|------|------|
|layouts|string|Layout config root|Yes|
|number|string|Unique key of the layout|Yes|
|{ID}/identifier|string|ID of the layout|Yes|
|{ID}/name|string|Name of the layout|Yes|
|{ID}/description|string|Description of the layout|Yes|
|{ID}/thumbnail|string|<path> to thumbnail image|Yes|
|{ID}/template|string|<path> to template View|Yes|
|{ID}/zones|string|Collection of zones|Yes|
|{ID}/{zone}/zone_id|string|ID of the zone|Yes|
|{ID}/{zone}/name|string|Zone name|Yes|

#### Layout template

A layout template will include all zones the layout contains.

A zone is a container for blocks. Each zone must have a `data-ez-zone-id` attribute.

The best way to display blocks in the zone is to iterate over a blocks array and render the blocks in a loop.
Each block must have the `landing-page__block block_{{ block.type }}` classes and the `data-ez-block-id="{{ block.id }}` attribute (see line 9).

``` html+twig hl_lines="9"
<div>
    <div data-ez-zone-id="{{ zones[0].id }}">
        {# If the first zone (with index [0]) contains any blocks #}
        {% if zones[0].blocks %}
            {# for each block #}
            {% for block in zones[0].blocks %}
                {# create a new layer with appropriate id #}
                {# the div's class takes the type of the block that is placed in it #}
                <div class="landing-page__block block_{{ block.type }}" data-ez-block-id="{{ block.id }}">
                    {# render the block by using the "EzPlatformPageFieldTypeBundle\Controller\BlockController:renderAction" controller #}
                    {{ render_esi(controller('EzPlatformPageFieldTypeBundle\Controller\BlockController:renderAction', {
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
    <div data-ez-zone-id="{{ zones[1].id }}">
        {# Repeat the same for the second zone, with index [1] #}
        {% if zones[1].blocks %}
            {% for block in zones[1].blocks %}
                <div class="landing-page__block block_{{ block.type }}" data-ez-block-id="{{ block.id }}">
                    {{ render_esi(controller('EzPlatformPageFieldTypeBundle\Controller\BlockController:renderAction', {
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

## Block templates

Every built-in Page block has a default template. You can [add new templates](../guide/templates.md) to blocks or override the default ones.

### Adding new block templates

You can add new block templates with the YAML config, for example for the Gallery block:

``` yaml
blocks:
    gallery:
        views:
            special:
                template: blocks/gallery/special.html.twig
                name: Special view
```

### Overriding default block templates

To override the default block template, create a new template.
Place it in a path that mirrors the original default template from the bundle folder.
For example:
`templates/bundles/EzPlatformPageFieldTypeBundle/blocks/gallery.html.twig`.

!!! tip

    To use a different file structure when overriding default templates,
    add an import statement to the template.

    For example, in `/app/Resources/EzPlatformPageFieldTypeBundle/views/blocks/gallery.html.twig`:

    ``` html+twig
    {% import 'app/Resources/views/blocks/gallery/new_default.html.twig'}
    ```

    Then, place the actual template in the imported file `app/Resources/views/blocks/gallery/new_default.html.twig`.
