# Indexing eContent data [[% include 'snippets/commerce_badge.md' %]]

If [[= product_name_com =]] is configured to use eContent as data provider, the following things have to be taken into consideration when indexing.

## Default indexing

eContent data can be indexed by executing the following command:

``` bash
php bin/console silversolutions:indexecontent
```

eContent Solr configuration uses two cores to keep search services available while indexing.
This means that the indexer indexes eContent data in a back core,
and then the indexer can be executed again with a swap parameter to swap the cores.

|Indexer options|Results|
|--- |--- |
|`-c 5000 -r --siteaccess=import`|`-c` specifies the chunk size (how many elements are indexed at a same time).</br>`-r` deletes all previous eContent data.</br>Important: the parameter `siteaccess=import` informs the indexer to take the product data from the temporary tables.|
|`--live-core`|Indexes directly on the live core (and not on the back core).</br>If you use `-r` and `--live-core`, the delete operation takes place before starting the indexer, so the full indexed content will not be available while indexing.|
|`swap`|Does not index, but swaps the cores instead.|

### Additional parameters

|||
|--- |--- |
|`siso_search.default.index_econtent_languages: [ ger-DE, eng-GB ]`|Specifies the languages to index.|
|`siso_search.default.solr_spellcheck: true`|Enables or disables Solr spellcheck (aka "Did you mean?" functionality)|
|`siso_search.default.index_facet_fields:`|Solr string fields are lowercased, therefore this configuration is used to specify an additional Solr `_id` field.</br>ID fields are not lowercased, which results in facets that can preserve their original case.</br>Field names must be specified without the `_s` suffix.|

## Custom indexing using plugins

eContent indexer also supports a plugin architecture for adding additional logic to the indexing process.

The plugin can index price ranges. Given a product price, it creates a range index based on that price.
For example, for the price of $150, the output can be 100-200.

In order to work the plugins must implement the `EcontentIndexerPluginInterface` interface.

For more information, see [Custom indexer plugin for eContent](../../econtent_cookbook/econtent_search_cookbook/custom_indexer_plugin_for_econtent.md)
