# LocationId Criterion

The [`LocationId` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-LocationId.html)
searches for content based in the Location ID.

## Arguments

- `value` - int(s) representing the Location ID(s)

## Example

### PHP

``` php
$query->query = new Criterion\LocationId(62);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <LocationIdCriterion>62</LocationIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "LocationIdCriterion": "62"
        }
    }
    ```