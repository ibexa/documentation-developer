# Extending Universal Discovery Widget (UDW)

Universal Discovery module allows you to browse the content structure and search for content
using an interactive interface: browse, search, create, and bookmarks view .

## How to use UDW?

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

## Adding new tabs to the UDW

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

## Property list

The `<UniversalDiscoveryModule />` module can handle additional properties.
There are 2 types of properties: **required** and **optional**.

### Required properties

Without all the following properties the Universal Discovery module will not work.

**onConfirm** _{Function}_ - a callback to be invoked when a user clicks on the confirm button
in a Universal Discovery popup. The function takes one param: `content` which is an array of Content item structs.

**onCancel** _{Function}_ - a callback to be invoked when a user clicks on the cancel button
in a Universal Discovery popup. It takes no extra params.

**restInfo** _{Function}_ - a config hash containing: token (_{String}_) and SiteAccess (_{String}_).

### Optional props

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

## Configuration

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

### Adding new configuration

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

#### Adding new configuration to a button

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

#### Additional parameters

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