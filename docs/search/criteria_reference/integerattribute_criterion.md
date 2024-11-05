# IntegerAttribute Criterion

The `IntegerAttribute` Search Criterion searches for products by the value of their integer attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - string representing the attribute value

## Example

### PHP

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\IntegerAttribute(
        'size',
        38
    )
);
```

### REST API

=== "XML"

    ```xml
    <AttributeQuery>
        <Query>
            <IntegerAttributeCriterion>
                <identifier>size</identifier>
                <value>38</value>
            </IntegerAttributeCriterion>
        </Query>
    </AttributeQuery>
    ```

=== "JSON"

    ```json
    {
        "AttributeQuery": {
            "Query": {
                "IntegerAttributeCriterion": {
                    "identifier": "size",
                    "value": 38
                }
            }
        }
    }
    ```