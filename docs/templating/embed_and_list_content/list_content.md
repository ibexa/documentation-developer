---
description: Create and render a list of Content items, for example, content in a folder or blog posts in a blog.
---

# List content

To render a list of Content items, for example, content in a folder, blog posts in a blog, and so on,
you can use one of two methods:

- use a [Query type](#list-children-with-query-type)
- create a Content Type with a [Content Query Field](#list-children-in-content-query-field)

## List children with Query type

The following example shows how to render the children of a Folder.

First, in the [content view configuration](template_configuration.md), add the following view for the Folder Content Type:

``` yaml
[[= include_file('code_samples/front/list_content/config/packages/views.yaml', 8, 22) =]]
```

`controller` defines which controller is used to render the view.
In this example, it is the default [Query controller](content_queries.md).

``` yaml
[[= include_file('code_samples/front/list_content/config/packages/views.yaml', 11, 12) =]]
```

`params` define that you want to render the content by using the [`Children` Query type](built-in_query_types.md#children).
This Query type automatically finds the children of the current Content item.
The results of the query are placed in the `items` variable, which you can use in templates.

Then, place the following template in `templates/themes/<my_theme>/full/folder.html.twig`:

``` html+twig
[[= include_file('code_samples/front/list_content/templates/themes/my_theme/full/folder.html.twig') =]]
```

This template uses the [`ibexa_render()` Twig function](content_twig_functions.md#ibexa_render)
to render every child of the folder with the default template for the `line` view.

## List children in Content query Field

A [Content query Field](contentqueryfield.md) is a Field that defines a query.
The following example shows how to use a Content query Field to render a Blog with its Blog Post children.

First, create a Blog Content Type that contains a Content query Field with the identifier `query`.

In the Field definition, select "Children" as the Query type. 
Provide the `content` parameter that the Query type requires:

```
content: '@=content'
```

You can paginate the query results by checking the **Enable pagination** box and selecting a limit of results per page.

Select the Content Type you want to render (in this case, Blog Post) as **Returned type**.

Then, in the content view configuration, add the configuration under `content_query_field`:

``` yaml
[[= include_file('code_samples/front/list_content/config/packages/views.yaml', 8, 9) =]][[= include_file('code_samples/front/list_content/config/packages/views.yaml', 22, 28) =]]
```

The `match` configuration matches both the Content Type and the identifier of the Content query Field.

Finally, in the template `templates/themes/<my_theme/content_query/blog_posts.html.twig`, render all results of the query:

``` html+twig
[[= include_file('code_samples/front/list_content/templates/themes/my_theme/full/blog_post.html.twig') =]]
```
