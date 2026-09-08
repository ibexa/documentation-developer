---
description: LocationId Search Criterion
---

# LocationId Criterion

The `LocationId` Search Criterion searches for content based in the location ID.

## Arguments

- `value` - int(s) representing the location ID(s)

## Example

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
