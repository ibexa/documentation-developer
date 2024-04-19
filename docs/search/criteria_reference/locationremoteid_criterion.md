# LocationRemoteId Criterion

The [`LocationRemoteId` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/LocationRemoteId.php)
searches for content based in the Location remote ID.

## Arguments

- `value` - string(s) representing the Location remote ID(s)

## Example

### PHP

``` php
$query->query = new Criterion\LocationRemoteId(['4d1e5f216c0a7aaab7f005ffd4b6a8a8', 'b81ef3e62b514188bfddd2a80d447d34']);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <LocationRemoteIdCriterion>3aaeefdb0ae573ac91f6d6ea78d230b7</LocationRemoteIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "LocationRemoteIdCriterion": "3aaeefdb0ae573ac91f6d6ea78d230b7"
        }
    }
    ```