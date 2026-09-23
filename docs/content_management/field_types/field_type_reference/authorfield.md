# Authors field type

This field type allows the storage and retrieval of one or more authors. For each author, it can handle a name and an email address. It's typically used to store information about additional authors who have written/created different parts of a content item.

| Name    | Field type identifier |
|---------|-----------------------|
| Authors | `ibexa_author`        |

## Field value

The field value is an array of author objects, each with the following keys:

| Key     | Type     | Description                                                                | Example                 |
|---------|----------|----------------------------------------------------------------------------|-------------------------|
| `id`    | `string` | Identifier of the author entry. An integer is also accepted on input.      | `1`                     |
| `name`  | `string` | Name of the author.                                                        | `Boba Fett`             |
| `email` | `string` | Email address of the author.                                               | `boba.fett@example.com` |

``` json
{
    "fieldDefinitionIdentifier": "authors",
    "languageCode": "eng-GB",
    "fieldValue": [
        {
            "id": "1",
            "name": "Boba Fett",
            "email": "boba.fett@example.com"
        },
        {
            "id": "2",
            "name": "Darth Vader",
            "email": "darth.vader@example.com"
        }
    ]
}
```

## Validation

This field type doesn't perform any special validation of the input value.

## Settings

The field definition of this field type can be configured with a single option:

| Name            | Type      | Default value | Description                                                                                   |
|-----------------|-----------|---------------|-----------------------------------------------------------------------------------------------|
| `defaultAuthor` | `integer` | `0`           | Default field value used by the editing interface. `0` means empty, `1` means current user. |

``` json
{
    "fieldSettings": {
        "defaultAuthor": 1
    }
}
```
