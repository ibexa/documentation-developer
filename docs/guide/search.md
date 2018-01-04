# Search

## Introduction

eZ Platform exposes very powerful Search API, allowing both Full Text search and querying the content repository using several built-in Criteria and Sort Clauses. These are supported across several search engines, allowing you to plug in another search engine without changing your code.

### Available Search Engines

Currently 3 search engines exists on their own eZ Platform Bundles:

1.  [Legacy](#legacy-search-engine-bundle), a database-powered search engines for basic needs.
1.  [Solr](#solr-bundle), an integration providing better overall performance, much better scalability and support for more advance search capabilities RECOMMENDED
1.  [ElasticSearch](#elasticsearch-bundle), similar to Solr integration, however currently not under active development EXPERIMENTAL, NOT SUPPORTED

## Usage

### Search Criteria and Sort Clauses

Search Criteria  and Sort Clauses are `value` object classes used for building Search Query, to define filter criteria and ordering of the result set. eZ Platform provides a number of standard Criteria and Sort Clauses that you can use out of the box and that should cover the majority of use cases.

``` php
// Example of standard ContentId criterion

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

#### Search Engine Handling of Search Criteria and Sort Clauses

As Search Criteria and Sort Clauses are `value` objects which are used to define the Query from API perspective, they are are common for all storage engines. Each storage engine needs to implement its own `handler` for corresponding Criterion and Sort Clause `value` object, which will be used to translate the value object into storage specific search query.

``` php
// Example of ContentId criterion handler in Legacy Storage Engine

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

``` php
// Example of ContentId criterion handler in Solr Storage engine

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
     * CHeck if visitor is applicable to current criterion
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

#### Custom Criteria and Sort Clauses

Sometimes you will find that standard Search Criteria and Sort Clauses provided with eZ Publish are not sufficient for you needs. Most often this will be the case if you have developed a custom Field Type using external storage, which therefore can not be searched using standard Field Criterion.

!!! caution "On use of Field Criterion/SortClause with large databases"

    Field Criterion/SortClause does not perform well by design when using SQL database, so if you have a large database and want to use them you either need to use Solr search engine, or develop your own Custom Criterion / Sort Clause to avoid use of attributes (Fields) database table, and instead uses a custom simplified table which can handle the amount of data you have.

In this case you can implement a custom Criterion or Sort Clause, together with the corresponding handlers for the storage engine you are using.

#### Difference between Content and Location Search

These are two basic types of searches, you can either search for Locations or for Content. Each has dedicated methods in Search Service:

| Type of search | Method in Search Service |
|----------------|--------------------------|
| Content        | `findContent()`          |
| Content        | `findSingle()`           |
| Location       | `findLocations()`        |

All Criteria and Sort Clauses will be accepted with Location Search, but not all of them can be used with Content Search. Reason for this is that while one Location always has exactly one Content item, one Content item can have multiple Locations. In this context some Criteria and Sort Clauses would produce ambiguous queries and such will therefore not be accepted by Content Search.

Content Search will explicitly refuse to accept Criteria and Sort Clauses implementing these abstract classes:

- eZ\Publish\API\Repository\Values\Content\Query\Criterion\Location
- eZ\Publish\API\Repository\Values\Content\SortClause\Criterion\Location

#### How to configure your own Criterion and Sort Clause Handlers

After you have implemented your Criterion / Sort Clause and its handler, you will need to configure the handler for the service container using dedicated service tags for each type of search. Doing so will automatically register it and handle your Criterion / Search Clause when it is given as a parameter to one of the Search Service methods.

Available tags for Criterion handlers in Legacy Storage Engine are:

- `ezpublish.search.legacy.gateway.criterion_handler.content`
- `ezpublish.search.legacy.gateway.criterion_handler.location`

Available tags for Sort Clause handlers in Legacy Storage Engine are:

- `ezpublish.search.legacy.gateway.sort_clause_handler.content`
- `ezpublish.search.legacy.gateway.sort_clause_handler.location`

!!! note

    You will find all the native handlers and the tags for the Legacy Storage Engine available in the eZ/Publish/Core/settings/storage\_engines/legacy/**search\_query\_handlers.yml** file.

##### Example of registering ContentId Criterion handler, common for both Content and Location Search

``` yaml
# Registering Criterion handler
services:
    ezpublish.search.legacy.gateway.criterion_handler.common.content_id:
        class: eZ\Publish\Core\Search\Legacy\Content\Common\Gateway\CriterionHandler\ContentId
        arguments: [@ezpublish.api.storage_engine.legacy.dbhandler]
        tags:
          - {name: ezpublish.search.legacy.gateway.criterion_handler.content}
          - {name: ezpublish.search.legacy.gateway.criterion_handler.location}
```

##### Example of registering Depth Sort Clause handler for Location Search

``` yaml
# Registering Sort Clause handler
ezpublish.search.legacy.gateway.sort_clause_handler.location.depth:
    class: eZ\Publish\Core\Search\Legacy\Content\Location\Gateway\SortClauseHandler\Location\Depth
    arguments: [@ezpublish.api.storage_engine.legacy.dbhandler]
    tags:
        - {name: ezpublish.search.legacy.gateway.sort_clause_handler.location}
```

!!! note "See also"

    See also [Symfony documentation about Service Container](http://symfony.com/doc/current/book/service_container.html#service-parameters) for passing parameters

#### Criteria Independence Example

With eZ Publish you can have multiple location content. Criterions do not relate to others criterion you can  use the Public API and Criterion to search this content, it can lead to a comportement you are not expecting.

Example of Criterions not relating to each other:

There is a Content with two Locations: Location A and Location B

- Location A is visible
- Location B is hidden

Searching with LocationId criterion with Location B id and Visibility criterion with Visibility::VISIBLE will return the Content because conditions are satisfied:

- Content has Location B
- Content is visible (it has Location A that is visible)

``` php
<?php

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalAnd;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\LocationId;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Visibility;

/** @var string|int $locationBId */
/** @var \eZ\Publish\API\Repository\Repository $repository */

$searchService = $repository->getSearchService();

$query = new Query(
    array(
        'filter' => new LogicalAnd(
            array(
                new LocationId( $locationBId ),
                new Visibility( Visibility::VISIBLE ),
            )
        )
    )
);

$searchResult = $searchService->findContent( $query );

// Content is found
$content = $searchResult->searchHits[0];
```

## Reindexing

To (re)create or refresh the search engine index for configured search engines (per siteaccess repository), use the `php app/console ezplatform:reindex` command.

Some examples of common usage _(using 1.7.7/1.13 and up)_:
```bash
# Reindex whole index using parallel process
# (with the 'auto' option which detects the number of CPU cores -1, default as of 1.13)
php app/console ezplatform:reindex --processes=auto

# Refresh part of the subtree (implies --no-purge)
php app/console ezplatform:reindex --subtree=2

# Refresh content updated since a date (implies --no-purge)
php app/console ezplatform:reindex --since=yesterday

# Refresh (or delete when not found) content by IDs  (implies --no-purge)
php app/console ezplatform:reindex --content-ids=3,45,33
```

For further info on possible options, see `php app/console ezplatform:reindex --help`.

## Reference

See sections on [Search Criteria reference](#search-criteria-reference) and [Sort Clauses reference](#sort-clauses-reference).
 
## Solr Bundle

For use with eZ Publish 5.4, go to [the corresponding documentation page](https://doc.ez.no/display/EZP/Solr+Search+Engine+Bundle) which covers the v1.0 version of the bundle compatible with eZ Publish 5.4.

### What is Solr Search Engine Bundle?

[ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine), as the package is called, aims to be a transparent drop-in replacement for the SQL-based "Legacy" search engine powering eZ Platform Search API by default. When you enable Solr and re-index your content, all your existing Search queries using SearchService will be powered by Solr automatically. This allows you to scale up your eZ Platform installation and be able to continue development locally against SQL engine, and have a test infrastructure, Staging and Prod powered by Solr. This removes considerable load from your database. *See [Architecture](architecture.md)* *for further information on the architecture of eZ Platform.*

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

### How to set up Solr Search engine

#### Step 0: Enable Solr Bundle

Not needed with eZ Platform

This step is not needed as of eZ Platform 15.09, however it is kept here for reference in case you have previously disabled the bundle.

1\. Check in composer.json if you have the `ezsystems/ezplatform-solr-search-engine` package, if not add/update composer dependencies:

``` bash
composer require --no-update ezsystems/ezplatform-solr-search-engine:~1.0
composer update
```

2\. Make sure `EzPublishSolrSearchEngineBundle` is activated with the following line in the `app/AppKernel.php` file: new `EzSystems\EzPlatformSolrSearchEngineBundle\EzSystemsEzPlatformSolrSearchEngineBundle()`

#### Step 1: Configuring & Starting Solr

The example presents a configuration with single core, look to [Solr](https://cwiki.apache.org/confluence/display/solr/Solr+Cores+and+solr.xml) [documentation](https://wiki.apache.org/solr/CoreAdmin) for configuring Solr in other ways, including examples.

##### Download and configure

###### Solr 4.10.4

First, download and extract Solr. Solr Bundle 1.x supports Solr 4.10.4:

- [solr-4.10.4.tgz](http://archive.apache.org/dist/lucene/solr/4.10.4/solr-4.10.4.tgz) or [solr-4.10.4.zip](http://archive.apache.org/dist/lucene/solr/4.10.4/solr-4.10.4.zip)

Secondly, copy configuration files needed for eZ Solr Search Engine bundle, in the example below from the root of your project to the place you extracted Solr:

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

SOLR BUNDLE &gt;= 1.3.0First download and extract Solr, in Solr Bundle 1.3 and higher we also support Solr 6 *(currently tested with Solr 6.6.0)*:

- [solr-6.6.0.tgz](http://archive.apache.org/dist/lucene/solr/6.6.0/solr-6.6.0.tgz) or [solr-6.6.0.zip](http://archive.apache.org/dist/lucene/solr/6.6.0/solr-6.6.0.zip)

Secondly, copy configuration files needed for eZ Solr Search Engine bundle, *here from the root of your project to the place you extracted Solr*:

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

Thirdly, on both Solr 4 and 6 Solr the bundle does not commit solr index changes directly on repository updates, leaving it up to you to tune this using `solrconfig.xml` as best practice suggests, for example:

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

#### Step 2: Configuring bundle

The Solr search engine bundle can be configured in many ways. The config further below assumes you have parameters set up for solr dsn and search engine *(however both are optional)*, for example:

``` yaml
# parameters.yml
    search_engine: solr
    solr_dsn: 'http://localhost:8983/solr'
```

On to configuring the bundle.

##### Single Core example (default)

Out of the box in eZ Platform the following is enabled for a simple setup:

``` yaml
# config.yml
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

##### Shared Core example

In the following example we have decided to separate one language as the installation contains several similar languages, and one very different language that should receive proper language analysis for proper stemming and sorting behavior by Solr:

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

##### Multi Core example

If full language analysis features are preferred, then each language can be configured to separate cores.

*Note: Please make sure to test this setup against single core setup, as it might perform worse than single core if your project uses a lot of language fallbacks per SiteAccess, as queries will then be performed across several cores at once.*

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

The following is an example of configuring Solr Search Engine, where `connection` name is same as in the example above, and engine is set to `solr`:

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

`%search_engine%` is a parameter that is configured in `app/config/parameters.yml`, and should be changed from its default value "`legacy`" to "`solr`" to activate Solr as the Search engine.

#### Step 4: Clear prod cache

While Symfony `dev` environment keeps track of changes to yml files, `prod` does not, so to make sure Symfony reads the new config we clear cache:

``` bash
php app/console --env=prod cache:clear
```

#### Step 5: Run CLI indexing command

Make sure to configure your setup for indexing

Some exceptions might happen on indexing if you have not configured your setup correctly, here are the most common issues you may encounter:

- Exception if Binary files in database have an invalid path prefix
    - Make sure `ezplatform.yml` configuration `var_dir` is configured properly.
    - If your database is inconsistent in regards to file paths, try to update entries to be correct *(but make sure to make a backup first)*.
- Exception on unsupported Field Types
    - Make sure to implement all Field Types in your installation, or to configure missing ones as [NullType](field_type_reference.md#null-field-type) if implementation is not needed.
- Content not immediately available 
    - Solr Bundle on purpose does not commit changes directly on Repository updates *(on indexing)*, but lets you control this using Solr configuration. Adjust Solr **autoSoftCommit** *visibility of change to search index)* and/or **autoCommit** (hard commit, for durability and replication) to balance performance and load on your Solr instance against needs you have for "[NRT](https://cwiki.apache.org/confluence/display/solr/Near+Real+Time+Searching)".
- Running out of memory during indexing
    - In general make sure to run indexing using prod environment to avoid debuggers and loggers from filing up memory.
    - Stash: Disable in\_memory cache as recommended on [Persistence cache](repository.md#persistence-cache) for long running scripts.
    - Flysystem: You can find further info in: <https://jira.ez.no/browse/EZP-25325>.

The last step is to execute the initial indexation of data:

``` bash
php app/console --env=prod --siteaccess=<name> ezplatform:solr_create_index
```

SOLR BUNDLE &gt;= 1.2Since eZ Platform v1.7.0 the `ezplatform:solr_create_index` command is deprecated, use `php app/console ezplatform:reindex` instead:

``` bash
php app/console --env=prod --siteaccess=<name> ezplatform:reindex
```

### Configuring the Solr Search engine Bundle

For configuration of Solr connection for your repository, see [How to set up Solr Search engine](#how-to-set-up-solr-search-engine) above.

#### Boost configuration

SOLR BUNDLE &gt;= 1.4

Boosting currently happens when indexing, so if you change your configuration you'll need to re-index (this is expected behavior). This can possibly be solved by a contribution to change boosting to be performed on query time.

Boosting tells the search engine which parts of the content model have more importance when searching, and is an important part of tuning your search results relevance. Importance is defined using a numeric value, where `1.0` is default, values higher than that are more important, and values lower (down to `0.0`) are less important.

Boosting is configured per connection that you configure to use for a given repository, like in the example below:

``` yaml
# config.yml snippet example
ez_search_engine_solr:
    connections:
        default:
            boost_factors:
                content_type:
                    # Boost a whole Content Type
                    article: 2.0
                field_definition:
                    # Boost a content Field system wide, or for a given Content Type
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

### Extending the Solr Search engine Bundle

#### Document Field Mappers

SOLR BUNDLE &gt;= 1.2

As a developer you will often find the need to index some additional data in the search engine. The use cases for this are varied, for example the data could come from an external source *(e.g. from recommendation system)*, or from an internal source. The common use case for the latter is indexing data through the Location hierarchy, for example from the parent Location to the child Location, or in the opposite direction, indexing child data on the parent Location. The reason might be you want to find the content with fulltext search, or you want to simplify search for a complicated data model. To do this effectively, you first need to understand how the data is indexed with Solr Search engine. Documents are indexed per translation, as Content blocks. In Solr, a block is a nested document structure. In our case, parent document represents Content, and Locations are indexed as child documents of the Content. To avoid duplication, full text data is indexed on the Content document only. Knowing this, you have the option to index additional data on:

- all block documents (meaning Content and its Locations, all translations)
- all block documents per translation
- Content documents
- Content documents per translation
- Location documents

Indexing additional data is done by implementing a document field mapper and registering it at one of the five extension points described above. You can create the field mapper class anywhere inside your bundle, as long as when you register it as a service, the "class" parameter" in your `services.yml` matches the correct path. We have three different field mappers. Each mapper implements two methods, by the same name, but accepting different arguments:

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

The following example shows how to index data from the parent Location content, in order to make it available for full text search on the children content. A concrete use case could be indexing webinar data on the webinar events, which are children of the webinar. Field mapper could then look something like this:

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

Since we index full text data only on the Content document, you would register the service like this:

``` yaml
my_webinar_app.webinar_event_title_fulltext_field_mapper:
    class: My\WebinarApp\WebinarEventTitleFulltextFieldMapper
    arguments:
        - '@ezpublish.spi.persistence.content_handler'
        - '@ezpublish.spi.persistence.location_handler'
    tags:
        - {name: ezpublish.search.solr.field_mapper.content}
```

### Providing feedback

After completing the installation you are now free to use your site as usual. If you get any exceptions for missing features, have feedback on performance, or want to discuss, join our community slack channel at <https://ezcommunity.slack.com/messages/ezplatform-use/>

## ElasticSearch Bundle

EXPERIMENTAL

ElasticSearch exists only as a technology preview, and only running on the same version of ElasticSearch as it was originally prototyped for, [v1.4.2](https://github.com/ezsystems/ezpublish-kernel/blob/v6.9.0/.travis.yml#L48). We encourage everyone to try it and help make it better, even help porting it to a more up to date version of Elastic.

Given it is experimental, it is currently not supported in any possible way besides code review on contributions.

### How to use ElasticSearch Search engine

#### Step 1: Enabling Bundle

First, activate the Elasticsearch Search Engine Bundle (eZ\\Bundle\\EzPublishElasticsearchSearchEngineBundle\\EzPublishElasticsearchSearchEngineBundle) in your `app/AppKernel.php` class file.

#### Step 2: Configuring Bundle

Then configure your search engine in config.yml

Example:

``` yaml
# config.yml
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

For further information on the ElasticSearch integration in eZ Platform, find the default [configuration](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/Search/Elasticsearch/Content/Resources/elasticsearch.yml) and [mappings](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/Core/Search/Elasticsearch/Content/Resources/mappings) for Content and Location type documents *(Note: Content/Location modeling will most likely be simplified in the future, like in the Solr search engine bundle)*.

#### Step 3: Configuring repository

The following is an example of configuring the ElasticSearch Search Engine, where the `connection` name is same as in example above, and engine is set to be `elasticsearch`:

``` yaml
# ezplatform.yml
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

Last step is to execute initial indexation of data:

``` bash
php app/console ezplatform:elasticsearch_create_index
```

## Legacy Search Engine Bundle

**Legacy Search Engine** is the default search engine, it is SQL based and uses Doctrine's database connection. So its connections are, and should be, defined in the same way as for storage engine, and no further specific configuration is needed.

Its features and performance are limited, and if you have specific search or performance needs you should rather look towards using [Solr](#solr-bundle).

### Configuring repository with the legacy search engine

Search can be configured independently from storage, and the following configuration example shows both the default values, and how you configure legacy as the search engine:

``` yaml
# ezpublish.yml
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

## Search Criteria Reference

**Criteria** are the filters for Content and Location Search, for generic use of API Search see [Search Criteria and Sort Clauses](#search-criteria-and-sort-clauses).

A Criterion consist of two parts just like SortClause and FacetBuilder:

- The API Value: `Criterion`
- Specific handler per search engine: `Criterion Handler`

`Criterion` represents the value you use in the API, while `CriterionHandler` deals with the business logic in the background translating the value to something the Search engine can understand.

Implementation and availability of a handler typically depends on search engine capabilities and limitations, currently only Legacy (SQL) Search Engine exists, and for instance its support for FullText and Field Criterion is not optimal and it is advised to avoid heavy use of these until future search engine arrives.

#### Common concepts for most Criteria

For how to use each and every Criterion see the list below, as it depends on the Criterion Value constructor, but *in general* you should be aware of the following common concepts:

- `target`: Exposed if the given Criterion supports targeting a specific sub field, example: FieldDefinition or Meta Data identifier
- `value`: The value(s) to *filter* on, this is typically a  `scalar` or `array` of` scalars.`
- `operator`: Exposed on some Criteria
    - All operators can be seen as constants on `eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator`, at time of writing: `IN, EQ, GT, GTE, LT, LTE, LIKE, BETWEEN, CONTAINS`
    - Most Criteria do not expose this and select `EQ` **or** `IN` depending on if value is `scalar` **or** `array`
    - `IN` & `BETWEEN`always acts on an `array` of values, while the other operators act on single `scalar` value
- `valueData`: Additional value data, required by some Criteria, MapLocationDistance for instance

In the Legacy search engine, the field index/sort key column is limited to 255 characters by design.
Due to this storage limitation, searching content using the eZ Country Field Type or Keyword when there are multiple values selected may not return all the expected results.

#### List of Criteria

The list below reflects Criteria available in the `eZ\Publish\API\Repository\Values\Content\Query\Criterion` namespace (it is also possible to make a custom Criterion):

##### Only for LocationSearch

|Criterion|Constructor arguments description|
|------|------|
|`Location\Depth`|`operator` (`IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `BETWEEN`), `value` being the Location depth(s) as an integer(s).|
|`Location\IsMainLocation`|Whether or not the Location is a Main Location. `value (Location\IsMainLocation::MAIN, Location\IsMainLocation::NOT_MAIN)`|
|`Location\Priority`|Priorities are integers that can be used for sorting in ascending or descending order. What is higher or lower priority in relation to the priority number is left to the user choice. `operator` (`GT`, `GTE`, `LT`, `LTE`, `BETWEEN`), `value` being the location priority(s) as an integer(s).|

##### Common

|Criterion|Constructor arguments description|
|------|------|
|`ContentId`|`value` being scalar(s) representing the Content id.|
|`ContentTypeGroupId`|`value` being scalar(s) representing the Content Typ eGroup id.|
|`ContentTypeId`|`value` being scalar(s) representing the Content Type id.|
|`ContentTypeIdentifier`|`value` being string(s) representing the Content Type identifier, example: "article".|
|`DateMetadata`|`target` ( `DateMetadata ::MODIFIED`, `DateMetadata ::CREATED`), `operator` (`IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `BETWEEN`), `value` being integer(s) representing unix timestamp.|
|`Field`|`target` (FieldDefinition identifier ), `operator` (`IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `LIKE`, `BETWEEN`, `CONTAINS`), `value` being scalar(s) relevant for the field.|
|`FieldRelation`|`target` (FieldDefinition identifier), `operator` (`IN`, `CONTAINS`), `value` being array of scalars representing Content id of relation. *Use of `IN` means relation needs to have one of the provided ID's, while `CONTAINS` implies it needs to have all provided id's.*|
|`FullText`|`value` being the string to search for, `properties` is array to set additional properties for use with future search engines like Solr/ElasticSearch.|
|`LanguageCode`|`value` being string(s) representing Language Code(s) on the Content (not on Fields), `matchAlwaysAvailable` as boolean.|
|`LocationId`|`value` being scalar(s) representing the Location id.|
|`LocationRemoteId`|`value` being string(s) representing the Location Remote id.|
|`LogicalAnd`|A `LogicalOperator` that takes `array` of other Criteria, makes sure all Criteria match.|
|`LogicalNot`|A `LogicalOperator` that takes `array` of other Criteria, makes sure none of the Criteria match.|
|`LogicalOr`|A `LogicalOperator` that takes `array` of other Criteria, makes sure one of the Criteria match.|
|`MapLocationDistance`| `target` (FieldDefinition identifier), `operator` (`IN`, `EQ`, `GT`, `GTE`, `LT`, `LTE`, `BETWEEN`), `distance` as float(s) from a position using `latitude` as float, `longitude` as float as arguments|
|`MatchAll`|*No arguments, mainly for internal use when no `filter` or `query` is provided on Query object.*|
|`MatchNone`|*No arguments, mainly for internal use by [BlockingLimitation](repository.md#blockinglimitation).*|
|`ObjectStateId`|`value` being string(s) representing the Content ObjectState id.|
|`ParentLocationId`|`value` being scalar(s) representing the Parent's Location id|
|`RemoteId`|`value` being string(s) representing the Content Remote id.|
|`SectionId`|`value` being scalar(s) representing the Content Section id.|
|`Subtree`|`value` being string(s) representing the Location id in which you can filter. *If the Location Id is `/1/2/20/42`, you will filter everything under `42`.*|
|`UserMetadata`|`target` (`UserMetadata ::OWNER`, `UserMetadata ::GROUP`, `UserMetadata ::MODIFIER`), `operator` (`IN`, `EQ`), `value` being scalar(s) representing the User or User Group id(s).|
|`Visibility`|`value` (`Visibility ::VISIBLE`, `Visibility ::HIDDEN`). *Note: This acts on all assigned locations when used with ContentSearch, meaning hidden content will be returned if it has a location which is visible. Use LocationSearch to avoid this.*|

## Sort Clauses Reference

**Sort Clauses** are the *sorting options* for Content and Location Search in eZ Platform. For generic use of API Search see [Search Criteria and Sort Clauses](#search-criteria-and-sort-clauses).

A Sort Clause consists of two parts just like Criterion and FacetBuilder:

- The API Value: `SortClause`
- Specific handler per search engine: `SortClausesHandler`

The `SortClause` represents the value you use in the API, while `SortClauseHandler` deals with the business logic in the background, translating the value to something the Search engine can understand.

Implementation and availability of a handler sometimes depends on search engine capabilities and limitations.

#### Common concepts for all Sort Clauses 

For how to use each and every Sort Clause, see list below as it depends on the Sort Clause Value constructor, but *in general* you should be aware of the following common concept:

- `sortDirection`: The direction to perform the sort, either `Query::SORT_ASC`*(default)* or `Query::SORT_DESC`

You can use the method `SearchService::getSortClauseFromLocation( Location $location )` to return an array of Sort Clauses that you can use on `LocationQuery->sortClauses`.

#### List of Sort Clauses 

The list below reflects Sort Clauses available in the `eZ\Publish\API\Repository\Values\Content\Query\SortClause` namespace (it is also possible to make a custom Sort Clause):

!!! tip

    Arguments starting with "`?`" are optional.

##### Only for LocationSearch

| Sort Clause                     | Constructor arguments description |
|---------------------------------|-----------------------------------|
| `Location\Depth`                | ?`sortDirection`                  |
| `Location\Id`                   | ?`sortDirection`                  |
| `Location\IsMainLocation`       | ?`sortDirection`                  |
| `Location\Depth`                | ?`sortDirection`                  |
| `Location\Priority`             | ?`sortDirection`                  |
| `Location\Visibility `          | ?`sortDirection`                  |

##### Common

|Sort Clause|Constructor arguments description|
|------|------|
|`ContentId`|`?sortDirection`|
|`ContentName`|`?sortDirection`|
|`DateModified`|`?sortDirection`|
|`DatePublished`|`?sortDirection`|
|`Field`|`typeIdentifier` as string, `fieldIdentifier` as string, `?sortDirection`, `?languageCode` as string|
|`MapLocationDistance `|`typeIdentifier` as string, `fieldIdentifier` as string, `latitude` as float, `longitude` as float, `?sortDirection`, `?languageCode` as string|
|`SectionIdentifier`|`?sortDirection`|
|`SectionName`|`?sortDirection`|
