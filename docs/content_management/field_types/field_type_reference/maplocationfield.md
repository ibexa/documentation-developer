# MapLocation field type

This field type represents a geographical location.

As input it expects three values:

- two float values latitude and longitude,
- a string value, corresponding to the name or address of the location.

| Name          | Internal name         | Expected input |
|---------------|-----------------------|----------------|
| `MapLocation` | `ibexa_gmap_location` | `mixed`        |

## Input expectations

| Type    | Example                                                                               |
|---------|---------------------------------------------------------------------------------------|
| `array` | `[ 'latitude' => 59.928732, 'longitude' => 10.777888, 'address' => "Ibexa Nordics" ]` |

### Properties

The Value class of this field type contains the following properties:

| Property     | Type     | Description                                                             |
|--------------|----------|-------------------------------------------------------------------------|
| `$latitude`  | `float`  | This property stores the latitude value of the map location reference.  |
| `$longitude` | `float`  | This property stores the longitude value of the map location reference. |
| `$address`   | `string` | This property stores the address of map location.                       |
