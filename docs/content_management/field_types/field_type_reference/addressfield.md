# Address field type

This field represents and handles address fields.
It allows you to customize address fields per country.

| Name    | Field type identifier |
|---------|-----------------------|
| Address | `ibexa_address`       |

## Field value

The field value is an object with the following keys:

| Key       | Type     | Description                                                   | Example           |
|-----------|----------|---------------------------------------------------------------|-------------------|
| `name`    | `string` | Name of the address.                                          | `My home address` |
| `country` | `string` | Country code in ISO 3166-1 alpha-2 format.                    | `NO`              |
| `fields`  | `object` | Additional fields, keyed by identifier.                       | See below.        |

The keys available under `fields` depend on the address format configured for the country and on the `type` field definition setting.

``` json
{
    "fieldDefinitionIdentifier": "billing_address",
    "languageCode": "eng-GB",
    "fieldValue": {
        "name": "Headquarters",
        "country": "NO",
        "fields": {
            "region": "Company HQ location region",
            "locality": "Company HQ location city",
            "street": "Company HQ location street and building",
            "postal_code": "00000",
            "email": "company@email.invalid",
            "phone_number": "+47 000 000 000"
        }
    }
}
```

## Validation

This field type doesn't perform any special validation of the input value.
The REST API accepts an address in which `name`, `country`, or both, are `null`.

## Settings

The field definition of this field type can be configured with a single option:

| Name   | Type     | Default value  | Description                                              |
|--------|----------|----------------|------------------------------------------------------------|
| `type` | `string` | `"personal"`   | Identifier of the address format used by this field. |

``` json
{
    "fieldSettings": {
        "type": "personal"
    }
}
```
