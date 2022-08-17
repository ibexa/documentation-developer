---
description: Embed a Content item in another using query types or controllers.
---

# Embed related content

To embed content in another Content item, you query for it in the Repository.
There are two ways to query for a Content item:

- by using a [Query type](#embed-siblings-with-query-type)
- by writing a [custom controller](#embed-relations-with-a-custom-controller)

## Embed siblings with Query type

To render the Siblings of a Content item (other content under the same parent Location), use the [Siblings Query type](built-in_query_types.md#siblings).

To do it, use the built-in `ibexa_query` controller's `contentQueryAction`:

``` yaml
[[= include_file('code_samples/front/embed_content/config/packages/views.yaml', 8, 23) =]]
```

The results of the Siblings query are placed in the `items` variable, which you can use in the template:

``` html+twig
[[= include_file('code_samples/front/embed_content/templates/themes/my_theme/full/blog_post.html.twig') =]]
```

## Embed Relations with a custom controller

You can use a custom controller for any situation where Query types are not sufficient.

``` yaml
[[= include_file('code_samples/front/embed_content/config/packages/views.yaml', 23, 30) =]]
```

This configuration points to a custom `RelationController` that should render all Articles with the `showContentAction()` method.

``` php hl_lines="23 27 28"
[[= include_file('code_samples/front/embed_content/src/Controller/RelationController.php') =]]
```

This controller uses the Public PHP API to get [the Relations of a Content item](browsing_content.md#relations) (lines 27-28).

The controller takes the custom parameter called `accepted_content_types` (line 23),
which is an array of Content Type identifiers that are rendered.

This way you can control which Content Types you want to show or exclude.

Finally, the controller returns the view with the results that were provided in the `items` parameter.
You can use this parameter as a variable in the template:

``` html+twig
[[= include_file('code_samples/front/embed_content/templates/themes/my_theme/full/article.html.twig') =]]
```
