---
description: Configure Elasticsearch to use it with Ibexa DXP.
---

# Configure Elasticsearch

## Configure connections

To configure Elasticsearch, first, you need to configure the connections. 

There are two possibilities of connection:
- using [cluster of Elasticsearch nodes](#cluster)
- using [Elasticsearch Cloud](#elasticsearch-cloud)

No matter which option you choose, you have to define the connection settings under the `connections` key. 
Set a name of the connection:

``` yaml
ibexa_elasticsearch:
    connections:
        <connection_name>:
```

!!! tip "A default connection"

    If you define more than one connection, for example, to create a separate connection for
    each repository, you must select the one that [[= product_name =]] should use with the following setting:

    ``` yaml
    ibexa_elasticsearch:
        # ...
        default_connection: <connection_name>
    ```

Now, you need to decide whether to add a cluster that you administer and manage yourself, or use a cloud
solution from Elastic, as well as configure additional parameters.

If you want to connect by using a cluster, follow the instructions below in the [Cluster](#cluster) section.
If you want to use Elasticsearch Cloud, skip to [Elasticsearch Cloud](#elasticsearch-cloud) section.

## Configure clustering

A cluster consists of nodes.
You might start with one node and then add more nodes if you need more processing power.

When you configure a node, you need to set the following parameters:

- `host` - an IP address or domain name of the host. Default value: `localhost`.
- `port` - a port to connect to. Default value: `9200`.
If you have several Elasticsearch instances that run on the same host, and want to make them
distinct, you can change the default number.
- `scheme` - a protocol used to access the node. Default value: `http`.
- `path` - by default, path is not used. Default value: `null`.
If you have several Elasticsearch instances that run on the same host, and want to make them
distinct, you can define a path for each instance.  
- `user`/`pass` - credentials, if needed to log in to the host. Default values: `null`.

Next, list the addresses of cluster nodes under the `hosts` key:

``` yaml
ibexa_elasticsearch:
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
ibexa_elasticsearch:
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

### Multi-node cluster behavior

When you configure a cluster-based connection, and the cluster consists of many nodes, you can
choose strategies that govern how the cluster reacts to changing operating conditions, or how
workload is distributed among the nodes.

#### Connection pool

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

#### Connection selector

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

## Configure Elasticsearch Cloud

As an alternative to using your own cluster, you can use Elasticsearch Cloud, a commercial SaaS solution.
With Elasticsearch Cloud you do not have to build or manage your own Elasticsearch cluster.
Also, you do all the configuration and administration in a graphical user interface.

To connect to a cloud solution with [[= product_name =]], you must set the `elastic_cloud_id` parameter by
providing an alphanumerical ID string that you get from the cloud's user interface, for example:

``` yaml
<connection_name>:
    elastic_cloud_id: 'production:ZWFzdHVzMi5henVyZS5lbGFzdGljLWNsb3VkLmNvbTo5MjQzJGUwZ'
```

With the ID set, you must configure authentication to be able to access the remote environment.

## Configure security

Elasticsearch instances support `basic` and `api_key` authentication methods.
You select authentication type and configure the settings under the `authentication` key. By default, authentication is disabled:

``` yaml
<connection_name>:
    # ...
    authentication:
        type: null
```

If you connect to Elasticsearch hosts outside of your local network, you might also need to configure SSL encryption.

### Basic authentication

If your Elasticsearch server is protected by HTTP authentication, you must provide [[= product_name =]] with the credentials.
In the basic authentication, you must pass the following parameters:

``` yaml
<connection_name>
    # ...
    authentication:
        type: basic
        credentials: ['<user_name', '<password>']
```

For example:

``` yaml
ibexa_elasticsearch:
    connections:
        cloud:
            debug: true
            elastic_cloud_id: 	'test:ZWFzdHVzMi5henVyZS5lbGFzdGljLWNsb3VkLmNvbTo5MjQzJGUwZ'
            authentication:
                type: basic
                credentials: ['elastic', '1htFY83VvX2JRDw88MOkOejk']
```

### API key authentication

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
ibexa_elasticsearch:
    connections:
        cloud:
            debug: true
            elastic_cloud_id: 	'test:ZWFzdHVzMi5henVyZS5lbGFzdGljLWNsb3VkLmNvbTo5MjQzJGUwZ'
            authentication:
                type: api_key
                credentials: ['8Ek5f3IBGQlWj6v4M7zG', 'rmI6IechSnSJymWJ4LZqUw']
```

### SSL

When you need to protect your communication with the Elasticsearch server, you can use SSL encryption.
When configuring SSL for your internal infrastructure, you can use your own client certificates signed by a public CA.
Configure SSL by passing the path-passwords pairs for both the certificate and the certificate key.

For example:

``` yaml
ibexa_elasticsearch:
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
ibexa_elasticsearch:
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

### Enable debugging

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

## Define Field Type mapping templates

Before you can re-index the [[= product_name =]] data, so that Elasticsearch can search through its contents, you must define an index template.
Templates instruct Elasticsearch to recognize [[= product_name =]] Fields as specific data types, based on, for example, a field name.
They help you prevent Elasticsearch from using the dynamic field mapping feature to create type mappings automatically.
You can create several Field Type mapping templates for each index, for example, to define settings that are specific for different languages.
When you establish a relationship between a field mapping template and a connection, you can apply several templates, too.

### Define a template

To define a field mapping template, you must provide settings under the `index_templates` key.
The structure of the template is as follows:

``` yaml
ibexa_elasticsearch:
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
    there can be [several repositories with different names](repository_configuration.md#defining-custom-connection).
    Document type can be either `content` or `location`.
    In a language code, hyphens are replaced with underscores, and all characters must be lowercase.
    An index name can therefore look like this:

    `default_content_eng_gb_2`

    You can use the `patterns` setting when your data contains content in different languages.
    You can create index templates with settings that apply to a specific language only,
    for example, to eliminate stop words from the index, or help divide concatenations.
    You use patterns to identify index templates that contain settings specific for a given language:

  ``` yaml
  ibexa_elasticsearch:
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
    ibexa_elasticsearch:
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
    For an example of default configuration with a list of searchable fields.
    To see the default configuration, go to `vendor/ibexa/elasticsearch/src/bundle/Resources/config/` and open the `default-config.yaml` file.

### Fine-tune the search results

Your search results can be adjusted by configuring additional parameters.
For a list of available mapping parameters and their usage, see [Elasticsearch documentation](https://www.elastic.co/guide/en/elasticsearch/reference/7.x/mapping-params.html).

For example, you can apply a mapping parameter, in this case, a normalizer, to a specific
mapping under the `dynamic_templates` key:

``` yaml
ibexa_elasticsearch:
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
ibexa_elasticsearch:
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
ibexa_elasticsearch:
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

## Bind templates with connections

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

# Extend Elasticsearch

To learn how you can create document field mappers, custom Search Criteria, 
custom Sort Clauses and Aggregations, see [Create custom Search Criterion](create_custom_search_criterion.md).
