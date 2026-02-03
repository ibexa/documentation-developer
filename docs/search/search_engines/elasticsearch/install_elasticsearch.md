---
month_change: true
description: Install Elasticsearch to use it with Ibexa DXP.
---

# Install Elasticsearch

## Download and install Elasticsearch


[[= product_name =]] supports Elasticsearch in version 7.16 with the `ibexa/elasticsearch` package that is installed by default.
You can use Elasticsearch 8.19 by installing the `ibexa/elasticsearch8` package instead.

To install it, run:

``` console
composer require ibexa/elasticsearch8
```

Then, install Elasticsearch on your server:

- Elasticsearch 7: [Install Elasticsearch 7](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/install-elasticsearch.html)
- Elasticsearch 8: [Install Elasticsearch 8](https://www.elastic.co/guide/en/elasticsearch/reference/8.19/install-elasticsearch.html)

As an example, you can use the following [Docker](https://docs.docker.com/get-started/docker-overview/) commands:

=== "Elasticsearch 7"

    ```yml
    docker run -d --name ibexa-dxp-elasticsearch -p 9200:9200 -p 9300:9300 -e "discovery.type=single-node" docker.elastic.co/elasticsearch/elasticsearch:7.16.2
    ```

=== "Elasticsearch 8"

    ```yml
    docker run -d --name ibexa-dxp-elasticsearch -p 9200:9200 -p 9300:9300 -e "discovery.type=single-node" docker.elastic.co/elasticsearch/elasticsearch:8.19.0
    ```

## Verify the instance

To make sure that the Elasticsearch instance operates properly, access the instance, for example, with `curl http://localhost:9200/`.

If Elasticsearch operates properly, an object with cluster details is displayed.
It should be similar to one of the following examples:

=== "Elasticsearch 7"

    ``` json
    {
        "name": "doej-MacPro-mTkBe",
        "cluster_name": "elasticsearch",
        "cluster_uuid": "WLYqnQ_lSZGbX-vDIe_vZQ",
        "version": {
            "number": "7.7.0",
            "build_flavor": "default",
            "build_type": "tar",
            "build_hash": "5b1fea5",
            "build_date": "2020-05-10T02:35:59.208Z",
            "build_snapshot": false,
            "lucene_version": "8.5.1",
            "minimum_wire_compatibility_version": "6.8.0",
            "minimum_index_compatibility_version": "6.0.0-beta1"
        },
        "tagline": "You Know, for Search"
    }
    ```

=== "Elasticsearch 8"

    ``` json
    {
        "name": "f45b86ab3726",
        "cluster_name": "docker-cluster",
        "cluster_uuid": "5OAEghGPTLSd4jUJColoNQ",
        "version": {
            "number": "8.19.0",
            "build_flavor": "default",
            "build_type": "docker",
            "build_hash": "93788a8c2882eb5b606510680fac214cff1c7a22",
            "build_date": "2025-07-23T22:10:18.138212839Z",
            "build_snapshot": false,
            "lucene_version": "9.12.2",
            "minimum_wire_compatibility_version": "7.17.0",
            "minimum_index_compatibility_version": "7.0.0"
        },
        "tagline": "You Know, for Search"
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

    All the settings, their order and meaning, correspond to the settings that are described in the Elasticsearch documentation.

First, decide how [[= product_name =]] connects to Elasticsearch and configure other connection settings.

For more information, see [Configuring connections](configure_elasticsearch.md#configure-connections).

Then, define a field type mappings template that instructs Elasticsearch to interpret [[= product_name =]] fields as specific types.

For more information, see [Configuring field type mappings](configure_elasticsearch.md#define-field-type-mapping-templates).

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

    Don't reindex your data before you create index templates.
    Otherwise, Elasticsearch attempts to use its dynamic field mapping feature to create type mappings automatically.
    
    For more information, see:
    
    - Elasticsearch 7: [Dynamic field mapping](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/dynamic-field-mapping.html)
    - Elasticsearch 8: [Dynamic field mapping](https://www.elastic.co/guide/en/elasticsearch/reference/8.19/dynamic-field-mapping.html)
