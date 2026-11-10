# List content

Create and render a list of content items, for example, content in a folder or blog posts in a blog.

To render a list of content items, for example, content in a folder, or blog posts in a blog, you can use one of two methods:

- use a [Query type](#list-children-with-query-type)
- create a content type with a [Content Query Field](#list-children-in-content-query-field)

## List children with Query type

The following example shows how to render the children of a Folder.

First, in the [content view configuration](../../templates/template_configuration/index.md), add the following view for the Folder content type:

```yaml
            content_view:
                full:
                    folder:
                        controller: ibexa_query::contentQueryAction
                        template: '@ibexadesign/full/folder.html.twig'
                        params:
                            query:
                                query_type: 'Children'
                                parameters:
                                    content: '@=content'
                                assign_results_to: items
                                limit: 3
                        match:
                            Identifier\ContentType: folder
```

`controller` defines which controller is used to render the view. In this example, it's the default [Query controller](../../queries_and_controllers/content_queries/index.md).

```yaml
                        controller: ibexa_query::contentQueryAction
```

`params` define that you want to render the content by using the [`Children` Query type](../../queries_and_controllers/built-in_query_types/index.md#children). This Query type automatically finds the children of the current content item. The results of the query are placed in the `items` variable, which you can use in templates.

Then, place the following template in `templates/themes/<my_theme>/full/folder.html.twig`:

```html+twig
{% for item in items.searchHits %}
    {{ ibexa_render(item.valueObject, {'viewType': 'line'}) }}
{% endfor %}
```

This template uses the [`ibexa_render()` Twig function](../../twig_function_reference/content_twig_functions/index.md#ibexa_render) to render every child of the folder with the default template for the `line` view.

## List children in Content query Field

A [Content query Field](../../../content_management/field_types/field_type_reference/contentqueryfield/index.md) is a field that defines a query. The following example shows how to use a Content query field to render a Blog with its Blog Post children.

First, create a Blog content type that contains a Content query field with the identifier `query`.

In the Field definition, select "Children" as the Query type. Provide the `content` parameter that the Query type requires:

```yaml
content: '@=content'
```

You can paginate the query results by checking the **Enable pagination** box and selecting a limit of results per page.

Select the content type you want to render (in this case, Blog Post) as **Returned type**.

Then, in the content view configuration, add the configuration under `content_query_field`:

```yaml
            content_view:
                content_query_field:
                    blog:
                        template: '@ibexadesign/content_query/blog_posts.html.twig'
                        match:
                            Identifier\ContentType: blog
                            '@Ibexa\FieldTypeQuery\ContentView\FieldDefinitionIdentifierMatcher': query
```

The `match` configuration matches both the content type and the identifier of the Content query field.

Finally, in the template `templates/themes/<my_theme>/content_query/blog_posts.html.twig`, render all results of the query:

```html+twig
{% for item in items.searchHits %}
    {{ ibexa_render(item.valueObject, {'viewType': 'line'}) }}
{% endfor %}
```
