# URL Twig functions

- [`ez_path()`](#ez_path) returns the relative URL to a Content item or Location.
- [`ez_url()`](#ez_url) returns the absolute URL to a Content item or Location.
- [`ez_urlalias()`](#ez_urlalias) generates URLs for a Location from the given arguments.

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

For more information about the use of `ez_urlalias` as a parameter of the [Symfony `path` Twig function](https://symfony.com/doc/current/reference/twig_reference.html#path), see [Links to other locations](../../templates.md#links-to-other-locations).
