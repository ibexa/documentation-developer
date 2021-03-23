# SesSelection

This Field Type stores a single selection choice. 

Unlike the [Selection Field Type](selectionfield.md),
the SesSelection Field Type is configured in a YAML file.
For that reason, it is possible to set up SiteAccess-specific selection Field Types.

The Field Type must be configured per attribute:

``` yaml
siso_core.default.sesselection.news_type:
    default: general
    translation_context: news
    options:
        general: general
        sports: sports
        culture: culture
```

The `translation_context` key is optional. 

To add a SesSelection Field to a Content Type, make sure the Field's identifier is the same as the configuration key (in the example above, `news_type`).
