# Keyword field type

This field type stores one or several comma-separated keywords as a string or array of strings.

| Name      | Internal name   | Expected input         |
|-----------|-----------------|------------------------|
| `Keyword` | `ibexa_keyword` | `string[]` or `string` |

## Input expectations

| Type       | Example                                                   |
|------------|-----------------------------------------------------------|
| `string`   | `"documentation"`                                         |
| `string`   | `"php, Ibexa Platform, html5"`                            |
| `string[]` | `[ "Ibexa", "Enterprise", "User Experience Management" ]` |

### Properties

The Value class of this field type contains the following properties:

| Property  | Type       | Description                            |
|-----------|------------|----------------------------------------|
| `$values` | `string[]` | Holds an array of keywords as strings. |
