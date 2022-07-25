# Search API

## Search interfaces

The following interfaces represent the entry point for search:

- `Ibexa\Bundle\Commerce\Search\Api\EshopContentSearchInterface`
- `Ibexa\Bundle\Commerce\Search\Api\EshopCatalogSearchInterface`
- `Ibexa\Bundle\Commerce\Search\Api\EshopProductSearchInterface`

### EshopQuery

`Ibexa\Bundle\Commerce\Search\Api\EshopQuery` is the value object class for all search query parameters.

### SearchContext

The current controller implementation for the shop search uses a service call to instantiate the `SearchContext`: `Ibexa\Bundle\Commerce\Search\Service\SearchContextService`.
It has the service ID: `Ibexa\Bundle\Commerce\Search\Service\SearchContextService`.
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
