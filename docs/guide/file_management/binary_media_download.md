# Binary and Media download
<<<<<<< HEAD

Unlike image files, you can restrict files stored in BinaryFile or Media to certain user roles.
=======

Unlike image files, you can restrict files stored in BinaryFile or Media to certain user roles.
>>>>>>> cbb79188... Updates on handling.md
As such, they are not publicly downloadable from disk, and are instead served by Symfony, using a custom route that runs the necessary checks. This route is automatically generated as the `url` property for those Field values.

## The content/download route

The path to content download should follow the route name.

It also accepts optional query parameters:

- `version`: the version number that the file must be downloaded for. Requires the `content / versionread` permission. If not specified, uses the published version.
- `inLanguage`: The language the file should be downloaded in. If not specified, the most prioritized language for the SiteAccess will be used.

<<<<<<< HEAD
The [ibexa\_render\_field](../content_rendering/twig_function_reference/field_twig_functions.md#ibexa_render_field) Twig helper will by default generate a working link.
=======
The [ibexa\_render\_field](../content_rendering/twig_function_reference/field_twig_functions.md#ibexa_render_field) Twig helper will by default generate a working link.
>>>>>>> cbb79188... Updates on handling.md

## Download link generation

To generate a direct download link for the `File` Field Type you have to create
a Route Reference with the `ibexa_route` helper, passing `content` and `File` Field identifier as parameters.
Optional parameter `inLanguage` may be used to specify File content translation.

```twig
  {% set routeReference = ibexa_route( 'ibexa.content.download', {'content': content, 'fieldIdentifier': 'file', 'inLanguage': content.prioritizedFieldLanguageCode  } ) %}
  <a href="{{ ibexa_path( routeReference ) }}">Download</a>
```

## REST API: `uri` property

The `uri` property of Binary Fields in REST contains a valid download URL, of the same format as the Public API, prefixed with the same host as the REST Request.

For [more information about REST API see the documentation](../../api/rest_api_guide).
