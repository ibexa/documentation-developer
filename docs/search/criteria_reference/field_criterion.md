# Field Criterion

The [`Field` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Field.html)
searches for content based on the content of one of its Fields.

## Arguments

- `target` - string representing the identifier of the Field to query
- `operator` - operator constant (IN, EQ, GT, GTE, LT, LTE, LIKE, BETWEEN, CONTAINS)
- `value` - the value to query for

The `LIKE` operator works together with wildcards (`*`). Without a wildcards its results are the same as for the `EQ` operator.

The `CONTAINS` operator works with collection Fields like the Country Field Type,
enabling you to retrieve results when the query value is one of the values of the collection.
Querying for a collection with the `EQ` operator returns result only when the whole collection equals the query values.

## Limitations

The `Field` Criterion isn't available in [Repository filtering](search_api.md#repository-filtering).


## Example

### PHP

``` php
$query->query = new Criterion\Field('name', Criterion\Operator::CONTAINS, 'Platform');
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <Field>
                <name>name</name>
                <operator>CONTAINS</operator>
                <value>Platform</value>
            </FieldCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    {
        "Query": {
            "Filter": {
                "Field": {
                    "name": "name",
                    "operator": "CONTAINS",
                    "value": "Platform"
                }
            }
        }
    }
    ```

## Use case

You can use the `Field` Criterion to search for articles that contain the word "featured":

``` php hl_lines="4"
$query = new LocationQuery();
$query->query = new Criterion\LogicalAnd([
        new Criterion\ContentTypeIdentifier('article'),
        new Criterion\Field('name', Criterion\Operator::CONTAINS, 'Featured')
    ]
);
```
