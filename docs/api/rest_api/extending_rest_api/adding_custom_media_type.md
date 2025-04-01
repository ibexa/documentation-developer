---
description: Add a custom media type to REST API request headers.
---

# Adding custom media type

In this example case, you pass a new media type in the `Accept` header of a GET request to `/content/locations/{locationPath}` route and its controller action (`Controller/Location::loadLocation`).

By default, this resource takes an `application/vnd.ibexa.api.Location+xml` (or `+json`) `Accept` header.
The following example adds the handling of a new media type `application/app.api.Location+xml` (or `+json`) `Accept` header to obtain a different response with the same controller.

You need the following elements:

- `ValueObjectVisitor` - to create the new response corresponding to the new media type
- `ValueObjectVisitorResolver` - to have this `ValueObjectVisitor` used to visit the default controller result
- `Output\Visitor` - service associating this new `ValueObjectVisitorResolver` with the new media type

!!! note

    You can change the vendor name (from default `vnd.ibexa.api` to new `app.api` like in this example), or you can create a new media type in the default vendor (like `vnd.ibexa.api.Greeting` in the [Creating a new REST resource](creating_new_rest_resource.md) example).
    To do so, tag your new `ValueObjectVisitor` with `ibexa.rest.output.value_object.visitor` to add it to the existing `ValueObjectVisitorResolver`, and a new one isn't needed.
    This way, the `media-type` attribute is also easier to create, because the default `Output\Generator` uses this default vendor.
    This example presents creating a new vendor as a good practice, to highlight that this is custom extensions that isn't available in a regular [[= product_name =]] installation.

## New `RestLocation` `ValueObjectVisitor`

The controller action returns a `Values\RestLocation` object wrapped in `Values\CachedValue`.
The new `ValueObjectVisitor` has to visit `Values\RestLocation` to prepare the new `Response`.

To be accepted by the `ValueObjectVisitorDispatcher`, all new `ValueObjectVisitor` need to extend the abstract class `Output\ValueObjectVisitor`.
In this example, this new `ValueObjectVisitor` extends the built-in `RestLocation` visitor to reuse it.
This way, the abstract class is implicitly inherited.

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/ValueObjectVisitor/RestLocation.php') =]]
```

This new `ValueObjectVisitor` receives a new tag `app.rest.output.value_object.visitor` to be associated to the new `ValueObjectVisitorDispatcher` in the next step.
This tag has a `type` property to associate the new `ValueObjectVisitor` with the type of value is made for.

``` yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 33, 41) =]]
```

## New `ValueObjectVisitorResolver`

The new `ValueObjectVisitorResolver` receives the `ValueObjectVisitor`s tagged `app.rest.output.value_object.visitor`.
As not all value FQCNs are handled, the new `ValueObjectVisitorResolver` also receives the default one as a fallback.

``` yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 28, 32) =]]
```

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/Output/ValueObjectVisitorResolver.php') =]]
```

## New `Output\Visitor` service

The following new pair of `Ouput\Visitor` entries associates `Accept` headers starting with `application/app.api.` to the new `ValueObjectVisitorResolver` for both XML and JSON.
A priority is set higher than other `ibexa.rest.output.visitor` tagged built-in services.

``` yaml
parameters:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 1, 3) =]]
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 6, 27) =]]
```

## Testing the new media-type

In the following example, `curl` and `diff` commands are used to compare the default media type (`application/vnd.ibexa.api.Location+xml`) with the new `application/app.api.Location+xml`.

```shell
diff --ignore-space-change \
  <(curl --silent https://api.example.com/api/ibexa/v2/content/locations/1/2) \
  <(curl --silent https://api.example.com/api/ibexa/v2/content/locations/1/2 --header 'Accept: application/app.api.Location+xml');
```

``` diff
2c2,3
< <Location media-type="application/vnd.ibexa.api.Location+xml" href="/api/ibexa/v2/content/locations/1/2">
---
> <Location media-type="application/app.api.Location+xml" href="/api/ibexa/v2/content/locations/1/2">
>  <Location media-type="application/vnd.ibexa.api.Location+xml" href="/api/ibexa/v2/content/locations/1/2">
37a39,42
>  </Location>
>  <UrlAliasRefList media-type="application/vnd.ibexa.api.UrlAliasRefList+xml" href="/api/ibexa/v2/content/locations/1/2/urlaliases">
>   <UrlAlias media-type="application/vnd.ibexa.api.UrlAlias+xml" href="/api/ibexa/v2/content/urlaliases/0-d41d8cd98f00b204e9800998ecf8427e"/>
>  </UrlAliasRefList>
```
