# Solr cores for eContent [[% include 'snippets/commerce_badge.md' %]]

The main goal of dedicated Solr cores for the eContent data provider is to import and re-index data (e.g. products) with a temporary Solr core.
In this case the application is not disturbed while the importer and indexer are working in temporary cores.

After the processes are finished, the temporary cores are swapped with the production cores and the application starts using fresh data.

## Adapt configuration for two Solr eContent cores

The standard configuration for [[= product_name_com =]] supports two Solr eContent cores by default (see `app/config/ezcommerce_advanced.yml`).

In `ezpublish/config/config.yml`:

``` yaml
nelmio_solarium:
    endpoints:
        default:
            host: '%siso_search.solr.host%'
            port: '%siso_search.solr.port%'
            path: '%siso_search.solr.path%'
            core: '%siso_search.solr.core%'
            timeout: 30
        siso_core_admin:
            host: '%siso_search.solr.host%'
            port: '%siso_search.solr.port%'
            path: '%siso_search.solr.path%'
            core: admin
            timeout: 30
        siso_econtent:
            host: '%siso_search.solr.host%'
            port: '%siso_search.solr.port%'
            path: '%siso_search.solr.path%'
            core: econtent
            timeout: 30
        siso_econtent_back:
            host: '%siso_search.solr.host%'
            port: '%siso_search.solr.port%'
            path: '%siso_search.solr.path%'
            core: econtent_back
            timeout: 30
    clients:
        default:
            endpoints:
                - default
        econtent:
            endpoints:
                - siso_econtent
                - siso_econtent_back
                - siso_core_admin 
```

## Add parameters

``` yaml
parameters:
    siso_search.solr.host: 127.0.0.1
    siso_search.solr.port: 8983
    siso_search.solr.path: /solr
    siso_search.solr.core: collection1
    
```

## Manual changes in Solr

[[= product_name_com =]] comes with an bash script which installs the Solr engine and adapts the configuration for Solr:

``` bash
bash ./install-solr.sh 8983
```
