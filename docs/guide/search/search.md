# Search

[[= product_name =]] exposes a very powerful [Search API](../../api/public_php_api_search.md), allowing both full-text search and querying the content Repository using several built-in Search Criteria and Sort Clauses. These are supported across different search engines, allowing you to plug in another search engine without changing your code.

Currently, the following search engines exist in their own [[= product_name =]] Bundles:

1.  [Legacy search engine](search_engines.md#legacy-search-engine-bundle), a database-powered search engine for basic needs.
1.  [Solr](solr.md), an integration providing better overall performance, much better scalability and support for more advanced search capabilities.
1.  [Elasticsearch](elastic.md), available for [[= product_name_exp =]] customers, a document-oriented engine providing even better performance and scalability.

### Feature comparison

| Feature | Elasticsearch | Apache Solr | Legacy Search Engine (SQL) |
| --- | --- | --- | --- |
| Filtering | Yes | Yes | Yes, limited\* |
| Query (filter with scoring) | Yes | Yes | Only filters, no scoring |
| Fulltext search | Yes, limited | Yes | Yes, limited\*\* |
| Index-time boosting | \*\*\* | No | No |
| Aggregations | Yes | Yes | No |


\* Usage of Criteria and Sort Clauses for Fields does not perform well on medium to larger 
amount of data with Legacy Search Engine (SQL), use Solr for this.

\*\* For more information about fulltext search syntax support, see [Fulltext Criterion](criteria_reference/fulltext_criterion.md).

\*\*\* Elasticsearch offers query-time boosting instead.

## Search Criteria and Sort Clauses

Search Criteria and Sort Clauses are value object classes used for building a search query, to define filter criteria and ordering of the result set.
[[= product_name =]] provides a number of standard Search Criteria and Sort Clauses that you can use out of the box and that should cover the majority of use cases.

For an example of how to use and combine Criteria and Sort Clauses, refer to [Searching in PHP API](../../api/public_php_api_search.md).

### Search engine handling of Search Criteria and Sort Clauses

As Search Criteria and Sort Clauses are value objects which are used to define the query from API perspective, they are common for all storage engines.
Each storage engine needs to implement its own handlers for the corresponding Criterion and Sort Clause value object,
which will be used to translate the value object into a storage-specific search query.

As an example take a look at the [`ContentId` Criterion handler](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/Search/Legacy/Content/Common/Gateway/CriterionHandler/ContentId.php) in Legacy search engine
or [`ContentId` Criterion handler](https://github.com/ezsystems/ezplatform-solr-search-engine/blob/v1.7.0/lib/Query/Common/CriterionVisitor/ContentIdIn.php) in Solr search engine.

## Search Facet reference

!!! caution "Deprecated"

    Search Facets are deprecated since version v3.2.

Search Facets enable you to apply [faceted search](../../api/public_php_api_search.md#faceted-search)
to get a count of search results for each Facet value.

### Available FacetBuilders

#### ContentTypeFacetBuilder

Arguments:

- `name`: `string`
- `minCount` (optional): `integer`
- `limit` (optional): `integer`

#### SectionFacetBuilder

Arguments:

- `name`: `string`
- `minCount` (optional): `integer`
- `limit` (optional): `integer`

#### UserFacetBuilder

Arguments:

- `name`: `string`
- `type`: `string` [`OWNER = 'owner'`, `GROUP = 'group'`, `MODIFIER = 'modifier'`]
- `minCount` (optional): `integer`
- `limit` (optional): `integer`

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

#### Difference between Content and Location Search

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

- `eZ\Publish\API\Repository\Values\Content\Query\Criterion\Location`
- `eZ\Publish\API\Repository\Values\Content\SortClause\Criterion\Location`

#### How to configure your own Criterion and Sort Clause Handlers

After you have implemented your Criterion / Sort Clause and its handler, you will need to configure the handler for the service container using dedicated service tags for each type of search. Doing so will automatically register it and handle your Criterion / Search Clause when it is given as a parameter to one of the Search Service methods.

Available tags for Criterion handlers in Legacy Storage Engine are:

- `ezpublish.search.legacy.gateway.criterion_handler.content`
- `ezpublish.search.legacy.gateway.criterion_handler.location`

Available tags for Sort Clause handlers in Legacy Storage Engine are:

- `ezpublish.search.legacy.gateway.sort_clause_handler.content`
- `ezpublish.search.legacy.gateway.sort_clause_handler.location`

!!! note

    You will find all the native handlers and the tags for the Legacy Storage Engine in files located in `eZ/Publish/Core/settings/storage_engines/legacy/`.

!!! tip

    When you search in trash, use the following service tags:

    - for Criterion handlers: `ezplatform.trash.search.legacy.gateway.criterion_handler`
    - for Sort Clause handlers: `ezplatform.trash.search.legacy.gateway.sort_clause_handler`

    For more information about searching for Content items in Trash, see [Searching in trash](../../api/public_php_api_search.md#searching-in-trash).

    For more information about the Criteria and Sort Clauses that are supported when searching for trashed Content items, see [Searching in trash reference](search_in_trash_reference.md).

##### Example of registering a ContentId Criterion handler, common for both Content and Location Search

``` yaml
services:
    eZ\Publish\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\ContentId:
        arguments: ['@ezpublish.api.storage_engine.legacy.dbhandler']
        tags:
          - {name: ezpublish.search.legacy.gateway.criterion_handler.content}
          - {name: ezpublish.search.legacy.gateway.criterion_handler.location}
```

##### Example of registering a Depth Sort Clause handler for Location Search

``` yaml
eZ\Publish\Core\Search\Legacy\Content\Location\Gateway\SortClauseHandler\Location\Depth:
    arguments: ['@ezpublish.api.storage_engine.legacy.dbhandler']
    tags:
        - {name: ezpublish.search.legacy.gateway.sort_clause_handler.location}
```

!!! note "See also"

    See also [Symfony documentation about Service Container](http://symfony.com/doc/5.0/book/service_container.html#service-parameters) for passing parameters.

### Search using custom Field Criterion [REST]

REST search can be performed via `POST /views` using custom `FieldCriterion`. This allows you to build custom content logic queries with nested logical operators OR/AND/NOT.

Custom Field Criterion search mirrors the one already existing in PHP API `eZ\Publish\API\Repository\Values\Content\Query\Criterion\Field` by exposing it to REST.

##### Example of custom Content Query:

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

## Reindexing

To (re)create or refresh the search engine index for configured search engines (per SiteAccess repository), use the `php bin/console ezplatform:reindex` command.

Some examples of common usage:
```bash
# Reindex the whole index using parallel process (by default starts by purging the whole index)
# (with the 'auto' option which detects the number of CPU cores -1, default behavior)
php bin/console ezplatform:reindex --processes=auto

# Refresh a part of the subtree (implies --no-purge)
php bin/console ezplatform:reindex --subtree=2

# Refresh content updated since a date (implies --no-purge)
php bin/console ezplatform:reindex --since=yesterday

# Refresh (or delete when not found) content by IDs (implies --no-purge)
php bin/console ezplatform:reindex --content-ids=3,45,33
```

For further info on possible options, see `php bin/console ezplatform:reindex --help`.

## Search view

You can extend the search view by overwriting or extending `Ibexa\Platform\Search\View\SearchViewFilter` and `Ibexa\Platform\Search\View\SearchViewBuilder`.
