---
description: Site context Twig functions return the website selected in the back office, determine if a location is site context-aware, and render brand context attribute values.
edition: experience
page_type: reference
---

# Site context Twig functions

Site context Twig functions work with the website that the user selected in the back office top bar, and with [brand contexts](brand_context_guide.md).

## `ibexa_site_context_get_current()`

`ibexa_site_context_get_current()` returns the SiteAccess of the website that the current user selected in the back office top bar, or `null` if no website is selected.

``` html+twig
{% set site_access = ibexa_site_context_get_current() %}
{% if site_access is not null %}
    <p>You're working with the {{ site_access.name }} website.</p>
{% endif %}
```

## `ibexa_site_context_aware()`

`ibexa_site_context_aware()` is a [Twig test](https://twig.symfony.com/doc/3.x/tests/index.html) that checks whether a given location is site context-aware, meaning it's not excluded from Site context by using the `ibexa.system.<scope>.site_context.excluded_paths` [configuration](configure_brand_context.md#exclude-locations-from-website-selection).

``` html+twig
{% if location is ibexa_site_context_aware %}
    <p>I am aware of the site context!</p>
{% endif %}
```

## `ibexa_site_context_is_location_preview_enabled()`

`ibexa_site_context_is_location_preview_enabled()` checks whether the current user enabled location preview in their user settings.

``` html+twig
{% if ibexa_site_context_is_location_preview_enabled() %}
    {# Render the preview #}
{% endif %}
```

## `ibexa_location_preview_url()`

`ibexa_location_preview_url()` returns the preview URL of a location.

| Argument | Type | Description |
|---|---|---|
| `location` | `Ibexa\Contracts\Core\Repository\Values\Content\Location` | Location to preview. |
| `context` | `array` | Parameters passed to the URL resolver: `language` - the language code of the preview, and `siteaccess` - the name of the SiteAccess in which to preview the location. |

To change how preview URLs are generated, for example, for a headless front end, listen to the [`ResolveLocationPreviewUrlEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Event-ResolveLocationPreviewUrlEvent.html) event.

``` html+twig
{% set site_access = ibexa_site_context_get_current() %}
<a href="{{ ibexa_location_preview_url(location, { language: 'eng-GB', siteaccess: site_access.name }) }}">Preview</a>
```

## `ibexa_format_brand_context_attribute`

`ibexa_format_brand_context_attribute` is a filter that renders the value of a brand context attribute by using the [attribute templates](configure_brand_context.md#customize-attribute-rendering).

| Argument | Type | Description |
|---|---|---|
| `attributeValue` | `Ibexa\Contracts\SiteContext\Values\BrandContextAttributeValueInterface` | Attribute value to render. |
| `parameters` | `array` | (Optional) Additional parameters passed to the template block. |

In the following example, `brand_context` is a [`BrandContextInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-BrandContextInterface.html) object that a controller passes to the template:

``` html+twig
{{ brand_context.getAttributeValue('tagline')|ibexa_format_brand_context_attribute }}
```
