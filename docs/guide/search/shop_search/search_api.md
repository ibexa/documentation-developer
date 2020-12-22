# Search API [[% include 'snippets/commerce_badge.md' %]]

## Search interfaces

The following interfaces represent the entry point for search:

- `Siso\Bundle\SearchBundle\Api\EshopContentSearchInterface`
- `Siso\Bundle\SearchBundle\Api\EshopCatalogSearchInterface`
- `Siso\Bundle\SearchBundle\Api\EshopProductSearchInterface`

### EshopQuery

`Siso\Bundle\SearchBundle\Api\EshopQuery` is the value object class for all search query parameters.

### SearchContext

The current controller implementation for the eshop search uses a service call to instantiate the `SearchContext`: `\Siso\Bundle\SearchBundle\Service\SearchContextService`.
It has the service ID: `siso_search.search_context_service.default`.
To change the default implementation, override this service.

The search context defines context information for the query which is not contained in the search clauses.
This can be, for example, data related to the SiteAccess (which was addressed by the HTTP request).
This information can be used by the respective search service implementation.

## Conditions API

The conditions API offers the following Conditions:

- `ContentTypesCondition` - filters results by Content Type. Valid Content Types are, for example, `ses_product`, `ses_category` or `ses_content`.
- `SearchTermCondition` - filters results by phrase, potentially in a specific field. For example: search for `SE10000` in field `sku`:

``` php
$myQuery->addCondition(new SearchTermCondition(array(
    'searchTerm' => 'SE10000',
    'fieldRestrictions' => 'ses_product_ses_sku_value_s'
)));
```

- `SectionCondition` - filters results by Section ID. Returns only elements that belong to the given Section.
- `SubtreeCondition` - filters results by setting a path. Only elements under this path are fetched.
- `VisibilityCondition` - filters results that are shown or hidden.

### Boosting API

- `FieldBoosting` - defines which fields should be boosted in search result. They have higher priority in search.

### Sorting API

- `RelevanceSorting` - sorts the results by relevance, which is internal Solr implementation for the `score` field.
- `ProductFieldSorting` - sorting for products. Supports sorting by name, SKU or price in a given direction.
- `ContentNameSorting` - sorts the results by content Field name in a given direction.
