---
description: DateRangeAggregation
---

# DateRangeAggregation

The field-based DateRangeAggregation aggregates search results by the value of the Date, DateTime, or Time field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "DateRangeAggregation": {
                "name": "aggregation_name",
                "contentTypeIdentifier": "article",
                "fieldDefinitionIdentifier": "publication_date",
                "ranges": [
                    {
                        "from": null,
                        "to": "2024-01-01T00:00:00+00:00"
                    },
                    {
                        "from": "2024-01-01T00:00:00+00:00",
                        "to": null
                    }
                ]
            }
        }
    ]
}
```
