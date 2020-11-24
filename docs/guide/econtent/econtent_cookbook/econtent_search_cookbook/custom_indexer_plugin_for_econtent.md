# Custom indexer plugin for eContent [[% include 'snippets/commerce_badge.md' %]]

The following example shows how to create a plugin for eContent that indexes an additional field
based on a serialised array that comes from the database.

The database stores keys and values for the articles. They come in a serialised format, for example:

``` 
ses_datamap_additional_data = a:2:{s:4:"Code";s:3:"AXW";s:4:"Name";s:20:"Awesome Speaker AX50";}
```

The indexer creates the following output:

- Index field `additional_product_code` with value "AXW"
- Index field `additional_product_name` with value "Awesome Speaker AX50"

### Create a plugin class

Create a plugin class that implements `EcontentIndexerPluginInterface`

``` php
class AdditionalDataIndexerPlugin implements EcontentIndexerPluginInterface
{
    public function buildIndexFields(array $econtentData, $elementType)
    {
    }
}
```

### Create a service definition

You must register the class as a service:

``` xml
<parameter key="siso_search.additional_data_indexer_plugin.class">YOURNAMESPACE\AdditionalDataIndexerPlugin</parameter>
  
<service id="siso_search.additional_data_indexer_plugin" class="%siso_indexer.additional_data_indexer_plugin.class%">
    <tag name="siso_search.econtent_indexer_plugin" />
</service>
```

### Create custom logic

In your custom logic, you have to loop through the product data map.

eContent data map supports the following data types:

- strings, stored in a `data_text` field
- integers, stored in a `data_int` field
- floats, stored in a `data_float` field

For array support use serialised arrays.

``` php
class AdditionalDataIndexerPlugin implements EcontentIndexerPluginInterface
{
    public function buildIndexFields(array $econtentData, $elementType)
    {
        foreach ($econtentData['data_map'] as $attribute) {
            if ($attribute['attribute_name'] === 'ses_datamap_additional_data ') {
                // If the stored attribute is a string, the value will be in a field name data_text
                $additionalData = unserialize($attribute['data_text']);
                if (
                    is_array($additionalData) &&
                    isset($additionalData['ArrayFieldHash']['array'][0]['code']) &&
                    isset($additionalData['ArrayFieldHash']['array'][0]['name'])
                ) {
                    return array (
                        'additional_data_code' => $additionalData['ArrayFieldHash']['array'][0]['code'],
                        'additional_data_name' => trim($additionalData['ArrayFieldHash']['array'][0]['name'])
                    );
                }
        }
        return null;
    }
}
``` 

This creates two new Solr fields with the following names and values:

- The prefix (here `ses_product_ses_datamap_ext_`) is added automatically and contains the Content Type (here `product`) as well
- The suffix `_s` is added because the indexer detects the value as a string.
The indexer also supports these additional data types with the corresponding suffix:

|Suffix|Data type|
|---|---|
|String|`_s`|
|Array (Multiple strings)|`_ms`|
|Float|`_f`|
|Integer|`_i`|
|long|`_l`|

The data type is specified in `EcontentFieldNameResolver`.

!!! note "Long data types"

    Solr accepts the following min and max integer values:

    ```
    SOLR_MAX_INT = 2147483647;
    SOLR_MIN_INT = -2147483648;
    ```

```
ses_product_ses_datamap_ext_additional_data_code_s: "AXW"
ses_product_ses_datamap_ext_additional_data_name_s: "Awesome Speaker AX50"
```

After executing the indexer command line, you should be able to see the new indexed content in Solr.

For instructions about running the eContent indexer, see [Indexing econtent data](../../econtent_features/indexing_econtent_data/indexing_econtent_data.md).
