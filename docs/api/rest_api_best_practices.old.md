# REST API best practices

This page refers to [REST API reference](rest_api_reference/rest_api_reference.html), where you can find detailed information about
REST API resources and endpoints.

## Specifying SiteAccess

## Media types

## URIs

The REST API is designed in such a way that the client doesn't need to construct any URIs to resources.
Starting from the root resources (`ListRoot_`) every response includes further links to related resources.
The URIs should be used directly as identifiers on the client side and the client should not construct any URIs by using an ID.

### URIs prefix

In [REST reference](rest_api_reference/rest_api_reference.html), for the sake of readability, there are no prefixes used in the URIs.
In practice, the `/api/ibexa/v2` prefixes are all REST hrefs.

Remember that the URIs to REST resources should never be generated manually, but obtained from earlier REST calls.

### OPTIONS requests
