# Product search [[% include 'snippets/commerce_badge.md' %]]

This example uses the product search API to search products using `searchterm`:

``` php
 /**
     * Returns all products
     * @param $offset
     * @param $limit
     * @patram $locationId
     * @return \Siso\Bundle\SearchBundle\Api\Catalog\ProductSearchResult
     */
    private function getAllProducts($offset, $limit, $queryString, $locationId = 2)
    {
        $searchService = $this->get('siso_search.search_service.product');
        $searchGroup =  $this->container->get('ezpublish.config.resolver')->getParameter('groups.product_list', 'siso_search');
        $searchContextService = $this->get('siso_search.search_context_service');
        $searchContext = $searchContextService->getContext();
        $facetService = $this->get('siso_search.facet_service.simple_field');

        $query = new EshopQuery();
        if ($queryString != '' ) {
            $query->addCondition(
                new SearchTermCondition(
                    array(
                        SearchController::SEARCH_CONDITION_TERM => $queryString
                    )
                )
            );
        }
        $query->addCondition(
            new ContentTypesCondition(
                array(
                    SearchController::SEARCH_CONDITION_CONTENT_TYPES =>
                        $searchGroup[SearchController::PRODUCT_LIST_GROUP][SearchController::SEARCH_CONDITION_CONTENT_TYPES]
                )
            )
        );
        if ($locationId > 2) {
            /** @var CatalogDataProviderService $catalogService */
            $catalogService = $this->get('silver_catalog.data_provider_service');
            $catalogProvider = $catalogService->getDataProvider();
            $catalogElement = $catalogProvider->fetchElementByIdentifier($locationId);
            $query->addCondition(
                new SubtreeCondition(
                    array(
                        'path' => implode('/',$catalogElement->path )
                    )
                )
            );
        }
        $formData = array();
        // Add facets
        $productFacets = $facetService->buildFacets($formData, 'product_list');
        foreach($productFacets as $productFacet) {
            $query->addFacet($productFacet);
        }

        $query->setOffset($offset);
        $query->setLimit($limit);
        return $searchService->searchProducts($query, $searchContext);
    }
```

## Use query filter in product search

You can filter by a search engine field in PHP code in the following way:

``` php
use Siso\Bundle\SearchBundle\Api\SearchContext;
use Siso\Bundle\SearchBundle\Api\EshopQuery;
use Siso\Bundle\SearchBundle\Controller\SearchController;
$query = new EshopQuery();

$queryString = 'content_type_id_id:2 AND ses_product_ses_datamap_ses_brand_value_s:HP';

$query->addCondition(
    new SearchQueryCondition(
        array(SearchController::SEARCH_CONDITION_QUERY => $queryString)
    )
);
$searchService = $this->getContainer()->get('siso_search.search_service.product');
$result = $searchService->searchProducts($query, new SearchContext());
```
