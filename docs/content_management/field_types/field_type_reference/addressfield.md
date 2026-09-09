# Address field type

This field represents and handles address fields.
It allows you to customize address fields per country.

| Name      | Internal name   | Expected input              |
|-----------|-----------------|-----------------------------|
| `Address` | `ibexa_address` | `string`, `string`, `array` |


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

```
