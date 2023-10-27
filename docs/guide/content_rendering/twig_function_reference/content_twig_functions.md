---
description: Content Twig function enable rendering whole Content items and their information.
---

# Content Twig functions

- [`ez_render()`](#ez_render) renders a Content item.
- [`ez_content_name()`](#ez_content_name) renders the name of a Content item.
- [`ez_render_content_query()`](#ez_render_content_query) renders the results of a non-content related query.
- [`ez_render_location_query()`](#ez_render_location_query) renders the results of a non-content related Location query.

## Content rendering

### `ez_render()`

`ez_render()` renders the indicated Content item.

It uses the `embed` view by default, but you can pass a different view as an argument.

You can provide `ez_render()` with either a Content item or a Location object.

!!! tip

    Depending on whether you pass a Content item or a Location object,
    the helper automatically selects and uses one of internal Twig functions:
    `ez_render_content()` or `ez_render_location()`.

|Argument|Type|Description|
|------|------|------|
|`content`</br>or</br>`location`|`eZ\Publish\API\Repository\Values\Content\Content`</br>or</br>`eZ\Publish\API\Repository\Values\Content\Location`|Content item or its Location.|
|`method`|`string`|(optional) [Rendering method](#rendering-methods). One of: `direct`, `inline`, `esi`, `ssi`.|
|`viewType`|`string`|(optional) [View type](../templates/template_configuration.md#view-types).|

#### Rendering methods

You can pass one of the following rendering methods to `ez_render()`:

- `direct` - (default) renders the Content item without using a request
- `inline` - Symfony inline rendering method, sends a request to the server and inserts the response
- `esi` - uses the Symfony [Edge Side Include mechanism]([[= symfony_doc =]]/http_cache/esi.html) to render the correct tag that is handled by the reverse proxy
- `ssi` - uses the Symfony [Server Side Include mechanism]([[= symfony_doc =]]/http_cache/ssi.html) to render the correct tag that is handled by the web server

``` html+twig
{{ ez_render(location) }}

{{ ez_render(content, {'viewType': 'line'}) }}

{{ ez_render(content, {'method': 'inline'}) }}
```

## Content information

### `ez_content_name()`

`ez_content_name()` renders the name of a Content item.

The function uses prioritized languages from SiteAccess settings unless you pass another language as `forcedLanguage`.
If the Content item does not have a translation in the prioritized or passed language,
the function returns the name in the main language.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content`</br>or</br>`eZ\Publish\API\Repository\Values\Content\ContentInfo` | Content item or its ContentInfo object.|
| `forcedLanguage` | `string` | (optional) Language to use (for example, `fre-FR`). |

``` html+twig
{{ ez_content_name(content) }}

{{ ez_content_name(content, 'pol-PL') }}
```

## Non-content related queries

### `ez_render_content_query()`

`ez_render_content_query` renders the results of a non-content related query made by using a Query type.

|Argument|Type|Description|
|------|------|------|
|`options`|array|Available options are: `query`, `pagination`, `template`.|

!!! tip

    For an example of using `ez_render_content_query`, see [Add navigation menu](../layout/add_menu.md#render-menu-using-a-query).

### `ez_render_location_query()`

`ez_render_location_query` renders the results of a non-content related Location query made by using a Query type.

|Argument|Type|Description|
|------|------|------|
|`options`|array|Available options are: `query`, `pagination`, `template`.|
