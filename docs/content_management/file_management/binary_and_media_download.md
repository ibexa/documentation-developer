---
description: Create route to to enable binary and media files download.
---

# Binary and Media download

You can restrict files stored in BinaryFile or Media Fields to certain user Roles.
These files are not publicly downloadable from disk, and are instead served by Symfony, using a custom route that runs the necessary checks.
This route is automatically generated as the `url` property for those Field values.

## The content/download route

You have to create a route using the `download` route name.

It accepts optional query parameters:

- `version`: The content version number that the file is downloaded for. Requires the `content / read` permission for a published version and additionally `content / versionread` permission for an unpublished version. If not specified, uses the published version.
- `inLanguage`: The language the file should be downloaded in. If not specified, the most prioritized language for the SiteAccess is used.

The [`ibexa_render`_field`](field_twig_functions.md#ibexa_render_field) Twig helper by default generates a working link.

## Download link generation

To generate a direct download link for the `File` Field Type you have to create
a [RouteReference](urls_and_routes.md#routereference) with the `ibexa_route` helper, passing `content` and `File` Field identifier as parameters.
Optional parameter `inLanguage` may be used to specify File content translation.

```twig
  {% set routeReference = ibexa_route( 'ibexa.content.download', {'content': content, 'fieldIdentifier': 'file', 'inLanguage': content.prioritizedFieldLanguageCode  } ) %}
  <a href="{{ ibexa_path( routeReference ) }}">Download</a>
```

## REST API: `uri` property

The `uri` property of Binary Fields in REST contains a valid download URL, of the same format as the Public API, prefixed with the same host as the REST Request.

For [more information about REST API see the documentation](rest_api_usage.md).
