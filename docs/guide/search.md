# Search

eZ Platform exposes a very powerful Search API, allowing both full-text search and querying the content Repository using several built-in Search Criteria and Sort Clauses. These are supported across different search engines, allowing you to plug in another search engine without changing your code.

Currently three search engines exist in their own eZ Platform Bundles:

1.  [Legacy search engine](search_engines.md#legacy-search-engine-bundle), a database-powered search engine for basic needs.
1.  [Solr](solr.md), an integration providing better overall performance, much better scalability and support for more advanced search capabilities **(recommended)**
1.  [ElasticSearch](search_engines.md#elasticsearch-bundle), similar to Solr integration, currently not under active development *(experimental, not supported)*

## Search Criteria and Sort Clauses

Search Criteria and Sort Clauses are value object classes used for building a search query, to define filter criteria and ordering of the result set.
eZ Platform provides a number of standard Search Criteria and Sort Clauses that you can use out of the box and that should cover the majority of use cases.

As an example take a look at the built-in `ContentId` Criterion

``` php
<?php

namespace eZ\Publish\API\Repository\Values\Content\Query\Criterion;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator\Specifications;
use eZ\Publish\API\Repository\Values\Content\Query\CriterionInterface;

/**
 * A criterion that matches content based on its id
 *
 * Supported operators:
 * - IN: will match from a list of ContentId
 * - EQ: will match against one ContentId
 */
class ContentId extends Criterion implements CriterionInterface
{
    /**
     * Creates a new ContentId criterion
     *
     * @param int|int[] $value One or more content Id that must be matched.
     *
     * @throws \InvalidArgumentException if a non numeric id is given
     * @throws \InvalidArgumentException if the value type doesn't match the operator
     */
    public function __construct( $value )
    {
        parent::__construct( null, null, $value );
    }

    public function getSpecifications()
    {
        $types = Specifications::TYPE_INTEGER | Specifications::TYPE_STRING;
        return [
            new Specifications( Operator::IN, Specifications::FORMAT_ARRAY, $types ),
            new Specifications( Operator::EQ, Specifications::FORMAT_SINGLE, $types ),
        ];
    }

    public static function createFromQueryBuilder( $target, $operator, $value )
    {
        return new self( $value );
    }
}
```

### Search engine handling of Search Criteria and Sort Clauses

As Search Criteria and Sort Clauses are value objects which are used to define the query from API perspective, they are common for all storage engines.
Each storage engine needs to implement its own handlers for the corresponding Criterion and Sort Clause value object,
which will be used to translate the value object into a storage-specific search query.

Example of the `ContentId` Criterion handler in Legacy storage engine:

``` php
<?php

namespace eZ\Publish\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;

use eZ\Publish\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler;
use eZ\Publish\Core\Search\Legacy\Content\Common\Gateway\CriteriaConverter;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\Core\Persistence\Database\SelectQuery;

/**
 * Content ID criterion handler
 */
class ContentId extends CriterionHandler
{
    /**
     * Check if this criterion handler accepts to handle the given criterion.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Query\Criterion $criterion
     *
     * @return boolean
     */
    public function accept( Criterion $criterion )
    {
        return $criterion instanceof Criterion\ContentId;
    }

    /**
     * Generate query expression for a Criterion this handler accepts
     *
     * accept() must be called before calling this method.
     *
     * @param \eZ\Publish\Core\Search\Legacy\Content\Common\Gateway\CriteriaConverter $converter
     * @param \eZ\Publish\Core\Persistence\Database\SelectQuery $query
     * @param \eZ\Publish\API\Repository\Values\Content\Query\Criterion $criterion
     *
     * @return \eZ\Publish\Core\Persistence\Database\Expression
     */
    public function handle( CriteriaConverter $converter, SelectQuery $query, Criterion $criterion )
    {
        return $query->expr->in(
            $this->dbHandler->quoteColumn( "id", "ezcontentobject" ),
            $criterion->value
        );
    }
}
```

Example of a `ContentId` Criterion handler in Solr storage engine:

``` php
<?php

namespace EzSystems\EzPlatformSolrSearchEngine\Query\Content\CriterionVisitor;

use EzSystems\EzPlatformSolrSearchEngine\Query\CriterionVisitor;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator;

/**
 * Visits the ContentId criterion
 */
class ContentIdIn extends CriterionVisitor
{
    /**
     * Check if visitor is applicable to current criterion
     *
     * @param Criterion $criterion
     *
     * @return boolean
     */
    public function canVisit( Criterion $criterion )
    {
        return
            $criterion instanceof Criterion\ContentId &&
            ( ( $criterion->operator ?: Operator::IN ) === Operator::IN ||
              $criterion->operator === Operator::EQ );
    }


    /**
     * Map field value to a proper Solr representation
     *
     * @param Criterion $criterion
     * @param CriterionVisitor $subVisitor
     *
     * @return string
     */
    public function visit( Criterion $criterion, CriterionVisitor $subVisitor = null )
    {
        return '(' .
            implode(
                ' OR ',
                array_map(
                    function ( $value )
                    {
                        return 'id:"' . $value . '"';
                    },
                    $criterion->value
                )
            ) .
            ')';
    }
}
```

#### Criteria independence

Criteria are independent of one another. This can lead to unexpected behavior, for instance because Content can have multiple Locations.

As an example, take a Content item with two Locations: Location A and Location B.

- Location A is visible
- Location B is hidden

When you search for the ID of Location B with the `LocationId` Criterion and with Visibility Criterion set to `Visibility::VISIBLE`
the search will return the Content because both conditions are satisfied:

- the Content item has Location B
- the Content item is visible (it has Location A which is visible)

``` php hl_lines="17 18 27"
<?php

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalAnd;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\LocationId;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Visibility;

/** @var string|int $locationBId */
/** @var \eZ\Publish\API\Repository\Repository $repository */

$searchService = $repository->getSearchService();

$query = new Query(
    [
        'filter' => new LogicalAnd(
            [
                new LocationId( $locationBId ),
                new Visibility( Visibility::VISIBLE ),
            ]
        ),
    ]
);

$searchResult = $searchService->findContent( $query );

// Content is found
$content = $searchResult->searchHits[0];
```

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
|`Field`|`target` (FieldDefinition identifier), `operator` (`IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `LIKE`, `BETWEEN`, `CONTAINS`), `value` being scalar(s) relevant for the field.|
|`FieldRelation`|`target` (FieldDefinition identifier)</br>`operator` (`IN`, `CONTAINS`)</br>`value` being array of scalars representing Content ID of relation.</br>Use of `IN` means the relation needs to have one of the provided IDs, while `CONTAINS` implies it needs to have all provided IDs.|
|`FullText`|`value` which is the string to search for</br>`properties` is array to set additional properties for use with search engines like Solr/ElasticSearch.|
|`LanguageCode`|`value` string(s) representing Language Code(s) on the Content (not on Fields)</br>`matchAlwaysAvailable` as boolean.|
|`LocationId`|`value` scalar(s) representing the Location ID.|
|`LocationRemoteId`|`value` string(s) representing the Location Remote ID.|
|`LogicalAnd`|A `LogicalOperator` that takes `array` of other Criteria, makes sure all Criteria match.|
|`LogicalNot`|A `LogicalOperator` that takes `array` of other Criteria, makes sure none of the Criteria match.|
|`LogicalOr`|A `LogicalOperator` that takes `array` of other Criteria, makes sure one of the Criteria match.|
|`MapLocationDistance`| `target` (FieldDefinition identifier)</br>`operator` (`IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `BETWEEN`)</br>`distance` as float(s) from a position using `latitude` as float, `longitude` as float as arguments|
|`MatchAll`|No arguments, mainly for internal use when no `filter` or `query` is provided on Query object.|
|`MatchNone`|No arguments, mainly for internal use by the [Blocking Limitation](limitation_reference.md#blocking-limitation).|
|`ObjectStateId`|`value` string(s) representing the Content Object State ID.|
|`ParentLocationId`|`value` scalar(s) representing the Parent's Location ID.|
|`RemoteId`|`value` string(s) representing the Content Remote ID.|
|`SectionId`|`value` scalar(s) representing the Content Section ID.|
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

Refer to the [list below](#list-of-sort-clauses) to see how to use each Sort Clause, as it depends on the Sort Clause Value constructor, but in general you should be aware of the following common concept:

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
|`SectionIdentifier`|`?sortDirection`|
|`SectionName`|`?sortDirection`|

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
    ezpublish.search.legacy.gateway.criterion_handler.common.content_id:
        class: eZ\Publish\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\ContentId
        arguments: [@ezpublish.api.storage_engine.legacy.dbhandler]
        tags:
          - {name: ezpublish.search.legacy.gateway.criterion_handler.content}
          - {name: ezpublish.search.legacy.gateway.criterion_handler.location}
```

##### Example of registering a Depth Sort Clause handler for Location Search

``` yaml
ezpublish.search.legacy.gateway.sort_clause_handler.location.depth:
    class: eZ\Publish\Core\Search\Legacy\Content\Location\Gateway\SortClauseHandler\Location\Depth
    arguments: [@ezpublish.api.storage_engine.legacy.dbhandler]
    tags:
        - {name: ezpublish.search.legacy.gateway.sort_clause_handler.location}
```

!!! note "See also"

    See also [Symfony documentation about Service Container](http://symfony.com/doc/current/book/service_container.html#service-parameters) for passing parameters.

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
