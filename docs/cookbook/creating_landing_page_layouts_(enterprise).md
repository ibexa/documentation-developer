# Creating Landing Page layouts (Enterprise)

A Landing Page has a customizable layout with multiple zones where you can place blocks with content.

A clean installation has only one default layout. You can preview more layouts in the Demo bundle.

A Landing Page layout is composed of zones.

### Zone structure

Each zone contains the following parameters:

| Name             | Description                  |
|------------------|------------------------------|
| `zone_id` | Required. A unique zone ID |
| `name`     | Required. Zone name        |

## Layout configuration

The layout is configured in YAML files:

``` yaml
ez_systems_landing_page_field_type:
    layouts:
        sidebar:
            identifier: sidebar
            name: Right sidebar
            description: Main section with sidebar on the right
            thumbnail: assets/images/layouts/sidebar.png
            template: AppBundle:layouts:sidebar.html.twig
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
|{ID}/description|string|Description of layout|Yes|
|{ID}/thumbnail|string|<path> to thumbnail image|Yes|
|{ID}/template|string|<path> to template View For example: `AppBundle:layouts:sidebar.html.twig`</br>`<bundle>:<directory>:<file name>`|Yes|
|{ID}/zones|string|Collection of zones|Yes|
|{ID}/{zone}/zone_id|string|ID of the zone|Yes|
|{ID}/{zone}/name|string|Zone name|Yes|

## Layout template

A layout template will include all zones the layout contains. The zone container must have a `data-studio-zones-container` attribute.

A Zone is a container for blocks. Each zone must have a `data-studio-zone` attribute.
The best way to display blocks in the zone is to iterate over a blocks array and render the blocks in a loop.

``` html
<div data-studio-zones-container>
    <div data-studio-zone="{{ zones[0].id }}">
        {# If a zone with [0] index contains any blocks #}
        {% if zones[0].blocks %}
            {# for each block #}
            {% for block in zones[0].blocks %}
                {# create a new layer with appropriate id #}
                <div class="landing-page__block block_{{ block.type }}">
                    {# render the block by using the "ez_block:renderBlockAction" controller #}
                    {{ render_esi(controller('ez_block:renderBlockAction', {
                            'contentId': contentInfo.id,
                            'blockId': block.id
                        }))
                    }}
                </div>
            {% endfor %}
        {% endif %}
    </div>
    <div data-studio-zone="{{ zones[1].id }}">
        {% if zones[1].blocks %}
            {% for block in zones[1].blocks %}
                <div class="landing-page__block block_{{ block.type }}">
                    {{ render_esi(controller('ez_block:renderBlockAction', {
                            'contentId': contentInfo.id,
                            'blockId': block.id
                        }))
                    }}
                </div>
            {% endfor %}
        {% endif %}
    </div>
</div>
```
