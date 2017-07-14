1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Cookbook](Cookbook_31429528.html)

# Creating Landing Page layouts (Enterprise) 

Created by Dominika Kurek, last modified on Jun 22, 2016

# Description

V1.2

A Landing Page has a customizable layout with multiple zones where you can place predefined blocks with content.

By default eZ Enterprise comes with a number of preset layouts. You can, however, add custom layouts with zones to your configuration.

# Solution

## Defining the layout

A Landing Page layout is composed of zones.

### Zone structure

Each zone contains the following parameters: **
**

| Name             | Description                  |
|------------------|------------------------------|
| &lt;zone\_id&gt; | *Required*. A unique zone ID |
| &lt;name&gt;     | *Required*. Zone name        |

### Defining a zone layout

You can define a new layout file (e.g. in Twig) for a zone and include it in a Landing page layout.

A Zone is a container for blocks. The best way to display blocks in the zone is to iterate over a blocks array and render the blocks in a loop.

 For eZ Enterprise, the `data-studio-zone` attribute is required to allow dropping the Content into specific zones.

**Example zone.html.twig**

``` brush:
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

 

## Creating and configuring layouts

In the Demo installation the layout configuration is stored in ezstudio-demo-bundle/Resources/config/default\_layouts.yml:

**Example default\_layouts.yml**

``` brush:
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

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Parameter</th>
<th>Type</th>
<th>Description</th>
<th>Required</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><p><strong>layouts</strong></p></td>
<td>string</td>
<td>Layout config root</td>
<td>Yes</td>
</tr>
<tr class="even">
<td><p><strong>number</strong></p></td>
<td>string</td>
<td>Unique key of the layout</td>
<td>Yes</td>
</tr>
<tr class="odd">
<td><p>{ID}/<strong>identifier</strong></p></td>
<td>string</td>
<td>ID of the Layout</td>
<td>Yes</td>
</tr>
<tr class="even">
<td><p>{ID}/<strong>name</strong></p></td>
<td>string</td>
<td>Name of the Layout</td>
<td>Yes</td>
</tr>
<tr class="odd">
<td><p>{ID}/<strong>description</strong></p></td>
<td>string</td>
<td>Description of Layout</td>
<td>Yes</td>
</tr>
<tr class="even">
<td><p>{ID}/<strong>thumbnail</strong></p></td>
<td>string</td>
<td>&lt;path&gt; to thumbnail image</td>
<td>Yes</td>
</tr>
<tr class="odd">
<td><p>{ID}/<strong>template</strong></p></td>
<td>string</td>
<td><p>&lt;path&gt; to template View</p>
<p>For example:<br />
<em>eZStudioDemoBundle:layouts:1.html.twig</em></p>
<p><em>&lt;bundle&gt;:&lt;directory&gt;:&lt;file name&gt;</em></p></td>
<td>Yes</td>
</tr>
<tr class="even">
<td><p>{ID}/<strong>zones</strong></p></td>
<td>string</td>
<td><p>Collection of zones</p></td>
<td>Yes</td>
</tr>
<tr class="odd">
<td>{ID}/{zone}/<strong>zone_id</strong></td>
<td>string</td>
<td>ID of the zone</td>
<td>Yes</td>
</tr>
<tr class="even">
<td>{ID}/{zone}/<strong>name</strong></td>
<td>string</td>
<td>Zone name</td>
<td>Yes</td>
</tr>
</tbody>
</table>

 

 

#### In this topic:

-   [Description](#CreatingLandingPagelayouts(Enterprise)-Description)
-   [Solution](#CreatingLandingPagelayouts(Enterprise)-Solution)
    -   [Defining the layout](#CreatingLandingPagelayouts(Enterprise)-Definingthelayout)
        -   [Zone structure](#CreatingLandingPagelayouts(Enterprise)-Zonestructure)
        -   [Defining a zone layout](#CreatingLandingPagelayouts(Enterprise)-Definingazonelayout)
    -   [Creating and configuring layouts](#CreatingLandingPagelayouts(Enterprise)-Creatingandconfiguringlayouts)

 

#### Related topics:

[Landing Page Field Type (Enterprise)](31430521.html)

[Creating Landing Page blocks (Enterprise) (old)](https://doc.ez.no/pages/viewpage.action?pageId=31430614)

 






