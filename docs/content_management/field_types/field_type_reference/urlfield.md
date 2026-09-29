# URL field type

This field type represents and handles a URL.
It's formed by the combination of a link and the respective text.

| Name | Field type identifier |
|------|-----------------------|
| URL  | `ibexa_url`           |

## Field value

The field value is an object with the following keys, or `null` when the field is empty:

| Key    | Type     | Description                              | Example                 |
|--------|----------|------------------------------------------|-------------------------|
| `link` | `string` | The URL.                                 | `https://www.ibexa.co/` |
| `text` | `string` | Text that represents the stored link.    | `Ibexa`                 |

``` json
{
    "fieldDefinitionIdentifier": "website",
    "languageCode": "eng-GB",
    "fieldValue": {
        "link": "https://www.ibexa.co/",
        "text": "Ibexa"
    }
}
```

The `text` key is optional on input.

## Validation

This field type doesn't perform validation.

## Settings

This field type doesn't have settings.
