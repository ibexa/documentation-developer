---
description: The REST API covers objects in the Ibexa DXP Repository with regular and custom HTTP methods, such as GET or PUBLISH, as well as HTTP headers.
---

# REST API usage

The REST API in [[= product_name =]] allows you to interact with an [[= product_name =]] installation using the HTTP protocol,
following a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) interaction model.

Each resource (URI) interacts with a part of the system (content, users, search, and so on).
Every interaction with the Repository than you can do from Back Office or using the [Public PHP API](php_api.md) can also be done using the REST API.

The REST API uses HTTP methods (`GET`, `PUBLISH` , and so on), as well as HTTP headers to specify the type of request.

## URIs

The REST API is designed in such a way that the client can explore the Repository without constructing any URIs to resources.
Starting from the [root resource](#rest-root), every response includes further links (`href`) to related resources.

### URI prefix

[REST reference](../rest_api_reference/rest_api_reference.html), for the sake of readability, uses no prefixes in the URIs.
In practice, the `/api/ibexa/v2` prefixes all REST hrefs.

This prefix immediately follows the domain, and you can't use the [`URIElement` SiteAccess matcher](siteaccess_matching.md#urielement).
If you need to the select a SiteAccess, see the [`X-Siteaccess` HTTP header](rest_requests#siteaccess).

### URI parameters

URI parameters (query string) can be used on some resources.
They usually serve as options or filters for the requested resource.

As an example, the request below would paginate the results and return the first 5 relations for version 3 of the Content item 59:

```
GET /content/objects/59/versions/3/relations?limit=5 HTTP/1.1
Accept: application/vnd.ibexa.api.RelationList+xml
```

#### Working with value objects IDs

Resources that accept a reference to another resource expect the reference to be given as a REST URI, not a single ID.
For example, the URI requesting a list of user groups assigned to the role with ID 1 is:

```
GET /api/ibexa/v2/user/groups?roleId=/api/ibexa/v2/user/roles/1
```

### REST root

The `/` root route is answered by a reference list with the main resource routes and media-types.
It is presented in XML by default, but you can also switch to JSON output.

```shell
curl https://api.example.com/api/ibexa/v2/
curl -H "Accept: application/json" https://api.example.com/api/ibexa/v2/
```

### Country list

Alongside regular Repository interactions, there is a REST service providing a list of countries with their names, [ISO-3166](http://en.wikipedia.org/wiki/ISO_3166) codes and International Dialing Codes (IDC). It could be useful when presenting a country options list from any application.

This country list's URI is `/services/countries`.

The ISO-3166 country codes can be represented as:

- two-letter code (alpha-2) — recommended as the general purpose code
- three-letter code (alpha-3) — related to the country name
- three-digit numeric code (numeric-3) — useful if you need to avoid using Latin script

For details, see the [ISO-3166 glossary](http://www.iso.org/iso/home/standards/country_codes/country_codes_glossary.htm).

## REST communication summary

* A REST route (URI) leads to a REST controller action. A REST route is composed of the root prefix (`ibexa.rest.path_prefix: /api/ibexa/v2`) and a resource path (for example, `/content/objects/{contentId}`).
* This controller action returns an `Ibexa\Rest\Value` descendant.
  - This controller action might use the `Request` to build its result according to, for example, GET parameters, the `Accept` HTTP header, or the request payload and its `Content-Type` HTTP header.
  - This controller action might wrap its return in a `CachedValue` which contains caching information for the reverse proxies.
* The `Ibexa\Bundle\Rest\EventListener\ResponseListener` attached to the `kernel.view event` is triggered, and passes the request and the controller action's result to the `AcceptHeaderVisitorDispatcher`.
* The `AcceptHeaderVisitorDispatcher` matches one of the `regexps` of an `ibexa.rest.output.visitor` service (an `Ibexa\Contracts\Rest\Output\Visitor`). The role of this `Output\Visitor` is to transform the value returned by the controller into XML or JSON output format. To do so, it combines an `Output\Generator` corresponding to the output format and a `ValueObjectVisitorDispatcher`. This `Output\Generator` is also adding the `media-type` attributes.
* The matched `Output\Visitor` uses its `ValueObjectVisitorDispatcher` to select the right `ValueObjectVisitor` according to the fully qualified class name (FQCN) of the controller result. A `ValueObjectVisitor` is a service tagged `ibexa.rest.output.value_object.visitor` and this tag has a property `type` pointing a FQCN.
* `ValueObjectVisitor`s will recursively help to transform the controller result thanks to the abstraction layer of the `Generator`.
* The `Output\Visitor` returns the `Response` to send back to the client.
