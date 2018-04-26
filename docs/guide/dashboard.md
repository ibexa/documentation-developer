# Extending the Dashboard

eZ Platform contains a Dashboard which shows the user the most relevant Content items divided into blocks for a quick overview.

You can remove existing built-in blocks from the Dashboard and extend it with new ones.

Adding Dashboard blocks can be done in four steps:

1. [Create a block view](#create-a-block-view)
1. [Create a template](#create-a-template)
1. [Create a plugin for the view](#create-a-plugin-for-the-view)
1. [Add modules to configuration](#add-modules-to-configuration)

## Create a block view

The first step is creating a view that will be added to the Dashboard. You can do it based on the Dashboard Block Asynchronous View. Then you only provide the data to display in the table.

Using the Dashboard Block Asynchronous View you set an `identifier` of the block. The asynchronous view fires the `_fireLoadDataEvent` method to get the data. The data must find itself in an array with the `items` attribute.

If you want to create a completely different view, without a table, you can use the Dashboard Block Base View.

In the example below an `images` block is defined which looks up all content under the `/images/` folder in the tree:

``` php
YUI.add('ezs-dashboardblockimagesview', function (Y) {
    'use strict';
    /**
     * Provides the Dashboard Images Block View class
     *
     * @module ez-dashboardblockimagesview
     */
    Y.namespace('eZS');
    var BLOCK_IDENTIFIER = 'images';
    /**
     * The dashboard images block view
     *
     * @namespace eZS
     * @class DashboardBlockImagesView
     * @constructor
     * @extends eZ.DashboardBlockAsynchronousView
     */
    Y.eZS.DashboardBlockImagesView = Y.Base.create('dashboardBlockImagesView', Y.eZ.DashboardBlockAsynchronousView, [], {
        initializer: function () {
            this._set('identifier', BLOCK_IDENTIFIER);
        },
        _fireLoadDataEvent: function () {
            this.fire('locationSearch', {
                viewName: 'images-dashboard',
                resultAttribute: 'items',
                loadContentType: true,
                loadContent: true,
                search: {
                    criteria: {SubtreeCriterion: '/1/43/51/'},
                    limit: 10
                }
            });
        },
        _getTemplateItem: function (item) {
            return {
                content: item.content.toJSON(),
                contentType: item.contentType.toJSON(),
                location: item.location.toJSON(),
                contentInfo: item.location.get('contentInfo').toJSON(),
            };
        },
    });
});
```

In the `_getTemplateItem` method you can specify the structure of the item which will be provided to the template. In the example above each item will be an object with four properties.

If you don't intend to change the structure of the item, there's no need to override this method.

## Create a template

Now create a template for the view, for example:

``` html
<h2 class="ez-block-title">Images</h2>
<div class="ez-block-wrapper ez-asynchronousview">
    {{#if loadingError}}
    <p class="ez-asynchronousview-error ez-font-icon">
        An error occurred while loading the images list.
        <button class="ez-asynchronousview-retry ez-button ez-font-icon pure-button">Retry</button>
    </p>
    {{else}}
    <table class="ez-block-items-table">
        <thead class="ez-block-header">
            <tr>
                <th class="ez-block-head-title">Title</th>
                <th class="ez-block-head-content-type">Content Type</th>
                <th class="ez-block-head-version">Version</th>
                <th class="ez-block-head-modified">Last saved</th>
            </tr>
        </thead>
        <tbody class="ez-block-content">
        {{#each items}}
            <tr class="ez-block-row">
                <td class="ez-block-cell">{{ contentInfo.name }}</td>
                <td class="ez-block-cell">{{ lookup contentType.names contentInfo.mainLanguageCode }}</td>
                <td class="ez-block-cell">{{ contentInfo.currentVersionNo }}</td>
                <td class="ez-block-cell ez-block-cell-options">
                    {{ contentInfo.lastModificationDate }}
                    <div class="ez-block-row-options">
                        <a class="ez-block-option-edit ez-font-icon" href="{{ path "editContent" id=contentInfo.id languageCode=contentInfo.mainLanguageCode }}"></a>
                        <a class="ez-block-option-view ez-font-icon" href="{{ path "viewLocation" id=location.id languageCode=contentInfo.mainLanguageCode }}"></a>
                    </div>
                </td>
            </tr>
        {{/each}}
        </tbody>
    </table>
    {{/if}}
</div>
```

You may notice that the template is prepared to handle the `loadingError`, because the asynchronous view provides it if there are problems with loading data. If no error occurs, a table with basic info about your images will be displayed.

## Create a plugin for the view

The next step is adding the view and the template to the Dashboard. To do this, create a plugin for the Dashboard view.

In the initializer you can use the public `addBlock` method from the Dashboard view. In this method you only have to provide the instance of your view. Here you also set some properties for your new view: `bubbleTargets` to make sure that the events will bubble up to the other views, and `priority` where you can set the order of blocks in the Dashboard (higher number goes first).

``` php
YUI.add('ezs-dashboardblocksplugin', function (Y) {
    'use strict';
    /**
     * The plugin is responsible for adding a new block to the dashboard.
     *
     * @module ezs-dashboardblocksplugin
     */
    Y.namespace('eZS.Plugin');
    Y.eZS.Plugin.DashboardBlocks = Y.Base.create('studioDashboardBlocks', Y.Plugin.Base, [], {
        initializer: function () {
            this.get('host').addBlock(this.get('imagesBlockView'));
        }
    }, {
        NS: 'studioDashboardBlocks',
        ATTRS: {
            imagesBlockView: {
                valueFn : function () {
                    return new Y.eZS.DashboardBlockImagesView({
                        bubbleTargets: this.get('host'),
                        priority: 500
                    });
                }
            }
        }
    });
    Y.eZ.PluginRegistry.registerPlugin(
        Y.eZS.Plugin.DashboardBlocks, ['dashboardBlocksView']
    );
});
```

If you want to remove a block, use another public method, `removeBlock`, and provide it with just the block identifier.

## Add modules to configuration

The last thing to do is add the new modules to the yml configuration:

``` yaml
ezs-dashboardblocksplugin:
    requires:
        - 'plugin'
        - 'base'
        - 'ez-pluginregistry'
        - 'ezs-dashboardblockimagesview'
    dependencyOf: ['ez-dashboardblocksview']
    path: %ezstudioui.public_dir%/js/views/services/plugins/ezs-dashboardblocksplugin.js
ezs-dashboardblockimagesview:
    requires:
        - 'ez-dashboardblockasynchronousview'
        - 'dashboardblockimagesview-ez-template'
    path: %ezstudioui.public_dir%/js/views/ezs-dashboardblockimagesview.js
dashboardblockimagesview-ez-template:
    type: 'template'
    path: %ezstudioui.public_dir%/templates/dashboardblock-images.hbt
```

In this example the plugin is added as a dependency of the Dashboard block view, requiring the new images block view. The Dashboard images view in turn requires the asynchronous view.

After this configuration is complete the Dashboard should display the new block.
