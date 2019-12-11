# Extending modules

## Universal Discovery Widget (UDW)

Universal Discovery module allows you to browse the content structure and search for content
using an interactive interface: browse, search, create, and bookmarks view .

### How to use UDW?

With vanilla JS:

``` js
const container = document.querySelector('#react-udw');

ReactDOM.render(React.createElement(eZ.modules.UniversalDiscovery, {
    restInfo: {
        token: {String},
        siteaccess: {String}
    }
    onConfirm: {Function},
    onCancel: {Function},
}), container);
```

With JSX:

``` jsx
const props = {
    onConfirm: {Function},
    onCancel: {Function}
};

<UniversalDiscoveryModule {...props} />
```

### Adding new tabs to the UDW

The Universal Discovery module is highly customizable. It allows you to add new tabs to the module.

``` jsx
const props = {
    onConfirm: {Function},
    onCancel: {Function},
    extraTabs: [{
        id: {String},
        title: {String},
        panel: {Element}, // React component that represents content of a tab
        attrs: {Object}
    }]
};

<UniversalDiscoveryModule {...props} />
```

Each tab definition is an object containing properties:

- **id** _{String}_ - unique tab identifier (it cannot be: `browse` or `search`)
- **title** _{String}_ - tab button title/label
- **panel** _{Element}_ - any kind of React component. A panel component will receive the following props:
    - **isVisible** _{Boolean}_ - visible flag
    - **onItemSelect** _{Function}_ - a callback to be invoked when content is selected
    - **maxHeight** _{Number}_ - the maximum height of the panel container
    - **id** _{String}_ - panel identifier
    - **startingLocationId** _{Number}_ - Location ID
    - **findLocationsByParentLocationId** _{Function}_ - finds Locations related to the parent Location
    - **findContentBySearchQuery** _{Function}_ - finds content matching a given text query
    - **contentTypesMap** _{Object}_ - Content Type map with Content Type IDs as keys
    - **multiple** _{Boolean}_ - can select multiple Content items flag
    - **labels** _{Object}_ - a hash containing text messages to be placed across many places in a component
- **attrs** {Object} - any optional list of props that should applied to the panel component.
It can override the panel props listed above.

### Property list

The `<UniversalDiscoveryModule />` module can handle additional properties.
There are 2 types of properties: **required** and **optional**.

#### Required properties

Without all the following properties the Universal Discovery module will not work.

**onConfirm** _{Function}_ - a callback to be invoked when a user clicks on the confirm button
in a Universal Discovery popup. The function takes one param: `content` which is an array of Content item structs.

**onCancel** _{Function}_ - a callback to be invoked when a user clicks on the cancel button
in a Universal Discovery popup. It takes no extra params.

**restInfo** _{Function}_ - a config hash containing: token (_{String}_) and SiteAccess (_{String}_).

#### Optional props

Optionally, Universal Discovery module can take a following list of props:

