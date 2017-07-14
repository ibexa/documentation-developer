1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)
4.  [Search](Search_31429673.html)
5.  [Search Engines](Search-Engines_32112955.html)

# Legacy Search Engine Bundle 

Created by Dominika Kurek, last modified on Apr 29, 2016

**Legacy Search Engine** is the default search engine, it is SQL based and uses Doctrine's database connection. So its connections are, and should be, defined in the same way as for storage engine, and no further specific configuration is needed.

Its features and performance are limited, and if you have specific search or performance needs you should rather look towards using [Solr](Solr-Bundle_31430592.html).

## Configuring repository with the legacy search engine

Search can be configured independently from storage, and the following configuration example shows both the default values, and how you configure legacy as the search engine:

**ezpublish.yml**

``` brush:
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

 






