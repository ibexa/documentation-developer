# LocationId Criterion

The [`LocationId` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/LocationId.php)
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