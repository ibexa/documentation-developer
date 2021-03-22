# MapLocation Field Type

This Field Type represents a geographical location.

As input it expects three values:

- two float values latitude and longitude,
- a string value, corresponding to the name or address of the location.

| Name          | Internal name    | Expected input |
|---------------|------------------|----------------|
| `MapLocation` | `ezgmaplocation` | `mixed`        |

## PHP API Field Type 

### Input expectations

|Type|Example|
|------|------|
|`array`|`[ 'latitude' => 59.928732, 'longitude' => 10.777888, 'address' => "Ibexa Nordics" ]`|

### Value object

##### Properties

The Value class of this Field Type contains the following properties:

|Property|Type|Description|
|------|------|------|
|`$latitude`|`float`|This property stores the latitude value of the map location reference.|
|`$longitude`|`float`|This property stores the longitude value of the map location reference.|
|`$address`|`string`|This property stores the address of map location.|

##### Constructor

The `MapLocation\Value` constructor will initialize a new Value object with values provided as hash. Accepted keys are `latitude` (`float`), `longitude` (`float`), `address` (`string`).

``` php
// Constructor example

// Instantiates a MapLocation Value object
$MapLocationValue = new MapLocation\Value(
                        [
                            'latitude' => 59.928732,
                            'longitude' => 10.777888,
                            'address' => "Ibexa Nordics"
                        ]
                    );
```

## Template rendering

The template called by [the `ez_render_field()` Twig function](../../guide/twig_functions_reference.md#ez_render_field) while rendering a Map Location Field accepts the following parameters:

|Parameter|Type|Default|Description|
|------|------|------|------|
|`draggable`|`boolean`|`true`|Whether to enable a draggable map.|
|`height`|`string|false`|`"200px"`|The height of the rendered map with its unit (for example "200px" or "20em"), set to false to not set any height style inline.|
|`mapType`|`string`|`"ROADMAP"`|[One of the GMap types of map](https://developers.google.com/maps/documentation/javascript/maptypes#BasicMapTypes)|
|`scrollWheel`|`boolean`|`true`| Allows you to disable scroll wheel starting to zoom when mouse comes over the map as user scrolls down a page.|
|`showInfo`|`booolean`|`true`|Whether to show a latitude, longitude and the address outside of the map.|
|`showMap`|`boolean`|`true`|Whether to show a Google Map.|
|`width`|`string|false`|`"500px"`|The width of the rendered map with its unit (for example "500px" or "50em"), set to false to not set any width style inline.|
|`zoom`|`integer`|`13`|The initial zoom level on the map.|

Example:

``` html+twig
{{ ez_render_field(content, 'location', {'parameters': {'width': '100%', 'height': '330px', 'showMap': true, 'showInfo': false}}) }}
```

### Configuration

| Config | SiteAccess/Group-aware | Description |
|--------|-------------------------|-------------|
| `api_keys.google_maps` | yes | Google maps requires the use of an API key for serving maps to web pages. This setting allows you to specify your personal [Google Maps API key](https://developers.google.com/maps/documentation/javascript/get-api-key) used during template rendering. |

Example use:

``` yaml
# ezplatform.yaml
ezplatform:
    system:
        site_group:
            api_keys: { google_maps: MY_KEY }
```

!!! note

    The option to automatically get user coordinates through the "Locate me" button
    is only available when the back office is served through the `https://` protocol.
