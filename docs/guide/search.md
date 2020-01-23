# Search

eZ Platform exposes a very powerful [Search API](../api/public_php_api_search.md), allowing both full-text search and querying the content Repository using several built-in Search Criteria and Sort Clauses. These are supported across different search engines, allowing you to plug in another search engine without changing your code.

Currently two search engines exist in their own eZ Platform Bundles:

1.  [Legacy search engine](search_engines.md#legacy-search-engine-bundle), a database-powered search engine for basic needs.
1.  [Solr](solr.md), an integration providing better overall performance, much better scalability and support for more advanced search capabilities **(recommended)**

## Search Criteria and Sort Clauses

Search Criteria and Sort Clauses are value object classes used for building a search query, to define filter criteria and ordering of the result set.
eZ Platform provides a number of standard Search Criteria and Sort Clauses that you can use out of the box and that should cover the majority of use cases.

For an example of how to use and combine Criteria and Sort Clauses, refer to [Searching in PHP API](../api/public_php_api_search.md).

### Search engine handling of Search Criteria and Sort Clauses

As Search Criteria and Sort Clauses are value objects which are used to define the query from API perspective, they are common for all storage engines.
Each storage engine needs to implement its own handlers for the corresponding Criterion and Sort Clause value object,
which will be used to translate the value object into a storage-specific search query.

As an example take a look at the [`ContentId` Criterion handler](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.2/eZ/Publish/Core/Search/Legacy/Content/Common/Gateway/CriterionHandler/ContentId.php) in Legacy search engine
or [`ContentId` Criterion handler](https://github.com/ezsystems/ezplatform-solr-search-engine/blob/v1.7.0/lib/Query/Common/CriterionVisitor/ContentIdIn.php) in Solr search engine.

## Search Criteria Reference

Criteria are the filters for Content and Location Search.

A Criterion consist of two parts (similar to Sort Clause and Facet Builder):

- The API Value: `Criterion`
- Specific handler per search engine: `CriterionHandler`

`Criterion` represents the value you use in the API, while `CriterionHandler` deals with the business logic in the background translating the value to something the search engine can understand. `CriterionHandler` also handles `ezkeyword` external storage for Legacy (SQL-based) search.

Implementation and availability of a handler typically depends on search engine capabilities and limitations.
Currently only Legacy (SQL-based) search engine is available out of the box,
and for instance its support for Field Criterion is not optimal.
You should avoid heavy use of these until future improvements to the search engine.

#### Common concepts for most Criteria

Refer to the [list below](#list-of-criteria) to see how to use each Criterion, as it depends on the Criterion Value constructor, but in general you should be aware of the following common concepts:

- `target`: Exposed if the given Criterion supports targeting a specific subfield, example: `FieldDefinition` or Metadata identifier
- `value`: The value(s) to filter on, this is typically a scalar or array of scalars.
- `operator`: Exposed on some Criteria:
    - all operators can be seen as constants on `eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator`: `IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `LIKE`, `BETWEEN`, `CONTAINS`
    - most Criteria do not expose this and select `EQ` or `IN` depending if value is scalar or an array
    - `IN` and `BETWEEN` always act on an array of values, while the other operators act on single scalar value
- `valueData`: Additional value data, required by some Criteria, for instance MapLocationDistance

In the Legacy search engine, the field index/sort key column is limited to 255 characters by design.
Due to this storage limitation, searching content using the eZ Country Field Type or Keyword when there are multiple values selected may not return all the expected results.

#### List of Criteria

The list below presents the Criteria available in the `eZ\Publish\API\Repository\Values\Content\Query\Criterion` namespace:

##### Only for LocationSearch

|Criterion|Constructor arguments description|
|------|------|
|`Location\Depth`|`operator` (`IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `BETWEEN`)</br>`value` being the Location depth(s) as integer(s).|
|`Location\IsMainLocation`|Whether or not the Location is a main Location.</br>`value (Location\IsMainLocation::MAIN, Location\IsMainLocation::NOT_MAIN)`|
|`Location\Priority`|Priorities are integers that can be used for sorting in ascending or descending order. What is higher or lower priority in relation to the priority number is left to your choice.</br>`operator` (`GT`, `GTE`, `LT`, `LTE`, `BETWEEN`), `value` being the location priority(s) as an integer(s).|

##### Common

|Criterion|Constructor arguments description|
|------|------|
|`ContentId`|`value` scalar(s) representing the Content ID.|
|`ContentTypeGroupId`|`value` scalar(s) representing the Content Type Group ID.|
|`ContentTypeId`|`value` scalar(s) representing the Content Type ID.|
|`ContentTypeIdentifier`|`value` string(s) representing the Content Type Identifier, example: "article".|
|`DateMetadata`|`target` ( `DateMetadata::MODIFIED`, `DateMetadata::CREATED`)</br>`operator` (`IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `BETWEEN`)</br>`value` being integer(s) representing unix timestamp.|
|`Field`|`target` (Field definition identifier), `operator` (`IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `LIKE`, `BETWEEN`, `CONTAINS`), `value` being scalar(s) relevant for the field.|
|`FieldRelation`|`target` (Field definition identifier)</br>`operator` (`IN`, `CONTAINS`)</br>`value` being array of scalars representing Content ID of Relation.</br>Use of `IN` means the Relation needs to have one of the provided IDs, while `CONTAINS` implies it needs to have all provided IDs.|
|`FullText`|`value` which is the string to search for</br>`properties` is array to set additional properties for use with search engines like Solr.</br>For advanced search, you can extend the query syntax by using:</br> `word`, `"phrase"`, `(group)`, `+mandatory`, `-prohibited`, `AND`, `&&`, `OR`, `||`, `NOT`, `!`. |
|`IsFieldEmpty`|`('field_name')` – determines if the Field is empty</br>Optionally:</br> `-false` –  for searching Fields that are *not* empty</br>`-true` – used by default, for searching Fields that are empty| 
|`LanguageCode`|`value` string(s) representing language code(s) on the content (not on Fields)</br>`matchAlwaysAvailable` as boolean.|
|`LocationId`|`value` scalar(s) representing the Location ID.|
|`LocationRemoteId`|`value` string(s) representing the Location Remote ID.|
|`LogicalAnd`|A `LogicalOperator` that takes `array` of other Criteria, makes sure all Criteria match.|
|`LogicalNot`|A `LogicalOperator` that takes `array` of other Criteria, makes sure none of the Criteria match.|
|`LogicalOr`|A `LogicalOperator` that takes `array` of other Criteria, makes sure one of the Criteria match.|
|`MapLocationDistance`| `target` (FieldDefinition identifier)</br>`operator` (`IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `BETWEEN`)</br>`distance` as float(s) from a position using `latitude` as float, `longitude` as float as arguments|
|`MatchAll`|No arguments, mainly for internal use when no `filter` or `query` is provided on Query object.|
|`MatchNone`|No arguments, mainly for internal use by the [Blocking Limitation](limitation_reference.md#blocking-limitation).|
|`ObjectStateId`|`value` string(s) representing the Object state ID.|
|`ParentLocationId`|`value` scalar(s) representing the parent's Location ID.|
|`RemoteId`|`value` string(s) representing the content remote ID.|
|`SectionId`|`value` scalar(s) representing the Section ID.|
|`Subtree`|`value` string(s) representing the Location ID in which you can filter. If the Location ID is `/1/2/20/42`, you will filter everything under `42`.|
|`UserMetadata`|`target` (`UserMetadata::OWNER`, `UserMetadata::GROUP`, `UserMetadata::MODIFIER`)</br>`operator` (`IN`, `EQ`), `value` scalar(s) representing the User or User Group ID(s).|
|`Visibility`|`value` (`Visibility::VISIBLE`, `Visibility::HIDDEN`).</br>*Note: This acts on all assigned Locations when used with Content Search, meaning hidden content will be returned if it has a Location which is visible. Use Location Search to avoid this.*|

## Sort Clauses Reference

Sort Clauses are the sorting options for Content and Location Search in eZ Platform.

A Sort Clause consists of two parts (similar to Criterion and Facet Builder):

- The API Value: `SortClause`
- Specific handler per search engine: `SortClausesHandler`

The `SortClause` represents the value you use in the API, while `SortClauseHandler` deals with the business logic in the background, translating the value to something the search engine can understand.

Implementation and availability of a handler sometimes depends on search engine capabilities and limitations.

#### Common concepts for all Sort Clauses 

Refer to the [list below](#list-of-sort-clauses) to see how to use each Sort Clause, as it depends on the Sort Clause value constructor, but in general you should be aware of the following common concept:

- `sortDirection`: The direction to perform the sort, either `Query::SORT_ASC` *(default)* or `Query::SORT_DESC`

You can use the method `SearchService::getSortClauseFromLocation( Location $location )` to return an array of Sort Clauses that you can use on `LocationQuery->sortClauses`.

#### List of Sort Clauses 

The list below presents the Sort Clauses available in the `eZ\Publish\API\Repository\Values\Content\Query\SortClause` namespace:

!!! tip

    Arguments starting with "`?`" are optional.

##### Only for LocationSearch

| Sort Clause                     | Constructor arguments |
|---------------------------------|-----------------------------------|
| `Location\Depth`                | `?sortDirection`                  |
| `Location\Id`                   | `?sortDirection`                  |
| `Location\IsMainLocation`       | `?sortDirection`                  |
| `Location\Depth`                | `?sortDirection`                  |
| `Location\Priority`             | `?sortDirection`                  |
| `Location\Visibility `          | `?sortDirection`                  |

##### Common

|Sort Clause|Constructor arguments |
|------|------|
|`ContentId`|`?sortDirection`|
|`ContentName`|`?sortDirection`|
|`DateModified`|`?sortDirection`|
|`DatePublished`|`?sortDirection`|
|`Field`|`typeIdentifier` as string</br>`fieldIdentifier` as string</br> `?sortDirection`</br>`?languageCode` as string|
|`MapLocationDistance `|`typeIdentifier` as string</br>`fieldIdentifier` as string</br>`latitude` as float</br>`longitude` as float</br>`?sortDirection`</br>`?languageCode` as string|
|`Random`|`?seed` as integer (recommended to use with Solr only for performance reasons)</br>`?sortDirection`|
|`SectionIdentifier`|`?sortDirection`|
|`SectionName`|`?sortDirection`|

## Search Facet reference

Search Facets enable you to apply [faceted search](../api/public_php_api_search.md#faceted-search)
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

Sometimes you will find that standard Search Criteria and Sort Clauses provided with eZ Platform are not sufficient for your needs. Most often this will be the case if you have a custom Field Type using external storage which cannot be searched using the standard Field Criterion.

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

    See also [Symfony documentation about Service Container](http://symfony.com/doc/4.3/book/service_container.html#service-parameters) for passing parameters.

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
