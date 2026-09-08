# Address field type

This field represents and handles address fields.
It allows you to customize address fields per country.

| Name      | Internal name   | Expected input              |
|-----------|-----------------|-----------------------------|
| `Address` | `ibexa_address` | `string`, `string`, `array` |

The Address field type is available via the Address Bundle
provided by the `ibexa/fieldtype-address` package.

## Inputs

| Type     | Description                                   | Example           |
|----------|-----------------------------------------------|-------------------|
| `string` | Name of the address.                          | `My home address` |
| `string` | Country code in ISO 3166-1 alpha-2 format.    | `PL`              |
| `array`  | Additional fields, defined by address format. | see below         |

## Validation

This field type validates whether `Country` and `Name` fields have been filled out.

### Properties

| Property   | Type     | Description                                   |
|------------|----------|-----------------------------------------------|
| `$name`    | `string` | Name of the address.                          |
| `$country` | `string` | Country code in ISO 3166-1 alpha-2 format.    |
| `$fields`  | `array`  | Additional fields, defined by address format. |

## Formats

The following default configuration defines default fields for `personal` address type:

```yaml
formats:
    personal:
        country:
            default:
                - region
                - locality
                - street
                - postal_code
```

### Modifying field configuration

```yaml
formats:
    billing_address:
        country:
            DE:
                - tax_number
                - city
                - address
                - postal_code
```

Adds (or alters) an address format for `DE` country of `billing_address` type.

## Field form types

By default, each field is a simple text input with a label made of field identifier.
To change the type of field, you need to listen to a specific event.
For each field below events are dispatched (in order):

```yaml
ibexa.address.field.{FIELD_IDENTIFIER}
ibexa.address.field.{FIELD_IDENTIFIER}.{ADDRESS_TYPE}
ibexa.address.field.{FIELD_IDENTIFIER}.{ADDRESS_TYPE}.{COUNTRY_CODE}
```

### Example

```yaml
ibexa.address.field.tax_number
ibexa.address.field.tax_number.billing_address
ibexa.address.field.tax_number.billing_address.DE
```
