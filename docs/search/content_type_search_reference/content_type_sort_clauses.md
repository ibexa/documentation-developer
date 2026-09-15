---
description: Content Type Search Sort Clauses
month_change: false
---

# Content Type Search Sort Clauses

Content Type Search Sort Clauses are the sorting options for content types.

You use them over the REST API, in the `SortClauses` element of the payload of the
[`POST /content/types/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Type/operation/ibexa.rest.content_types.view) request.
Each Sort Clause takes the `ascending` or `descending` direction.

| Name | Description |
| --- | --- |
| Id | Sort by content type's ID |
| Identifier | Sort by content type's identifier |

## Example

``` json
{
    "ViewInput": {
        "identifier": "ContentTypeView",
        "ContentTypeQuery": {
            "Query": {
                "ContentTypeGroupIdCriterion": 1
            },
            "SortClauses": {
                "Identifier": "ascending"
            }
        }
    }
}
```
