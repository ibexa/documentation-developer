# Repository data provider

The Repository data provider is the default provider for catalog and product data.

Products are stored directly in the content structure as Content items.
Products can have the characteristics provided by the Repository, such as languages, Objects states, versioning, etc.
You can maintain the product catalog in the Back Office.

## Configuration

The data provider uses configuration to limit the fetched catalog elements.

The following configuration sets the limit for fetching elements in navigation:

``` yaml
silver_eshop.default.ez5_catalog_data_provider.filter:
    navigation:
        contentTypes: [ "ses_category" ]
        limit: 20
```

!!! note

    By default, hidden items (for example, products) are not fetched.
