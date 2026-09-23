# Map location field type

This field type represents a geographical location.

| Name         | Field type identifier |
|--------------|-----------------------|
| Map location | `ibexa_gmap_location` |

## Field value

The field value is an object with the following keys, or `null` when the field is empty:

| Key         | Type     | Description                              | Example         |
|-------------|----------|------------------------------------------|-----------------|
| `latitude`  | `float`  | Latitude of the map location reference.  | `59.928732`     |
| `longitude` | `float`  | Longitude of the map location reference. | `10.777888`     |
| `address`   | `string` | Address of the map location.             | `Ibexa Nordics` |

``` json
{
    "fieldDefinitionIdentifier": "location",
    "languageCode": "eng-GB",
    "fieldValue": {
        "latitude": 59.928732,
        "longitude": 10.777888,
        "address": "Ibexa Nordics"
    }
}
```
