# Elasticsearch search engine

Elasticsearch is an open-source, distributed, Java-based search engine that responds to queries
in real-time and is easily scalable in reaction to changing processing needs.

For a detailed description of advanced settings that you might require in a specific
production environment, see the documentation provided by Elastic, beginning with the [Set up Elasticsearch](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/setup.html) section.

**Prerequisite**

To proceed you need to be familiar with how indexing, filtering and queries work.

## Step 1: Download and install Elasticsearch

[Install Elasticsearch](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/install-elasticsearch.html) on your server.
For example, use the following [Docker](https://docs.docker.com/get-started/overview/) command:

```
docker run -d --name ibexa-dxp-elasticsearch -p 9200:9200 -p 9300:9300 -e "discovery.type=single-node" docker.elastic.co/elasticsearch/elasticsearch:7.7.1
```

!!! note

    [[= product_name =]] supports Elasticsearch in version 7.7.

## Step 2: Verify that the Elasticsearch instance is up

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

## Step 3: Set the default search engine

Set the following environment variable (for example, in the `.env` or `.env.local` file):

``` yaml
SEARCH_ENGINE=elasticsearch
```

## Step 4: Configure the search engine

[[= product_name =]] comes pre-configured to work with an Elasticsearch cluster that uses default settings, and you can use this initial setup for testing purposes.
However, to effectively search through actual data, you must provide specific settings.
All configuration is made in the `/config/packages/ezplatform_elastic_search_engine.yaml` file.

!!! note

    All the settings, their order and meaning, correspond to the settings that are described in
    the Elasticsearch documentation.

First, decide how [[= product_name =]] connects to Elasticsearch and configure other connection settings.
For more information, see [Configuring connections](#configuring-connections).

Then, define a field type mappings template that instructs Elasticsearch to interpret [[= product_name =]] fields as specific types. For more information, see [Configuring field type mappings](#configuring-field-type-mapping-templates).

## Step 5: Push the templates

For each of your defined connections, push the templates to the Elasticsearch engine by running the following command:

``` bash
php bin/console ezplatform:elasticsearch:put-index-template
```

You can modify the behavior of the command with a number of switches. Use the `-h` switch to display a complete list of available options.

## Step 6: Reindex the database

After creating index templates, run the following command to reindex your data:

``` bash
php bin/console ezplatform:reindex
```

!!! caution "Risks of premature indexing"

    Do not reindex your data before you create index templates.
    Otherwise Elasticsearch attempts to use its [dynamic field mapping](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/dynamic-field-mapping.html) feature to create type mappings automatically.

## Elasticsearch configuration reference

### Configuring connections

When you configure the Elasticsearch integration, you must first configure the connections.
You either connect to a [cluster of Elasticsearch nodes](#configure-a-cluster) or the [Elasticsearch Cloud](#configure-elasticsearch-cloud).

Define the connection settings under the `connections` key. First, set a name of the connection:

``` yaml
ez_platform_elastic_search_engine:
    connections:
        <connection_name>:
```

Then decide whether to add a cluster that you administer and manage yourself, or use a cloud
solution from Elastic, as well as configure additional parameters.
You can then decide how the cluster [handles communication with individual nodes](#configure-the-multi-node-cluster-behavior),
and configure the [security settings](#configure-security).

!!! tip "A default connection"

    If you define more than one connection, for example, to create a separate connection for
    each repository, you must select the one that [[= product_name =]] should use with the following setting:

    ``` yaml
    ez_platform_elastic_search_engine:
        # ...
        default_connection: <connection_name>
    ```

### Configuring a cluster

A cluster consists of a number of nodes.
You might start with just one node and add more nodes if you need more processing power.

When you configure a node, set the following parameters:

- `host` - An IP address or domain name of the host.
The default value is `localhost`.
- `port` - A port to connect to.
The default value is `9200`.
If you have several Elasticsearch instances that run on the same host, and want to make them
distinct, you can change the default number.
- `scheme` - A protocol to be used to access the node. Default value is `http`.
- `path` - By default, path is not used.
The default value is `null`.
If you have several Elasticsearch instances that run on the same host, and want to make them
distinct, you can define a path for each instance.  
- `user`/`pass` - Credentials, if needed to log in to the host.
Default values are `null`.

List the addresses of cluster nodes under the `hosts` key:

``` yaml
ez_platform_elastic_search_engine:
    connections:
        <connection_name>:
            hosts:
                - '127.0.0.1:9200'
                # ...
```

There are several ways that you can use to pass host parameters.
The easiest one is to pass them as a string:

``` yaml
- https://<my.elasticsearch.domain>:9200/<path>/
```

You can also pass the host configuration as an object that lists parameter-value pairs,
for example, when your authentication settings contain special characters.  

``` yaml
- { host: '<my.elasticsearch.domain>', scheme: 'http', port: 9200, path: '/', user: <username>, pass: <password> }
```

Cluster connection configuration should have the following structure:

``` yaml
ezplatform_elastic_search_engine:
    connections:
        simple:
            hosts:
                - '127.0.0.1:9200'
                - '127.0.0.1:9201'
                - '127.0.0.1:9202'

        localhost:
            debug: true
            hosts:
                - "127.0.0.1:9200"
                - "b.elasticsearch.loc:9200"
                - "c.elasticsearch.loc:9200"

        intranet:
            debug: true
            hosts:
                - "c.elasticsearch.loc:9200"

    default_connection: simple
```

#### Configuring the multi-node cluster behavior

When you configure a cluster-based connection, and the cluster consists of many nodes, you can
choose strategies that govern how the cluster reacts to changing operating conditions, or how
workload is distributed among the nodes.

##### Connection pool

With this setting you decide how a list of hosts that form a cluster is managed.
The list of active hosts tends to change in time, due to different reasons, such as connectivity
issues, host malfunction, or the fact that you add new hosts to the cluster to increase
its performance.
By default, the `StaticNoPingConnectionPool` setting is used.

You can change the default setting with the following key:

``` yaml
<connection_name>:
    # ...
    connection_pool: Elasticsearch\ConnectionPool\<connection_pool_name>
```

For more information and a list of available choices, see [Connection pool](https://www.elastic.co/guide/en/elasticsearch/client/php-api/7.x/connection_pool.html).

!!! tip "Load tests recommendation"

    If you change the connection pool setting, it is recommended that you to perform load tests
    to check whether the change does not negatively impact the performance of your environment.

##### Connection selector

When the cluster consists of many hosts, the `connection_selector` setting decides what strategy
is used to pick a node to send query requests to.
By default, the `RoundRobinSelector` setting is used.

If you prefer a different strategy, or have created your own, custom strategy, you can change the default setting with the following key:

``` yaml
<connection_name>:
    # ...
    connection_selector: Elasticsearch\ConnectionPool\Selectors\<selector_name>
```

For more information and a list of available choices, see [Selectors](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/selectors.html).

##### Number of retries

The `retries` setting configures the number of attempts that [[= product_name =]] makes to connect
to the nodes of the cluster before it throws an exception.
By default, `null` is used, which means that the number of retries equals to the number of nodes in the cluster.

``` yaml
<connection_name>:
    # ...
    retries: null
```

Depending on the connection pool that you select, [[= product_name =]]'s reaction to reaching the maximum
number of retries might differ.

For more information, see [Set retries](https://www.elastic.co/guide/en/elasticsearch/client/php-api/7.x/configuration.html#_set_retries).

### Configuring Elasticsearch Cloud

As an alternative to using your own cluster, you can use Elasticsearch Cloud, a commercial SaaS solution.
With Elasticsearch Cloud you do not have to build or manage your own Elasticsearch cluster.
Also, you do all the configuration and administration in a graphical user interface.

To connect to a cloud solution with [[= product_name =]], you must set the `elastic_cloud_id` parameter by
providing an alphanumerical ID string that you obtain from the cloud's user interface, for example:

``` yaml
<connection_name>:
    elastic_cloud_id: 'production:ZWFzdHVzMi5henVyZS5lbGFzdGljLWNsb3VkLmNvbTo5MjQzJGUwZ'
```

With the ID set, you must configure authentication to be able to access the remote environment.

### Configuring security

Elasticsearch instances support `basic` and `api_key` authentication methods.
You select authentication type and configure the settings under the `authentication` key. By default, authentication is disabled:

``` yaml
<connection_name>:
    # ...
    authentication:
        type: null
```

If you connect to Elasticsearch hosts outside of your local network, you might also need to configure SSL encryption.

#### Configuring basic authentication

If your Elasticsearch server is protected by HTTP authentication, you must provide [[= product_name =]] with the credentials.
When using basic authentication, you must pass the following parameters:

``` yaml
<connection_name>
    # ...
    authentication:
        type: basic
        credentials: ['<user_name', '<password>']
```

For example:

``` yaml
ezplatform_elastic_search_engine:
    connections:
        cloud:
            debug: true
            elastic_cloud_id: 	'test:ZWFzdHVzMi5henVyZS5lbGFzdGljLWNsb3VkLmNvbTo5MjQzJGUwZ'
            authentication:
                type: basic
                credentials: ['elastic', '1htFY83VvX2JRDw88MOkOejk']
```

#### Configuring API key authentication

If your Elasticsearch cluster is protected by API keys, you must provide the key and secret in authentication configuration to
connect [[= product_name =]] with the cluster. With API key authentication you can define different
authorization levels, such as [`create_index`, `index`, etc.](https://www.elastic.co/guide/en/elasticsearch/reference/7.x/security-privileges.html#privileges-list-indices). Such approach
proves useful if the cluster is available to the public.

For more information, see [Create API key](https://www.elastic.co/guide/en/elasticsearch/reference/7.x/security-api-create-api-key.html).

When using API key authentication, you must pass the following parameters to
authenticate access to the cluster:

``` yaml
<connection_name>:
    # ...
    authentication:
        type: api_key
        credentials: ['<api_key>', '<api_secret>']
```

For example:

``` yaml
ezplatform_elastic_search_engine:
    connections:
        cloud:
            debug: true
            elastic_cloud_id: 	'test:ZWFzdHVzMi5henVyZS5lbGFzdGljLWNsb3VkLmNvbTo5MjQzJGUwZ'
            authentication:
                type: api_key
                credentials: ['8Ek5f3IBGQlWj6v4M7zG', 'rmI6IechSnSJymWJ4LZqUw']
```

#### Configuring SSL

When you need to protect your communication with the Elasticsearch server, you can use SSL encryption.
When configuring SSL for your internal infrastructure, you can use your own client certificates signed by a public CA.
Configure SSL by passing the path-passwords pairs for both the certificate and the certificate key.

For example:

``` yaml
ezplatform_elastic_search_engine:
    connections:
        cloud_with_ssl:
            debug: true
            elastic_cloud_id: 	'test:ZWFzdHVzMi5henVyZS5lbGFzdGljLWNsb3VkLmNvbTo5MjQzJGUwZ'
            authentication:
                type: api_key
                credentials: ['8Ek5f3IBGQlWj6v4M7zG', 'rmI6IechSnSJymWJ4LZqUw']
            ssl:
                cert:
                    path: '/path/to/cert.pem'
                    pass: ~
                cert_key:
                    path: '/path/to/cert-key'
                    pass: ~
```

If you do not have a client certificate signed by public certificate authority,
but you have a self-signed CA certificate generated by `elasticsearch-certutil` or another tool (for example for development purposes),
use the following `ssl` configuration:

``` yaml
ezplatform_elastic_search_engine:
    connections:
        cloud_with_ssl:
            debug: true
            elastic_cloud_id: 	'test:ZWFzdHVzMi5henVyZS5lbGFzdGljLWNsb3VkLmNvbTo5MjQzJGUwZ'
            ssl:
                ca_cert:
                    path: '/path/to/ca_cert.pem'
```
    
If you configure both `ca_cert` and `cert` entries, the `ca_cert` parameter takes precedence over the `cert` parameter.

After you have configured SSL, you can still disable it, for example when the certificates
expire, or you are migrating to a new set of certificates.
To do this, pass the following setting under the `ssl` key:

``` yaml
verification: false
```

For more information, see [Elasticsearch: SSL Encyption](https://www.elastic.co/guide/en/elasticsearch/client/php-api/7.x/security.html#_ssl_encryption_2).

#### Enabling debugging

In a staging environment, you can log messages about the status of communication with Elasticsearch.
You can then use Symfony Profiler to review the logs.

By default, debugging is disabled. To enable debugging, you can toggle either of the following two settings:

``` yaml
<connection_name>:
    # ...
    debug:	<true/false>
    trace:	<true/false>
```

- `debug` logs basic information about a request, such as request status and time.
- `trace` logs additional information, such as steps to reproduce an exact copy of a query.

!!! tip

    Make sure that you disable debugging in a production environment.

### Configuring field type mapping templates

Before you can re-index the [[= product_name =]] data, so that Elasticsearch can search through its contents, you must define an index template.
Templates instruct Elasticsearch to recognize [[= product_name =]] Fields as specific data types, based on, for example, a field name.
They help you prevent Elasticsearch from using the dynamic field mapping feature to create type mappings automatically.
You can create several field type mapping templates for each index, for example, to define settings that are specific for different languages.
When you establish a relationship between a field mapping template and a connection, you can apply several templates, too.

#### Defining a template

To define a field mapping template, you must provide a number of settings under the `index_templates` key.
The structure of the template is as follows:

``` yaml
ez_platform_elastic_search_engine:
    # ...
    index_templates:
        <index_template_name>:
            patterns:
            # ...
            settings:
            # ...
            mappings:
            # ...
```

Set a unique name for the template and configure the following keys:

- `patterns` - A list of wildcards that Elasticsearch uses to match the field mapping template to an index.
Index names use the following pattern:

    `<repository>_<document_type>_<language_code>_<content_type_id>`

    By default, repository name is set to `default`, however, in the context of an [[= product_name =]] instance,
    there can be [several repositories with different names](https://doc.ezplatform.com/en/latest/guide/config_repository/#defining-custom-connection).
    Document type can be either `content` or `location`.
    In a language code, hyphens are replaced with underscores, and all characters must be lowercase.
    An index name can therefore look like this:

    `default_content_eng_gb_2`

    You can use the `patterns` setting when your data contains content in different languages.
    You can create index templates with settings that apply to a specific language only,
    for example, to eliminate stop words from the index, or help divide concatenations.
    You use patterns to identify index templates that contain settings specific for a given language:

  ``` yaml
  ez_platform_elastic_search_engine:
    # ...
    index_templates:
        default_en_us:
            patterns: ['default_*', '*eng_us*']
            # ...
  ```

- `settings` - Settings under this key control all aspects related to an index.
For more information and a list of available settings, see [Elasticsearch documentation](https://www.elastic.co/guide/en/elasticsearch/reference/7.x/index-modules.html#index-modules-settings).

    For example, you can define settings that convert text into a format that is optimized for
    search, like a normalizer that changes a case of all phrases in the index:

  ``` yaml
    ez_platform_elastic_search_engine:
        # ...
            index_templates:
                default:
                    # ...
                    settings:
                        analysis:
                            normalizer:
                                lowercase_normalizer:
                                    type: custom
                                    char_filter: []
                                    filter: lowercase
                                    # ...
  ```

- `mappings` - Settings under this key define mapping for fields in the index.
For more information about mappings, see [Elasticsearch documentation](https://www.elastic.co/guide/en/elasticsearch/reference/7.x/mapping.html).

    When you create a custom index template, with settings for your own field and document
    types, make sure that it contains mappings for all searchable fields that are available in [[= product_name =]].
    For an example of default configuration with a list of searchable fields, see [Default configuration](https://github.com/ezsystems/ezplatform-elastic-search-engine/blob/v1.0.0/src/bundle/Resources/config/default-config.yaml).

#### Fine-tuning the search results

Your search results can be adjusted by configuring additional parameters.
For a list of available mapping parameters and their usage, see [Elasticsearch documentation](https://www.elastic.co/guide/en/elasticsearch/reference/7.x/mapping-params.html).

For example, you can apply a mapping parameter, in this case, a normalizer, to a specific
mapping under the `dynamic_templates` key:

``` yaml
ez_platform_elastic_search_engine:
    # ...
    index_templates:
        default:
            # ...
            mappings:
                # ...
                dynamic_templates:
                    - ez_string:
                        match: "*_s"
                        mapping:
                        type: keyword
                        normalizer: lowercase_normalizer
                    # ...
```

You can also set a boosting factor for a specific field.
Boosting increases the relevance of hits, for example making keywords from the title more relevant than the ones from other places of the document.
Set the boosting factor under the `properties` key:

``` yaml
ez_platform_elastic_search_engine:
    # ...
    index_templates:
        default:
            # ...
            mappings:
                properties:
                    content_name_s:
                        boost: 2.0
                # ...
```

You can even copy contents of existing fields, process them and then paste into another field, which than can be queried:

``` yaml
ez_platform_elastic_search_engine:
    # ...
    index_templates:
        default:
            # ...
            mappings:
                properties:
                    user_first_name_s:
                        type: keyword
                        normalizer: lowercase_normalizer
                        copy_to: custom_field
                # ...
```

### Binding templates with connections

Once you have created the field mapping template(s), you must establish a relationship between the templates and a connection. You do this by adding the "index_templates" key to a connection definition.

If your configuration file contains several connection definitions, you can reuse the same template for different connections.
If you have several index templates, you can apply different combinations of templates to different connections.

``` yaml
<connection_name>:
    # ...
    index_templates:
        - default
        - default_en_us
```

For more information about how Elasticsearch handles settings and mappings from multiple templates that match the same index, see [Elasticsearch documentation](https://www.elastic.co/guide/en/elasticsearch/reference/7.x/indices-templates-v1.html#multiple-templates-v1).

## Extending Elasticsearch

To learn how to create custom Search Criteria, Sort Clauses and Facets for use with Elasticsearch,
and how to index custom data and manipulate the query, see [Elasticsearch extensibility](extend_elasticsearch.md).
