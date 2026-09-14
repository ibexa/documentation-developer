# Country field type

This field type represents one or multiple countries.

| Name      | Internal name   |
|-----------|-----------------|
| `Country` | `ibexa_country` |

## Field value

The field value is an array of [Alpha-2](https://www.iso.org/iso-3166-country-codes.html) country codes, or `null` when the field is empty.

``` json
{
    "fieldDefinitionIdentifier": "country",
    "languageCode": "eng-GB",
    "fieldValue": ["NO", "PL"]
}
```

On input, each entry can be a country Name, Alpha-2, or Alpha-3 code.
The stored and returned value always uses Alpha-2 codes.

## Validation

This field type validates whether multiple countries are allowed by the field definition, and whether the  [Alpha2](https://www.iso.org/iso-3166-country-codes.html) is valid according to the countries configured in [[= product_name =]].

## Settings

The field definition of this field type can be configured with a single option:

| Name         | Type      | Default value | Description                                                                                |
|--------------|-----------|---------------|--------------------------------------------------------------------------------------------|
| `isMultiple` | `boolean` | `false`       | This setting allows (if true) or prohibits (if false) the selection of multiple countries. |

``` json
{
    "fieldSettings": {
        "isMultiple": true
    }
}
```
