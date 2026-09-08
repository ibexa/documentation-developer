# URL field type

This field type makes it possible to store and retrieve a URL.
It's formed by the combination of a link and the respective text.

| Name  | Internal name | Expected input |
|-------|---------------|----------------|
| `Url` | `ibexa_url`   | `string`       |

## Input expectations

| Type     | Description                                   | Example                |
|----------|-----------------------------------------------|------------------------|
| `string` | Link content provided to the value.           | "https://www.ibexa.co" |
| `string` | Text content that represents the stored link. | "Ibexa"                |

### Properties

The Value class of this field type contains the following properties:

| Property | Type     | Description                                                                                          |
|----------|----------|------------------------------------------------------------------------------------------------------|
| `$link`  | `string` | This property stores the link provided to the value of this field type.                              |
| `$text`  | `string` | This property stores the text to represent the stored link provided to the value of this field type. |

## Hash format

| Key    | Type     | Description   | Example                 |
|--------|----------|---------------|-------------------------|
| `link` | `string` | Link content. | "https://www.ibexa.co/" |
| `text` | `string` | Text content. | "Ibexa"                 |

## Validation

This field type doesn't perform validation.

But some validation can be made afterward, see [External URL validation](url_management.md#external-url-validation) for more information.

## Settings

This field type doesn't have settings.
