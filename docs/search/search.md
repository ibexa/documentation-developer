---
description: Cohesivo search functionalities allow running complex and precise queries about content and products.
page_type: landing_page
---

# Search

[[= product_name =]] exposes a very powerful Search API, allowing both full-text search and querying the content repository by using several built-in Search Criteria and Sort Clauses.

You run searches over the REST API: with the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request for content and locations,
and with the [`POST /product/catalog/products/view`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/ibexa.product_catalog.rest.products.view) request for products.
For all available endpoints, see the [REST API reference](/api/rest_api/rest_api_reference/rest_api_reference.html).

[[= cards([
    "search/search_criteria_and_sort_clauses",
], columns=4) =]]
