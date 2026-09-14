# Matrix field type

This field represents and handles a table of rows and columns of data.

| Name     | Internal name  |
|----------|----------------|
| `Matrix` | `ibexa_matrix` |

## Field value

The field value is an object with a single `entries` key, holding an array of rows.
Each row is an object that maps the column identifiers defined in the field definition to cell values.

``` json
{
    "fieldDefinitionIdentifier": "specification",
    "languageCode": "eng-GB",
    "fieldValue": {
        "entries": [
            {
                "col1": "Value 1",
                "col2": "Value 2"
            },
            {
                "col1": "Value 3",
                "col2": "Value 4"
            }
        ]
    }
}
```

## Validation

Validation checks for empty rows.
A row is considered empty if it contains only empty cells (or cells containing only spaces).
Empty rows are removed.

If, after removing empty rows, the number of rows doesn't fulfill the configured `minimum_rows` setting, the field doesn't validate.

## Settings

| Name           | Type      | Default value | Description                                                                     |
|----------------|-----------|---------------|-----------------------------------------------------------------------------------|
| `minimum_rows` | `integer` | `1`           | Minimum number of rows that the field must contain.                             |
| `columns`      | `array`   | `[]`          | Definitions of the columns, each with a unique `identifier` and a `name`. |

``` json
{
    "fieldSettings": {
        "minimum_rows": 1,
        "columns": [
            {
                "identifier": "col1",
                "name": "Column 1"
            },
            {
                "identifier": "col2",
                "name": "Column 2"
            }
        ]
    }
}
```
