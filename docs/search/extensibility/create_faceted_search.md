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

### Create tags

One of the types of facets that is implemented in the following example, is searching by category.
To be able to search for created posts by their category, you must first create tags
and then assign them to individual content types - blog posts.

One of the elements of the blog post is **Categories** - this field works with taxonomy entry assignment.
Thanks to this mechanism, user can search by category: News, Editorial insights, Product, Marketer insights.

To create new tag:

1\. Go to the Back Office -> **Tags**.

2\. Click **Create**.

3\. Input the Tag's name and identifier:

- Name: News, identifier: news
- Name: Editorial insights, identifier: editorial_insights
- Name: Product, identifier: product
- Name: Marketer insights, identifier: marketer_insights

4\. Click **Save and close**.

### Create blog and blog posts

Next step in this example, is to create two new content types:

-`Blog` - defining all the structure for the blog.
-`Blog Post` - defining the entire post structure, including all components, selection of required or optional fields, and any additional elements.

To create new Content Type:

1\. Go to the Back Office -> **Content Types**.

2\. Enter the Content group and click **Create**.

3\. Input the Content Type's name and identifier:

=== "Blog"

    - **Name**: Blog
    - **Identifier**: blog

=== "Blog Post"

    - **Name**: Blog Post
    - **Identifier**: blog_post

4\. In the Field definitions area, add following Fields with settings:

- **Blog**

|Field|Name|Identifier|Description|Required|Searchable|Translatable|
|----|----|----|----|----|----|----|
|`Text line`|Title|title|Insert title of the blog|Yes|Yes|Yes|

- **Blog Post**

|Field|Name|Identifier|Description|Required|Searchable|Translatable|
|----|----|----|----|----|----|----|
|`Text line`|Title|title|Insert title of the post|Yes|Yes|Yes|
|`Rich Text`|Content|content|Isert content body of the post|Yes|Yes|Yes|
|`Image`|Image|image|Upload selected image|No|Yes|Yes|
|`Taxonomy Entry Assignment`|Categories|categories|Assign one or more tag to allow searching by category|No|Yes|Yes|
|`Date and time`|Publication date|publication_date|Select publication date to allow searching by publication date|No|Yes|Yes|
|`Authors`|Author|author|Insert author's name|No|Yes|Yes|
|`Float`|Rate|rate|Choose rate number for the post|No|Yes|Yes|

5\. Click **Save and close**.

## Create templates

Create a templates for post and blog posts, including full layout, and line preview.

In the `templates/themes/storefront` directory, add the following file:

- `layout` template:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/layout.html.twig') =]]
```

Then, in `storefront` add two new folders: `full` and `line`.

`Full` folder includes templates, that define full view of the blog.
In this folder create two templates:

- `blog` template defining the preview of the blog:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/full/blog.html.twig') =]]
```

- `blog_post` template defining the preview of the post published on the blog in the post view:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/full/blog_post.html.twig') =]]
```

`Line` folder includes template, that defines line view of the blog post, so how the blog posts look like in the list.
In this folder create new template:

- `blog_post` template defining the preview of the post published on the blog in the list view:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/line/blog_post.html.twig') =]]
```

### Create QueryType class

Next step in the process of creating faceted search, is to create QueryType class.
Query allows to quickly find specific data by filtering on requested criteria.
Seleted class facilitates parameters handling by using Symfony's `OptionsResolver`.
This component that enables you to build an options system that includes validation, normalization, required options, defaults, and more.

Created QueryType class consists of number of functions:

- `configureOptions` - configures the OptionsResolver for the QueryType.
- `doGetQuery` - builds and returns the Query object.
- `getName` - returns the QueryType name.
- `createFilters` - creates filters based on specific Criterion.
- `createPublicationDateAggregation` - creates aggregation that collects related items depending on publication date.

In the `src/QueryType` directory, create `BlogPostsQueryType` class with the following code:

``` php
[[= include_file('code_samples/search/faceted_search/src/QueryType/BlogPostsQueryType.php') =]]
```
### Create controller

A controller is a PHP function you write that constructs and returns a `Response` object after reading data from the `Request` object.

`BlogController` class from the following example, uses a PHP package called Pagerfanta - it aids in the computation
and presentation of paginated lists.

Controller creates query parameters from current request.

``` php
[[= include_file('code_samples/search/faceted_search/src/Controller/BlogController.php') =]]
```

### Add new abstract class

You need to add an abstract class - it is a class that is designed to be specifically used as a base class.
Add it in the `src/Menu/Builder` localization. Create a `AbstractFacetsMenuBuilder.php` file with the following code:

``` php
[[= include_file('code_samples/search/faceted_search/src/Menu/Builder/AbstractFacetsMenuBuilder.php') =]]
```

### Add styling

Next step is to add styling for the project.
To do it, in the `assets/styles` add `app.scss` file.
Then, paste a code that includes styling:

``` scss
[[= include_file('code_samples/search/faceted_search/assets/styles/app.scss') =]]
```

Next, clear the cache by runnig the following command:

```bash
php bin/console cache:clear
```

### Implement facets

#### Publication date facet

This facet finds results based on publication date. 
To implement it, in the `src/Menu/Builder` add `PublicationDateMenuBuilder.php` file with the following code:

``` php
[[= include_file('code_samples/search/faceted_search/src/Menu/Builder/PublicationDateMenuBuilder.php') =]]
```

Then, register a configuration in `services`:

``` yaml
[[= include_file('code_samples/search/faceted_search/config/services.yaml') =]]
```

#### Rate range facet

To define a facet that searches by rate range, in the `src/Menu/Builder`, add the following configuration:


#### Category facet

Last type of facets in this example, is the one, that looks for the results depending on the category.
In the `src/Menu/Builder` add `CategoriesMenuBuilder.php` file with the following configuration:


``` php
[[= include_file('code_samples/search/faceted_search/src/Menu/Builder/CategoriesMenuBuilder.php') =]]
```

### Add templates

In order to display and render properly the side bar menu, you need to add templates.

The first file, `facets_menu.html.twig`, includes a template that defines, to the facets menu is rendered. 
It searches the page to check whether it contains relevant search results that meet the criteria, that is they belong to one of the given facets categories.
In case that there are no search results, specific category is not displayed in the menu.

Add the following code in the `templates/themes/storefront/full` localization:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/full/facets_menu.html.twig') =]]
```

The second file, `blog_sidebar.hmtl.twig`, creates a template for three categories: Publication Date, Categories and Rate.
It includes `facets_menu` file for menu rendering.

Add the following code in the `templates/themes/storefront/full` localization:

``` html+twig
[[= include_file('code_samples/search/faceted_search/templates/themes/storefront/full/blog_sidebar.html.twig', 1, 10) =]]
```