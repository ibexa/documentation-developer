---
description: Index custom data when using the Elasticsearch search engine.
---

# Index custom Elasticsearch data

[Elasticsearch](elasticsearch_overview.md) indexes content and location data out of the box.
Besides what is indexed automatically, you can add additional data to the Elasticsearch index.

To do so, subscribe to one of the following events:

- [`Ibexa\Contracts\ElasticSearchEngine\Mapping\Event\ContentIndexCreateEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Elasticsearch-Mapping-Event-ContentIndexCreateEvent.html)
- [`Ibexa\Contracts\ElasticSearchEngine\Mapping\Event\LocationIndexCreateEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Elasticsearch-Mapping-Event-LocationIndexCreateEvent.html)

These events are called when the index is created for the content and location documents.

You can pass the event to a subscriber which gives you access to the document that you can modify.

In the following example, when an index in created for a content or a location document, the event subscriber adds a `custom_field` of the type [`StringField`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-FieldType-StringField.html) to the index:

``` php hl_lines="19 20 21"
--8<--
code_samples/search/custom/src/EventSubscriber/CustomIndexDataSubscriber.php
--8<--
```

If you're not using [Symfony's autoconfiguration]([[= symfony_doc =]]/service_container.html#the-autoconfigure-option)
for event subscribers, register it as a service:

``` yaml
services:
    App\EventSubscriber\CustomIndexDataSubscriber:
        tags:
            - { name: kernel.event_subscriber }
```
