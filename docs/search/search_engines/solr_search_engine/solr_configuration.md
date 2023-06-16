---
description: Configure Solr search engine to use with Ibexa DXP.
---

# Solr configuration

## Boost configuration

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

## Indexing related objects

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

## Configuring Solr Replication (master/slave)

!!! note

    The configuration below has been tested on Solr 7.7.

### Configuring Master for replication

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

### Configuring Slave for replication

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

# Configuring HTTP Client for Solr queries

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

# Extending Solr

To learn how you can create document field mappers, custom Search Criteria, 
custom Sort Clauses and Aggregations, see [Search extensibility](create_custom_search_criterion.md).
