---
description: Install Solr search engine to use it with Ibexa DXP.
---

# Install Solr search engine

## Configure and start Solr

The example presents a configuration with a single core. 
For configuring Solr in other ways, including examples, see [Solr Cores and `solr.xml`](https://cwiki.apache.org/confluence/display/solr/Solr+Cores+and+solr.xml) and [core administration](https://wiki.apache.org/solr/CoreAdmin).

### Download Solr files

!!! note "Solr versions"

    Supported Solr versions are Solr 7 and 8. Using most recent version of Solr 7.7 or 8.11 is recommended.

Download and extract Solr:

- [solr-7.7.2.tgz](http://archive.apache.org/dist/lucene/solr/7.7.2/solr-7.7.2.tgz) or [solr-7.7.2.zip](http://archive.apache.org/dist/lucene/solr/7.7.2/solr-7.7.2.zip)
- [solr-8.11.2.tgz](https://www.apache.org/dyn/closer.lua/lucene/solr/8.11.2/solr-8.11.2.tgz) or [solr-8.11.2.zip](https://www.apache.org/dyn/closer.lua/lucene/solr/8.11.2/solr-8.11.2.zip)

Copy the necessary configuration files. In the example below from the root of your project to the place you extracted Solr:

``` bash
# Make sure to replace the /opt/solr/ path with where you have placed Solr
cd /opt/solr
mkdir -p server/ibexa/template
cp -R <project_root>/vendor/ibexa/solr/src/lib/Resources/config/solr/* server/ibexa/template
cp server/solr/configsets/_default/conf/{solrconfig.xml,stopwords.txt,synonyms.txt} server/ibexa/template
cp server/solr/solr.xml server/ibexa

# If you are using Ibexa Commerce, additionally copy commerce-specific configuration files:
cat <project_root>/vendor/ibexa/commerce-shop/src/bundle/Search/Resources/config/solr/custom-fields-types.xml >> server/ibexa/template/custom-fields-types.xml
cat <project_root>/vendor/ibexa/commerce-shop/src/bundle/Search/Resources/config/solr/language-fieldtypes.xml >> server/ibexa/template/language-fieldtypes.xml

# Modify solrconfig.xml to remove the section that doesn't agree with your schema
sed -i.bak '/<updateRequestProcessorChain name="add-unknown-fields-to-the-schema".*/,/<\/updateRequestProcessorChain>/d' server/ibexa/template/solrconfig.xml

# Start Solr (but apply autocommit settings below first if you need to)
bin/solr -s ibexa
bin/solr create_core -c collection1 -d server/ibexa/template
```

#### Set up SolrCloud

SolrCloud is a cluster of Solr servers. It enables you to:

- centralize configuration
- automatically load balance and fail-over for queries
- integrate ZooKeeper for cluster coordination and configuration

To set SolrCloud up follow [SolrCloud reference guide](https://lucene.apache.org/solr/guide/7_7/solrcloud.html).

### Continue Solr configuration

The bundle does not commit Solr index changes directly on Repository updates, leaving it up to you to tune this using `solrconfig.xml` as best practice suggests.

This setting is **required** if you want to see the changes after publish. It is strongly recommended to set-up `solrconfig.xml` like this:

``` xml
<!--solrconfig.xml-->
<autoCommit>
  <!-- autoCommit is here left as-is like it is out of the box in Solr, this controls hard commits for durability/replication -->
  <maxTime>${solr.autoCommit.maxTime:15000}</maxTime>
  <openSearcher>false</openSearcher>
</autoCommit>

<autoSoftCommit>
  <!-- Soft commits controls mainly when changes becomes visible, by default we change value from -1 (disabled) to 20ms, so Solr gets to bulk update changes a bit, but before a request typically finishes -->
  <maxTime>${solr.autoSoftCommit.maxTime:20}</maxTime>
</autoSoftCommit>
```

### Generate Solr configuration automatically

The command line tool `bin/generate-solr-config.sh` generates Solr 7 configuration automatically.
It can be used for deploying to Ibexa Cloud (Platform.sh) and on-premise installs.

Execute the script from the [[= product_name =]] root directory for further information:

``` bash
./vendor/ibexa/solr/bin/generate-solr-config.sh --help
```

## Configure the bundle

The Solr Search Engine Bundle can be configured in many ways. The config further below assumes you have parameters set up for Solr DSN and search engine *(however both are optional)*, for example:

``` yaml
    env(SEARCH_ENGINE): solr
    env(SOLR_DSN): 'http://localhost:8983/solr'
    env(SOLR_CORE): collection1
```

### Single-core example (default)

Out of the box in [[= product_name =]] the following is enabled for a simple setup:

``` yaml
ibexa_solr:
    endpoints:
        endpoint0:
            dsn: '%solr_dsn%'
            core: '%solr_core%'
    connections:
        default:
            entry_endpoints:
                - endpoint0
            mapping:
                default: endpoint0
```

### Shared-core example

The following example separates one language. The installation contains several similar languages,
and one very different language that should receive proper language analysis for proper stemming and sorting behavior by Solr:

``` yaml
ibexa_solr:
    endpoints:
        endpoint0:
            dsn: '%solr_dsn%'
            core: core0
        endpoint1:
            dsn: '%solr_dsn%'
            core: core1
    connections:
        default:
            entry_endpoints:
                - endpoint0
                - endpoint1
            mapping:
                translations:
                    jpn-JP: endpoint1
                # Other languages, for instance eng-US and other western languages are sharing core
                default: endpoint0
```

### Multi-core example

If full language analysis features are preferred, then each language can be configured with separate cores.

!!! note

    Make sure to test this setup against a single-core setup, as it might perform worse than single-core if your project uses a lot of language fallbacks per SiteAccess, as queries will then be performed across several cores at once.

``` yaml
ibexa_solr:
    endpoints:
        endpoint0:
            dsn: '%solr_dsn%'
            core: core0
        endpoint1:
            dsn: '%solr_dsn%'
            core: core1
        endpoint2:
            dsn: '%solr_dsn%'
            core: core2
        endpoint3:
            dsn: '%solr_dsn%'
            core: core3
        endpoint4:
            dsn: '%solr_dsn%'
            core: core4
        endpoint5:
            dsn: '%solr_dsn%'
            core: core5
        endpoint6:
            dsn: '%solr_dsn%'
            core: core6
    connections:
        default:
            entry_endpoints:
                - endpoint0
                - endpoint1
                - endpoint2
                - endpoint3
                - endpoint4
                - endpoint5
                - endpoint6
            mapping:
                translations:
                    jpn-JP: endpoint1
                    eng-US: endpoint2
                    fre-FR: endpoint3
                    ger-DE: endpoint4
                    esp-ES: endpoint5
                # Not really used, but specified here for fallback if more languages are suddenly added by content admins
                default: endpoint0
                # Also use separate core for main languages (differs from content object to content object)
                # This is useful to reduce number of cores queried for always available language fallbacks
                main_translations: endpoint6
```

### SolrCloud example

To use SolrCloud you need to specify data distribution strategy for connection via the `distribution_strategy` option to [`cloud`](https://lucene.apache.org/solr/guide/7_7/solrcloud.html).

The example is based on multi-core setup so any specific language analysis options could be specified on the collection level.

``` yaml
ibexa_solr:
    endpoints:
        main:
            dsn: '%solr_dsn%'
            core: '%solr_main_core%'
        en:
            dsn: '%solr_dsn%'
            core: '%solr_en_core%'
        fr:
            dsn: '%solr_dsn%'
            core: '%solr_fr_core%'
        # ...
    connections:
        default:
            distribution_strategy: cloud
            entry_endpoints:
                - main
                - en
                - fr
             # -  ...
            mapping:
                translations:
                    eng-GB: en
                    fre-FR: fr
                    # ...
                main_translations: main
```

This solution uses the default SolrCloud [document routing strategy: `compositeId`](https://lucene.apache.org/solr/guide/7_7/shards-and-indexing-data-in-solrcloud.html#ShardsandIndexingDatainSolrCloud-DocumentRouting).

### Solr Basic HTTP Authorization
Solr core can be secured with Basic HTTP Authorization. See more information here: [Solr Basic Authentication Plugin](https://cwiki.apache.org/confluence/display/solr/Basic+Authentication+Plugin).
In the example below we configured Solr Bundle to work with secured Solr core.

``` yaml
ibexa_solr:
    endpoints:
        endpoint0:
            dsn: '%solr_dsn%'
            core: core0
            user: example
            pass: password
```

Obviously, you should pass credentials for every configured and HTTP Basic secured Solr core. Configuration for multi core setup is exactly the same.

## Configure repository with the specific search engine

The following is an example of configuring Solr search engine, where `connection` name is same as in the example above, and engine is set to `solr`:

``` yaml
ibexa:
    repositories:
        default:
            storage: ~
            search:
                engine: '%search_engine%'
                connection: default
```

`%search_engine%` is a parameter that is configured in `config/packages/ibexa.yaml`, and should be changed from its default value `legacy` to `solr` to activate Solr as the search engine.

## Clear prod cache

While Symfony `dev` environment keeps track of changes to YAML files, `prod` does not, so clear the cache to make sure Symfony reads the new config:

``` bash
php bin/console --env=prod cache:clear
```

## Run CLI indexing command

The last step is to execute the initial indexation of data:

``` bash
php bin/console --env=prod --siteaccess=<name> ibexa:reindex
```

### Possible exceptions

If you have not configured your setup correctly, some exceptions might happen on indexing.
Here are the most common issues you may encounter:

- Exception if Binary files in database have an invalid path prefix
    - Make sure `var_dir` is configured properly in `ibexa.yaml` configuration.
    - If your database is inconsistent in regards to file paths, try to update entries to be correct *(make sure to make a backup first)*.
- Exception on unsupported Field Types
    - Make sure to implement all Field Types in your installation, or to configure missing ones as [NullType](nullfield.md) if implementation is not needed.
- Content is not immediately available 
    - Solr Bundle on purpose does not commit changes directly on Repository updates *(on indexing)*, but lets you control this using Solr configuration. Adjust Solr's `autoSoftCommit` (visibility of changes to search index) and/or `autoCommit` (hard commit, for durability and replication) to balance performance and load on your Solr instance against needs you have for "[NRT](https://cwiki.apache.org/confluence/display/solr/Near+Real+Time+Searching)".
- Running out of memory during indexing
    - In general make sure to run indexing using the prod environment to avoid debuggers and loggers from filling up memory.
    - Flysystem: You can find further info in https://issues.ibexa.co/browse/EZP-25325.