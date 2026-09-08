# Content Twig functions

Content Twig function enable rendering whole content items and their information.

- [`ibexa_render()`](#ibexa_render) renders a content item.
- [`ibexa_content_name()`](#ibexa_content_name) renders the name of a content item.
- [`ibexa_render_content_query()`](#ibexa_render_content_query) renders the results of a non-content related query.
- [`ibexa_render_location_query()`](#ibexa_render_location_query) renders the results of a non-content related Location query.
- [`ibexa_seo_is_empty()`](#ibexa_seo_is_empty) returns a Boolean indication of whether SEO data is available for a content item.
- [`ibexa_seo()`](#ibexa_seo) attaches SEO tags to content item's HTML code.

## Content rendering

### `ibexa_render()`

`ibexa_render()` renders the indicated content item.

It uses the `embed` view by default, but you can pass a different view as an argument.

You can provide `ibexa_render()` with either a content item or a Location object.

> **Tip: Tip**
>
> Depending on whether you pass a content item or a Location object, the helper automatically selects and uses one of internal Twig functions: `ibexa_render_content()` or `ibexa_render_location()`.

| Argument                | Type                                                                                                                                                                                                                                                                                                                                                                                                                                                               | Description                                                                                                                                 |
| ----------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------- |
| `content` or `location` | [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Content.php), [`Ibexa\Contracts\Core\Repository\Values\Content\ContentAwareInterface`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentAwareInterface.php) or [`Ibexa\Contracts\Core\Repository\Values\Content\Location`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Location.php) | Content item or its location.                                                                                                               |
| `method`                | `string`                                                                                                                                                                                                                                                                                                                                                                                                                                                           | (optional) [Rendering method](#rendering-methods). One of: `direct`, `inline`, `esi`, `ssi`. (Default method is `direct`)                   |
| `viewType`              | `string`                                                                                                                                                                                                                                                                                                                                                                                                                                                           | (optional) [View type](../../templates/template_configuration/index.md#view-types). (Default view type is `embed`) |
| `params`                | `array`                                                                                                                                                                                                                                                                                                                                                                                                                                                            | (optional) Hash of variables to pass to the template.                                                                                       |

#### Rendering methods

You can pass one of the following rendering methods to `ibexa_render()`:

- `direct` - (default) renders the content item without using a request
- `inline` - Symfony inline rendering method, sends a request to the server and inserts the response
- `esi` - uses the Symfony [Edge Side Include mechanism](https://symfony.com/doc/7.4/http_cache/esi.html) to render the correct tag that is handled by the reverse proxy
- `ssi` - uses the Symfony [Server Side Include mechanism](https://symfony.com/doc/7.4/http_cache/ssi.html) to render the correct tag that is handled by the web server

```html+twig
{{ ibexa_render(location) }}

{{ ibexa_render(content, {'viewType': 'line'}) }}

{{ ibexa_render(content, {'method': 'inline'}) }}

{{ ibexa_render(content, {
    'viewType': 'line',
    'params': {
        'custom_param': 'custom_value'
    }
}) }}
```

## Content information

### `ibexa_content_name()`

`ibexa_content_name()` renders the name of a content item.

The function uses prioritized languages from SiteAccess settings unless you pass another language as `forcedLanguage`. If the content item doesn't have a translation in the prioritized or passed language, the function returns the name in the main language.

| Argument         | Type                                                                                                                                                                                                                                                                                                                                                                                                                                                                      | Description                                                            |
| ---------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------- |
| `content`        | [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Content.php), [`Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentInfo.php), or [`Ibexa\Contracts\Core\Repository\Values\Content\ContentAwareInterface`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentAwareInterface.php) | Content item, its ContentInfo object, or ContentAwareInterface object. |
| `forcedLanguage` | `string`                                                                                                                                                                                                                                                                                                                                                                                                                                                                  | (optional) Language to use (for example, `fre-FR`).                    |

```html+twig
{{ ibexa_content_name(content) }}

{{ ibexa_content_name(content, 'pol-PL') }}
```

```html+twig
{{ ibexa_content_name(product) }}

{{ ibexa_content_name(product, 'fr-FR') }}
```

### `ibexa_seo_is_empty()`

`ibexa_seo_is_empty()` returns a Boolean value which indicates whether [SEO](../../../../user/search_engine_optimization/seo/index.md) data is available for the content item that is passed as an argument.

| Argument  | Type                                                                                                                                                                                                                                                                                                                 | Description                                   |
| --------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------- |
| `content` | [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Content.php) or [`Ibexa\Contracts\Core\Repository\Values\Content\ContentAwareInterface`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentAwareInterface.php) | Content item or ContentAwareInterface object. |

```html+twig
{{ ibexa_seo_is_empty(content) }}
```

```html+twig
{{ ibexa_seo_is_empty(product) }}
```

### `ibexa_seo()`

`ibexa_seo()` attaches [SEO](../../../../user/search_engine_optimization/seo/index.md) data to the content item's HTML code.

| Argument  | Type                                                                                                                                                                                                                                                                                                                 | Description                                   |
| --------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------- |
| `content` | [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Content.php) or [`Ibexa\Contracts\Core\Repository\Values\Content\ContentAwareInterface`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentAwareInterface.php) | Content item or ContentAwareInterface object. |

```html+twig
{{ ibexa_seo(content) }}
```

```html+twig
{{ ibexa_seo(product) }}
```

> **Tip: Tip**
>
> The following example uses both SEO-related functions:
>
> ```html+twig
> {% if not ibexa_seo_is_empty(content) %}
>     {{ ibexa_seo(content)}}
> {% else %}
>     <title>{{ ibexa_content_name(content) }}</title>
>     # Generate other tags
> {% endif %}
> ```

### `ibexa_taxonomy_entries_for_content()` filter

`ibexa_taxonomy_entries_for_content()` fetches names of content categories.

| Argument  | Type                                                                                                                                                                                                                                                                                                                 | Description                                    |
| --------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------- |
| `content` | [`Ibexa\Contracts\Core\Repository\Values\Content\Content`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Content.php) or [`Ibexa\Contracts\Core\Repository\Values\Content\ContentAwareInterface`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentAwareInterface.php) | Content item to display the category name for. |

```html+twig
{{ content|ibexa_taxonomy_entries_for_content|map(entry => "#{entry.name}")|join(', ') }}
```

```html+twig
{{ product|ibexa_taxonomy_entries_for_content|map(entry => "#{entry.name}")|join(', ') }}
```

## Non-content related queries

### `ibexa_render_content_query()`

`ibexa_render_content_query` renders the results of a non-content related query made by using a Query type.

| Argument  | Type  | Description                                               |
| --------- | ----- | --------------------------------------------------------- |
| `options` | array | Available options are: `query`, `pagination`, `template`. |

> **Tip: Tip**
>
> For an example of using `ibexa_render_content_query`, see [Add navigation menu](../../layout/add_navigation_menu/index.md#render-menu-using-a-query).

### `ibexa_render_location_query()`

`ibexa_render_location_query` renders the results of a non-content related location query made by using a Query type.

| Argument  | Type  | Description                                               |
| --------- | ----- | --------------------------------------------------------- |
| `options` | array | Available options are: `query`, `pagination`, `template`. |
