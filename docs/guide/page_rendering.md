# Page rendering

!!! enterprise

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
                template: AppBundle:layouts:sidebar.html.twig
                zones:
                    first:
                        name: First zone
                    second:
                        name: Second zone
    ```

    The following parameters need to be included in the settings of the [configuration](../guide/best_practices.md#configuration_1):

    |Parameter|Type|Description|Required|
    |------|------|------|------|
    |layouts|string|Layout config root|Yes|
    |number|string|Unique key of the layout|Yes|
    |{ID}/identifier|string|ID of the layout|Yes|
    |{ID}/name|string|Name of the layout|Yes|
    |{ID}/description|string|Description of the layout|Yes|
    |{ID}/thumbnail|string|<path> to thumbnail image|Yes|
    |{ID}/template|string|<path> to template View, for example: `AppBundle:layouts:sidebar.html.twig`</br>`<bundle>:<directory>:<file name>`|Yes|
    |{ID}/zones|string|Collection of zones|Yes|
    |{ID}/{zone}/zone_id|string|ID of the zone|Yes|
    |{ID}/{zone}/name|string|Zone name|Yes|

    #### Layout template

    A layout template will include all zones the layout contains.

    A zone is a container for blocks. Each zone must have a `data-ez-zone-id` attribute.
    The best way to display blocks in the zone is to iterate over a blocks array and render the blocks in a loop.

    ``` html
    <div>
        <div data-ez-zone-id="{{ zones[0].id }}">
            {# If the first zone (with index [0]) contains any blocks #}
            {% if zones[0].blocks %}
                {# for each block #}
                {% for block in zones[0].blocks %}
                    {# create a new layer with appropriate id #}
                    {# the div's class takes the type of the block that is placed in it #}
                    <div class="landing-page__block block_{{ block.type }}" data-ez-block-id="{{ block.id }}">
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
        <div data-ez-zone-id="{{ zones[1].id }}">
            {# Repeat the same for the second zone, with index [1] #}
            {% if zones[1].blocks %}
                {% for block in zones[1].blocks %}
                    <div class="landing-page__block block_{{ block.type }}" data-ez-block-id="{{ block.id }}">
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

    ### Page blocks

    To create a Page block, use the following YAML configuration in an application or a bundle,
    under the `ezplatform_page_fieldtype` key.

    ``` yaml
    ezplatform_page_fieldtype:
        blocks:
            example_block:
                name: 'Example Block'
                thumbnail: 'assets/images/blocks/exampleblock.svg'
                views:
                    default:
                        template: 'blocks/template.html.twig'
                        name: 'Default view'
                    special:
                        template: 'blocks/special_template.html.twig'
                        name: 'Special view'
                attributes:
                    name:
                        type: text
                        validators:
                            not_blank:
                                message: 'Please provide a name'
                    email:
                        type: string
                        name: 'E-mail address'
                        validators:
                            regexp:
                                options:
                                    pattern: '/^\S+@\S+\.\S+$/'
                                message: 'Provide a valid e-mail address'
                    topics:
                        type: select
                        name: 'Select topics'
                        value: value2
                        options:
                            multiple: true
                            choices:
                                value1: 'Sports'
                                value2: 'Culture'
                                value3: 'Politics'
    ```

    You can define multiple views for a block, with separate templates.

    A block has a number of attributes, each with the following properties:

    |||
    |----|----|
    |`type`|Type of attribute.|
    |`name`|The displayed name for the attribute. You can omit it, block identifier will then be used as the name.|
    |`value`|The default value for the attribute.|
    |`validators`|Available validators are `not_blank` and `regexp`.|
    |`options`|Additional options, dependent on the attribute type.|

    Attribute types:

    |Type|Description|Options|
    |----|----|----|
    |`integer`|Intereger value|-|
    |`string`|String|-|
    |`url`|URL|-|
    |`text`|Text block|-|
    |`embed`|Embedded Content item|-|
    |`select`|Drop-down with options to select|`choices` lists the available options</br>`multiple`, when set to true allows selecting more than one option.
    |`multiple`|Checkbox(es)|`choices` lists the available options.|
    |`radio`|Radio buttons|`choices` lists the available options.|

    When defining attributes you can omit most keys as long as you use simple types that do not require additional options:

    ``` yaml
    attributes:
        first_field: text
        second_field: string
        third_field: integer
    ```

    #### Overwriting existing blocks

    You can overwrite following properties in the existing blocks:

    - `thumbnail`
    - `name`
    - `views`

    #### Block configuration modal

    The block configuration modal by default contains two tabs, Basic and Design.

    In Design you can choose the view that will be used for the block and its styling.

    **Class** indicates the CSS class used for this block.
    **Style** defines the CSS rules.

    You can disable the Design tab by setting `ezsettings.default.page_builder.block_styling_enabled` to `false`.
    It is set to `true` by default.
