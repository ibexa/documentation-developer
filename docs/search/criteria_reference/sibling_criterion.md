# Sibling Criterion

The [`Sibling` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/Sibling.php)
searches for content under the same parent as the indicated Location.

## Arguments

- `locationId` - int representing the Location ID
- `parentLocationId` - int representing the parent Location ID

## Example

### PHP

``` php
$query->query = new Criterion\Sibling(59, 2);
```

You can also use the named constructor `Criterion\Sibling::fromLocation`
and provide it with the Location object:

``` php
$location = $locationService->loadLocation(59);
$query->query = Criterion\Sibling::fromLocation($location);
```

### REST API

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <SiblingCriterion>
                <locationId>85</locationId>
                <parentLocationId>81</parentLocationId>
            </SiblingCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "SiblingCriterion": {
                "locationId": 85,
                "parentLocationId": 81
            }
        }
    }
    ```