---
description: SectionIdentifier Search Criterion
---

# SectionIdentifier Criterion

The `SectionIdentifier` Search Criterion searches for content based on the identifier of the Section it's assigned to.

## Arguments

- `value` - string(s) representing the identifiers of the Section(s)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

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
