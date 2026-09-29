# Taxonomy Entry field type

Taxonomy Entry is a field type that stores information about the parent entry in the taxonomy tree, placing the taxonomy entry (tag or product category) in the taxonomy structure.

| Name           | Field type identifier  |
|----------------|------------------------|
| Taxonomy Entry | `ibexa_taxonomy_entry` |

## Field value

The field value is an object with a single key:

| Key              | Type              | Description                                       | Example |
|------------------|-------------------|---------------------------------------------------|---------|
| `taxonomy_entry` | `integer`, `null` | ID of the selected taxonomy entry, or `null`.     | `3`     |

``` json
{
    "fieldDefinitionIdentifier": "parent",
    "languageCode": "eng-GB",
    "fieldValue": {
        "taxonomy_entry": 3
    }
}
```

## Validation

This field type doesn't perform any special validation of the input value.

## Settings

The field definition of this field type can be configured with the following option:

| Name       | Type     | Default value | Description                              |
|------------|----------|---------------|--------------------------------------------|
| `taxonomy` | `string` | `null`        | Identifier of the taxonomy from which you choose an entry. |

``` json
{
    "fieldSettings": {
        "taxonomy": "tags"
    }
}
```
