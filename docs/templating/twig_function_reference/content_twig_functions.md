---
description: Content Twig function enable rendering whole Content items and their information.
---

# Content Twig functions

- [`ibexa_render()`](#ibexa_render) renders a Content item.
- [`ibexa_content_name()`](#ibexa_content_name) renders the name of a Content item.
- [`ibexa_render_content_query()`](#ibexa_render_content_query) renders the results of a non-content related query.
- [`ibexa_render_location_query()`](#ibexa_render_location_query) renders the results of a non-content related Location query.
- [`ibexa_seo_is_empty()`](#ibexa_seo_is_empty) returns a Boolean indication of whether SEO data is available for a Content item.
- [`ibexa_seo()`](#ibexa_seo) attaches SEO tags to Content item's HTML code.

## Content rendering

### `ibexa_render()`

`ibexa_render()` renders the indicated Content item.

It uses the `embed` view by default, but you can pass a different view as an argument.

You can provide `ibexa_render()` with either a Content item or a Location object.

!!! tip

    Depending on whether you pass a Content item or a Location object,
    the helper automatically selects and uses one of internal Twig functions:
    `ibexa_render_content()` or `ibexa_render_location()`.

|Argument|Type|Description|
|------|------|------|
|`content`</br>or</br>`location`|`Ibexa\Contracts\Core\Repository\Values\Content\Content`</br>or</br>`Ibexa\Contracts\Core\Repository\Values\Content\Location`|Content item or its Location.|
|`method`|`string`|(optional) [Rendering method](#rendering-methods). One of: `direct`, `inline`, `esi`, `ssi`.|
|`viewType`|`string`|(optional) [View type](template_configuration.md#view-types).|

#### Rendering methods

You can pass one of the following rendering methods to `ibexa_render()`:

- `direct` - (default) renders the Content item without using a request
- `inline` - Symfony inline rendering method, sends a request to the server and inserts the response
- `esi` - uses the Symfony [Edge Side Include mechanism]([[= symfony_doc =]]/http_cache/esi.html) to render the correct tag that is handled by the reverse proxy
- `ssi` - uses the Symfony [Server Side Include mechanism]([[= symfony_doc =]]/http_cache/ssi.html) to render the correct tag that is handled by the web server

``` html+twig
{{ ibexa_render(location) }}

{{ ibexa_render(content, {'viewType': 'line'}) }}

{{ ibexa_render(content, {'method': 'inline'}) }}
```

## Content information

### `ibexa_content_name()`

`ibexa_content_name()` renders the name of a Content item.

The function uses prioritized languages from SiteAccess settings unless you pass another language as `forcedLanguage`.
If the Content item does not have a translation in the prioritized or passed language,
the function returns the name in the main language.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `Ibexa\Contracts\Core\Repository\Values\Content\Content`</br>or</br>`Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo` | Content item or its ContentInfo object.|
| `forcedLanguage` | `string` | (optional) Language to use (for example, `fre-FR`). |

``` html+twig
{{ ibexa_content_name(content) }}

{{ ibexa_content_name(content, 'pol-PL') }}
```

### `ibexa_seo_is_empty()`

`ibexa_seo_is_empty()` returns a Boolean value which indicates whether [SEO](https://doc.ibexa.co/projects/userguide/en/latest/search_engine_optimization/seo/) data is available for the Content item that is passed as an argument.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `Ibexa\Contracts\Core\Repository\Values\Content\Content`</br>or</br>`Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo` | Content item or its ContentInfo object.|

``` html+twig
{{ ibexa_seo_is_empty(content) }}
```

### `ibexa_seo()`

`ibexa_seo()` attaches [SEO](https://doc.ibexa.co/projects/userguide/en/latest/search_engine_optimization/seo/) 
data to the Content item's HTML code.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `Ibexa\Contracts\Core\Repository\Values\Content\Content`</br>or</br>`Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo` | Content item or its ContentInfo object.|

``` html+twig
{{ ibexa_seo(content) }}
```

!!! tip 

    The following example uses both SEO-related functions:

    ``` html+twig
    {% if not ibexa_seo_is_empty(content) %}
        {{ ibexa_seo(content)}}
    {% else %}
        <title>{{ ibexa_content_name(content) }}</title>
        # Generate other tags
    {% endif %}
    ```

## Non-content related queries

### `ibexa_render_content_query()`

`ibexa_render_content_query` renders the results of a non-content related query made by using a Query type.

|Argument|Type|Description|
|------|------|------|
|`options`|array|Available options are: `query`, `pagination`, `template`.|

!!! tip

    For an example of using `ibexa_render_content_query`, see [Add navigation menu](add_navigation_menu.md#render-menu-using-a-query).

### `ibexa_render_location_query()`

`ibexa_render_location_query` renders the results of a non-content related Location query made by using a Query type.

|Argument|Type|Description|
|------|------|------|
|`options`|array|Available options are: `query`, `pagination`, `template`.|
