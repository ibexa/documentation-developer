---
description: Search Criteria and Sort Clauses help you fine-tune searches done by using the Search API.
---

# Search Criteria and Sort Clauses

Search Criteria and Sort Clauses are value object classes used for building a search query, to define filter criteria and ordering of the result set.
[[= product_name =]] provides a number of standard Search Criteria and Sort Clauses that you can use out of the box and that should cover the majority of use cases.

For an example of how to use and combine Criteria and Sort Clauses, refer to [Searching in PHP API](search_api.md).

## Search engine handling of Search Criteria and Sort Clauses

As Search Criteria and Sort Clauses are value objects which are used to define the query from API perspective, they are common for all storage engines.
Each storage engine needs to implement its own handlers for the corresponding Criterion and Sort Clause value object,
which will be used to translate the value object into a storage-specific search query.

As an example take a look at the [`ContentId` Criterion handler](https://github.com/ibexa/core/blob/main/src/lib/Search/Legacy/Content/Common/Gateway/CriterionHandler/ContentId.php) in Legacy search engine
or [`ContentId` Criterion handler](https://github.com/ibexa/solr-search-engine/blob/main/lib/Query/Common/CriterionVisitor/ContentIdIn.php) in Solr search engine.

## Custom Criteria and Sort Clauses

Sometimes you will find that standard Search Criteria and Sort Clauses provided with [[= product_name =]] are not sufficient for your needs. Most often this will be the case if you have a custom Field Type using external storage which cannot be searched using the standard Field Criterion.

!!!note

    Legacy (SQL-based) search can also be used in `ezkeyword` external storage.

In such cases you can implement a custom Criterion or Sort Clause, together with the corresponding handlers for the storage engine you are using.

!!! caution "Using Field Criterion or Sort Clause with large databases"

    Field Criterion and Sort Clause do not perform well by design when using SQL database.
    If you have a large database and want to use them, you either need to use the Solr search engine,
    or develop your own Custom Criterion or Sort Clause. This way you can avoid using the attributes (Fields) database table,
    and instead use a custom simplified table which can handle the amount of data you have.

### Difference between Content and Location Search

There are two basic types of searches, you can either search for Locations or for Content.
Each type has dedicated methods in the Search Service:

| Type of search | Method in Search Service |
|----------------|--------------------------|
| Content        | `findContent()`          |
| Content        | `findContentInfo()`      |
| Content        | `findSingle()`           |
| Location       | `findLocations()`        |

All Criteria and Sort Clauses will be accepted with Location Search, but not all of them can be used with Content Search.
The reason for this is that while one Location always has exactly one Content item, one Content item can have multiple Locations.
In this context some Criteria and Sort Clauses would produce ambiguous queries that would not be accepted by Content Search.

Content Search explicitly refuses to accept Criteria and Sort Clauses implementing these abstract classes:

- `Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Location`
- `Ibexa\Contracts\Core\Repository\Values\Content\SortClause\Criterion\Location`

### Configuring custom Criterion and Sort Clause handlers

After you have implemented your Criterion / Sort Clause and its handler, you will need to configure the handler for the [service container](php_api.md#service-container) by using dedicated service tags for each type of search. Doing so will automatically register it and handle your Criterion / Search Clause when it is given as a parameter to one of the Search Service methods.

Available tags for Criterion handlers in Legacy Storage Engine are:

- `ibexa.search.legacy.gateway.criterion_handler.content`
- `ibexa.search.legacy.gateway.criterion_handler.location`

Available tags for Sort Clause handlers in Legacy Storage Engine are:

- `ibexa.search.legacy.gateway.sort_clause_handler.content`
- `ibexa.search.legacy.gateway.sort_clause_handler.location`

!!! note

    You will find all the native handlers and the tags for the Legacy Storage Engine in files located in `core/src/lib/Resources/settings/storage_engines/`.

!!! tip

    When you search in trash, use the following service tags:

    - for Criterion handlers: `ibexa.core.trash.search.legacy.gateway.criterion_handler`
    - for Sort Clause handlers: `ibexa.core.trash.search.legacy.gateway.sort_clause_handler`

    For more information about searching for Content items in Trash, see [Searching in trash](search_api.md#searching-in-trash).

    For more information about the Criteria and Sort Clauses that are supported when searching for trashed Content items, see [Searching in trash reference](search_in_trash_reference.md).

The following example shows how to register a ContentId Criterion handler, common for both Content and Location Search:

``` yaml
services:
    Ibexa\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\ContentId:
        arguments: ['@ibexa.api.storage_engine.legacy.dbhandler']
        tags:
          - {name: ibexa.search.legacy.gateway.criterion_handler.content}
          - {name: ibexa.search.legacy.gateway.criterion_handler.location}
```

The following example shows how to register a Depth Sort Clause handler for Location Search:

``` yaml
Ibexa\Core\Search\Legacy\Content\Location\Gateway\SortClauseHandler\Location\Depth:
    arguments: ['@ibexa.api.storage_engine.legacy.dbhandler']
    tags:
        - {name: ibexa.search.legacy.gateway.sort_clause_handler.location}
```

!!! note "See also"

    For more information about passing parameters, see [Symfony Service Container documentation]([[= symfony_doc =]]/book/service_container.html#service-parameters).

## Search using custom Field Criterion [REST]

REST search can be performed via `POST /views` using custom `FieldCriterion`. This allows you to build custom content logic queries with nested logical operators OR/AND/NOT.

Custom Field Criterion search mirrors the one already existing in PHP API `Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Field` by exposing it to REST.

#### Example of custom Content Query:

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
