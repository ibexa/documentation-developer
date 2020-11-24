# Implement custom search [[% include 'snippets/commerce_badge.md' %]]

This example shows how to create a new service which searches for products that:

- are discontinued
- are visible

It sets the sorting option to `relevance`, adds a Manufacturer facet,
and boosts some of the fields (they will be more relevant than others).

The built-in implementation of search interface has all methods required for searching using the Solr gateway.

To get discontinued products the controller uses `SearchTermCondition`, which has the search phrase and the specific field.
In this case, in the current data model, all discontinued fields have the word `DECLINE` in Solr field `ses_product_ses_discontinued_value_s`.
A condition for visibility ensures that only visible products are returned.

Boosting is set up so that SKU and name are more important than long description.

The field boosting condition is implementation dependent. This means that the field name values which are passed to the constructor are different for eContent and content model search.
For content model data, you need to pass the content Field identifier strings.
For eContent you need to pass the raw Solr field names, including the default search field (which is `text` by default).

``` php
class CustomSearchController extends BaseController
{
    public function searchDiscontinuedProductsAction() {
        
        // Inject the search and facet service
        $searchService = $this->get('siso_search.ezsolr_search_service');
  
        // Create the query with all the parameters we want.
        $eshopQuery = new EshopQuery();
        $eshopQuery->addCondition(new SearchTermCondition(array(
            'searchTerm' => 'DECLINE',
            'fieldRestrictions' => 'ses_product_ses_discontinued_value_s'
        )));
  
        // Add visibility
        $eshopQuery->addCondition(new VisibilityCondition(array('visibility' => 0)));
  
        // Add boosting (Content items)
        $boosts = array(
            'ses_name' => 50,
            'ses_sku' => 100,
            'ses_intro' => 20,
            'ses_short_description' => 2,
            'ses_long_description' => 1.5,
            'ses_manufacturer' => 2,
        );
        // Add boosting (Econtent)
        $boosts = array(
            'text' => 1,
            'ses_product_ses_name_value_t' => 50,
            'ses_product_ses_sku_value_s' => 100,
            'ses_product_ses_intro_value_t' => 20,
            'ses_product_ses_short_description_value_t' => 2,
            'ses_product_long_description_value_t' => 1.5,
            'ses_product_ses_manufacturer_value_s' => 2,
        );
        $eshopQuery->addCondition(new FieldBoosting(array('boost' => $boosts)));
  
        // Add offset and limit
        $eshopQuery->setOffset(0);
        $eshopQuery->setLimit(10);
  
        // Add sorting option by relevance
        $eshopQuery->setSortCriteria(array(new RelevanceSorting()));
        
        // Perform the search
        $productSearchResult = $searchService->searchProducts($eshopQuery, new SearchContext());
  
        // The hits can be found here
        $numberOfHits = $productSearchResult->numFound;
  
        // The search results can be found in this array:
        $productSearchResult->resultLines;
    }
}
```
