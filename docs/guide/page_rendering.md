# Page rendering

!!! enterprise

    ### Page layouts

    A Page has a customizable layout with multiple zones where you can place blocks with content.

    A clean installation has only one default layout. You can preview more layouts in the Demo bundle.

    A Page layout is composed of zones.

    ##### Zone structure

    Each zone contains the following parameters:

    | Name             | Description                  |
    |------------------|------------------------------|
    | `zone_id` | Required. A unique zone ID |
    | `name`     | Required. Zone name        |

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
    |{ID}/description|string|Description of layout|Yes|
    |{ID}/thumbnail|string|<path> to thumbnail image|Yes|
    |{ID}/template|string|<path> to template View For example: `AppBundle:layouts:sidebar.html.twig`</br>`<bundle>:<directory>:<file name>`|Yes|
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
                    flavor:
                        type: multiple
                        name: 'Favorite ice cream flavor'
                        value: [value2]
                        options:
                            value1: 'vanilla'
                            value2: 'chocolate'
    ```

    You can define multiple views for a block, with separate templates.

    A block has a number of attributes, each with the following properties:

    |||
    |----|----|
    |`type`|Available attribute types are:</br>- `integer`</br>- `string`</br>- `url`</br>- `text`</br>- `embed`</br>- `select`</br>- `multiple`</br>- `radio`</br>- `contenttypelist`|
    |`name`|The displayed name for the attribute. You can omit it, block identifier will then be used as the name.|
    |`value`|The default value for the attribute.|
    |`validators`|Available validators are `not_blank` and `regexp`.|
    |`options`|Additional options, such as the possible choices in case of `multiple`, `select` or `radio` attribute types.|

    When defining attributes you can omit most keys as long as you use simple types that do not require additional options:

    ``` yaml
    attributes:
        first_field: text
        second_field: string
        third_field: integer
    ```

    ###### Overwriting existing blocks

    You can overwrite following properties in the existing blocks:

    - `thumbnail`
    - `name`
    - `views`
