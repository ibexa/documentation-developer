---
description: Content Type Search Criteria help define and fine-tune search queries for content types.
page_type: reference
month_change: false
---

# Content Type Search Criteria reference

Content Type Search Criteria filter the content types returned by content type search.

You use them over the REST API, in the `Query` element of the payload of the
[`POST /content/types/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Type/operation/ibexa.rest.content_types.view) request.
All Criteria that you provide in one query are combined with a logical AND.

| Criterion | Description |
|-------|-------------|
| ContainsFieldDefinitionIdCriterion | Matches content types that contain a field definition with the specified ID. |
| ContentTypeGroupIdCriterion | Matches content types by their assigned group ID. |
| ContentTypeGroupNameCriterion | Matches content types by the name of their assigned group. |
| ContentTypeIdCriterion | Matches content types by their ID. |
| ContentTypeIdentifierCriterion | Matches content types by their identifier. |
| IsSystemCriterion | Matches content types based on whether the group they belong to is system or not. |

## Example

``` json
{
    "ViewInput": {
        "identifier": "ContentTypeView",
        "ContentTypeQuery": {
            "limit": 10,
            "offset": 0,
            "Query": {
                "ContentTypeIdentifierCriterion": "folder",
                "IsSystemCriterion": false
            }
        }
    }
}
```
