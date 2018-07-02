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
    window.eZ.pbExtensionPointCallbacks.customizeNewBlockNode = function (blockNode, meta) {};
    ```

    ## Extensibility on block preview update

    When block preview is updated, JavaScript event `postUpdateBlocksPreview` is fired .
    You can use it to run your own JS scripts after block update:

    ``` js
    (function () {
        window.document.body.addEventListener('postUpdateBlocksPreview', () => console.log('block updated'), false);
    })();
    ```
