---
description: Configure Legacy search engine to use it with Ibexa DXP.
---

# Configure repository with Legacy search engine

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
