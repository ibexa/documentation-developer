# Elasticsearch search engine

!!! enterprise

    Elasticsearch is an open-source, distributed, Java-based search engine that responds to queries
    in real-time and is easily scalable in reaction to changing processing needs.

    With this document you learn to configure Elastic and eZ Platform to work together.
    For a detailed description of advanced settings that you might require in a specific
    production environment, see the documentation provided by Elastic, beginning with the [Set up Elasticsearch](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/setup.html) section.

    !!! tip "**Prerequisite**"

        Before you proceed to configuring the integration between Elasticsearch and eZ Platform, make sure
      	that you install a standalone instance of Elasticsearch locally and experiment with it
      	to become familiar with how indexing, filtering and queries work.

    ## How to set up the Elasticsearch search engine

    Elasticsearch integration requires that you do the following steps:

    ### Step 1: Download and install Elasticsearch

    Download an Elasticsearch installation package for the system platform of your choice and install it on a dedicated machine using out-of-the-box settings.
    For example, download the `tar.gz` file and execute the `bin/elasticsearch` command.

    For more information, see [Install Elasticsearch](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/install-elasticsearch.html).

    !!! note

        eZ Platform is optimised to work with Elasticsearch in version 7.7.

    ### Step 2: Verify that your Elasticsearch instance is up

    To make sure that the Elasticsearch instance operates properly, in the address bar of your browser, enter the address of the instance:

    ```
    localhost:9200
    ```

    If Elasticsearch operates properly, an object with cluster details is displayed.
    It should be similar to the following example:

    ``` Java
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

    ### Step 3: Set the default search engine

    In your `.env` file, change the setting of the following environment variable:

    ``` yaml
    SEARCH_ENGINE=elasticsearch
    ```

    ### Step 4: Configure the search engine

    eZ Platform comes pre-configured to work with an Elasticsearch cluster that uses default settings, and you can use this initial setup for testing purposes.
    However, to effectively search through actual data, you must provide specific settings.
    All configuration is made in the `ezplatform_elastic_search_engine.yaml` file.

    !!! note

    		All the settings, their order and meaning, correspond to the settings that are described in the Elasticsearch documentation.
        However, in eZ Platform you provide the settings in a form of a YAML file, instead of a JSON file.

    First, you decide how eZ Platform connects to Elasticsearch, as well as configure other settings that control the way Elasticsearch operates.
    For more information, see [Configure connections](#configure-connections).

    Then, you define a field type mappings template that instructs Elasticsearch to interpret eZ Platform fields as specific types. For more information, see [Configure field type mappings](#configure-field-type-mappings).

    When ready, you [push the template to the Elasticsearch engine](#step-4- push-the--template).

    #### Configure connections

    When you configure the Elasticsearch integration, you must first configure the connections.
    You either connect to a [cluster of Elasticsearch nodes](#configure-a-cluster) or the [Elasticsearch Cloud](#Configure-Elasticsearch-Cloud).

    You define the connection settings under the `connections` key. First, you set a name of the connection:

    ``` yaml
    ez_platform_elastic_search_engine:
      	connections:
          	<connection_name>:
    ```

    Then you decide whether to add a cluster that you administer and manage yourself, or resort to a cloud solution from Elastic, as well as configure additional parameters.
    You can then decide how the cluster [handles communication with individual nodes](#configure-the-multi-node-cluster-behaviour), and configure the [security settings](#configure-security).

    !!! tip "A default connection"

        If you define more than one connection in the YAML file, for example, for testing purposes,
    	  you must select the one that eZ Platform should use with the following setting:

    	  ``` yaml
    		ez_platform_elastic_search_engine:
              # ...
              default_connection: <connection_name>
    	  ```

    ##### Configure a cluster

    A cluster consists of a number of nodes.
    You might start with just one node, and add more nodes if you need more processing power.

    When configuring a node, you set the following parameters:

    - `host` - An IP number or URL address of the host.
    The default value is `localhost`.
    - `port` - A port to connect to.
    The efault value is `9200`.
    If you have several Elasticsearch instances that run on the same host, and want to differentiate them, you can change the default number.
    - `scheme` - A protocol to be used to access the node.  Default value is `http`.
    - `path` - By default, path is not used.
    The default value is `null`.
    If you have several Elasticsearch instances that run on the same host, and want to differentiate
    them, you can define a path for each instance.  
    - `user`/`pass` - Credentials, if needed to login to the host.
    Default values are `null`.

    You list the addresses of cluster nodes under the `hosts` key:

    ``` yaml
    ez_platform_elastic_search_engine:
      connections:
        <connection_name>:
          hosts:
            - '127.0.0.1:9200'
            # - ...
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

    Your cluster connection configurations should be similar to the following examples:

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

    ###### Configure the multi-node cluster behaviour

    When you configure a cluster-based connection, and the cluster consists of many nodes, you can
    choose strategies that govern how the cluster reacts to changing operating conditions, or how
    workload is distributed among the nodes.

    Connection pool

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

    One of possible choices is the `sniffingConnectionPool` setting, which provides increased flexibility.
    This connection pool setting requires that you provide a list of seed hosts.
    Elasticsearch then queries seed hosts for cluster topology and pulls a list of available hosts.
    However, this setting might result in a large amount of overhead.

    !!! tip "Load tests recommendation"

    		It is recommended that you to perform load tests to check whether the change does not negatively impact the performance of your environment.

    Connection selector

    When the cluster consists of many hosts, with this setting you decide what strategy is used to pick a node to send a query requests to.
    By default, the `RoundRobinSelector` setting is used.

    If you prefer a different strategy, or have created your own, proprietary strategy, you can change the default setting with the following key:

    ``` yaml
    <connection_name>:
      # ...
      connection_selector: Elasticsearch\ConnectionPool\Selectors\<selector_name>
    ```

    For more information and a list of available choices, see [Selectors](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/selectors.html).

    Number of retries

    With this setting you can configure the number of attempts that eZ platform makes to connect
    to the nodes of the cluster before it throws an exception.
    By default, the `null` setting is used, which means that the number of retries equals to the number of nodes in the cluster.

    ``` yaml
    <connection_name>:
      # ...
      retries: null
    ```

    Depending on the connection pool that you select, eZ Platform's reaction to reaching the maximum number of retries might differ.

    For more information, see [Set retries](https://www.elastic.co/guide/en/elasticsearch/client/php-api/7.x/configuration.html#_set_retries).

    ##### Configure Elasticsearch Cloud

    As an alternative, you might decide to use Elasticsearch Cloud, a commercial SaaS solution.
    With Elasticsearch Cloud you do not have to build or manage your own Elasticsearch cluster.
    Also, you do all the configuration and administration in a graphical user interface.

    To connect to a cloud solution with eZ Platform, you must set the `elastic_cloud_id` parameter by
    providing an alphanumerical ID string that you obtain from the cloud's user interface, for example:

    ``` yaml
    <connection_name>:
      elastic_cloud_id: 'production:ZWFzdHVzMi5henVyZS5lbGFzdGljLWNsb3VkLmNvbTo5MjQzJGUwZ'
    ```

    With the ID set, you must configure authentication to be able to access the remote environment.

    ##### Configure security

    Elasticsearch instances support `basic` and `api_key` authentication methods.
    You select authentication type and configure the settings under the `authentication` key. By default, authentication is disabled:

    ``` yaml
    <connection_name>:
      # ...
    	authentication:
    	  type: null
    ```

    If you connect to Elasticsearch hosts outside of your local network, you might also need to configure SSL encryption.

    #### Configure basic authentication

    If your Elasticsearch server is protected by HTTP authentication, you must provide eZ Platform with the credentials, so that eZ Platform requests can be authenticated by the server.
    Basic authentication support requires that you pass a set of parameters that is similar to the following example:

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

    #### Configure API key authentication

    If your Elasticsearch cluster is protected by API keys, you must use the values described below to
    connect eZ Platform with the cluster. With API key authentication you can define different
    authorisation levels, such as [`create_index`, `index`, etc.](https://www.elastic.co/guide/en/elasticsearch/reference/7.x/security-privileges.html#privileges-list-indices). Such approach
    proves useful if the cluster is available to the public.

    For more information, see [Create API key](https://www.elastic.co/guide/en/elasticsearch/reference/7.x/security-api-create-api-key.html).

    API key authentication support requires that you provide the following set of parameters to
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

    #### Configure SSL

    When you need to protect your communication with the Elasticsearch server, you can use SSL encryption.
    When configuring SSL for your internal infrastructure, you can use your own certificates.
    You configure ssl by passing the path-passwords pairs for both the certificate and the certificate key.

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

    After you have configured SLL, you can still disable it, for example, when the certificates expire, or you are migrating to a new set of certificates.
    To do this, you must pass the following setting under the `ssl` key:

    ``` yaml
    verification: false
    ```

    For more information, see [Elasticsearch: SSL Encyption](https://www.elastic.co/guide/en/elasticsearch/client/php-api/7.x/security.html#_ssl_encryption_2).

    #### Enable debugging

    In a staging environment, you can decide that eZ Platform populates its logs with messages about the status of communication with Elasticsearch. You can then use Symfony Profiler to review the logs.

    By default, debugging is disabled. To enable debugging, you can toggle either of the following two settings:

    ``` yaml
    <connection_name>:
      # ...
      debug:	<true/false>
      trace:	<true/false>
    ```

    Enabling the `debug` setting results in logging basic information about a request, such as request status and time.
    Enabling the `trace` setting results in logging additional information, such as steps to reproduce an an exact copy of a query.

    !!! tip

    	Make sure that you disable debugging in a production environment.

    #### Configure field type mappings

    Before you can re-index the eZ Platform data, so that Elasticsearch can search through its contents, you must define an index template.
    Templates instruct Elasticsearch to recognise eZ Platform fields as specific data types, based on, for example, a field name.
    They help you prevent Elasticsearch from using the dynamic field mapping feature to create type mappings automatically.
    You can create several field type mapping templates for each index, for example, to define settings that are specific for different languages.
    When you establish a relationship between a field mapping template and a connection, you can apply several templates, too.

    ##### Define a template

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
    ```

    You first set a unique name for the template, then the keys, which have the following meaning:

    - `patterns` - A list of wildcards that Elasticsearch uses to match the field mapping template to an index.
    If you use the `_location_*` wildcard as a pattern, the settings and mappings listed belowapply to all indexes, whose names are prefixed with the word "location".

      The `patterns` setting proves useful when your data contains content in different languages, you can create index templates with settings that apply to a specific language only, for example, to eliminate stop words from the index, or help divide concatenations.
      You use patterns to identify index templates that contain settings specific for a given language:

      ``` yaml
      ez_platform_elastic_search_engine:
        # ...
        index_templates:
          default_en_us:
            patterns: ['default_*', '*eng_us*'']
            # ...
      ```

    - `settings` - Settings under this key control all aspects related to an index.
    For more information and a list of available settings, see [Elasticsearch documentation](https://www.elastic.co/guide/en/elasticsearch/reference/7.x/index-modules.html#index-modules-settings).

      For example, you can define settings that convert text into a format that is optimized for search, like a normalizer that changes a case of all phrases in the index:

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

      When you create a custom index template, with settings for your own field and document types, make sure that it contains mappings for all searchable fields that are available in eZ Platform. For an example of default configuration with a list of searchable fields, see [Default configuration](https://github.com/ezsystems/ezplatform-elastic-search-engine/blob/v1.0.0/src/bundle/Resources/config/default-config.yaml).

    ##### Fine-tune the search results

    Your search results can be adjusted by configuring additional parameters. For a list of available mapping parameters and their usage, see [Elasticsearch documentation](https://www.elastic.co/guide/en/elasticsearch/reference/7.x/mapping-params.html).

    For example, you can apply a mapping parameter, in this case, a normalizer, to a specific mapping under the `dynamic_templates` key:

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
    Boosting increases the relevance of hits, for example, to help you account for the fact that keywords from the title are more relevant than the ones from other places of the document.
    You set the boosting factor under the `properties` key:

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

    ##### Bind templates with connections

    Once you have created the field mapping template(s), you must establish a relationship between the templates and a connection. You do this by adding a "index_templates" key to a connection definition.

    If your configuration file contains several connection definitions, you can reuse the same template for different connections.
    If you have several index templates, you can apply different combinations of templates to different connections.

    ``` yaml
    <connection_name>:
      # ...
      index_templates:
        - default
        - default_en_us
    ```

    ### Step 5: Push the templates

    You push the templates to the Elasticsearch engine by running the following command:

    ``` bash
    run php bin/console ezplatform:elasticsearch:put-index-template
    ```

    You can modify the behaviour of the command with a number of switches:

    | Switch | meaning |
    |---|---|
    | -c, --connection[=CONNECTION] | Elasticsearch connection name |
    | --overwrite | Overwrite existing index template |
    | -h, --help | Display a help message |
    | -q, --quiet | Do not output messages |
    | -V, --version | Display application version |
    | --ansi | Force ANSI output |
    | --no-ansi | Disable ANSI output |
    | -n, --no-interaction | Do not ask interactive questions |
    | -e, --env=ENV | Environment name (default value is "dev") |
    | --no-debug | Switch off debug mode |
    | --siteaccess[=SITEACCESS] | SiteAccess to be uses for operations. If not provided, default siteaccess is used |
    | -v/vv/vvv, --verbose | Increase the verbosity of messages (1 is normal output, 2 is verbose output, 3 is debug) |
    |---|---|

    ### Step 6: Reindex the database

    Once you have created index templates that satisfy your needs, run the following command to reindex your data:

    ``` bash
    run php bin/console ezplatform:reindex
    ```

    !!! caution "Risks of premature indexing"

        Do not reindex your data before you create custom templates.
        Otherwise Elasticsearch attempts to use its [dynamic field mapping](https://www.elastic.co/guide/en/elasticsearch/reference/7.7/dynamic-field-mapping.html) feature to create type mappings automatically.
