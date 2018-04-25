## ElasticSearch Bundle

!!! caution "Experimental"

    ElasticSearch exists only as a technology preview, and only running on the same version of ElasticSearch as it was originally prototyped for, [v1.4.2](https://github.com/ezsystems/ezpublish-kernel/blob/v6.9.0/.travis.yml#L48). We encourage everyone to try it and help make it better, even help porting it to a more up-to-date version of Elastic.

    Given it is experimental, it is currently not supported in any possible way besides code review on contributions.

### How to use ElasticSearch search engine

#### Step 1: Enabling the bundle

First, activate the ElasticSearch Search Engine Bundle (`eZ\Bundle\EzPublishElasticsearchSearchEngineBundle\EzPublishElasticsearchSearchEngineBundle`) in your `app/AppKernel.php`.

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

For further information on the ElasticSearch integration in eZ Platform, find the default [configuration](https://github.com/ezsystems/ezpublish-kernel/blob/v6.7.7/eZ/Publish/Core/Search/Elasticsearch/Content/Resources/elasticsearch.yml) and [mappings](https://github.com/ezsystems/ezpublish-kernel/tree/v6.7.7/eZ/Publish/Core/Search/Elasticsearch/Content/Resources/mappings) for Content and Location type documents.

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

Legacy search engine is the default search engine, it is SQL-based and uses Doctrine's database connection.
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
