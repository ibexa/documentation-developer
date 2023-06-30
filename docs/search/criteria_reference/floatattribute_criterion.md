# FloatAttribute Criterion

The `FloatAttribute` Search Criterion searches for products by the value of their float attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - string representing the attribute value

## Example

### PHP

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\FloatAttribute(
        'length',
        16.5
    )
);
```

### REST API

=== "XML"

    ```xml
    <AttributeQuery>
        <Query>
            <FloatAttributeCriterion>
                <identifier>length</identifier>
                <value>16.5</value>
            </FloatAttributeCriterion>
        </Query>
    </AttributeQuery>
    ```

=== "JSON"

    ```json
    {
        "AttributeQuery": {
            "Query": {
                "FloatAttributeCriterion": {
                    "identifier": "length",
                    "value": 16.5
                }
            }
        }
    }
    ```