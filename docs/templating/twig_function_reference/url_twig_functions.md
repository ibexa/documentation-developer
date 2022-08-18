---
description: URL Twig functions enable rendering URLs and routes.
---

# URL Twig functions

- [`ibexa_path()`](#ibexa_path) returns the relative URL to a Content item or Location.
- [`ibexa_url()`](#ibexa_url) returns the absolute URL to a Content item or Location.
- [`ibexa.url.alias()`](#ibexa.url.alias) generates URLs for a Location from the given arguments.
- [`ibexa_route()`](#ibexa_route)  generates a RouteReference object from the given parameters.
- [`ibexa_oauth2_connect_path()`](#ibexa_oauth2_connect_path) generates a relative path for the given OAuth2 route.
- [`ibexa_oauth2_connect_url()`](#ibexa_oauth2_connect_url) generates an absolute URL for the given OAuth2 route.

## URLs

### `ibexa_path()`

`ibexa_path()` returns the relative URL to a Content item or Location.

|Argument|Type|Description|
|------|------|------|
|`name`|`string`</br>`Ibexa\Contracts\Core\Repository\Values\Content\Location`</br>`Ibexa\Contracts\Core\Repository\Values\Content\Content`</br>`Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo`</br>`Ibexa\Contracts\Core\Repository\Values\Content\Location`</br>`Ibexa\Core\MVC\Symfony\Routing\RouteReference`|The name of the route, Location or Content.|
|`parameters`|`array`|Route parameters.|
|`relative`|`boolean`|Whether to generate a relative path.|

``` html+twig
{{ ibexa_path(location) }}
```

### `ibexa_url()`

`ibexa_url()` returns the absolute URL to a Content item or Location.

|Argument|Type|Description|
|------|------|------|
|`name`|`string`</br>`Ibexa\Contracts\Core\Repository\Values\Content\Location`</br>`Ibexa\Contracts\Core\Repository\Values\Content\Content`</br>`Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo`</br>`Ibexa\Contracts\Core\Repository\Values\Content\Location`</br>`Ibexa\Core\MVC\Symfony\Routing\RouteReference`|The name of the route, Location or Content.|
|`parameters`|`array`|Route parameters.|
|`schemeRelative`|`boolean`|Whether to generate a relative URL.|

``` html+twig
{{ ibexa_url(location, {}, false) }}
```

### `ibexa.url.alias()`

`ibexa.url.alias()` generates URLs for a Location from the given parameters.

!!! note

    `ibexa.url.alias` is a not a Twig function, but a special route name.

For more information about the use of `ibexa.url.alias` as a parameter of the [Symfony `path` Twig function]([[= symfony_doc =]]/reference/twig_reference.html#path), see [Links to other locations](urls_and_routes.md).

### `ibexa_route()`

`ibexa_route()` generates a [RouteReference object](urls_and_routes.md#routereference) from the given parameters.

|Argument|Type|Description|
|------|------|------|
|`resource`|`string`</br>`Ibexa\Contracts\Core\Repository\Values\Content\Location`</br>`Ibexa\Contracts\Core\Repository\Values\Content\Content`</br>`Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo`</br>`Ibexa\Contracts\Core\Repository\Values\Content\Location`</br>`Ibexa\Core\MVC\Symfony\Routing\RouteReference`|Resource or route name.|
|`params`|`array`|Route parameters.|

``` html+twig
{% set routeReference = ibexa_route("ibexa.url.alias", { 'locationId': 2 }) %}
```

## OAuth2

### `ibexa_oauth2_connect_path()`

`ibexa_oauth2_connect_path()` generates a relative path for the given [OAuth2 route](oauth_authentication.md).

|Argument|Type|Description|
|------|------|------|
|`identifier`|string|Identifier of the OAuth connection.|
|`parameters`|`array`|Route parameters.|
|`relative`|`boolean`|Whether to generate a relative path.|

### `ibexa_oauth2_connect_url()`

`ibexa_oauth2_connect_url()` generates an absolute URL for the given [OAuth2 route](oauth_authentication.md).

|Argument|Type|Description|
|------|------|------|
|`identifier`|string|Identifier of the OAuth connection.|
|`parameters`|`array`|Route parameters.|
|`schemeRelative`|`boolean`|Whether to generate a relative URL.|
