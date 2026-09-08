---
description: Sibling Search Criterion
---

# Sibling Criterion

The `Sibling` Search Criterion searches for content under the same parent as the indicated location.

## Arguments

- `locationId` - int representing the location ID
- `parentLocationId` - int representing the parent location ID

## Example

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
