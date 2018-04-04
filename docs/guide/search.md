# Search

eZ Platform exposes a very powerful Search API, allowing both full-text search and querying the content Repository using several built-in Search Criteria and Sort Clauses. These are supported across different search engines, allowing you to plug in another search engine without changing your code.

Currently three search engines exist in their own eZ Platform Bundles:

1.  [Legacy search engine](#legacy-search-engine-bundle), a database-powered search engine for basic needs.
1.  [Solr](#solr-bundle), an integration providing better overall performance, much better scalability and support for more advanced search capabilities **(recommended)**
1.  [ElasticSearch](#elasticsearch-bundle), similar to Solr integration, currently not under active development *(experimental, not supported)*

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
        return array(
            new Specifications( Operator::IN, Specifications::FORMAT_ARRAY, $types ),
            new Specifications( Operator::EQ, Specifications::FORMAT_SINGLE, $types ),
        );
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

`Criterion` represents the value you use in the API, while `CriterionHandler` deals with the business logic in the background translating the value to something the search engine can understand.

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
|`MatchNone`|No arguments, mainly for internal use by the [BlockingLimitation](repository.md#blockinglimitation).|
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

## Reindexing

To (re)create or refresh the search engine index for configured search engines (per SiteAccess repository), use the `php app/console ezplatform:reindex` command.

Some examples of common usage:
```bash
# Reindex the whole index using parallel process (by default starts by purging the whole index)
# (with the 'auto' option which detects the number of CPU cores -1, default as of 1.13)
php app/console ezplatform:reindex --processes=auto

# Refresh a part of the subtree (implies --no-purge)
php app/console ezplatform:reindex --subtree=2

# Refresh content updated since a date (implies --no-purge)
php app/console ezplatform:reindex --since=yesterday

# Refresh (or delete when not found) content by IDs (implies --no-purge)
php app/console ezplatform:reindex --content-ids=3,45,33
```

For further info on possible options, use `php app/console ezplatform:reindex --help`.

## Solr Bundle

[ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine) aims to be a transparent drop-in replacement for the SQL-based Legacy search engine powering eZ Platform Search API by default. When you enable Solr and re-index your content, all your existing Search queries using `SearchService` will be powered by Solr automatically. This allows you to scale up your eZ Platform installation and be able to continue development locally against SQL engine, and have a test infrastructure, Staging and Prod powered by Solr. This removes considerable load from your database. See [further information on the architecture of eZ Platform](architecture.md).

Status of features:

- Able to handle all eZ Platform queries. DONE
    - Much more suitable for handling field criteria *(performance)* DONE
    - Scoring for content queries and sorting by them by default DONE
- Indexing plugins *(Solr Bundle &gt;= v1.2)* DONE
- Solr 6 support *(Solr Bundle &gt;= v1.3)* DONE
    - Scoring for Location queries and sorting by them by default DONE
- Work in progress:
    - Faceting *(possible to [write your own](../api/public_php_api.md#performing-a-faceted-search), ContentType/Section/User implemented, suggested further changes to the API for Faceting can be found [here](https://github.com/ezsystems/ezpublish-kernel/pull/1960))*
    - Index time Boosting *(Solr Bundle &gt;= v1.4)* DONE
- Future:
    - Solr cloud support
    - Highlighting
    - Spell checking
    - Query time Boosting

### How to set up Solr search engine

!!! note "Enable the bundle"

    If you have previously disabled the bundle, add/update composer dependencies:

    ``` bash
    composer require --no-update ezsystems/ezplatform-solr-search-engine:~1.0
    composer update
    ```

    Make sure `EzPublishSolrSearchEngineBundle` is activated with the following line in the `app/AppKernel.php` file: `new EzSystems\EzPlatformSolrSearchEngineBundle\EzSystemsEzPlatformSolrSearchEngineBundle()`

#### Step 1: Configuring and starting Solr

The example presents a configuration with single core, look to [Solr](https://cwiki.apache.org/confluence/display/solr/Solr+Cores+and+solr.xml) [documentation](https://wiki.apache.org/solr/CoreAdmin) for configuring Solr in other ways, including examples.

##### Download and configure

###### Solr 4.10.4

Download and extract Solr. Solr Bundle 1.x supports Solr 4.10.4:

- [solr-4.10.4.tgz](http://archive.apache.org/dist/lucene/solr/4.10.4/solr-4.10.4.tgz) or [solr-4.10.4.zip](http://archive.apache.org/dist/lucene/solr/4.10.4/solr-4.10.4.zip)

Copy the necessary configuration files. In the example below from the root of your project to the place you extracted Solr:

``` bash
# Make sure to replace the /opt/solr/ path with where you have placed Solr
cd /opt/solr/example
mkdir -p multicore/collection1/conf
cp -R <ezplatform-solr-search-engine>/lib/Resources/config/solr/* multicore/collection1/conf
cp solr/collection1/conf/{currency.xml,stopwords.txt,synonyms.txt} multicore/collection1/conf
## Remove default cores configuration and add core configuration
sed -i.bak 's/<core name=".*" instanceDir=".*" \/>//g' multicore/solr.xml
sed -i.bak "s/<shardHandlerFactory/<core name=\"collection1\" instanceDir=\"collection1\" \/><shardHandlerFactory/g" multicore/solr.xml
cp multicore/core0/conf/solrconfig.xml multicore/collection1/conf
sed -i.bak s/core0/collection1/g multicore/collection1/conf/solrconfig.xml
cd /opt/solr
bin/solr start -f -a "-Dsolr.solr.home=multicore"
```

###### Solr 6

Download and extract Solr. Solr Bundle 1.3 and higher supports Solr 6 *(currently tested with Solr 6.6.0)*:

- [solr-6.6.0.tgz](http://archive.apache.org/dist/lucene/solr/6.6.0/solr-6.6.0.tgz) or [solr-6.6.0.zip](http://archive.apache.org/dist/lucene/solr/6.6.0/solr-6.6.0.zip)

Copy the necessary configuration files. In the example below from the root of your project to the place you extracted Solr:

``` bash
# Make sure to replace the /opt/solr/ path with where you have placed Solr
cd /opt/solr
mkdir -p server/ez/template
cp -R <ezplatform-solr-search-engine>/lib/Resources/config/solr/* server/ez/template
cp server/solr/configsets/basic_configs/conf/{currency.xml,solrconfig.xml,stopwords.txt,synonyms.txt,elevate.xml} server/ez/template
cp server/solr/solr.xml server/ez

# Modify solrconfig.xml to remove the section that doesn't agree with your schema
sed -i.bak '/<updateRequestProcessorChain name="add-unknown-fields-to-the-schema">/,/<\/updateRequestProcessorChain>/d' server/ez/template/solrconfig.xml
 
# Start Solr (but apply autocommit settings below first if you need to)
bin/solr -s ez
bin/solr create_core -c collection1 -d server/ez/template
```

##### Further configuration

On both Solr 4 and 6 Solr the bundle does not commit Solr index changes directly on repository updates, leaving it up to you to tune this using `solrconfig.xml` as best practice suggests.

This setting is **required** if you want to see the changes after publish. It is strongly recommended to set-up `solrconfig.xml` like this:

``` xml
<!--solrconfig.xml-->
<autoCommit>
  <!-- autoCommit is here left as-is like it is out of the box in Solr, this controls hard commits for durability/replication -->
  <maxTime>${solr.autoCommit.maxTime:15000}</maxTime>
  <openSearcher>false</openSearcher>
</autoCommit>

<autoSoftCommit>
  <!-- Soft commits controls mainly when changes becomes visible, by default we change value from -1 (disabled) to 20ms, so Solr gets to bulk update changes a bit, but before a request typically finishes -->
  <maxTime>${solr.autoSoftCommit.maxTime:20}</maxTime>
</autoSoftCommit>
```

#### Step 2: Configuring the bundle

The Solr Search Engine Bundle can be configured in many ways. The config further below assumes you have parameters set up for Solr DSN and search engine *(however both are optional)*, for example (in `parameters.yml`):

``` yaml
    search_engine: solr
    solr_dsn: 'http://localhost:8983/solr'
```

##### Single-core example (default)

Out of the box in eZ Platform the following is enabled for a simple setup (in `config.yml`):

``` yaml
ez_search_engine_solr:
    endpoints:
        endpoint0:
            dsn: %solr_dsn%
            core: collection1
    connections:
        default:
            entry_endpoints:
                - endpoint0
            mapping:
                default: endpoint0
```

##### Shared-core example

The following example separates one language. The installation contains several similar languages,
and one very different language that should receive proper language analysis for proper stemming and sorting behavior by Solr:

``` yaml
# config.yml
ez_search_engine_solr:
    endpoints:
        endpoint0:
            dsn: %solr_dsn%
            core: core0
        endpoint1:
            dsn: %solr_dsn%
            core: core1
    connections:
        default:
            entry_endpoints:
                - endpoint0
                - endpoint1
            mapping:
                translations:
                    jpn-JP: endpoint1
                # Other languages, for instance eng-US and other western languages are sharing core
                default: endpoint0
```

##### Multi-core example

If full language analysis features are preferred, then each language can be configured with separate cores.

!!! note

    Make sure to test this setup against a single-core setup, as it might perform worse than single-core if your project uses a lot of language fallbacks per SiteAccess, as queries will then be performed across several cores at once.

``` yaml
# config.yml
ez_search_engine_solr:
    endpoints:
        endpoint0:
            dsn: %solr_dsn%
            core: core0
        endpoint1:
            dsn: %solr_dsn%
            core: core1
        endpoint2:
            dsn: %solr_dsn%
            core: core2
        endpoint3:
            dsn: %solr_dsn%
            core: core3
        endpoint4:
            dsn: %solr_dsn%
            core: core4
        endpoint5:
            dsn: %solr_dsn%
            core: core5
        endpoint6:
            dsn: %solr_dsn%
            core: core6
    connections:
        default:
            entry_endpoints:
                - endpoint0
                - endpoint1
                - endpoint2
                - endpoint3
                - endpoint4
                - endpoint5
                - endpoint6
            mapping:
                translations:
                    - jpn-JP: endpoint1
                    - eng-US: endpoint2
                    - fre-FR: endpoint3
                    - ger-DE: endpoint4
                    - esp-ES: endpoint5
                # Not really used, but specified here for fallback if more languages are suddenly added by content admins
                default: endpoint0
                # Also use separate core for main languages (differs from content object to content object)
                # This is useful to reduce number of cores queried for always available language fallbacks
                main_translations: endpoint6
```

#### Step 3: Configuring repository with the specific search engine

The following is an example of configuring Solr search engine, where `connection` name is same as in the example above, and engine is set to `solr`:

``` yaml
# ezplatform.yml
ezpublish:
    repositories:
        default:
            storage: ~
            search:
                engine: %search_engine%
                connection: default
```

`%search_engine%` is a parameter that is configured in `app/config/parameters.yml`, and should be changed from its default value `legacy` to `solr` to activate Solr as the search engine.

#### Step 4: Clear prod cache

While Symfony `dev` environment keeps track of changes to YAML files, `prod` does not, so clear the cache to make sure Symfony reads the new config:

``` bash
php app/console --env=prod cache:clear
```

#### Step 5: Run CLI indexing command

The last step is to execute the initial indexation of data:

``` bash
php app/console --env=prod --siteaccess=<name> ezplatform:solr_create_index
```

##### Possible exceptions

If you have not configured your setup correctly, some exceptions might happen on indexing.
Here are the most common issues you may encounter:

- Exception if Binary files in database have an invalid path prefix
    - Make sure `var_dir` is configured properly in `ezplatform.yml` configuration.
    - If your database is inconsistent in regards to file paths, try to update entries to be correct *(make sure to make a backup first)*.
- Exception on unsupported Field Types
    - Make sure to implement all Field Types in your installation, or to configure missing ones as [NullType](../api/field_type_reference.md#null-field-type) if implementation is not needed.
- Content is not immediately available 
    - Solr Bundle on purpose does not commit changes directly on Repository updates *(on indexing)*, but lets you control this using Solr configuration. Adjust Solr's `autoSoftCommit` (visibility of changes to search index) and/or `autoCommit` (hard commit, for durability and replication) to balance performance and load on your Solr instance against needs you have for "[NRT](https://cwiki.apache.org/confluence/display/solr/Near+Real+Time+Searching)".
- Running out of memory during indexing
    - In general make sure to run indexing using the prod environment to avoid debuggers and loggers from filling up memory.
    - Stash: Disable inMemory cache as recommended in [Persistence cache](repository.md#persistence-cache) for long-running scripts.
    - Flysystem: You can find further info in https://jira.ez.no/browse/EZP-25325.

### Configuring the Solr Search Engine Bundle

#### Boost configuration

!!! note

    Boosting is available since Solr bundle version 1.4.

!!! tip "How boosting interacts with Search API"

    Boosting of fields or documents will affect the score (relevance) of your search result hits
    when using Search API for any Criteria you specify on `$query->query`, or in REST by using `Query` element.
    When you don't specify anything to sort on, the result will be sorted by this relevance.
    Anything set on `$query->filter`, or in REST using `Filter` element, will *not* affect scoring and only works
    as a pure filter for the result. Thus make sure to place Criteria you want to affect scoring on `query`.

Boosting currently happens when indexing, so if you change your configuration you will need to re-index.

Boosting tells the search engine which parts of the content model have more importance when searching, and is an important part of tuning your search results relevance. Importance is defined using a numeric value, where `1.0` is default, values higher than that are more important, and values lower (down to `0.0`) are less important.

Boosting is configured per connection that you configure to use for a given Repository, like in this `config.yml` example:

``` yaml
ez_search_engine_solr:
    connections:
        default:
            boost_factors:
                content_type:
                    # Boost a whole Content Type
                    article: 2.0
                field_definition:
                    # Boost a content Field system-wide, or for a given Content Type
                    title: 3.0
                    blog_post:
                        # Don't boost title of blog posts that high, but still higher than default
                        title: 1.5
                meta_field:
                    # Boost a meta Field (name, text) system wide, or for a given Content Type
                    name: 10.0
                    article:
                        # Boost the meta full text Field for article more than 2.0 set above
                        text: 5.0
```

The configuration above will result in the following boosting (Content Type / Field):

- `article/title: 2.0`
- `news/title: 3.0`
- `blog_post/title: 1.5`
- `news/description: 1.0` (default)
- `article/text (meta): 5.0`
- `blog_post/name (meta): 10.0`
- `article/name (meta): 2.0`

### Extending the Solr Search Engine Bundle

#### Document field mappers

!!! note

    Document Field Mappers are available since Solr bundle version 1.2.

You can use document field mappers to index additional data in the search engine.

The additional data can come from external sources (e.g. from a recommendation system), or from internal ones.
An example of the latter is indexing data through the Location hierarchy: from the parent Location to the child Location, or indexing child data on the parent Location.
This may be needed when you want to find the Content with full-text search, or to simplify search for a complicated data model.

To do this effectively, you first need to understand how the data is indexed with the Solr search engine.
Solr uses [documents](https://lucene.apache.org/solr/guide/6_6/overview-of-documents-fields-and-schema-design.html#how-solr-sees-the-world) as a unit of data that is indexed.
Documents are indexed per translation, as Content blocks. A block is a nested document structure.
When used in eZ Platform, a parent document represents Content, and Locations are indexed as child documents of the Content.
To avoid duplication, full-text data is indexed on the Content document only. Knowing this, you have the option to index additional data on:

- all block documents (meaning Content and its Locations, all translations)
- all block documents per translation
- Content documents
- Content documents per translation
- Location documents

Indexing additional data is done by implementing a document field mapper and registering it at one of the five extension points described above.
You can create the field mapper class anywhere inside your bundle,
as long as when you register it as a service, the `class` parameter in your `services.yml` matches the correct path.
There are three different field mappers. Each mapper implements two methods, by the same name, but accepting different arguments:

- `ContentFieldMapper`
    - `::accept(Content $content)`
    - `::mapFields(Content $content)`
- `ContentTranslationFieldMapper`
    - `::accept(Content $content, $languageCode)`
    - `::mapFields(Content $content, $languageCode)`
- `LocationFieldMapper`
    - `::accept(Location $content)`
    - `::mapFields(Location $content)`

These can be used on the extension points by registering them with the container using service tags, as follows:

- all block documents
    - `ContentFieldMapper`
    - `ezpublish.search.solr.document_field_mapper.block`
- all block documents per translation
    - `ContentTranslationFieldMapper`
    - `ezpublish.search.solr.field_mapper.block_translation`
- Content documents
    - `ContentFieldMapper`
    - `ezpublish.search.solr.document_field_mapper.content`
- Content documents per translation
    - `ContentTranslationFieldMapper`
    - `ezpublish.search.solr.field_mapper.content_translation`
- Location documents
    - `LocationFieldMapper`
    - `ezpublish.search.solr.field_mapper.location`

The following example shows how to index data from the parent Location content, in order to make it available for full-text search on the children content.
It is based on the use case of indexing webinar data on the webinar events, which are children of the webinar. Field mapper could then look like this:

``` php
 <?php

namespace My\WebinarApp;

use EzSystems\EzPlatformSolrSearchEngine\FieldMapper\ContentFieldMapper;
use eZ\Publish\SPI\Persistence\Content\Handler as ContentHandler;
use eZ\Publish\SPI\Persistence\Content\Location\Handler as LocationHandler;
use eZ\Publish\SPI\Persistence\Content;
use eZ\Publish\SPI\Search;

class WebinarEventTitleFulltextFieldMapper extends ContentFieldMapper
{
    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Type\Handler
     */
    protected $contentHandler;

    /**
     * @var \eZ\Publish\SPI\Persistence\Content\Location\Handler
     */
    protected $locationHandler;

    /**
     * @param \eZ\Publish\SPI\Persistence\Content\Handler $contentHandler
     * @param \eZ\Publish\SPI\Persistence\Content\Location\Handler $locationHandler
     */
    public function __construct(
        ContentHandler $contentHandler,
        LocationHandler $locationHandler
    ) {
        $this->contentHandler = $contentHandler;
        $this->locationHandler = $locationHandler;
    }

    public function accept(Content $content)
    {
        // ContentType with ID 42 is webinar event
        return $content->versionInfo->contentInfo->contentTypeId == 42;
    }

    public function mapFields(Content $content)
    {
        $mainLocationId = $content->versionInfo->contentInfo->mainLocationId;
        $location = $this->locationHandler->load($mainLocationId);
        $parentLocation = $this->locationHandler->load($location->parentId);
        $parentContentInfo = $this->contentHandler->loadContentInfo($parentLocation->contentId);

        return [
            new Search\Field(
                'fulltext',
                $parentContentInfo->name,
                new Search\FieldType\FullTextField()
            ),
        ];
    }
}
```

Since you index full text data only on the Content document, you would register the service like this:

``` yaml
my_webinar_app.webinar_event_title_fulltext_field_mapper:
    class: My\WebinarApp\WebinarEventTitleFulltextFieldMapper
    arguments:
        - '@ezpublish.spi.persistence.content_handler'
        - '@ezpublish.spi.persistence.location_handler'
    tags:
        - {name: ezpublish.search.solr.field_mapper.content}
```

## ElasticSearch Bundle

!!! caution "Experimental"

    ElasticSearch exists only as a technology preview, and only running on the same version of ElasticSearch as it was originally prototyped for, [v1.4.2](https://github.com/ezsystems/ezpublish-kernel/blob/v6.9.0/.travis.yml#L48). We encourage everyone to try it and help make it better, even help porting it to a more up-to-date version of Elastic.

    Given it is experimental, it is currently not supported in any possible way besides code review on contributions.

### How to use ElasticSearch search engine

#### Step 1: Enabling the bundle

First, activate the ElasticSearch Search Engine Bundle (`eZ\Bundle\EzPublishElasticsearchSearchEngineBundle\EzPublishElasticsearchSearchEngineBundle`) in your `app/AppKernel.php`.

#### Step 2: Configuring the bundle

Then configure your search engine in `config.yml`, for example:

``` yaml
ez_search_engine_elasticsearch:
    default_connection: es_connection_name
    connections:
        es_connection_name:
            server: http://localhost:9200
            index_name: ezpublish
            document_type_name:
                content: content
                location: location
```

For further information on the ElasticSearch integration in eZ Platform, find the default [configuration](https://github.com/ezsystems/ezpublish-kernel/blob/v6.7.7/eZ/Publish/Core/Search/Elasticsearch/Content/Resources/elasticsearch.yml) and [mappings](https://github.com/ezsystems/ezpublish-kernel/tree/v6.7.7/eZ/Publish/Core/Search/Elasticsearch/Content/Resources/mappings) for Content and Location type documents.

#### Step 3: Configuring repository

The following is an example (in `ezplatform.yml`) of configuring the ElasticSearch search engine, where the `connection` name is same as in example above, and engine is set to `elasticsearch`:

``` yaml
ezpublish:
    repositories:
        main:
            storage:
                engine: legacy
                connection: default
            search:
                engine: elasticsearch
                connection: es_connection_name
```

#### Step 4: Run CLI indexing command

The last step is to execute initial indexation of data:

``` bash
php app/console ezplatform:elasticsearch_create_index
```

## Legacy Search Engine Bundle

Legacy search engine is the default search engine, it is SQL-based and uses Doctrine's database connection.
Its connections are defined in the same way as for storage engine, and no further specific configuration is needed.

!!! tip

    The features and performance of Legacy search engine are limited.
    If you have specific search or performance needs you should look towards using [Solr](#solr-bundle).

### Configuring the Repository with the Legacy search engine

Search can be configured independently from storage, and the following configuration example (in `ezpublish.yml`) shows both the default values, and how you configure legacy as the search engine:

``` yaml
ezpublish:
    repositories:
        main:
            storage:
                engine: legacy
                connection: default
            search:
                engine: legacy
                connection: default
```
