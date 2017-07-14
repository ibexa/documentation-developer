1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)
4.  [Search](Search_31429673.html)
5.  [Search Engines](Search-Engines_32112955.html)

# ElasticSearch Bundle 

Created by Dominika Kurek, last modified on Jun 09, 2017

EXPERIMENTAL

ElasticSearch exists only as a technology preview, and only running on the same version of ElasticSearch as it was originally prototyped for, [v1.4.2](https://github.com/ezsystems/ezpublish-kernel/blob/v6.9.0/.travis.yml#L48). We encourage everyone to try it and help make it better, even help porting it to a more up to date version of Elastic.

Given it is experimental, it is currently not supported in any possible way besides code review on contributions.

 

## How to use ElasticSearch Search engine

### Step 1: Enabling Bundle

First, activate the Elasticsearch Search Engine Bundle (eZ\\Bundle\\EzPublishElasticsearchSearchEngineBundle\\EzPublishElasticsearchSearchEngineBundle) in your `app/AppKernel.php` class file.

### Step 2: Configuring Bundle

Then configure your search engine in config.yml

Example:

 

**config.yml**

``` brush:
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

 

### Step 3: Configuring repository

The following is an example of configuring the ElasticSearch Search Engine, where the `connection` name is same as in example above, and engine is set to be  `elasticsearch`:

 

 

**ezplatform.yml**

``` brush:
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

 

### Step 4: Run CLI indexing command

Last step is to execute initial indexation of data:

``` brush:
php app/console ezplatform:elasticsearch_create_index
```

 

 

#### In this topic:

-   [How to use ElasticSearch Search engine](#ElasticSearchBundle-HowtouseElasticSearchSearchengine)
    -   [Step 1: Enabling Bundle](#ElasticSearchBundle-Step1:EnablingBundle)
    -   [Step 2: Configuring Bundle](#ElasticSearchBundle-Step2:ConfiguringBundle)
    -   [Step 3: Configuring repository](#ElasticSearchBundle-Step3:Configuringrepository)
    -   [Step 4: Run CLI indexing command](#ElasticSearchBundle-Step4:RunCLIindexingcommand)






