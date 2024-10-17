# SesSelection

This field type stores a single selection choice.

The SesSelection field type is configured in a YAML file, unlike the [Selection field type](selectionfield.md).
This way, you can set up SiteAccess-specific selection field types.

The field type must be configured per attribute:

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

To add a SesSelection field to a content type, make sure the field's identifier is the same as the configuration key (in the example above, `news_type`).
