---
description: Search Criteria and Sort Clauses help you fine-tune searches done by using the Search API.
---

# Search Criteria and Sort Clauses

Search Criteria and Sort Clauses are the building blocks of a search query: Criteria
select which content is returned, and Sort Clauses order the results.
[[= product_name =]] provides a number of standard Search Criteria and Sort Clauses
that cover the majority of use cases.

For the full list, see the [Search Criteria reference](criteria_reference/search_criteria_reference.md)
and the [Sort Clause reference](sort_clause_reference/sort_clause_reference.md).

## Running a search over the REST API

You search for content and locations with the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request.
The query goes into the `ViewInput` element of the payload, where Criteria go into the `Filter`
or `Query` element, Sort Clauses into `SortClauses`, and aggregations into `Aggregations`.
You can limit the number of results with `limit` and `offset`.

``` json
{
    "ViewInput": {
        "identifier": "ArticlesView",
        "Query": {
            "Filter": {
                "ContentTypeIdentifierCriterion": "article",
                "SubtreeCriterion": "/1/2/"
            },
            "SortClauses": {
                "DatePublished": "descending"
            },
            "limit": 10,
            "offset": 0
        }
    }
}
```

Products have their own search endpoint,
[`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view),
which takes a `ProductQuery` element instead.
For more information, see the [Product Search Criteria reference](criteria_reference/product_search_criteria.md)
and the [Product Sort Clauses reference](sort_clause_reference/product_sort_clauses.md).

## Content and Location search

There are two basic types of search: you can search for content items, or for locations.

All Criteria and Sort Clauses are accepted by Location search, but not all of them can
be used with Content search.
The reason is that while one location always has exactly one content item, one content
item can have several locations.
In that context some Criteria and Sort Clauses would produce ambiguous queries, so
Content search refuses the Criteria and Sort Clauses that apply specifically to
locations.

With version 1.1 of the `ViewInput` media type
(`application/vnd.ibexa.api.ViewInput+json; version=1.1`), you select the type of search
by using the `ContentQuery` or `LocationQuery` element instead of `Query`.

## Search using a custom Field Criterion

You can also call the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request with a custom `Field` Criterion.
This allows you to build custom content logic queries with nested logical operators OR/AND/NOT.

### Example of custom Content Query

```json
 "ContentQuery":{
        "Query":{
           "OR":[
              {
                 "AND":[
                    {
                       "Field":{
                          "name":"name",
                          "operator":"CONTAINS",
                          "value":"foo"
                       }
                    },
                    {
                       "Field":{
                          "name":"info",
                          "operator":"CONTAINS",
                          "value":"bar"
                       }
                    }
                 ]
              },
              {
                 "AND":[
                    {
                       "Field":{
                          "name":"name",
                          "operator":"CONTAINS",
                          "value":"barfoo"
                       }
                    },
                    {
                       "Field":{
                          "name":"info",
                          "operator":"CONTAINS",
                          "value":"baz"
                       }
                    }
                 ]
              }
           ]
        }
     }
```
