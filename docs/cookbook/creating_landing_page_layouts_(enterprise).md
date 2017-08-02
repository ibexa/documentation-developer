# Creating Landing Page layouts (Enterprise)

## Description

V1.2

A Landing Page has a customizable layout with multiple zones where you can place predefined blocks with content.

By default eZ Enterprise comes with a number of preset layouts. You can, however, add custom layouts with zones to your configuration.

## Solution

### Defining the layout

A Landing Page layout is composed of zones.

#### Zone structure

Each zone contains the following parameters:

| Name             | Description                  |
|------------------|------------------------------|
| &lt;zone\_id&gt; | *Required*. A unique zone ID |
| &lt;name&gt;     | *Required*. Zone name        |

#### Defining a zone layout

You can define a new layout file (e.g. in Twig) for a zone and include it in a Landing page layout.

A Zone is a container for blocks. The best way to display blocks in the zone is to iterate over a blocks array and render the blocks in a loop.

!!! note

    For eZ Enterprise, the `data-studio-zone` attribute is required to allow dropping the Content into specific zones.

``` html
<!--Example zone.html.twig-->
<div data-studio-zone="{{ zones[0].id }}">                                       
    {# If a zone with [0] index contains any blocks #}
    {% if zones[0].blocks %}                                                    
        {# for each block #}
        {% for block in zone[0].blocks %}                                               
            {# create a new layer with appropriate id #}
            <div class="landing-page__block block_{{ block.type }}">            
                {# render the block by using the "ez_block:renderBlockAction" controller #}
                {{ render_esi(controller('ez_block:renderBlockAction', {        
                        {# id of the current content #}
                        'contentId': contentInfo.id,                            
                        {# id of the current block #}
                        'blockId': block.id                                     
                    }))
                }}
            </div>        
        {% endfor %}    
    {% endif %}
</div>
```

### Creating and configuring layouts

In the Demo installation the layout configuration is stored in ezstudio-demo-bundle/Resources/config/default\_layouts.yml:

``` yaml
# Example default_layouts.yml
layouts:
    1:  
        identifier: 1                       
        name: One column
        description: 'One column'
        thumbnail: '/bundles/ezstudiodemo/images/layouts/1.png'
        template: eZStudioDemoBundle:layouts:1.html.twig
        zones:
            first:
                name: First zone

    1_2:
        identifier: 1_2
        name: Two zones in columns, narrow left, wide right
        description: Two zones in columns, narrow left, wide right
        thumbnail: '/bundles/ezstudiodemo/images/layouts/1_2.png'
        template: eZStudioDemoBundle:layouts:1_2.html.twig
        zones:
            first:
                name: First zone
            second:
                name: Second zone

    1_2__1:   
        identifier: 1_2__1
        name: Three zones, two columns, narrow left, wide right in first row and one row
        description: Three zones, two columns, narrow left, wide right in first row and one row
        thumbnail: '/bundles/ezstudiodemo/images/layouts/1_2__1.png'
        template: eZStudioDemoBundle:layouts:1_2__1.html.twig
        zones:
            first:
                name: First zone
            second:
                name: Second zone
            third:
                name: Third zone
```

The following parameters need to be included in the settings of the default\_layouts.yml file:

|Parameter|Type|Description|Required|
|------|------|------|------|
|layouts|string|Layout config root|Yes|
|number|string|Unique key of the layout|Yes|
|{ID}/identifier|string|ID of the Layout|Yes|
|{ID}/name|string|Name of the Layout|Yes|
|{ID}/description|string|Description of Layout|Yes|
|{ID}/thumbnail|string|<path> to thumbnail image|Yes|
|{ID}/template|string|<path> to template View For example: `eZStudioDemoBundle:layouts:1.html.twig`</br>`<bundle>:<directory>:<file name>`|Yes|
|{ID}/zones|string|Collection of zones|Yes|
|{ID}/{zone}/zone_id|string|ID of the zone|Yes|
|{ID}/{zone}/name|string|Zone name|Yes|
