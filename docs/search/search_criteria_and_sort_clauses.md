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

## Content and Location search

There are two basic types of search: you can search for content items, or for locations.

All Criteria and Sort Clauses are accepted by Location search, but not all of them can
be used with Content search.
The reason is that while one location always has exactly one content item, one content
item can have several locations.
In that context some Criteria and Sort Clauses would produce ambiguous queries, so
Content search refuses the Criteria and Sort Clauses that apply specifically to
locations.

## Search using a custom Field Criterion

REST search can be performed by calling the `POST /views` method with a custom `FieldCriterion`.
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
