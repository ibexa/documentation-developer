# URLs and routes

To link to a [Location](../content_management.md#locations) or [Content item](../content_model.md#content-items), use the [`ez_path()`](twig_function_reference/url_twig_functions.md#ez_path) Twig function.
You need to provide the function with a Location, Content, ContentInfo or [RouteReference](#routereference) object:

``` html+twig
<p><a href="{{ ez_path(location) }}">Location</a></p>

<p><a href="{{ ez_path(content.contentInfo) }}">Content Info</a></p>
```

Use [`ez_url()`](twig_function_reference/url_twig_functions.md#ez_url) to get an absolute URL to a Content item or Location:

``` html+twig
<p><a href="{{ ez_url(location) }}">Location</a></p>
```

## RouteReference

You can use the [`ez_route()`](twig_function_reference/url_twig_functions.md#ez_route) Twig function
to create a RouteReference object based on the provided information.

A RouteReference contains a route with its parameters and can be modified after it is created.

``` html+twig
{% set routeReference = ez_route("ez_urlalias", { 'locationId': 2 }) %}
<p><a href="{{ ez_path(routeReference) }}">Route</a></p>
```

With `ez_route()` you can modify the route contained in RouteReference after creation, for example, by providing additional parameters:

``` html+twig
{% set routeReference = ez_route("ez_urlalias", { 'locationId': 2 }) %}
{% do routeReference.set("param", "param-value") %}
```

You can also use `ez_route()` to create links to predefined routes, such as the `ezplatform.search` route that leads to a search form page:

``` html+twig
<a href="{{ ez_path(ez_route('ezplatform.search')) }}">Search</a>
```

## File download links

To provide a download link for a file, use `ez_route()` with the `ez_content_download` route:

``` html+twig
{% set download_route = ez_route('ez_content_download', {
    'content': file,
    'fieldIdentifier': 'file',
}) %}

<a href="{{ ez_path(download_route) }}">Download</a>
```
