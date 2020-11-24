# Staging system [[% include 'snippets/commerce_badge.md' %]]

eContent supports a staging area. The product catalog can exist either as a live version which is used for the customer, or a staging (temporary) version, which can be used for staging and importing purposes.

[[= product_name_com =]] offers tools to switch between the production and staging versions. 

## Best practice

Depending on your import strategy, you can set up a staging system in the following ways:

### Full import

You can make a full import to temporary tables without modifying the production system.
This strategy supports large product catalogs as well.
After importing data the result of the import can be checked (e.g. number of products compared between the live and temporary tables)
and, depending on the results, the new catalog can be made live.

### Delta update

You can make a delta update, which directly uses the production system.

### Import SQL data

The staging system can be used for emergency situations as well.
If a product catalog encounters issues (legacy issues, wrong data or structure),
an SQL dump from past imports can be imported without interrupting the production system.

## Live and staging areas

Create an index for the new products (temporary area). The following command indexes the data from the temporary tables to a temporary core:

``` bash
php bin/console silversolutions:indexecontent --siteaccess=import
```

Use a SiteAccess (default: `import`) for the indexing process. The SiteAccess import should cover:

- all languages used in eContent (see `ezplatform.yml`)
- by default, the table set for this SiteAccess is configured to use the temporary tables

The product import can, for example, use the temporary tables. The import process does not stop the production system. It still uses the production version. 

## Switching between temporary and live versions

After the import, you must switch the database tables and Solr cores. Execute the following commands:

``` bash
php bin/console silversolutions:indexecontent swap
php bin/console silversolutions:econtent-tables-swap
```

Depending on the project, you should purge the HTTP cache for the product catalog.