- **loadContentInfo** _{Function}_ - loads content info. It takes 3 params: `restInfo`, `contentId` and `callback`
- **loadContentTypes** _{Function}_ - loads Content Type data. It takes 2 params: `restInfo`, `callback`,
- **canSelectContent** _{Function}_ - checks whether a Content item can be selected. It takes one param: a `data` object containing an `item` property as the content struct and `itemsCount` as a number of selected items in UDW,
- **findContentBySearchQuery** _{Function}_ - finds content using a search query. It takes 3 params: `restInfo`, `query` and `callback`,
- **findLocationsByParentLocationId** _{Function}_ - finds sub-items of a given Location. It takes 3 params: `restInfo`, `parentLocationId` and `callback`,
- **title** _{String}_ - the title of Universal Discovery popup. Default value: `Find content`,
- **multiple** _{Boolean}_ - can select multiple content items flag. Default value: `true`,
- **activeTab** _{String}_ - active tab identifier. Default value: `browse`,
- **visibleTabs** _{Array}_ - which UDW tabs are available (e.g. Browse, Search, Create),
- **startingLocationId** _{Number}_ - Location ID. Default value: `1`,
- **maxHeight** _{Number}_ - maximum height of panel container. Default value: `500`,
- **searchResultsPerPage** _{Number}_ - max amount of items visible per page in the search results. Default value: `10`,
- **extraTabs** _{Array}_ - optional, extra tabs. Each tab definition is an object containing the following properties (all of them are required):
    - **id** _{String}_ - unique tab identifier (it cannot be: `browse` or `search`),
    - **title** _{String}_ - tab button title/label,
    - **panel** _{Element}_ - any kind of React component,
    - **attrs** _{Object}_ - any optional list of props that should applied to the panel component.
})),
- **labels** _{Object}_ - a hash containing text messages to be placed across many places in a component. It contains text labels for child components, see [universal.discovery.module.js](https://github.com/ezsystems/ezplatform-admin-ui-modules/blob/master/src/modules/universal-discovery/universal.discovery.module.js#L438) for details,
- **selectedItemsLimit** _{Number}_ - the limit of items that can be selected. Should be combined with the `multiple` attribute set to `true`. Default value is `0`, which means no limit,
- **allowContainersOnly** _{Boolean}_ - when true, only containers can be selected. Default value: `false`,
- **cotfPreselectedLanguage** _{String}_ - language that is preselected in Content on the Fly,
- **cotfAllowedLanguages** _{Array}_ - languages that are available in Content on the Fly,
- **cotfPreselectedContentType** _{String}_ - Content Type that is preselected in Content on the Fly,
- **cotfAllowedContentTypes** _{Array}_ - Content Types that are available in Content on the Fly,
- **allowedContentTypes** _{Array}_ - Content Types that are available in other UDW tabs,
- **cotfPreselectedLocation** _{Number}_ - Location that is preselected in Content on the Fly,
- **cotfAllowedLocations** _{Array}_ - Locations that are available in Content on the Fly

The following props are deprecated:

- **languages** and **contentTypes** are lists of languages and Content Types in the system, read from the application config.

### Configuration

You can configure Universal Discovery module in the [`universal_discovery_widget.yaml`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/config/universal_discovery_widget.yaml) file.
There you can set e.g. the starting location ID, visible tabs, allowed Content Types, search limits, etc.

```yaml
system:
    <siteaccess|siteaccess_group>:
        universal_discovery_widget_module:
            configuration:
                default:
                    starting_location_id: 1
                    visible_tabs: [browse, search, bookmarks]
                    allowed_content_types: []
                    search:
                        results_per_page: 10
                        limit: 50
```

UDW configuration is SiteAccess-aware.
For each defined SiteAccess, you need to be able to use the same configuration tree in order to define SiteAccess-specific config.
These settings need to be mapped to SiteAccess-aware internal parameters that you can retrieve via the ConfigResolver.
For more information on ConfigResolver, see [eZ Platform dynamic configuration basics.](../config_dynamic#configresolver)

#### Adding new configuration

UDW configuration can change dynamically depending on occurring events.
It can be used e.g. for defining which content should be exposed to a user after logging in.

By default only one element from configuration file is applied to Universal Discovery module.
You can modify it dynamically by passing context to generate configuration based on a specific event.
This context event is caught by event listener `ConfigResolveEvent::NAME` before the original configuration is used.
Depending on what additional parameters are provided, original or event-specific configuration is applied.

In the example below `my_custom_udw` is used as a base configuration element for the following steps:

```yaml
ezplatform:
    system:
        <siteaccess|siteaccess_group>:
            universal_discovery_widget_module:
                configuration:
                    my_custom_udw:
                        multiple: false
```

##### Adding new configuration to a button

In the `ez_udw_config` Twig helper define a specific part of YAML configuration that will be used to render the **Content Browser**.
You can find Twig helper in your button template.
In the example below, a key is pointing to `my_custom_udw` configuration and has additional parameter `johndoe`.

```html+twig
<button class="btn btn-primary open-my-custom-udw" data-udw-config="{{
    ez_udw_config('my_custom_udw', {
	    'some_contextual_parameter': 'johndoe'
	}
) }}">
    Open My UDW
</button>
```

##### Additional parameters

If an event listener catches additional parameters passed with context, it will use a configuration specified for it in the event subscriber.

In the example below the `johndoe` parameter enables the user to choose multiple items from a **Browser window** by changing `multiple: false` from `my_custom_udw` configuration to `multiple: true`.

```php hl_lines="29 30 31"
class JohnDoeCanSelectMore implements EventSubscriberInterface
{
    private const CONFIGURATION_NAME = 'my_custom_udw';

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            ConfigResolveEvent::NAME => 'onUdwConfigResolve',
        ];
    }

    /**
     * @param \EzSystems\EzPlatformAdminUi\UniversalDiscovery\Event\ConfigResolveEvent $event
     */
    public function onUdwConfigResolve(ConfigResolveEvent $event)
    {
        if ($event->getConfigName !== self::CONFIGURATION_NAME) {
		    return;
		}

        $config = $event->getConfig();
		$context = $event->getContext();

        if (isset($context['some_contextual_parameter'])) {
			if ($context['some_contextual_parameter'] === 'johndoe') {
			    $config['multiple'] = true;
			}
		}

        $event->setConfig($config);
    }
}
```

For more information follow [Symfony Doctrine Event Listeners and Subscribers tutorial.](https://symfony.com/doc/4.3/event_dispatcher.html#creating-an-event-subscriber)

## Sub-items List

The Sub-items List module is meant to be used as a part of the editorial interface of eZ Platform.
It provides an interface for listing the sub-items of any Location.

!!! caution

    If you want to load the Sub-items module, you need to load the JS code for it in your view,
    as it is not available by default.

### How to use it?

With vanilla JS:

``` js
const containerNode = document.querySelector('#sub-items-container');

    ReactDOM.render(
        React.createElement(eZ.modules.SubItems, {
            parentLocationId: { Number },
            restInfo: {
                token: { String },
                siteaccess: { String }
            }
        }),
        containerNode
    );
```

With JSX:

``` jsx
const attrs = {
    parentLocationId: {Number},
    restInfo: {
        token: {String},
        siteaccess: {String}
    }
};

<SubItemsModule {...attrs}/>
```

### Properties list

The `<SubItemsModule />` module can handle additional properties. There are 2 types of properties: **required** and **optional**. All of them are listed below.

#### Required props

Without all the following properties the Sub-items module will not work.

- **parentLocationId** _{Number}_ - parent Location ID.
- **restInfo** _{Object}_ - backend config object:
    - **token** _{String}_ - CSRF token,
    - **siteaccess** _{String}_ - SiteAccess identifier.
- **handleEditItem** _{Function}_ - callback to handle edit content action.
- **generateLink** _{Function}_ - callback to handle view content action.

#### Optional properties

Optionally, Sub-items module can take a following list of props:

- **loadContentInfo** _{Function}_ - loads Content item info. Takes 2 params:
    - **contentIds** _{Array}_ - list of content IDs
    - **callback** _{Function}_ - a callback invoked when content info is loaded
- **loadContentTypes** _{Function}_ - loads Content Types. Takes one param:
    - **callback** _{Function}_ - callback invoked when Content Types are loaded
- **loadLocation** _{Function}_ - loads Location. Takes 4 params:
    - **restInfo** _{Object}_ - REST info params:
        - **token** _{String}_ - the user token
        - **siteaccess** _{String}_ - the current SiteAccess
    - **queryConfig** _{Object}_ - query config:
        - **locationId** _{Number}_ - Location ID
        - **limit** _{Number}_ - Content item limit
        - **offset** _{Number}_ - items offset
        - **sortClauses** _{Object}_ - the Sort Clauses, e.g. {LocationPriority: 'ascending'}
    - **callback** _{Function}_ - callback invoked when Location is loaded
- **updateLocationPriority** - updates item Location priority. Takes 2 params:
    - **params** _{Object}_ - parameters hash containing:
        - **priority** _{Number}_ - priority value
        - **location** _{String}_ - REST Location ID
        - **token** _{String}_ - CSRF token
        - **siteaccess** _{String}_ - SiteAccess identifier
    - **callback** _{Function}_ - callback invoked when Location priority is updated
- **activeView** _{String}_ - active list view identifier
- **extraActions** _{Array}_ - list of extra actions. Each action is an object containing:
    - **component** _{Element}_ - React component class
    - **attrs** _{Object}_ - additional component properties
- **items** _{Array}_ - list of Location's sub-items
- **limit** _{Number}_ - items limit count
- **offset** _{Number}_ - items limit offset
- **labels** _{Object}_ - list of module labels, see [sub.items.module.js](https://github.com/ezsystems/ezplatform-admin-ui-modules/blob/master/src/modules/sub-items/sub.items.module.js#L371) for details. Contains definitions for sub components:
    - **subItems** _{Object}_ - list of sub-items module labels
    - **tableView** _{Object}_ - list of table view component labels
    - **tableViewItem** _{Object}_ - list of table item view component labels
    - **loadMore** _{Object}_ - list of load more component labels
    - **gridViewItem** _{Object}_ - list of grid item view component labels

## Multi-file Upload

The Multi-file Upload module is meant to be used as a part of editorial interface of eZ Platform.
It provides an interface to publish content based on dropped files while uploading them in the interface.

!!! caution

    If you want to load the Multi-file Upload module, you need to load the JS code for it in your view,
    as it is not available by default.

### How to use it?

With vanilla JS:

``` js
React.createElement(eZ.modules.MultiFileUpload, {
    onAfterUpload: {Function},
    adminUiConfig: {
        multiFileUpload: {
            defaultMappings: [{
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String},
                mimeTypes: [{String}, {String}, ...]
            }],
            fallbackContentType: {
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String}
            },
            locationMappings: [{Object}],
            maxFileSize: {Number}
        },
        token: {String},
        siteaccess: {String}
    },
    parentInfo: {
        contentTypeIdentifier: {String},
        contentTypeId: {Number},
        locationPath: {String},
        language: {String}
    }
});
```

With JSX:

``` jsx
const attrs = {
    onAfterUpload: {Function},
    adminUiConfig: {
        multiFileUpload: {
            defaultMappings: [{
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String},
                mimeTypes: [{String}, {String}, ...]
            }],
            fallbackContentType: {
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String}
            },
            locationMappings: [{Object}],
            maxFileSize: {Number}
        },
        token: {String},
        siteaccess: {String}
    },
    parentInfo: {
        contentTypeIdentifier: {String},
        contentTypeId: {Number},
        locationPath: {String},
        language: {String}
    }
};

<MultiFileUploadModule {...attrs}/>
```

### Properties list

The `<MultiFileUpload />` module can handle additional properties.
There are 2 types of properties: **required** and **optional**. All of them are listed below.

#### Required properties

Without all the following properties the Multi-file Upload will not work.

- **onAfterUpload** _{Function}_ - a callback to be invoked just after a file has been uploaded
- **adminUiConfig** _{Object}_ - UI config object. It should keep the following structure:
    - **multiFileUpload** _{Object}_  - multi file upload module config:
        - **defaultMappings** _{Array}_ - a list of file type to Content Type mappings
        Sample mapping be an object and should follow the convention:
            - **contentTypeIdentifier** _{String}_ - Content Type identifier
            - **contentFieldIdentifier** _{String}_ - Field identifier
            - **nameFieldIdentifier** _{String}_ - name Field identifier
            - **mimeTypes** _{Array}_ - a list of file types assigned to a specific Content Type
        - **fallbackContentType** _{Object}_ - a fallback Content Type definition. Should contain the following info:
            - **contentTypeIdentifier** _{String}_ - Content Type identifier
            - **contentFieldIdentifier** _{String}_ - Field identifier
            - **nameFieldIdentifier** _{String}_ - name Field identifier
        - **locationMappings** _{Array}_ - list of file type to Content Type mappings based on a Location identifier
        - **maxFileSize** {Number} - maximum file size allowed for uploading. It's a number of bytes
    - **token** _{String}_ - CSRF token
    - **siteaccess** _{String}_ - SiteAccess identifier
- **parentInfo** _{Object}_ - parent Location meta information:
    - **contentTypeIdentifier** _{String}_ - Content Type identifier
    - **contentTypeId** _{Number}_ - Content Type ID
    - **locationPath** _{String}_ - Location path string
    - **language** _{String}_ - language code identifier

#### Optional properties

Optionally, the Multi-file Upload module can take a following list of props:

- **checkCanUpload** _{Function}_ - checks whether am uploaded file can be uploaded. The callback takes 4 params:
    - **file** _{File}_ - file object,
    - **parentInfo** _{Object}_ - parent Location meta information,
    - **config** _{Object}_ - Multi-file Upload module config,
    - **callbacks** _{Object}_ - error callbacks list: **fileTypeNotAllowedCallback** and **fileSizeNotAllowedCallback**.
- **createFileStruct** _{Function}_ - a function that creates a _ContentCreate_ struct. The function takes 2 params:
    - **file** _{File}_ - file object,
    - **params** _{Object}_ - params hash containing: **parentInfo** and **adminUiConfig** stored under the **config** key.
- **deleteFile** _{Function}_ - a function deleting content created from a given file. It takes 3 params:
    - **systemInfo** _{Object}_ - hash containing information about CSRF token and SiteAccess: **token** and **siteaccess**,
    - **struct** _{Object}_ - Content struct,
    - **callback** _{Function}_ - content deleted callback.
- **onPopupClose** _{Function}_ - function invoked when closing a Multi-file Upload popup. It takes one param: **itemsUploaded** - the list of uploaded items.
- **publishFile** _{Function}_ - publishes an uploaded file-based Content item. Takes 3 params:
    - **data** _{Object}_ - an object containing information about:
        - **struct** _{Object}_ - the ContentCreate struct (),
        - **token** _{String}_ - CSRF token,
        - **siteaccess** _{String}_ - SiteAccess identifier,
    - **requestEventHandlers** _{Object}_ - a list of upload event handlers:
        - **onloadstart** _{Function}_ - on load start callback,
        - **upload** _{Object}_ - file upload events:
            - **onabort** _{Function}_ - on abort callback,
            - **onload** _{Function}_ - on load callback,
            - **onprogress** _{Function}_ - on progress callback,
            - **ontimeout** _{Function}_ - on timeout callback.
    - **callback** _{Function}_ - a callback invoked when an uploaded file-based content has been published.
