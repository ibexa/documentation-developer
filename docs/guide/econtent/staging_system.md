# Staging system

eContent supports a staging area. 
The product catalog can exist either as a live version which is used for the customer,
or a temporary version, which can be used for staging and importing purposes.

## Live and staging areas

To set up staging, create an index for the new products (temporary area).
The following command indexes the data from the temporary tables to a temporary core:

``` bash
php bin/console ibexa:commerce:index-econtent --siteaccess=import
```

Use a SiteAccess (default: `import`) for the indexing process.
The import SiteAccess should cover all languages used in eContent (see `ezplatform.yaml`).
By default, the table set for this SiteAccess is configured to use the temporary tables

The import process does not stop the production system.

## Switching between temporary and live versions

After the import, switch the database tables and Solr cores. 
Execute the following commands:

``` bash
php bin/console ibexa:commerce:index-econtent swap
php bin/console ibexa:commerce:swap-econtent-tables
```

Depending on the project, you might want to purge the HTTP cache for the product catalog.
