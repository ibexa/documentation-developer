---
description: LocationId Search Criterion
---

# LocationId Criterion

The `LocationId` Search Criterion searches for content based in the location ID.

## Arguments

- `value` - int(s) representing the location ID(s)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

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
