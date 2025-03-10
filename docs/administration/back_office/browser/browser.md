---
description: Customize the configuration of the content browser.
---

# Browser

Browsing the content structure and selecting content from the repository uses the module Universal Discovery Widget (UDW).
UDW has an interactive interface which allows you to create, move or copy content items.

## Using UDW

UDW requires that you provide configuration by using the `ibexa_udw_config` Twig helper.
This configuration must be spread to the props of the component itself.

```html+twig
<button data-udw-config="{{ ibexa_udw_config('single') }}">
    Open My UDW
</button>
```

`single` configuration is one of the default configuration provided.
You can also do your [own configuration](#add-new-configuration).

With plain JS:

``` js
const container = document.querySelector('#react-udw');

const config = /* fetch the config somewhere */;
//const config = JSON.parse(document.querySelector('.btn-udw-trigger).dataset.udwConfig);

ReactDOM.render(React.createElement(ibexa.modules.UniversalDiscovery, {
    onConfirm: {Function},
    onCancel: {Function},
    ...config
}), container);
```

With JSX:

``` jsx
const props = {
    onConfirm: {Function},
    onCancel: {Function}
};
const config = /* fetch the config somewhere */;

<UniversalDiscoveryModule {...props} {...config} />
```

## UDW configuration

You can configure UDW under the `ibexa.system.<scope>.universal_discovery_widget_module.configuration` [configuration key](configuration.md#configuration-files).

There you can set the following properties:

|YML</br>React props|Values|Required|Definition|
|-------------------|------|--------|----------|
|multiple</br>`multiple`|true</br>false|no|The possibility to choose multiple locations.|
|multiple_items_limit</br>`multipleItemsLimit`|number|no|Maximum number of items with configuration `multiple: true`.|
|root_location_id</br>`rootLocationId`|number|no|UDW displays locations only below this content tree element.|
|starting_location_id</br>`startingLocationId`|number|no|This location is displayed as a starting location in UDW.|
|containers_only</br>`containersOnly`|true</br>false|no|When set to `true` only containers can be selected.|
|allowed_content_types</br>`allowedContentTypes`|null</br>[]</br>[`contentTypeIdentifier`]|yes|List of allowed content types:</br>`null` – all content types are allowed,</br>`[]` – empty table, no content types are allowed.|
|active_sort_clause</br>`activeSortClause`|DatePublished</br>ContentName|no|Sort Clause by which children in the content tree is sorted.|
|active_sort_order</br>`activeSortOrder`|ascending</br>descending|no|Sorting order of the children in the content tree.|
|active_tab</br>`activeTab`|browse</br>search</br>bookmarks|no|Starting tab in the UDW.|
|active_view</br>`activeView`|finder</br>grid</br>tree|no|Starting view in the UDW.|
|allow_redirects</br>`allowRedirects`|true</br>false|yes|Allows to redirect content from the UDW tab to another page, for example, to content edit page.|
|selected_locations</br>`selectedLocations`|[]</br>[locationId]|no|Location that is selected automatically.|
|allow_confirmation</br>`allowConfirmation`|true</br>false|yes|Shows confirmations buttons in the UDW. If set to false, it's not possible to confirm selection.|

### Content on the Fly group

|YML</br>React props|Values|Required|Definition|
|-------------------|------|--------|----------|
|allowed_languages</br>`allowedLanguages`|null</br>[]</br>[languageCode]|yes|Languages available in Content on the Fly:</br>`null` - all,</br>`[]` - none.|
|allowed_locations</br>`allowedLocations`|null</br>[]</br>[locationId]|yes|Location under which creating content is allowed:</br>`null` - everywhere,</br>`[]` - nowhere.|
|preselected_language</br>`preselectedLanguage`|null</br>languageCode|yes|First language on the Content on the Fly language list:</br>null - language order defined in the system.|
|preselected_content_type</br>`preselectedContentType`|null</br>contentTypeIdentifier|yes|Content selected in Content on the Fly.|
|hidden</br>`hidden`|true</br>false|yes|Content on the Fly visibility.|
|auto_confirm_after_publish</br>`autoConfirmAfterPublish`|true</br>false|yes|If set to `true` UDW is automatically closed after publishing the content.|

### Tabs config group

General configuration for tabs, for example, browse, search, bookmarks.

|YML</br>React props|Values|Required|Definition|
|-------------------|------|--------|----------|
|items_per_page</br>`itemsPerPage`|number|yes|Number of items shown on one page.|
|priority</br>`priority`|number|yes|Priority of items shown in the tab list. Item with a highest value is displayed as first.|
|hidden</br>`hidden`|true</br>false|yes|Hides or reveals specific tabs.|

### Configuration available only through JS

|React props|Values|Required|Definition|
|-----------|------|--------|----------|
|`onConfirm`|function|yes|A callback to be invoked when a user clicks the confirm button in a Universal Discovery Widget.|
|`onCancel`|function|yes|A callback to be invoked when a user clicks the cancel button in a Universal Discovery Widget.|
|`title`|string|yes|The title of Universal Discovery Widget.|

UDW configuration is SiteAccess-aware. For each defined SiteAccess, you need to be able to use the same configuration tree to define SiteAccess-specific config.
These settings need to be mapped to SiteAccess-aware internal parameters that you can retrieve with the [ConfigResolver](dynamic_configuration.md#configresolver).

## Add new configuration

UDW configuration can change dynamically depending on occurring events.
You can use it, for example, to define which content should be exposed to a user after logging in.

By default, only one element from configuration file is applied to Universal Discovery Widget.
You can modify it dynamically by passing context to generate configuration based on a specific event.
This context event is caught by event listener `ConfigResolveEvent::NAME` before the original configuration is used.
Depending on what additional parameters are provided, original or event-specific configuration is applied.

In the example below `my_custom_udw` is used as a base configuration element for the following steps:

```yaml
ibexa:
    system:
        <siteaccess|siteaccess_group>:
            universal_discovery_widget_module:
                configuration:
                    my_custom_udw:
                        multiple: false
```

### Add new configuration to button

In the `ibexa_udw_config` Twig helper, define a specific part of YAML configuration that is used to render the **Content Browser**.
You can find Twig helper in your button template.
In the example below, a key is pointing to `my_custom_udw` configuration and has additional parameter `johndoe`.

```html+twig
<button class="btn btn-primary open-my-custom-udw" data-udw-config="{{
    ibexa_udw_config('my_custom_udw', {
	    'some_contextual_parameter': 'johndoe'
	}
) }}">
    Open My UDW
</button>
```

### Additional parameters

If an event listener catches additional parameters passed with context, it uses a configuration specified for it in the event subscriber.

In the example below, the `johndoe` parameter enables the user to choose multiple items from a **Browser window** by changing `multiple: false` from `my_custom_udw` configuration to `multiple: true`.

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
     * @param \Ibexa\AdminUi\UniversalDiscovery\Event $event
     */
    public function onUdwConfigResolve(ConfigResolveEvent $event)
    {
        if ($event->getConfigName() !== self::CONFIGURATION_NAME) {
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

For more information, see [Symfony Doctrine Event Listeners and Subscribers tutorial]([[= symfony_doc =]]/event_dispatcher.html#creating-an-event-subscriber).
