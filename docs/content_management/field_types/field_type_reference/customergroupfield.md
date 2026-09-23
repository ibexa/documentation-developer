# Customer group field type

This field type represents a customer group that a user belongs to.

| Name           | Field type identifier  |
|----------------|------------------------|
| Customer group | `ibexa_customer_group` |

## Field value

The field value is an object with a single key, or `null` when the field is empty:

| Key                 | Type      | Description               | Example |
|---------------------|-----------|---------------------------|---------|
| `customer_group_id` | `integer` | ID of the customer group. | `1`     |

``` json
{
    "fieldDefinitionIdentifier": "customer_group",
    "languageCode": "eng-GB",
    "fieldValue": {
        "customer_group_id": 1
    }
}
```
