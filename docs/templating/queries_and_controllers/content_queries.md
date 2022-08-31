---
description: Query content by using Query types and content query Field.
---

# Content queries

With content queries you can find and render specific content according to criteria that you define.

You can use queries to list or embed Content items, such as:

- [children in a folder](list_content.md#children-query-type)
- related articles
- [most recent blog posts](create_custom_query_type.md)
- recommended products

Content queries use the built-in Query controller which simplifies querying.
For more complex cases, you can build custom [controllers](controllers.md).

## Query types

The Query controller offers a set of [built-in Query types](built-in_query_types.md).
You can use them in the content view configuration, or in the [Content query Field](#content-query-field).

You can also write [custom Query types](create_custom_query_type.md) for the cases that are not covered by the built-in ones.

### Query type configuration

To use a Query type, select the Query controller (`ibexa_query`) in the [content view configuration](template_configuration.md)
and select the Query type under `params.query.query_type`:

``` yaml hl_lines="2 6"
folder:
    controller: ibexa_query::contentQueryAction
    template: '@ibexadesign/full/folder.html.twig'
    params:
        query:
            query_type: 'Children'
            parameters:
                content: '@=content'
            assign_results_to: items
    match:
        Identifier\ContentType: folder
```

Use one of the following Query controller methods:

- `locationQueryAction` runs a Location Search
- `contentQueryAction` runs a content Search
- `contentInfoQueryAction` runs a ContentInfo search
- `pagingQueryAction` returns a `PagerFanta` object and can be used to quickly [paginate query results](#pagination)

See the [Search](search.md) documentation page for more details about different types of search.

All Query types take the following parameters:

- `query_type` is the name of the Query type to use.
- `parameters` can include:
    - arbitrary values
    - expressions based on the `content`, `location` and `view` variables.
    For example, `@=location.id` is evaluated to the current Location's ID.
- `assign_results_to` declares the Twig variable that contains the search results.

!!! tip

    Search results are a `SearchResult` object, which contains `SearchHit` objects.
    To get the content or Locations that are in search results, you access the `valueObject`
    of the `SearchHit`.

### Pagination

To paginate the results of a query, use the `pagingQueryAction` of the Query controller
and assign a limit per page in `params.query.limit`:

``` yaml hl_lines="4 12"
[[= include_file('code_samples/front/query_pagination/config/packages/views.yaml', 8, 22) =]]
```

Use the [`pagerfanta`](https://www.babdev.com/open-source/packages/pagerfanta/docs/3.x/intro) function to render pagination controls:

``` html+twig hl_lines="5 6 7 8"
[[= include_file('code_samples/front/query_pagination/templates/themes/my_theme/full/folder.html.twig') =]]
```

## Content query Field

The [Content query Field](contentqueryfield.md) is a Field that defines a query.
The results of the query are available in the Field value.

![Content query Field definition](content_query_field_definition.png)

### Query type

When adding the Field to a Content Type definition, select the Query type in the **Query type** dropdown.
All Query types in the application are available, both [built-in](built-in_query_types.md) and [custom ones](create_custom_query_type.md).

### Returned types

Select the Content Type of items you want to return in the **Returned type** dropdown.
To take it into account, your Query type must filter on the Content Type.
Provide the selected Content Type through the `returnedType` variable:

```
contentType: '@=returnedType'
```

### Pagination

Select **Enable pagination** and set the number of items per page to paginate the results.

You can override the pagination settings from Field definition
by setting the `enablePagination`, `disablePagination` or `itemsPerPage` parameters when rendering the Content query Field:

``` html+twig
{{ ibexa_render_field(content, 'query', {
    location: location|default(null), 'parameters': {
        'enablePagination': true,
        'itemsPerPage': 8
    }
}) }}
```

You can also define an offset for the results. 
Provide the offset in the Query type, or in parameters:

```
offset: 3
```

If pagination is disabled and an offset value is defined, the query's offset is added to the offset calculated for a page.
For example, with `offset` 5 and `itemsPerPage` 10, the first page starts with 5, the second page starts with 15, and so on.

Without offset defined, pagination defines the starting number for each page.
For example, with `itemsPerPage` 10, first page starts with 0, second page starts with 10, and so on.

### Parameters

The following variables are available in parameter expressions:

- `returnedType` - the identifier of the Content Type selected in the **Returned type** dropdown
- `content` - the current Content item
- `location` - the current Location of the Content item
- `mainLocation` - the main Location of the Content item
- `contentInfo` - the current Content item's ContentInfo

### Content view configuration

To render a Content query Field, in the content view configuration, use the `content_query_field` view type:

``` yaml
[[= include_file('code_samples/front/list_content/config/packages/views.yaml', 8, 9) =]][[= include_file('code_samples/front/list_content/config/packages/views.yaml', 22, 28) =]]
```

The identifier of the Content query Field must be matched by
using the `'@Ibexa\FieldTypeQuery\ContentView\FieldDefinitionIdentifierMatcher'` matcher.

Query results are provided to the template in the `items` variable.
See [List content](list_content.md#content-query-field) for an example of using the Content query Field.
