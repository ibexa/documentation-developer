# Accessing data provider via PHP [[% include 'snippets/commerce_badge.md' %]]

## Catalog Data Provider Service

Example usage in Controller or services:

``` php
/** @var $catalogService \Silversolutions\Bundle\EshopBundle\Services\Catalog\CatalogDataProviderService */
$catalogService = $this->get('silver_catalog.data_provider_service');

/** @var $catalogElement \Silversolutions\Bundle\EshopBundle\Catalog\CatalogElement */
/* Get product by Url/Request */
$catalogElement = $catalogService->getDataProvider()->lookupByUrl($urlService->getSeoUrl($request), $ezHelper->getCurrentLanguageCode()); 
/* Get product by sku  */
$catalogElement = $catalogService->getDataProvider()->fetchElementBySku(
    $productNodeSku,
    array()
);
```

This service injects different data providers to the Catalog Service using external configuration.
You can choose the provider depending on SiteAccess, URL, etc.

## Implementation

To choose the proper catalog provider, use [tags and compiler pass.](http://symfony.com/doc/3.4/components/dependency_injection/tags.html)

### Compiler pass

New compiler pass (`CatalogDataProviderOperationsPass`) collects all services which are tagged with `catalog_data_provider_operation`.
For example:

`<tag name="catalog_data_provider_operation" alias="ez5" />`

The compiler pass calls `setDataProviderService` from `CatalogDataProviderService` and sets all available providers.

When the actual call to catalog data provider service is made, the proper provider is chosen depending on the SiteAccess.

``` php
/**
* Array, which holds the catalog data providers services as dependencies.
*
* @var CatalogDataProvider[]
*/
protected $dataProviders;
 
...
 
public function getDataProvider()
{
    // return the data provider by SiteAccess
    return $this->dataProviders[$this->configResolver->getParameter('catalog_data_provider', 'silver_eshop')];
}
```
