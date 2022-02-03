# eContent configuration

## Languages

The indexer for eContent needs to know which languages are used in your project and whether you are using a fallback language.

Adapt this setting according to your project needs:

``` yaml
ibexa_commerce_search.default.index_econtent_languages:
    # eng-GB is the fallback language for ger-DE
    ger-DE: eng-GB
```

`sibexa.commerce.site_access.config.econtent.<scope>.languages` defines the languages used for eContent per SiteAccess.
Other languages present in the database are ignored.

``` yaml
ibexa.commerce.site_access.config.econtent.ger.languages: [ ger-DE, eng-GB ]
```

The second language specified is the fallback language.
This means that if content is not found in the first language, second language will be used.
