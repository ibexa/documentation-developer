# Content model data provider [[% include 'snippets/commerce_badge.md' %]]

The content model data provider provides an implementation for fetching catalogs and products from the database.

Products are stored directly in the content structure.
They can use the features provided by the content model such as languages, Objects states, versioning, etc.
The product catalog can be maintained in the Back Office.

## Configuration

The data provider uses configuration to limit the fetched catalog elements.

The following default setup filters content of type `ses_category` for the navigation service
(which uses this data provider to fetch the category objects).
The sort order is controlled by the Priority field and the publish date.

The second level key defines the scope, or `filterType`, for which the specific filter definitions are valid.
In this example, the `navigation` is passed by the navigation service's fetch.

``` yaml
silver_eshop.default.ez5_catalog_data_provider.filter:
    navigation:
        contentTypes: [ "ses_category" ]
        limit: 20
        sortClauses:
            -
                clause: "\\eZ\\Publish\\API\\Repository\\Values\\Content\\Query\\SortClause\\Location\\Priority"
                order: "\\eZ\\Publish\\API\\Repository\\Values\\Content\\Query::SORT_DESC"
            -
                clause: "\\eZ\\Publish\\API\\Repository\\Values\\Content\\Query\\SortClause\\DatePublished"
                order: "\\eZ\\Publish\\API\\Repository\\Values\\Content\\Query::SORT_ASC"
    catalogList:
        contentTypes: ["ses_category", "ses_product"]
        sortClauses:
            -
                clause: "\\eZ\\Publish\\API\\Repository\\Values\\Content\\Query\\SortClause\\Location\\Priority"
                order: "\\eZ\\Publish\\API\\Repository\\Values\\Content\\Query::SORT_DESC"
    productList:
        contentTypes: ["ses_product"]
        sortClauses:
            -
                clause: "\\eZ\\Publish\\API\\Repository\\Values\\Content\\Query\\SortClause\\Location\\Priority"
                order: "\\eZ\\Publish\\API\\Repository\\Values\\Content\\Query::SORT_DESC"
```

!!! note "Important"

    If a product has multiple Locations, the shop ensures that the proper Location is returned,
    so the URL of the product is correct.

    By default, hidden items (e.g. products) are not fetched.

|Parameter|Description|
|--- |--- |
|`contentTypes`|Identifier of the Content Types defined in the system|
|`limit`|Default limit to be used when no limit is given|
|`sortClauses`|Sorting clauses|
