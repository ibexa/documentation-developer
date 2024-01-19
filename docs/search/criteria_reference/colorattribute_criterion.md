# ColorAttribute Criterion

The `ColorAttribute` Search Criterion searches for products by the value of their color attribute.

## Arguments

- `identifier` - string representing the attribute
- `value` - array of strings representing the attribute values

## Example

### PHP

``` php
$query = new ProductQuery(
    null,
    new \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ColorAttribute('color', ['#FF0000'])
);
```

### REST API

=== "XML"

    ```xml
    <AttributeQuery>
        <Query>
            <ColorAttributeCriterion>
                <identifier>color</identifier>
                <value>#000000</value>
            </ColorAttributeCriterion>
        </Query>
    </AttributeQuery>
    ```

=== "JSON"

    ```json
    {
      "AttributeQuery": {
        "Query": {
          "ColorAttributeCriterion": {
                "identifier": "color",
                "value": ["#000000"]
            },
        }
      }
    }
    ```