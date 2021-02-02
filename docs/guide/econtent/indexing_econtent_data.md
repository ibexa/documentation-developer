# Indexing eContent data

eContent data can be indexed by executing the following command:

``` bash
php bin/console ibexa:commerce:index-econtent
```

eContent Solr configuration uses two cores to keep search services available while indexing.
This means that the indexer indexes eContent data in the back core,
and then the indexer can be executed again with a swap parameter to swap the cores.

|Command options|Results|
|--- |--- |
|`-c 5000`|Specifies the chunk size (how many elements are indexed at the same time).|
|`-r`|Deletes all previous eContent data.|
|`--siteaccess=import`|Informs the indexer to take the product data from the temporary tables.|
|`--live-core`|Indexes directly on the live core (and not on the back core).</br>If you use `-r` together `--live-core`, the delete operation takes place before starting the indexer, so the full indexed content is not be available while indexing.|
|`swap`|Does not index, but swaps the cores instead.|

### Additional parameters

|||
|--- |--- |
|`siso_search.default.index_econtent_languages`|Specifies the languages to index.|
|`siso_search.default.solr_spellcheck`|Enables or disables Solr spellcheck (aka "Did you mean?" functionality).|
|`siso_search.default.index_facet_fields`|Solr string fields are lowercased, therefore this configuration is used to specify an additional Solr `_id` field.</br>ID fields are not lowercased, which results in facets that can preserve their original case.</br>Field names must be specified without the `_s` suffix.|
