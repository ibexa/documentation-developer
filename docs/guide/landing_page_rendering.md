# Landing Page rendering

!!! enterprise

    ### Landing Page layouts

    A Landing Page has a customizable layout with multiple zones where you can place blocks with content.

    A clean installation has only one default layout. You can preview more layouts in the Demo bundle.

    A Landing Page layout is composed of zones.

    ##### Zone structure

    Each zone contains the following parameters:

    | Name             | Description                  |
    |------------------|------------------------------|
    | `zone_id` | Required. A unique zone ID |
    | `name`     | Required. Zone name        |

    #### Layout configuration

    The layout is configured in YAML files:

    ``` yaml
    ez_systems_landing_page_field_type:
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

    #### Layout template

    A layout template will include all zones the layout contains. The zone container must have a `data-studio-zones-container` attribute.

    A Zone is a container for blocks. Each zone must have a `data-studio-zone` attribute.
    The best way to display blocks in the zone is to iterate over a blocks array and render the blocks in a loop.

    ``` html
    <div data-studio-zones-container>
        <div data-studio-zone="{{ zones[0].id }}">
            {# If the first zone (with index [0]) contains any blocks #}
            {% if zones[0].blocks %}
                {# for each block #}
                {% for block in zones[0].blocks %}
                    {# create a new layer with appropriate id #}
                    {# the div's class takes the type of the block that is placed in it #}
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
            {# Repeat the same for the second zone, with index [1] #}
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

    ### Landing Page template
    Once published, a Landing Page will be displayed using the template according to the `content_view` setting, see [View Matchers](content_rendering.md#view-matchers). If you want to see the Landing Page displayed using a particular template in the edit mode of Landing Page Editor before publish, you need to configure the following additional settings in `ezplatform.yml` configuration file.

    ``` yml
    ezstudioui:
        system:
            # Defines the scope: a valid SiteAccess, SiteAccess group or even "global"
            front_siteaccess:
                studio_template: AppBundle:studio:template.html.twig
    ```

    This is an example of a minimal template file:

    ``` html
    {% extends base_template() %}
    {% block content %}

        <!-- Custom template header code -->

        <!-- This part is required! -->
        {% if content is defined %}
            {{ ez_render_field(content, 'page') }}
        {% else %}
            <div data-area="static" style="min-height:300px;"></div>
        {% endif %}
        <!-- End required part -->

        <!-- Rest of the custom template code -->

    {% endblock %}
    ```

        !!! caution
        Custom template always needs to extend `base_template()`. Morevoer, you have to check whether the `content` variable is defined to correctly display a previously published Landing Page. Otherwise, you need to display `<div data-area="static"></div>` which is the place where you can put the new blocks.

    ### Landing Page blocks

    By default eZ Enterprise comes with a number of preset Landing Page blocks. You can, however, add custom blocks to your configuration. There are two ways to do this: the full way and an [easier, YAML-based method](#defining-landing-page-blocks-in-the-configuration-file).

    #### Block Class

    The class for the block must implement the `BlockType` interface:

    ``` php
    EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockType
    ```

    Most methods are implemented in a universal way by using the `AbstractBlockType` abstract class:

    ``` php
    EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType
    ```

    If your block does not have specific attributes or a structure, you can extend the `AbstractBlockType` class, which contains simple generic converters designated for the block attributes.

    For example:

    ``` php
    <?php
    namespace AcmeBundle\Block;

    use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType;

    class ExampleBlock extends AbstractBlockType
    {
       // Class body
    }
    ```

    ##### Class definition

    A block **must** have a definition set using two classes:

    ###### BlockDefinition

    The `BlockDefinition` class describes a block:

    |Attribute|Type|Definition|
    |------|------|------|
    |$type|string|block type|
    |$name|string|block name|
    |$category|string|block category|
    |$thumbnail|string|path to block thumbnail image|
    |$templates|array|array of available paths of templates</br>See [Block templates](#block-templates) below|
    |$attributes|array|array of block attributes (objects of `BlockAttributeDefinition` class)|

    ###### BlockAttributeDefinition

    The `BlockAttributeDefinition` class defines the attributes of a block:

    |Attribute|Type|Definition|
    |------|------|------|
    |`$id`|string|block attribute ID|
    |`$name`|string|block attribute name|
    |`$type`|string|block attribute type, available options are:</br>`integer`</br>`string`</br>`url`</br>`text`</br>`embed`</br>`select`</br>`multiple`</br>`radio`|
    |`$regex`|string|block attribute regex used for validation|
    |`$regexErrorMessage`|string|message displayed when regex does not match|
    |`$required`|bool|`TRUE` if attribute is required|
    |`$inline`|bool|indicates whether block attribute input should be rendered inline in a form|
    |`$values`|array|array of chosen values|
    |`$options`|array|array of available options|

    ##### Class methods

    When extending `AbstractBlockType` you **must** implement at least 3 methods:

    ###### `createBlockDefinition()`

    This method must return an `EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition` object.

    Example of the built-in Gallery block:

    ``` php
    public function createBlockDefinition()
    {
        return new BlockDefinition(
            'gallery',
            'Gallery Block',
            'default',
            'bundles/ezsystemslandingpagefieldtype/images/thumbnails/gallery.svg',
            [],
            [
                new BlockAttributeDefinition(
                    'contentId',
                    'Folder',
                    'embed',
                    '/^([a-zA-Z]:)?(\/[a-zA-Z0-9_\/-]+)+\/?/',
                    'Choose an image folder'
                ),
            ]
        );
    }
    ```

    ###### `getTemplateParameters(BlockValue $blockValue)`

    This method returns an array of parameters to be displayed in rendered view of block. You can access them directly in a block template (e. g. via twig `{{ title }}` ).

    When parameters are used in the template you call them directly without the `parameters` array name:

    | Correct | Not Correct |
    |---------|-------------|
    | `<h1>{{ title }}</h1>` | `<h1>{{ parameters.title }}</h1>` |

    `getTemplateParameters()` method implementation using the example of the built-in RSS block:

    ``` php
    public function getTemplateParameters(BlockValue $blockValue)
    {
        $attributes = $blockValue->getAttributes();
        $limit = (isset($attributes['limit'])) ? $attributes['limit'] : 10;
        $offset = (isset($attributes['offset'])) ? $attributes['offset'] : 0;
        $parameters = [
            'title' => $attributes['title'],
            'limit' => $limit,
            'offset' => $offset,
            'feeds' => $this->RssProvider->getFeeds($attributes['url']),
        ];

        return $parameters;
    }
    ```

    ###### `checkAttributesStructure(array $attributes)`

    This method validates the input fields for a block. You can specify your own conditions to throw the `InvalidBlockAttributeException` exception.

    This `InvalidBlockAttributeException` exception has the following parameters:

    | Name           | Description                                            |
    |----------------|--------------------------------------------------------|
    |  `blockType` |  name of a block                                       |
    |  `attribute` |  name of the block's attribute which failed validation |
    |  `message`   |  a short information about an error                    |
    |  `previous`  |  previous exception, null by default                   |

    For example to validate an RSS block:

    ``` php
    public function checkAttributesStructure(array $attributes)
    {
        if (!isset($attributes['url'])) {
            throw new InvalidBlockAttributeException('RSS', 'url', 'URL must be set.');
        }

        if (isset($attributes['limit']) && (($attributes['limit'] < 1) || (!is_numeric($attributes['limit'])))) {
            throw new InvalidBlockAttributeException('RSS', 'limit', 'Limit must be a number greater than 0.');
        }

        if (isset($attributes['offset']) && (($attributes['offset'] < 0) || (!is_numeric($attributes['limit'])))) {
            throw new InvalidBlockAttributeException('RSS', 'offset', 'Offset must be a number no less than 0.');
        }
    }
    ```

    #### Adding the class to the container

    The **services.yml** file must contain info about your block class.

    The description of your class must contain a tag which provides:

    - tag name: `landing_page_field_type.block_type`
    - tag alias: `<name of a block>`

    For example:

    ``` yaml
    # service id
    acme.block.example:
        # block's class with namespace
        class: AcmeBundle\Block\ExampleBlock
        tags:
            # service definition must contain tag with
            # "landing_page_field_type.block_type" name and block name as an alias
            - { name: landing_page_field_type.block_type, alias: example}
    ```

    #### Block templates

    The templates for the new blocks are configured in your YAML config.

    ``` yaml
    blocks:
        example:
            views:
                test:
                    template: AcmeBundle:blocks:example.html.twig
                    name: Example Block View
    ```

    #### Example

    For a full working example of creating a new Landing Page block, see [step 4 of the Enterprise tutorial](../tutorials/enterprise_beginner/4_create_a_custom_block.md).

    !!! tip

        If you want to make sure that your block is only available in the Element menu in a specific situation, you can override the `isAvailable` method, which makes the block accessible by default:

        ``` php
        public function isAvailable()
            {
                return true;
            }
        ```

    #### Custom editing UI

    If you want to add a custom editing UI to your new block, you need to provide the code for the custom popup UI in Javascript (see the code for `ezs-scheduleblockview.js` or `ezs-tagblockview.js` in the StudioUIBundle in your installation for examples).

    Once it is ready, create a plugin for `eZS.LandingPageCreatorView` that makes a use of the `addBlock` public method from `eZS.LandingPageCreatorView`, see the example below:

    ``` php
    YUI.add('ezs-addcustomblockplugin', function (Y) {
        'use strict';

        var namespace = 'Any.Namespace.Of.Your.Choice',

        Y.namespace(namespace);
        NS = Y[namespace];

        NS.Plugin.AddCustomBlock = Y.Base.create('addCustomBlockPlugin', Y.Plugin.Base, [], {
            initializer: function () {
                this.get('host').addBlock('custom', NS.CustomBlockView);
            },
        }, {
            NS: 'dashboardPlugin'
        });

        Y.eZ.PluginRegistry.registerPlugin(
            NS.Plugin.AddCustomBlock, ['landingPageCreatorView']
        );
    });
    ```

    #### Defining Landing Page blocks in the configuration file

    There is a faster and simpler way to create Landing Page block types
    using only the YAML configuration in an application or a bundle, under the `ez_systems_landing_page_field_type` key.

    ``` yaml
    ez_systems_landing_page_field_type:
        blocks:
            example_block:
                initialize: true
                name: Example Block
                category: default
                thumbnail: bundles/ezsystemslandingpageblocktemplate/images/templateblock.svg
                views:
                    default:
                        template: blocks/template.html.twig
                        name: Default view
                    special:
                        template: blocks/special_template.html.twig
                        name: Special view
                attributes:
                    handle:
                        type: text
                        regex: /[\s]/
                        regexErrorMessage: Invalid text
                        required: true
                        inline: false
                        values: []
                        options: []
                    flavor:
                        type: multiple
                        required: true
                        inline: false
                        values: [value2]
                        options:
                            value1: vanilla
                            value2: chocolate
    ```

    !!! tip

        Configuration keys have to match `BlockDefinition` and `BlockAttributeDefinition` property names.

    Below you can find a few important notes:

    - You can omit the `name` attribute. Values are going to be generated automatically in the following fashion: `new_value` =&gt; `New Value`
    - `category` is not in use - it will be implemented in the future.
    - In most cases blocks have only a single view, therefore you can define it as: `views: EzSystemsLandingPageBlockTemplateBundle::template.html.twig`.
    - In case of multiple views you can omit `name` and simplify it as follows:

    ``` yaml
    views:
        default: blocks/template.html.twig
        special: blocks/special_template.html.twig
    ```

    - When defining attributes you can omit most keys as long as you use simple types:

    ``` yaml
    attributes:
        first_field: text
        second_field: string
        third_field: integer
    ```

    Keep in mind that other types such as `multiple`, `select`, `radio` have to use the `options` key.

    ###### Block type class and service

    If `intialize` is set to` true`, you no longer have to register a service associated with the new block.
    It will use a generic service which exposes all attribute values to the views.

    You can overwrite the `ez_systems.landing_page.block.{NEW_BLOCK_IDENTIFIER}` service with your own implementation.
    Just make sure your class extends the `ConfigurableBlockType` class.

    Some hints regarding custom service implementation:

    - do not override the `createBlockDefinition()` method unless you want to make further modifications to the `\EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition` object created from your YAML config. Do not forget to run `parent::createBlockDefinition()` to retrieve the original object.
    - implement other methods such as `checkAttributesStructure()` and `getTemplateParameters()` to provide more complex validation and implement the block functionality.

    ###### Overwriting existing blocks

    You can overwrite following properties in the existing blocks:

    - `thumbnail`
    - `name`
    - `category`
    - `views`

    !!! caution

        It is not possible to overwrite or add any attributes to existing blocks as there is no possibility to modify BlockType implementation, and therefore to use or display those new attributes.

    `\EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType::isFinal` indicates whether the block can be overwritten by the configuration. All blocks can be overwritten by default. 

    ### Schedule block

    Schedule block is an Enterprise-only feature that enables you to plan content to be published at a predetermined time in the future.

    Schedule blocks are placed on a Landing Page and can be configured like any other block. This includes providing different templates for the editor to choose in the Studio UI.

    A Schedule block consists of a number of slots. Each slot can hold one Content item.

    The number of slots and their order is defined in the template. A template for a Schedule block must include the `data-studio-slots-container` and `data-studio-slot` attributes to enable placing Content in the slots.

    #### Behavior

    ![Schedule block slot with options](img/schedule_block_slot_options.png "Schedule block slot with options")

    You can preview the content added to a Schedule block in full, as it is viewed in PlatformUI, by activating the **Preview** button.

    When content is added to the block, it is initially assigned an airtime equal to the current time. The airtime can then be changed to a date and time in the future. Content items are ordered in the block according to the airtime. When you add more items to a block than there are slots, oldest content (i.e., with earliest airtime), is pushed off the block.

    A Schedule block tracks all content that is added, deleted and pushed off it. In the back office (both in View and Edit mode) you can see all activity (adding, deleting or overflow) in a block using the timeline at the top of the editor. Colored stripes on the timeline indicate when any change to the block happens. You can select the stripe to see the details of the changes.

    **Full list** in the timeline bar gives you access to all changes. When you view it in Edit mode, it displays all changes in the selected Schedule block; when you select the list in View mode, you will see all changes in all blocks on the page.

    Overflow enables you to combine multiple Schedule blocks in one flow. It is set up in the editor. Overflow defines what happens with content that is pushed off a full block.

    ![Schedule block with overflow options](img/schedule_with_overflow.png "Schedule block with overflow options")

    Each Schedule block that has overflow enabled can have one target block defined. When a Content item is pushed off the block, it will overflow to the designated block. In target block the items will be ordered according to the original airtime, not the order in which they were overflown.

    You can connect more than two Schedule blocks in this way, one after the other. It is also possible for multiple Schedule blocks to overflow into one. However, it is not possible to build a circular overflow (where a sequence of overflowing items eventually points to the original block). This is disabled in the UI.

    The **Remove item** action removes the item from the block (but does not delete the Content item itself. Deleting a Content item is possible from Content structure). When an item is removed, other content is pulled back to fill its place. This also happens to content that has already been pushed off the block – it will be pulled back even from a target overflow block.

    ##### Special Schedule block use cases

    - **Enabling and disabling overflow.** When you disable overflow, items which have already overflown to a target block will be removed from preview, but will stay in the history of the source block. If some items have already been pushed off a block and you enable overflow on it afterwards, the moved items will still overflow to the target block. When the target block of overflow is deleted, overflow will turn off automatically.

    - **Multi-block configuration.** You can have more than one block overflow to a single target block. Content items will remember their history. This means that if content is removed in the source blocks, items will be pulled back into their original blocks.

    - **Multiple copies of the same Content item.** You cannot add the same Content item multiple times to the same Schedule block. If two copies would end up in the same block, e.g. as a result of overflow, the older copy will be removed.

    ###### Example

    A typical example of using a Schedule block is a "Featured" articles block which overflows to a regular "List" of articles.

    A multi-block setup can be used to collect items from two blocks into one list. In the example below two featured blocks at the top, "Places" and "Tastes", both overflow to a single list, where content is ordered according to its airtime:

    ![Schedule block example with multiple blocks](img/schedule_block_example.png "Schedule block example with multiple blocks")
