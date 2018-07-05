# Extending the Page

!!! enterprise

    ## Block templates

    All Page blocks, both those that come out of the box and [custom ones](page_rendering.md#page-blocks.md), can have multiple templates. This allows you to create different styles for each block and let the editor choose them when adding the block from the UI. The templates are defined in your configuration files like in the following example, with `simplelist` and `special` being the template names:

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
    See [this example from the Studio Demo](https://github.com/ezsystems/ezstudio-demo-bundle/blob/master/Resources/config/default_layouts.yml#L160):

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
    window.eZ.pageBuilder.callbacks.customizeNewBlockNode(node, meta) {};
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
