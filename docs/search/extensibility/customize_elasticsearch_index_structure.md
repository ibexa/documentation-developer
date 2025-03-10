---
description: You can adapt the structure of Elasticsearch index to the data in your Repository to improve performance and avoid instability.
---

# Customize Elasticsearch index structure

You can customize the structure of your Elasticsearch search index to manage how documents in the index are grouped.

This lets you control the size of [Elasticsearch shards](https://www.elastic.co/guide/en/elasticsearch/reference/current/scalability.html) that the index is divided into.

By customizing the structure to your needs, you can avoid "oversharding" (having too many shards), which negatively affects performance and can lead to instability.

For more information about adapting the size of your search index shards, see [Elasticsearch documentation](https://www.elastic.co/guide/en/elasticsearch/reference/8.4/size-your-shards.html).

## Selecting indexing strategy

In your Elasticsearch configuration you can select one of four built-in strategies that control grouping documents in the index.

The strategies are:

- `NullGroupResolver` - groups all documents into a single group.
- `LanguageGroupResolver` - groups documents by language code.
- `ContentTypeGroupResolver`- groups documents by content type ID.
- `CompositeGroupResolver` - allows combining multiple group resolves together to have a more granular index (default).

The default strategy is the composite of language and content type ID, resulting in indexes in the form of `<repository>_<document_type>_<language>_<content_type_id>`.

To change the strategy, use the `ibexa_elasticsearch.document_group_resolver` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa_elasticsearch:
    document_group_resolver: 'Ibexa\Elasticsearch\ElasticSearch\Index\Group\ContentTypeGroupResolver'
```

Select the strategy based on the structure of your repository, taking into accounts data such as the number of content items, content types, or languages.

## Custom indexing strategy

You can also create a group resolver that provides a custom indexing strategy.
This resolver must implement `Ibexa\Contracts\Elasticsearch\ElasticSearch\Index\Group\GroupResolverInterface`.

### Create group resolver

In this example, create a `ContentTypeGroupGroupResolver` based on the content type Group ID of the document:

``` php
[[= include_file('code_samples/search/custom/src/GroupResolver/ContentTypeGroupGroupResolver.php') =]]
```

Register the resolver as a service:

``` yaml
[[= include_file('code_samples/search/custom/config/group_resolver_services.yaml') =]]
```

### Configure indexing strategy

Finally, in configuration indicate that Elasticsearch should use your custom indexing strategy:

``` yaml
[[= include_file('code_samples/search/custom/config/packages/elasticsearch.yaml') =]]
```
