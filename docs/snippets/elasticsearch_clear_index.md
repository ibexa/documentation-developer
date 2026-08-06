To delete an index, you can use the Elasticsearch's REST API.

First, use the [`_cat/indices` endpoint](https://www.elastic.co/guide/en/elasticsearch/reference/8.19/cat-indices.html) to list existing indices.
For example, the command `curl  -H "Accept: application/text" elasticsearch:9200/_cat/indices` returns output like the following:

``` bash
yellow open default_location_eng_gb_54 DoSFV-CtQFylKKVvd48YfA 1 1  1 0 16.7kb 16.7kb
yellow open default_location_eng_gb_42 3Z_IrWVHQh2m37jPqQBOcQ 1 1  1 0 20.1kb 20.1kb
yellow open default_content_eng_gb_45  y-t4uNQwR4KRJ-N9i3zUog 1 1  1 0 21.3kb 21.3kb
yellow open default_content_eng_gb_46  e_LS5qG3RIih6iQRPsNp-w 1 1  1 0 22.5kb 22.5kb
yellow open default_content_eng_gb_1   101-1-tQS_2KSvNs2X2JAQ 1 1 17 0 39.8kb 39.8kb
yellow open default_location_eng_gb_46 fSGtpljwTpGfascFechmww 1 1  1 0   21kb   21kb
(...)
```

Create a list containing all indices used by [[= product_name =]], including the [custom indices](/search/search_engines/elasticsearch/configure_elasticsearch.md#define-field-type-mapping-templates) as well.

Then, delete them by using the [delete index endpoint](https://www.elastic.co/guide/en/elasticsearch/reference/8.19/indices-delete-index.html) 

``` bash
curl --request DELETE 'https://elasticsearch:9200/default_location*'
curl --request DELETE 'https://elasticsearch:9200/default_content*'
(...)
```

!!! tip

    To quickly delete all existing Elasticsearch indices, you can use the `_all` keyword as the name of the index, as in the following request: `curl --request DELETE https://elasticsearch:9200/_all`.
    Always review the list of existing indices and confirm they are safe to delete before executing this command, as it permanently removes data.

To update the schema and then reindex the search, use the following commands:

``` bash
php bin/console ibexa:elasticsearch:put-index-template --overwrite
php bin/console ibexa:reindex
```
