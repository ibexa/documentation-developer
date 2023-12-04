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

Facets are a subset of filtering and they're used to group results based on shared characteristics. 

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

In the following example, you can see the usage of faceted search in the business model - company blog. 

In the blog, user can search for articles and documents using available filters and facets.
Facets are important when it comes to customer experience - they are more flexible and exclude any content parts that don’t meet certain criteria.

You can implement different types of facets. In the following example, you can learn how to implement three different facets:

- **date**: searching by publication date (June 2023, July 2023, August 2023, September 2023)
- **rate** (with the minimum and maximum value): searching for materials depending on the star rating given by users, range 2-5 stars
- **category**: searching by category (News, Editorial insights, Product, Marketer insights)

![Blog overview](blog.png)

### Define facets

Define specific settings for the faceted search. Files should follow the Symfony configuration convention. Define various aspects of the searcg, include services, templates

### Create templates

Create a templates for the facets, including sidebar template, and general layout.
In the `templates`, add the following files:

- `blog` template defining the preview of the blog:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/full/blog.html.twig') =]]
```

- `blog_post` template defining the preview of the post published on the blog in the post view:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/full/blog_post.html.twig') =]]
```

- `blog_sidebar` template defining the preview of the sidebar on the blog:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/full/blog_sidebar.html.twig') =]]
```

- `layout` template:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/line/layout.html.twig') =]]
```

- `blog_post` template defining the preview of the post published on the blog in the list view:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/line/blog_post.html.twig') =]]
```

- `facets_menu` template defining the preview of the facets menu:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/facets_menu.html.twig') =]]
```

### Register facets

Then, register a configuration in `services`:

``` yaml
[[= include_file('code_samples/search/faceted_search/config/services.yaml') =]]
```

Next, clear the cache by runnig the following command:

```bash
php bin/console cache:clear
```