# Matrix field type

This field represents and handles a table of rows and columns of data.

| Name     | Internal name  | Expected input |
|----------|----------------|----------------|
| `Matrix` | `ibexa_matrix` | `array`        |

The Matrix field type is available via the Matrix Bundle provided by the [ibexa/fieldtype-matrix](https://github.com/ibexa/fieldtype-matrix) package.

## Input expectations

| Type    | Description                                                                            | Example   |
|---------|----------------------------------------------------------------------------------------|-----------|
| `array` | array of `Ibexa\FieldTypeMatrix\FieldType\Value\Row` objects which contain column data | see below |

Example of input:

## Field value

`Ibexa\FieldTypeMatrix\FieldType\Value` offers the following properties:

|Property|Type|Description|
|------|------|------|
|`rows`|`RowsCollection`|Array of `Row` objects containing an array of cells (`Row::getCells()` returns array `['col1' => 'Value 1', /* ... */]`).|

## Validation

The minimum number of rows is set on content type level for each field.

Validation checks for empty rows.
A row is considered empty if it contains only empty cells (or cells containing only spaces).
Empty rows are removed.

If, after removing empty rows, the number of rows doesn't fulfill the configured `Minimum number of rows`, the field doesn't validate.
