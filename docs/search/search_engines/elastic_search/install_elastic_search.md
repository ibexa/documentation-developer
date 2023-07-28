---
description: Install Elasticsearch to use it with Ibexa DXP.
---

# Install Elasticsearch

## Download and install Elasticsearch

[Install Elasticsearch](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/install-elasticsearch.html) on your server.
As an example, use the following [Docker](https://docs.docker.com/get-started/overview/) command:

```yml
docker run -d --name ibexa-dxp-elasticsearch -p 9200:9200 -p 9300:9300 -e "discovery.type=single-node" docker.elastic.co/elasticsearch/elasticsearch:7.16.2
```

!!! note

    [[= product_name =]] supports Elasticsearch in version 7.16.2 or higher.

## Verify the instance

To make sure that the Elasticsearch instance operates properly, access the instance (for example, with `curl http://localhost:9200/`).

If Elasticsearch operates properly, an object with cluster details is displayed.
It should be similar to the following example:

``` json
{
    "name" : "doej-MacPro-mTkBe",
    "cluster_name" : "elasticsearch",
    "cluster_uuid" : "WLYqnQ_lSZGbX-vDIe_vZQ",
    "version" : {
        "number" : "7.7.0",
        "build_flavor" : "default",
        "build_type" : "tar",
        "build_hash" : "5b1fea5",
        "build_date" : "2020-05-10T02:35:59.208Z",
        "build_snapshot" : false,
        "lucene_version" : "8.5.1",
        "minimum_wire_compatibility_version" : "6.8.0",
        "minimum_index_compatibility_version" : "6.0.0-beta1"
    },
    "tagline" : "You Know, for Search"
}
```

## Set the default search engine

Set the following environment variable (for example, in the `.env` or `.env.local` file):

``` yaml
SEARCH_ENGINE=elasticsearch
```

## Configure the search engine

[[= product_name =]] comes pre-configured to work with an Elasticsearch cluster that uses default settings, and you can use this initial setup for testing purposes.
However, to effectively search through actual data, you must provide specific settings.
All configuration is made in the `/config/packages/ibexa_elasticsearch.yaml` file.

!!! note

    All the settings, their order and meaning, correspond to the settings that are described in
    the Elasticsearch documentation.

First, decide how [[= product_name =]] connects to Elasticsearch and configure other connection settings.
For more information, see [Configuring connections](configure_elastic_search.md#connections).

Then, define a Field Type mappings template that instructs Elasticsearch to interpret [[= product_name =]] fields as specific types. For more information, see [Configuring Field Type mappings](configure_elastic_search.md#field-type-mapping-templates).

## Push the templates

For each of your defined connections, push the templates to the Elasticsearch engine by running the following command:

``` bash
php bin/console ibexa:elasticsearch:put-index-template
```

You can modify the behavior of the command with a number of switches. Use the `-h` switch to display a complete list of available options.

## Reindex the database

After creating index templates, run the following command to reindex your data:

``` bash
php bin/console ibexa:reindex
```

!!! caution "Risks of premature indexing"

    Do not reindex your data before you create index templates.
    Otherwise Elasticsearch attempts to use its [dynamic field mapping](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/dynamic-field-mapping.html) feature to create type mappings automatically.