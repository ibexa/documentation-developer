---
description: LanguageTermAggregation
---

# LanguageTermAggregation

The LanguageTermAggregation aggregates search results by the content item's language.

## Arguments

- `name` - name of the Aggregation object

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "LanguageTermAggregation": {
                "name": "languages"
            }
        }
    ]
}
```
