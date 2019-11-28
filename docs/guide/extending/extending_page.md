# Creating custom Page blocks

!!! enterprise

    To create a Page block, use the following YAML configuration in an application or a bundle,
    under the `ezplatform_page_fieldtype` key.

    !!! caution

        Page block configuration is not SiteAccess-aware.

    ``` yaml
    ezplatform_page_fieldtype:
        blocks:
            example_block:
                name: Example Block
                category: default
                thumbnail: assets/images/blocks/exampleblock.svg
                configuration_template: blocks/config.html.twig
                views:
                    default:
                        template: blocks/template.html.twig
                        name: Default view
                        priority: -255
                    special:
                        template: blocks/special_template.html.twig
                        name: Special view
                        priority: 50
                attributes:
                    name:
                        type: text
                        validators:
                            not_blank:
                                message: Please provide a name
                    email:
                        type: string
                        name: E-mail address
                        validators:
                            regexp:
                                options:
                                    pattern: '/^\S+@\S+\.\S+$/'
                                message: Provide a valid e-mail address
                    topics:
                        type: select
                        name: Select topics
                        value: value2
                        options:
                            multiple: true
                            choices:
                                'Sports': value1
                                'Culture': value2
                                'Politics': value3
    ```

    You can define multiple views for a block, with separate templates.

    `priority` defines the order of block views on the block configuration screen.
    The highest number will show first on the list.

    !!! tip

        Default views have a `priority` of -255.
        It's good practice to keep the value between -255 and 255.

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
    |`richtext`|Rich text block (see [creating richtext block](richtext_block.md)|-|
    |`embed`|Embedded Content item|-|
    |`select`|Drop-down with options to select|`choices` lists the available options</br>`multiple`, when set to true allows selecting more than one option.
    |`multiple`|Checkbox(es)|`choices` lists the available options.|
    |`radio`|Radio buttons|`choices` lists the available options.|
    |`locationlist`|Location selection|-|
    |`contenttypelist`|List of Content Types|-|
    |`schedule_events`,</br>`schedule_snapshots`,</br>`schedule_initial_items`,</br>`schedule_slots`,</br>`schedule_loaded_snapshot`|Used in the Content Scheduler block|-|

    When defining attributes you can omit most keys as long as you use simple types that do not require additional options:

    ``` yaml
    attributes:
        first_field: text
        second_field: string
        third_field: integer
    ```

    !!! tip "Hiding blocks"

        To hide a block from the block menu in Page Builder, set its `visible` property to `false`:

        ``` yaml
        example_block:
            # ...
            visible: false
        ```

    #### Custom block attributes

    You can create Page blocks with custom attributes.

    First, define the attribute type.
    You can use one of the types available in `ezplatform-page-fieldtype/src/lib/Form/Type/BlockAttribute/*`.

    You can also use one of the [built-in Symfony types](https://symfony.com/doc/3.4/forms.html), e.g. `AbstractType` for any custom type or `IntegerType` for numeric types.

    To define the type, create a file `src/AppBundle/Block/Attribute/MyStringAttributeType.php` that contains:

    ``` php hl_lines="5 6 15"
    <?php declare(strict_types=1);

    namespace AppBundle\Block\Attribute;

    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\Extension\Core\Type\TextType;

    class MyStringAttributeType extends AbstractType
    {
        public function getParent()
        {
            return TextType::class;
        }

        public function getBlockPrefix()
        {
            return 'my_string_attribute';
        }
    }
    ```

    Note that the attribute uses `AbstractType` (line 5) and `TextType` (line 6).
    Adding `getBlockPrefix` (line 15) returns a unique prefix key for a custom template of the attribute.

    Next, configure a template by creating a `src/AppBundle/Resources/views/custom_form_templates.html.twig` file:

    ``` html+twig
    {% block my_string_attribute_widget %}
        <div style='background: red'>
            <h2>My String</h2>
            {{ form_widget(form) }}
        </div>
    {% endblock %}

    {# more templates here #}
    ```

    Add the template to `Resources/config/ez_field_templates.yml`:

    ``` yaml
    system:
        default:
            field_templates:
                - { template: AppBundle:ezform_field.html.twig, priority: 0 }
    ```

    At this point, the attribute type configuration is complete, but it requires a mapper.
    Depending on the complexity of the type, you can use a `GenericFormTypeMapper` or create your own.

    For a generic mapper, register it as a service by adding:

    ``` yaml
     my_application.block.attribute.my_string:
            class: EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Attribute\FormTypeMapper\GenericFormTypeMapper
            arguments:
                $formTypeClass: AppBundle\Block\Attribute\MyStringAttributeType
            tags:
                - { name: ezplatform.page_builder.attribute_form_type_mapper, alias: my_string }
    ```

    For creating your own mapper, create a class that inherits from `EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Attribute\FormTypeMapper\AttributeFormTypeMapperInterface`.
    Then, register the class along with a tag by creating a `src/AppBundle/Block/Attribute/MyStringAttributeMapper.php` file:

    ``` php
    <?php declare(strict_types=1);

    namespace AppBundle\Block\Attribute;

    use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\BlockAttributeDefinition;
    use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\BlockDefinition;
    use Symfony\Component\Form\FormBuilderInterface;

    class MyStringAttributeMapper implements AttributeFormTypeMapperInterface
    {
        /**
         * @param \Symfony\Component\Form\FormBuilderInterface $formBuilder
         * @param \EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\BlockDefinition $blockDefinition
         * @param \EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\BlockAttributeDefinition $blockAttributeDefinition
         * @param array $constraints
         *
         * @return \Symfony\Component\Form\FormBuilderInterface
         * @throws \Exception
         */
        public function map(
            FormBuilderInterface $formBuilder,
            BlockDefinition $blockDefinition,
            BlockAttributeDefinition $blockAttributeDefinition,
            array $constraints = []
        ): FormBuilderInterface {
            return $formBuilder->create(
                'value',
                MyStringAttributeType::class,
                [
                    'constraints' => $constraints,
                ]
            );
        }
    }
    ```

    The final step is to register your mapper as a service:

    ``` yaml
    AppBundle\Block\Attribute\MyStringAttributeMapper:
            tags:
                - { name: ezplatform.page_builder.attribute_form_type_mapper, alias: my_string }
    ```

    Now, create a block containing your custom attribute:

    ``` yaml hl_lines="9 10 11 12"
    ezplatform_page_fieldtype:
        blocks:
            my_block:
                name: MyBlock
                category: default
                thumbnail: bundles/appbundle/images/thumbnails/my_block.svg
                views:
                    default: { name: Default block layout, template: AppBundle:my_block.html.twig, priority: -255 }
                attributes:
                    my_string_attribute:
                        type: my_string
                        name: MyString

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

    ##### Block configuration template

    The template for the configuration modal of built-in Page blocks is contained in
    `vendor/ezsystems/ezplatform-page-builder/src/bundle/Resources/views/page_builder/block/config.html.twig`.

    You can override it using the `configuration_template` setting:

    ``` yaml
    ezplatform_page_fieldtype:
        blocks:
            example_block:
                name: Example Block
                configuration_template: blocks/config/template.html.twig
                # ...
    ```

    The template can extend the default `config.html.twig` and modify its blocks.
    Blocks `basic_tab_content` and `design_tab_content` correspond to the Basic and Design tabs in the modal.

    The following example wraps all form fields for block attributes in an ordered list:

    ``` html+twig
    {% extends '@EzPlatformPageBuilder/page_builder/block/config.html.twig' %}

    {% block basic_tab_content %}
    <div class="ez-block-config__fields">
        {{ form_row(form.name) }}
        {% if attributes_per_category['default'] is defined %}
            <ol>
            {% for identifier in attributes_per_category['default'] %}
                {% block config_entry %}
                    <li>
                    {{ form_row(form.attributes[identifier]) }}
                    </li>
                {% endblock %}
            {% endfor %}
            </ol>
        {% endif %}
    </div>
    {% endblock %}
    ```

    ##### Exposing content relations from blocks

    Page blocks, for example Embed Block or Collection Block, can embed other Content items.
    Publishing a Page with such blocks creates relations to those Content items.

    When creating a custom block with embeds, you can ensure such relations are created using the block relation collection event.

    The event is dispatched on content publication. You can hook your event listener to one of the events:

    - `\EzSystems\EzPlatformPageFieldType\Event\BlockRelationEvents::COLLECT_BLOCK_RELATIONS` (`ezplatform.ezlandingpage.block.relation`)
    - `ezplatform.ezlandingpage.block.relation.{blockTypeIdentifier}`

    To expose relations, pass an array containing Content IDs to the `\EzSystems\EzPlatformPageFieldType\Event\CollectBlockRelationsEvent::setRelations()` method.

    You don't have to keep track of relations. If embedded Content changes, old relations will be removed automatically.

    Providing relations will also invalidate HTTP cache for your block response in one of the related Content items changes.

    ##### Block render response

    Block responses dispatch their response events which enables you to modify the Response object.
    You can use them for example to change cache headers.

    You can hook into `BlockResponseEvents` events:

    - `BlockResponseEvents::BLOCK_RESPONSE` (`ezplatform.ezlandingpage.block.response`)
    - `ezplatform.ezlandingpage.block.response.{blockTypeIdentifier}`

    Aside from `Request` and `Response` objects it also includes `BlockContext` and `BlockValue` data.

    ## Block templates

    All Page blocks, both those that come out of the box and custom ones, can have multiple templates. This allows you to create different styles for each block and let the editor choose them when adding the block from the UI. The templates are defined in your configuration files like in the following example, with `simplelist` and `special` being the template names:

    ``` yaml
    # app/config/block_templates.yml
    blocks:
        contentlist:
            views:
                simplelist:
                    template: blocks/contentlist_simple.html.twig
                    name: Simple Content List
                special:
                    template: blocks/contentlist_special.html.twig
                    name: Special Content List
    ```

    Some blocks can have slightly more complex configuration. An example is the Collection block, which requires an `options` key.
    This key defines which Content Types can be added to it.

    ``` yaml
    blocks:
        collection:
            views:
                content:
                    template: eZStudioDemoBundle:blocks:collection.content.html.twig
                    name: Content List View
                    options:
                        match: [article, blog_post]
                gallery:
                    template: eZStudioDemoBundle:blocks:collection.content.html.twig
                    name: Gallery View
                    options:
                        match: [image]
    ```

    ## Block definition events

    The following events are available to influence Page block definition:

    - `ezplatform.ezlandingpage.block.definition.{block_identifier}` is called when retrieving block definition. You can use it to influence any definition parameters. This includes the block's attributes. You can, e.g. add or remove some attributes.

    !!! caution

        You need to be careful when removing block attributes. If you modify the attributes of a block used on an existing Page, an error may occur.

    This event serves only to manipulate the block configuration, it does not add any logic to it.

    - `ezplatform.ezlandingpage.block.definition.{block_identifier}.attribute.{block_attribute_identifier}` works like the previous event, but is called for a specific block attribute, not the whole block. You can use it to manipulate attributes, validators, etc.

    The following example shows how the built-in Collection block uses events
    to assign different options to an attribute of a block depending on the selected view:

    ``` php
    <?php

    class CollectionBlockListener implements EventSubscriberInterface
    {
        /**
         * @return array The event names to listen to
         */
        public static function getSubscribedEvents()
        {
            return [
               // ...
               BlockDefinitionEvents::getBlockAttributeDefinitionEventName('collection', 'locationlist') => 'onLocationListAttributeDefinition',
            ];
        }

        // ...

        /**
         * @param BlockAttributeDefinitionEvent $event
         */
        public function onLocationListAttributeDefinition(BlockAttributeDefinitionEvent $event)
        {
            $definition = $event->getDefinition();
            $configuration = $event->getConfiguration();

            $options = $definition->getOptions();
            $options['match'] = $this->getViewMatchConfiguration($configuration);

            $definition->setOptions($options);
        }

        /**
         * @param array $configuration
         *
         * @return array
         */
        private function getViewMatchConfiguration(array $configuration): array
        {
            $list = [];

            foreach ($configuration['views'] as $viewName => $viewConfig) {
                if (!isset($viewConfig['options'])
                    || !isset($viewConfig['options']['match'])
                    || empty($viewConfig['options']['match'])
                ) {
                    $list[$viewName] = [];
                    continue;
                }
                $list[$viewName] = $viewConfig['options']['match'];
            }

            return $list;
        }
    }
    ```

    ## Block rendering events

    The following events are available to influence Page block rendering:

     - `ezplatform.ezlandingpage.block.render.pre` is called before rendering any block.
     - `ezplatform.ezlandingpage.block.render.post` is called after rendering any block.
     - `ezplatform.ezlandingpage.block.render.{block_identifier}.pre` is also called before rendering any block. This event contains the block logic (when needed).

    Example of the built-in Banner block:

    ``` php
    <?php

    class BannerBlockListener implements EventSubscriberInterface
    {
        /** @var \eZ\Publish\API\Repository\ContentService */
        private $contentService;

        /**
         * BannerBlockListener constructor.
         *
         * @param \eZ\Publish\API\Repository\ContentService $contentService
         */
        public function __construct(ContentService $contentService)
        {
            $this->contentService = $contentService;
        }

        /**
         * @return array The event names to listen to
         */
        public static function getSubscribedEvents()
        {
            return [
                BlockRenderEvents::getBlockPreRenderEventName('banner') => 'onBlockPreRender',
            ];
        }

        /**
         * @param \EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Event\PreRenderEvent $event
         *
         * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
         * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
         */
        public function onBlockPreRender(PreRenderEvent $event)
        {
            $blockValue = $event->getBlockValue();
            $renderRequest = $event->getRenderRequest();

            $parameters = $renderRequest->getParameters();

            $contentIdAttribute = $blockValue->getAttribute('contentId');
            $parameters['content'] = $this->contentService->loadContent($contentIdAttribute->getValue());

            $renderRequest->setParameters($parameters);
        }
    }
    ```

    The `onBlockPreRender` method adds `content` to `View` parameters.

    - `ezplatform.ezlandingpage.block.render.{block_identifier}.post` is called after rendering a specific block. It can be used to wrap HTML output.

    ## Extensibility on block creation

    The `customizeNewBlockNode` extension point enables you to manipulate the block preview wrapper node.
    You can use it e.g. to add a custom CSS class or a custom event listener when a new block is created.

    ``` js
    /**
         * Extension point to customize the new block HTML attributes
         *
         * @function customizeNewBlockNode
         * @param {HTMLElement} block
         * @param {Object} meta
         * @param {String} meta.blockType
         * @param {String} meta.pageLayoutIdentifier
         * @param {String} meta.zoneId
         * @returns {HTMLElement}
         */
    window.eZ.pageBuilder.callbacks.customizeNewBlockNode = function (blockNode, meta) {};
    ```

    ## Extensibility on block preview update

    When block preview is updated, JavaScript event `postUpdateBlocksPreview` is fired.
    You can use it to run your own JS scripts, such as reinitializing the work of a slider
    or any other JS-based feature implemented inside your block preview.

    ``` js
    (function () {
        window.document.body.addEventListener('postUpdateBlocksPreview', () => console.log('block updated'), false);
    })();
    ```

    !!! caution "Extending Page Builder configuration"

        If your bundle overrides Page Builder configuration, the bundle must be registered *before*
        `EzPlatformPageFieldTypeBundle()` in `AppKernel.php`.

        Also, `EzPlatformPageFieldTypeBundle()` must be registered *after* `EzPlatformPageBuilderBundle()`.
        Watch out for this if you update bundles selectively:

        ```php
        new Acme\PageBuilderCustomizationBundle\AcmePageBuilderCustomizationBundle(),
        new EzSystems\EzPlatformPageBuilderBundle\EzPlatformPageBuilderBundle(),
        new EzSystems\EzPlatformPageFieldTypeBundle\EzPlatformPageFieldTypeBundle(),
        ```
