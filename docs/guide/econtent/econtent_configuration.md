# eContent configuration

## Languages

The indexer for eContent needs to know which languages are used in your project and whether you are using a fallback language.

Adapt this setting according to your project needs:

``` yaml
siso_search.default.index_econtent_languages:
    # eng-GB is the fallback language for ger-DE
    ger-DE: eng-GB
```

`silver_econtent.<scope>.languages` defines the languages used for eContent per SiteAccess.
Other languages present in the database are ignored.

``` yaml
silver_econtent.ger.languages: [ ger-DE, eng-GB ]
```

The second language specified is the fallback language.
This means that if content is not found in the first language, second language will be used.

## Catalog segmentation

``` yaml
# Used for catalog segmentation: enabled or disabled
silver_econtent.default.section_filter: disabled
# Defines the name of the table to be used
silver_econtent.default.table_catalog_filter: sve_object_catalog
# The 'where' condition in order to limit product catalog
silver_econtent.default.filter_SQL_where:
# The catalog segmentation code used for this SiteAccess
silver_econtent.default.catalog_filter_default_catalogcode:
```
