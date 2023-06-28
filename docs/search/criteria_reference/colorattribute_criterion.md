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
      <Query>
        <Filter>
            <ContentIdCriterion>[69, 72]</ContentIdCriterion>
        </Filter>
      </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ContentIdCriterion": [69, 72]
            }
        }
    ```