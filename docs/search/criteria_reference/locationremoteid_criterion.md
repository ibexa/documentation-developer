---
description: LocationRemoteId Search Criterion
---

# LocationRemoteId Criterion

The `LocationRemoteId` Search Criterion searches for content based in the location remote ID.

## Arguments

- `value` - string(s) representing the location remote ID(s)

## Example

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
