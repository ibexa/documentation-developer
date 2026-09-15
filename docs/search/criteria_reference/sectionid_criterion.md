---
description: SectionId Search Criterion
---

# SectionId Criterion

The `SectionId` Search Criterion searches for content based on the ID of the Section it's assigned to.

## Arguments

- `value` - int(s) representing the IDs of the Section(s)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <SectionIdCriterion>3</SectionIdCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "SectionIdCriterion": "3"
        }
    }
    ```
