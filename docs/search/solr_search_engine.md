---
description: Configure Solr search engine to use with Ibexa DXP.
---

# Solr search engine

[ibexa/solr](https://github.com/ibexa/solr) aims to be a transparent drop-in replacement for the SQL-based Legacy search engine powering [[= product_name =]] Search API by default. When you enable Solr and re-index your content, all your existing Search queries using `SearchService` will be powered by Solr automatically. This allows you to scale up your [[= product_name =]] installation and be able to continue development locally against SQL engine, and have a test infrastructure, Staging and Prod powered by Solr. This removes considerable load from your database. See [further information on the architecture of Ibexa DXP](architecture.md).

## Set up Solr search engine

### Step 1: Configure and start Solr

The example presents a configuration with a single core. For configuring Solr in other ways, including examples, see [Solr Cores and `solr.xml`](https://cwiki.apache.org/confluence/display/solr/Solr+Cores+and+solr.xml) and [core administration](https://wiki.apache.org/solr/CoreAdmin).

#### Download and configure

!!! note "Solr versions"

    Supported Solr versions are Solr 7 and 8. Using most recent version of Solr 7.7 or 8.11 is recommended.

Download and extract Solr:

- [solr-7.7.2.tgz](http://archive.apache.org/dist/lucene/solr/7.7.2/solr-7.7.2.tgz) or [solr-7.7.2.zip](http://archive.apache.org/dist/lucene/solr/7.7.2/solr-7.7.2.zip)
- [solr-8.11.2.tgz](https://www.apache.org/dyn/closer.lua/lucene/solr/8.11.2/solr-8.11.2.tgz) or [solr-8.11.2.zip](https://www.apache.org/dyn/closer.lua/lucene/solr/8.11.2/solr-8.11.2.zip)

Copy the necessary configuration files. In the example below from the root of your project to the place you extracted Solr:

``` bash
# Make sure to replace the /opt/solr/ path with where you have placed Solr
cd /opt/solr
mkdir -p server/ibexa/template
cp -R <project_root>/vendor/ibexa/solr/src/lib/Resources/config/solr/* server/ibexa/template
cp server/solr/configsets/_default/conf/{solrconfig.xml,stopwords.txt,synonyms.txt} server/ibexa/template
cp server/solr/solr.xml server/ibexa

# If you are using Ibexa Commerce, additionally copy commerce-specific configuration files:
cat <project_root>/vendor/ibexa/commerce-shop/src/bundle/Search/Resources/config/solr/custom-fields-types.xml >> server/ibexa/template/custom-fields-types.xml
cat <project_root>/vendor/ibexa/commerce-shop/src/bundle/Search/Resources/config/solr/language-fieldtypes.xml >> server/ibexa/template/language-fieldtypes.xml

# Modify solrconfig.xml to remove the section that doesn't agree with your schema
sed -i.bak '/<updateRequestProcessorChain name="add-unknown-fields-to-the-schema".*/,/<\/updateRequestProcessorChain>/d' server/ibexa/template/solrconfig.xml

# Start Solr (but apply autocommit settings below first if you need to)
bin/solr -s ibexa
bin/solr create_core -c collection1 -d server/ibexa/template
```

##### SolrCloud

SolrCloud is a cluster of Solr servers. It enables you to:

- centralize configuration
- automatically load balance and fail-over for queries
- integrate ZooKeeper for cluster coordination and configuration

To set SolrCloud up follow [SolrCloud reference guide.](https://lucene.apache.org/solr/guide/7_7/solrcloud.html)

#### Further configuration

The bundle does not commit Solr index changes directly on Repository updates, leaving it up to you to tune this using `solrconfig.xml` as best practice suggests.

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

#### Generating configuration

The command line tool `bin/generate-solr-config.sh` generates Solr 7 configuration automatically.
It can be used for deploying to Ibexa Cloud (Platform.sh) and on-premise installs.

Execute the script from the [[= product_name =]] root directory for further information:

``` bash
./vendor/ibexa/solr/bin/generate-solr-config.sh --help
```

### Step 2: Configure the bundle

The Solr Search Engine Bundle can be configured in many ways. The config further below assumes you have parameters set up for Solr DSN and search engine *(however both are optional)*, for example:

``` yaml
    env(SEARCH_ENGINE): solr
    env(SOLR_DSN): 'http://localhost:8983/solr'
    env(SOLR_CORE): collection1
```

#### Single-core example (default)

Out of the box in [[= product_name =]] the following is enabled for a simple setup:

``` yaml
ibexa_solr:
    endpoints:
        endpoint0:
            dsn: '%solr_dsn%'
            core: '%solr_core%'
    connections:
        default:
            entry_endpoints:
                - endpoint0
            mapping:
                default: endpoint0
```

#### Shared-core example

The following example separates one language. The installation contains several similar languages,
and one very different language that should receive proper language analysis for proper stemming and sorting behavior by Solr:

``` yaml
ibexa_solr:
    endpoints:
        endpoint0:
            dsn: '%solr_dsn%'
            core: core0
        endpoint1:
            dsn: '%solr_dsn%'
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

#### Multi-core example

If full language analysis features are preferred, then each language can be configured with separate cores.

!!! note

    Make sure to test this setup against a single-core setup, as it might perform worse than single-core if your project uses a lot of language fallbacks per SiteAccess, as queries will then be performed across several cores at once.

``` yaml
ibexa_solr:
    endpoints:
        endpoint0:
            dsn: '%solr_dsn%'
            core: core0
        endpoint1:
            dsn: '%solr_dsn%'
            core: core1
        endpoint2:
            dsn: '%solr_dsn%'
            core: core2
        endpoint3:
            dsn: '%solr_dsn%'
            core: core3
        endpoint4:
            dsn: '%solr_dsn%'
            core: core4
        endpoint5:
            dsn: '%solr_dsn%'
            core: core5
        endpoint6:
            dsn: '%solr_dsn%'
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
                    jpn-JP: endpoint1
                    eng-US: endpoint2
                    fre-FR: endpoint3
                    ger-DE: endpoint4
                    esp-ES: endpoint5
                # Not really used, but specified here for fallback if more languages are suddenly added by content admins
                default: endpoint0
                # Also use separate core for main languages (differs from content object to content object)
                # This is useful to reduce number of cores queried for always available language fallbacks
                main_translations: endpoint6
```

#### SolrCloud example

To use SolrCloud you need to specify data distribution strategy for connection via the `distribution_strategy` option to [`cloud`.](https://lucene.apache.org/solr/guide/7_7/solrcloud.html)

The example is based on multi-core setup so any specific language analysis options could be specified on the collection level.

``` yaml
ibexa_solr:
    endpoints:
        main:
            dsn: '%solr_dsn%'
            core: '%solr_main_core%'
        en:
            dsn: '%solr_dsn%'
            core: '%solr_en_core%'
        fr:
            dsn: '%solr_dsn%'
            core: '%solr_fr_core%'
        # ...
    connections:
        default:
            distribution_strategy: cloud
            entry_endpoints:
                - main
                - en
                - fr
             # -  ...
            mapping:
                translations:
                    eng-GB: en
                    fre-FR: fr
                    # ...
                main_translations: main
```

This solution uses the default SolrCloud [document routing strategy: `compositeId`.](https://lucene.apache.org/solr/guide/7_7/shards-and-indexing-data-in-solrcloud.html#ShardsandIndexingDatainSolrCloud-DocumentRouting)

#### Solr Basic HTTP Authorization
Solr core can be secured with Basic HTTP Authorization. See more information here: [Solr Basic Authentication Plugin.](https://cwiki.apache.org/confluence/display/solr/Basic+Authentication+Plugin)
In the example below we configured Solr Bundle to work with secured Solr core.

``` yaml
ibexa_solr:
    endpoints:
        endpoint0:
            dsn: '%solr_dsn%'
            core: core0
            user: example
            pass: password
```

Obviously, you should pass credentials for every configured and HTTP Basic secured Solr core. Configuration for multi core setup is exactly the same.

### Step 3: Configure repository with the specific search engine

The following is an example of configuring Solr search engine, where `connection` name is same as in the example above, and engine is set to `solr`:

``` yaml
ibexa:
    repositories:
        default:
            storage: ~
            search:
                engine: '%search_engine%'
                connection: default
```

`%search_engine%` is a parameter that is configured in `config/packages/ibexa.yaml`, and should be changed from its default value `legacy` to `solr` to activate Solr as the search engine.

### Step 4: Clear prod cache

While Symfony `dev` environment keeps track of changes to YAML files, `prod` does not, so clear the cache to make sure Symfony reads the new config:

``` bash
php bin/console --env=prod cache:clear
```

### Step 5: Run CLI indexing command

The last step is to execute the initial indexation of data:

``` bash
php bin/console --env=prod --siteaccess=<name> ibexa:reindex
```

#### Possible exceptions

If you have not configured your setup correctly, some exceptions might happen on indexing.
Here are the most common issues you may encounter:

- Exception if Binary files in database have an invalid path prefix
    - Make sure `var_dir` is configured properly in `ibexa.yaml` configuration.
    - If your database is inconsistent in regards to file paths, try to update entries to be correct *(make sure to make a backup first)*.
- Exception on unsupported Field Types
    - Make sure to implement all Field Types in your installation, or to configure missing ones as [NullType](nullfield.md) if implementation is not needed.
- Content is not immediately available 
    - Solr Bundle on purpose does not commit changes directly on Repository updates *(on indexing)*, but lets you control this using Solr configuration. Adjust Solr's `autoSoftCommit` (visibility of changes to search index) and/or `autoCommit` (hard commit, for durability and replication) to balance performance and load on your Solr instance against needs you have for "[NRT](https://cwiki.apache.org/confluence/display/solr/Near+Real+Time+Searching)".
- Running out of memory during indexing
    - In general make sure to run indexing using the prod environment to avoid debuggers and loggers from filling up memory.
    - Flysystem: You can find further info in https://jira.ez.no/browse/EZP-25325.

## Solr configuration

### Boost configuration

!!! caution "Index time boosting"

    Index time boosting was deprecated in Solr 6.5 and removed in Solr 7.0.
    Until query time boosting is implemented, there is no way to boost in the bundle out of the box.

!!! tip "How boosting interacts with Search API"

    Boosting of fields or documents will affect the score (relevance) of your search result hits
    when using Search API for any Criteria you specify on `$query->query`, or in REST by using `Query` element.
    When you don't specify anything to sort on, the result will be sorted by this relevance.
    Anything set on `$query->filter`, or in REST using `Filter` element, will *not* affect scoring and only works
    as a pure filter for the result. Thus make sure to place Criteria you want to affect scoring on `query`.

Boosting currently happens when indexing, so if you change your configuration you will need to re-index.

Boosting tells the search engine which parts of the content model have more importance when searching, and is an important part of tuning your search results relevance. Importance is defined using a numeric value, where `1.0` is default, values higher than that are more important, and values lower (down to `0.0`) are less important.

Boosting is configured per connection that you configure to use for a given Repository, like in this `config/packages/ibexa_solr.yaml` example:

``` yaml
ibexa_solr:
    connections:
        default:
            boost_factors:
                content_type:
                    # Boost a whole Content Type
                    article: 2.0
                meta_field:
                    # Boost a meta Field (name, text) system wide, or for a given Content Type
                    name: 10.0
                    article:
                        # Boost the meta full text Field for article more than 2.0 set above
                        text: 5.0
```

The configuration above will result in the following boosting (Content Type / Field):

- `article/title: 2.0`
- `news/description: 1.0` (default)
- `article/text (meta): 5.0`
- `blog_post/name (meta): 10.0`
- `article/name (meta): 2.0`

!!! tip "How to configure boosting on specific fields"

    Currently, boosting on particular fields is missing.
    However, it could be configured using 3rd party [Novactive/NovaeZSolrSearchExtraBundle](https://github.com/Novactive/NovaeZSolrSearchExtraBundle) in case of custom search implementation, e.g. to handle your front-end search form.
    Unfortunately, this doesn't affect search performed in the administration interface.

    The following example presents boosting configuration for Folder's `name` and `description` fields.
    First, in `ibexa_solr.yaml` configure [custom fulltext fields.](https://github.com/Novactive/NovaeZSolrSearchExtraBundle/blob/master/doc/custom_fields.md)

    ```yaml
    ez_solr_search_extra:
        system:
            default:
                fulltext_fields:
                    custom_folder_name:
                        - folder/name
                    custom_folder_description:
                        - folder/description
    ```

    The second step requires you to use `\Novactive\EzSolrSearchExtra\Query\Content\Criterion\MultipleFieldsFullText` instead of default `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\FullText`.
    The following example shows custom query which benefits from the custom fields created in the previous example.

    ```php
    <?php

    namespace App\Controller;

    use Ibexa\Contracts\Core\Repository\SearchService;
    use Ibexa\Contracts\Core\Repository\Values\Content\Query;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    class SearchController
    {
        /**
         * @var \Ibexa\Contracts\Core\Repository\SearchService
         */
        private $searchService;

        public function __construct(SearchService $searchService)
        {
            $this->searchService = $searchService;
        }

        public function searchAction(Request $request): Response
        {
            $queryString = $request->get('query');

            $query = new Query();
            $query->query = new \Novactive\EzSolrSearchExtra\Query\Content\Criterion\MultipleFieldsFullText(
                $queryString,
                [
                    'metaBoost' => [
                        'custom_folder_name' => 20.0,
                        'custom_folder_description' => 10.0,
                    ]
                ]
            );

            $searchResult = $this->searchService->findContent($query);

            ...
        }
    }
    ```

    Remember to clear the cache and perform search engine reindex afterwords.

    The above configuration will result in the following boosting (Content Type / Field):
    
    - `folder/name: 20.0`
    - `folder/description: 10.0`

### Indexing related objects

You can use indexation of related objects to search through text of related content.
Indexing is disabled by default.
To set it up you need to define the maximum indexing depth using the following YAML configuration:

```yaml
ibexa_solr:
    # ...
    connections:
        default:
            # ...
            indexing_depth:
                # Default value: 0 - no relation indexing, 1 - direct relations, 2nd level  relations, 3rd level  relations (maximum value).
                default: 1      
                content_type:
                    # Index depth defined for specific content type
                    article: 2
```

### Configuring Solr Replication (master/slave)

!!! note

    The configuration below has been tested on Solr 7.7.

#### Configuring Master for replication

First you need to change the core configuration in `solrconfig.xml` (for example `*/opt/solr/server/ibexa/collection1/conf/solrconfig.xml`).
You can copy and paste the code below before any other `requestHandler` section.

```xml
<requestHandler name="/replication" class="solr.ReplicationHandler">
  <lst name="master">
    <str name="replicateAfter">optimize</str>
    <str name="backupAfter">optimize</str>
    <str name="confFiles">schema.xml,stopwords.txt,elevate.xml</str>
    <str name="commitReserveDuration">00:00:10</str>
  </lst>
  <int name="maxNumberOfBackups">2</int>
  <lst name="invariants">
    <str name="maxWriteMBPerSec">16</str>
  </lst>
</requestHandler>
<str name="confFiles">solrconfig_slave.xml:solrconfig.xml,x.xml,y.xml</str>
```

Then restart the master with:

```bash
sudo su - solr -c "/opt/solr/bin/solr restart"
```

#### Configuring Slave for replication

You have to edit the same file on the slave server, and use the code below:

```xml
<requestHandler name="/replication" class="solr.ReplicationHandler">
  <lst name="slave">

    <!-- fully qualified url for the replication handler of master. It is
         possible to pass on this as a request param for the fetchindex command -->
    <str name="masterUrl">http://123.456.789.0:8983/solr/collection1/replication</str>

    <!-- Interval in which the slave should poll master.  Format is HH:mm:ss .
         If this is absent slave does not poll automatically.
         But a fetchindex can be triggered from the admin or the http API -->
    <str name="pollInterval">00:00:20</str>

    <!-- THE FOLLOWING PARAMETERS ARE USUALLY NOT REQUIRED-->
    <!-- To use compression while transferring the index files. The possible
         values are internal|external.  If the value is 'external' make sure
         that your master Solr has the settings to honor the accept-encoding header.
         See here for details: http://wiki.apache.org/solr/SolrHttpCompression
         If it is 'internal' everything will be taken care of automatically.
         USE THIS ONLY IF YOUR BANDWIDTH IS LOW.
         THIS CAN ACTUALLY SLOWDOWN REPLICATION IN A LAN -->
    <str name="compression">internal</str>

    <!-- The following values are used when the slave connects to the master to
         download the index files.  Default values implicitly set as 5000ms and
         10000ms respectively. The user DOES NOT need to specify these unless the
         bandwidth is extremely low or if there is an extremely high latency -->
    <str name="httpConnTimeout">5000</str>
    <str name="httpReadTimeout">10000</str>

    <!-- If HTTP Basic authentication is enabled on the master, then the slave
         can be configured with the following -->
    <str name="httpBasicAuthUser">username</str>
    <str name="httpBasicAuthPassword">password</str>
  </lst>
</requestHandler>
```

Next, restart Solr slave.

Connect to the Solr slave interface (http://localhost:8983/solr), go to your core and check the replication status:

![Solr Slave](solr.png)

## Configuring HTTP Client for Solr queries

Ibexa Solr Bundle uses Symfony HTTP Client to fetch and update Solr index.
You can configure timeout and maximum number of retries for that client using Solr Bundle's Semantic configuration:

```yaml
ibexa_solr:
    # ...
    http_client:
        # ...
        timeout: 30
        max_retries: 5
```

## Extending Solr

To learn how you can create document field mappers, custom Search Criteria, 
custom Sort Clauses and Aggregations, see [Search extensibility](create_custom_search_criterion.md).
