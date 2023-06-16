---
description: Configure Legacy search engine to use with Ibexa DXP.
---

# Repository configuration with Legacy search engine

Search can be configured independently from storage, and the following configuration example shows both the default values, 
and how you configure legacy as the search engine:

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
