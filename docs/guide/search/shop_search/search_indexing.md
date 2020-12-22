# Search indexing [[% include 'snippets/commerce_badge.md' %]]

## Reindexing

Use the following command to reindex the search content:

``` bash
php bin/console ezplatform:reindex
```

## Removing index in production

When you use the content model as a data provider, `ezplatform:solr_create_index` removes the index in production.

Details of this action depend on the configuration. If Solr is configured to auto-commit, the index is removed.
If no auto-commit is configured, the index is removed as well, but the removal takes effect after the commit at the end. 
Until that time the index can be used for searching.

No auto-commit also means that changes are not visible in the Back Office, since the process does not include a commit.

To resolve this, you can increase the auto-commit time to a value close to the required time of the indexing process.
This is only applicable for setups with data that does not take very long to index.

Check `solrconfig.xml` of the respective Solr core and adjust the settings:

``` xml
<maxTime>${solr.autoCommit.maxTime:160000}</maxTime>
   <openSearcher>true</openSearcher>
 </autoCommit>
```

## Indexing content model product data

If the content model is used as the data provider, the Solr Search Engine Bundle indexes all product data.
This means all indexed product documents are Content items.

In order to customize the searchable data for products, you can write plug-ins for the indexer of the Solr search bundle.

### ProductDocumentMapperPlugin

The `ProductDocumentMapperPlugin` plugin generates a special field for the price range based on product unit price.
It is a service which is injected into the main indexer execution based on the `ezpublish.search.solr.document_mapper_plugin` tag.

This service implements `EzSystems\EzPlatformSolrSearchEngine\DocumentMapperPluginInterface`.

#### `canExtend()`

The `canExtend()` method checks and returns `true` if the passed Content Type can be extended.
For example, for products it checks for type `identifier == ses_products`

This is called in order to determine if this plugin implementation knows the given Content Type and is able to extend it.
If it returns true, `createExtensionFields()` is called, otherwise this plugin is ignored.

#### `createExtensionFields()`

The `createExtensionFields()` method creates the SPI search elements that correspond to each product's extended fields.
This method receives a Content item, a Content Type and a language code.

It is called for every indexed Content item and language.
The generated Field instances get a prefix (e.g. `ext_`) in their names in order to avoid naming conflicts with existing content Fields
and to distinguish them from standard fields.
