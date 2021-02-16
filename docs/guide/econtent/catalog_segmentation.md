# Catalog segmentation

Catalogs, especially in B2B shops, are often segmented by customers. 

An ERP system can provide a segmentation code, such as "certified".
A customer with this code can, for example, see more products than an anonymous user or a customer without the code.

A customer can even have individual products which are available for this customer only.

eContent uses an additional database table to segment the catalog. 

The configuration is SiteAccess-aware.

## Implement different catalog filtering

You can configure eContent so that catalog elements have assigned roles (and different users can see different content).

Adjust the configuration like in the following example:

``` yaml
silver_econtent.default.filter_SQL_where: 'sve_object_catalog.node_id = obj.node_id AND sve_object_catalog.catalog_code IN (%%catalog_code%%)'

silver_econtent.default.catalog_filter_default_catalogcode:
    - ANONYMOUS

silver_econtent.default.section_filter: enabled
```
