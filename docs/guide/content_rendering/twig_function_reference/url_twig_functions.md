---
description: URL Twig functions enable rendering URLs and routes.
---

# URL Twig functions

- [`ez_path()`](#ez_path) returns the relative URL to a Content item or Location.
- [`ez_url()`](#ez_url) returns the absolute URL to a Content item or Location.
- [`ez_urlalias()`](#ez_urlalias) generates URLs for a Location from the given arguments.
- [`ez_route()`](#ez_route)  generates a RouteReference object from the given parameters.
- [`ibexa_oauth2_connect_path()`](#ibexa_oauth2_connect_path) generates a relative path for the given OAuth2 route.
- [`ibexa_oauth2_connect_url()`](#ibexa_oauth2_connect_url) generates an absolute URL for the given OAuth2 route.

## URLs

### `ez_path()`

`ez_path()` returns the relative URL to a Content item or Location.

|Argument|Type|Description|
|------|------|------|
|`name`|`string`</br>`eZ\Publish\API\Repository\Values\Content\Location`</br>`eZ\Publish\API\Repository\Values\Content\Content`</br>`eZ\Publish\API\Repository\Values\Content\ContentInfo`</br>`eZ\Publish\API\Repository\Values\Content\Location`</br>`eZ\Publish\Core\MVC\Symfony\Routing\RouteReference`|The name of the route, Location or Content.|
|`parameters`|`array`|Route parameters.|
|`relative`|`boolean`|Whether to generate a relative path.|

``` html+twig
{{ ez_path(location) }}
```

### `ez_url()`

`ez_url()` returns the absolute URL to a Content item or Location.

|Argument|Type|Description|
|------|------|------|
|`name`|`string`</br>`eZ\Publish\API\Repository\Values\Content\Location`</br>`eZ\Publish\API\Repository\Values\Content\Content`</br>`eZ\Publish\API\Repository\Values\Content\ContentInfo`</br>`eZ\Publish\API\Repository\Values\Content\Location`</br>`eZ\Publish\Core\MVC\Symfony\Routing\RouteReference`|The name of the route, Location or Content.|
|`parameters`|`array`|Route parameters.|
|`schemeRelative`|`boolean`|Whether to generate a relative URL.|

``` html+twig
{{ ez_url(location, {}, false) }}
```

### `ez_urlalias()`

`ez_urlalias()` generates URLs for a Location from the given parameters.

!!! note

    `ez_urlalias` is a not a Twig function, but a special route name.

For more information about the use of `ez_urlalias` as a parameter of the [Symfony `path` Twig function]([[= symfony_doc =]]/reference/twig_reference.html#path), see [Links to other locations](../urls_and_routes.md).

### `ez_route()`

`ez_route()` generates a [RouteReference object](../urls_and_routes.md#routereference) from the given parameters.

|Argument|Type|Description|
|------|------|------|
|`resource`|`string`</br>`eZ\Publish\API\Repository\Values\Content\Location`</br>`eZ\Publish\API\Repository\Values\Content\Content`</br>`eZ\Publish\API\Repository\Values\Content\ContentInfo`</br>`eZ\Publish\API\Repository\Values\Content\Location`</br>`eZ\Publish\Core\MVC\Symfony\Routing\RouteReference`|Resource or route name.|
|`params`|`array`|Route parameters.|

``` html+twig
{% set routeReference = ez_route("ez_urlalias", { 'locationId': 2 }) %}
```

## OAuth2

### `ibexa_oauth2_connect_path()`

`ibexa_oauth2_connect_path()` generates a relative path for the given [OAuth2 route](../../user_management/oauth.md).

|Argument|Type|Description|
|------|------|------|
|`identifier`|string|Identifier of the OAuth connection.|
|`parameters`|`array`|Route parameters.|
|`relative`|`boolean`|Whether to generate a relative path.|

### `ibexa_oauth2_connect_url()`

`ibexa_oauth2_connect_url()` generates an absolute URL for the given [OAuth2 route](../../user_management/oauth.md).

|Argument|Type|Description|
|------|------|------|
|`identifier`|string|Identifier of the OAuth connection.|
|`parameters`|`array`|Route parameters.|
|`schemeRelative`|`boolean`|Whether to generate a relative URL.|
