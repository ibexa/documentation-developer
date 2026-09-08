---
description: SectionIdentifier Search Criterion
---

# SectionIdentifier Criterion

The `SectionIdentifier` Search Criterion searches for content based on the identifier of the Section it's assigned to.

## Arguments

- `value` - string(s) representing the identifiers of the Section(s)

## Example

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <SectionIdentifierCriterion>sports</SectionIdentifierCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "SectionIdentifierCriterion": "sports"
        }
    }
    ```
