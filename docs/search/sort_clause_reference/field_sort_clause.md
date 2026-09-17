---
description: Field Sort Clause
---

# Field Sort Clause

The `Field` Sort Clause sorts search results by the value of one of the content items' fields.

Search results of the provided content type are sorted in field value order.
Results of the query that don't belong to the content type are ranked lower.

## Arguments

- `typeIdentifier` - string representing the identifier of the content type to which the field belongs
- `fieldIdentifier` - string representing the identifier of the field to sort by [[= include_file('docs/snippets/sort_direction.md') =]]

## Example

You can use this Sort Clause over the REST API, in the `SortClauses` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "SortClauses": {
        "Field": {
            "contentTypeIdentifier": "article",
            "fieldDefinitionIdentifier": "title",
            "direction": "ascending"
        }
    }
}
```
