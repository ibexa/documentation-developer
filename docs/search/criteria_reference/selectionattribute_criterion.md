# SelectionAttribute Criterion

The `SelectionAttribute` Search Criterion searches for products by the value of their selection attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - array of strings representing the attribute values

## Example

### PHP

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\SelectionAttribute(
        'fabric_type',
        ['cotton']
    )
);
```

### REST API

=== "XML"

    ```xml
    <AttributeQuery>
        <Query>
            <SelectionAttributeCriterion>
                <identifier>fabric_type</identifier>
                <value>[cotton]</value>
            </SelectionAttributeeCriterion>
        </Query>
    </AttributeQuery>
    ```

=== "JSON"

    ```json
    {
        "AttributeQuery": {
            "Query": {
                "SelectionAttributeCriterion": {
                    "identifier": "fabric_type",
                    "value": [
                        "cotton"
                    ]
                }
            }
        }
    }
    ```