# Custom breadcrumbs [[% include 'snippets/commerce_badge.md' %]]

## Breadcrumbs for custom routes

To configure breadcrumbs for a custom route you need to configure `breadcrumb_path` and `breadcrumb_names`:

``` yaml hl_lines="5 6"
custom_blog_index:
    path: /blog/index
    defaults:
        _controller: App\Controller\BlogController::indexAction
        breadcrumb_path: custom_blog_index
        breadcrumb_names: Blog List
```

Both `breadcrumb_path` and `breadcrumb_names` must be configured for the breadcrumbs to render correctly.

|Option|Description|
|--- |--- |
|`breadcrumb_path`|Valid route identifier which exists in at least one of the routing YAML files.|
|`breadcrumb_names`|Name for the breadcrumb element. If the translation is not set, there will be a fallback to route translation.</br>In the example above if the `Blog List` key has no translation, the fallback key is `custom_blog_index|breadcrumb`.|

### Multi-part routes

If you want breadcrumbs to have more than one part, you can specify more paths and names with the `/` delimiter.
Both `breadcrumb_path` and `breadcrumb_names` must contain two parts.

In the example below breadcrumbs are generated with two elements (Profile and Blog list):

``` yaml hl_lines="5 6"
custom_blog_index:
    path: /blog/index
    defaults:
        _controller: App\Controller\BlogController::indexAction
        breadcrumb_path: blog/custom_blog_index
        breadcrumb_names: Profile/Blog List
```

!!! note "Restricting HTTP methods"

    When using breadcrumbs for custom routes you cannot restrict the HTTP method for the controller in the routing file.

    To see the correct breadcrumb, you have to check the method in the controller itself:

    ``` php
    if ($request->getMethod() != REQUEST::METHOD_POST) {
        throw new NotFoundHttpException();
    }
    ```

## Custom breadcrumb generator

To create a custom breadcrumb generator you have to write a generator class and register it as a service tagged as `siso_core.breadcrumbs_generator`.

The generator must implement `BreadcrumbsGeneratorInterface` and its two methods.

You can use `AbstractWhiteOctoberBreadcrumbsGenerator`
which implements this interface and provides access to the WhiteOctober breadcrumbs library.

Every breadcrumb generator has to add a `translationParameters` array with `type`, `identifier` and `content_type_id`.
Always create all three keys and leave the elements empty if not needed.

If you can't or do not want to use `AbstractWhiteOctoberBreadcrumbsGenerator`,
your generator's `renderBreadcrumbs()` method must handle rendering the HTML code for the breadcrumbs.

The highest priority generator which matches `canRender()` renders the breadcrumbs for the current request.
