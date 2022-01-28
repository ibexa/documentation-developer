# Other search engines

## Legacy Search Engine Bundle

Legacy search engine is the default search engine, it is SQL-based and uses Doctrine's database connection.
Its connections are defined in the same way as for storage engine, and no further specific configuration is needed.

!!! tip

    The features and performance of Legacy search engine are limited.
    If you have specific search or performance needs you should look towards using [Solr](solr.md)
    or [Elasticsearch](elastic.md).
    
    Using the Legacy search engine disables most shop features, such as product search.

### Configuring the Repository with the Legacy search engine

Search can be configured independently from storage, and the following configuration example shows both the default values, and how you configure legacy as the search engine:

``` yaml
ibexa:
    repositories:
        main:
            storage:
                engine: legacy
                connection: default
            search:
                engine: legacy
                connection: default
```
