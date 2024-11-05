# ObjectStateId Criterion

The [`ObjectStateId` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-ObjectStateId.html)
searches for content based on its Object State ID.

## Arguments

- `value` - int(s) representing the Object State ID(s)

## Example

### PHP

``` php
$query->query = new Criterion\ObjectStateId([4, 5]);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ObjectStateIdCriterion>1</ObjectStateIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ObjectStateIdCriterion": "1"
        }
    }
    ```