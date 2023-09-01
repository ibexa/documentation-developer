---
description: Create faceted search with aggregation API.
---

# Search for the results

[[= product_name =]] supports many search methods, using [search engines](search_engines.md) and several built-in [Search Criteria and Sort Clauses](search_criteria_and_sort_clauses.md).
While searching for content you can also use filters and facets to narrow down the results. 

## Filters vs facets

Both filters and facets are used to limit large set of search results to smaller subsets that match specified criteria.

![Filters vs facets](filters_vs_facets.png)

### Filters 

Filters use a certain attribute and they are typically used as predetermined list of products based on one specific criterion.
As a result, users can narrow a wide range of search results to just that ones that meet their needs.

Filters are frequently used while restricted search is needed for internal reasons and hidden for end-user. 

### Facets

Facets are a subset of filtering and they are used to group results based on shared characteristics. 

Facets are used to create a user experience - end-user can interact with them to narrow down search results. 
Comparing to filters, facets go one step further and let users narrow results by multiple dimensions at once. 

## Aggregation API

[Aggregation](aggregation_reference.md) is used to group search results into categories and returns a single value from a bunch of values.
Aggregations allow you to count the number of search results for each form of aggregations.
You can define limits for the results and group them into categories based on the value of a certain Field.

## Create faceted search

Faceted search allows you to focus and lower the amount of search results by using multiple filters at the same time.
You can find the content you're looking for without having to run multiple searches. 
What's more, you never have an empty search result set, because narrowing attributes are obtained from the search result set.

### Faceted search in business

In the following example, you can see the usage of faceted search in the business model - bike parts store 'La Bicicleta'. 

In the store, customer can search for bike parts by using available filters and facets.
Facets are important when it comes to customer experience - they are more flexible and and exclude any content parts that don’t meet certain criteria.

You can implement different types of facets. In the following example, you can learn how to implement three different facets:

- price range (with the minimum and maximum value): starting from 5€ and ending with 2500€, 
- wheels type: Low profile wheel, Mid profile wheel, High profile wheel, Disc wheel
- activity: Road, Hike, Gravel, Mountain bike, Mixed surface, Run, Cyclocross