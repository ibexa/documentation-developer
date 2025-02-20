---
description: Manipulate the search query when using the Elasticsearch search engine.
---

# Manipulate Elasticsearch query

You can customize the search query before it's executed.
To do it, subscribe to [`Ibexa\Contracts\Elasticsearch\Query\Event\QueryFilterEvent`](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Elasticsearch-Query-Event-QueryFilterEvent.html).

The following example shows how to add a Search Criterion to all queries.

Depending on your configuration, this might impact all search queries, including those used for search and content tree in the back office.

``` php hl_lines="34"
--8<--
code_samples/search/custom/src/EventSubscriber/CustomQueryFilterSubscriber.php
--8<--
```

If you're not using [Symfony's autoconfiguration]([[= symfony_doc =]]/service_container.html#the-autoconfigure-option)
for event subscribers, register it as a service:

``` yaml
services:
    App\EventSubscriber\CustomQueryFilterSubscriber:
        tags:
            - { name: kernel.event_subscriber }
```
