# SesSelection

This Field Type stores a single selection choice. 

The SesSelection Field Type is configured in a YAML file,
unlike the [Selection Field Type](selectionfield.md).
This way, you can set up SiteAccess-specific selection Field Types.

The Field Type must be configured per attribute:

``` yaml
ibexa.commerce.site_access.config.core.default.sesselection.news_type:
    default: general
    translation_context: news
    options:
        general: general
        sports: sports
        culture: culture
```

The `translation_context` key, which identifies the context used for translating the labels, is optional. 

To add a SesSelection Field to a Content Type, make sure the Field's identifier is the same as the configuration key (in the example above, `news_type`).
