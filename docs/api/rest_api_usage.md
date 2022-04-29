# REST API usage

TODO: Introduction? Do not explain what REST is, only the specificity of Ibexa DXP's REST API

The REST API v2 introduced in [[= product_name =]] allows you to interact with an [[= product_name =]] installation using the HTTP protocol, following a [REST](http://en.wikipedia.org/wiki/Representational_state_transfer) interaction model.

## HTTP verbs
https://doc.ibexa.co/en/latest/api/rest_api_guide/#http-methods
https://doc.ibexa.co/en/latest/api/general_rest_usage/#custom-http-verbs

TODO: https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods
TODO: Standard: GET, POST, DELETE, OPTIONS; Is PUT used??
TODO: Almost? standard: PATCH
TODO: Custom: COPY, MOVE, PUBLISH

It uses HTTP methods ( **`GET`** , **`POST`** , **`PUT`** , **`DELETE`** , etc.), as well as HTTP headers to specify the type of request. Depending on the used HTTP verb, different actions will be possible. Example:

| Action                                  | Description                                                          |
|-----------------------------------------|----------------------------------------------------------------------|
| `GET  /content/objects/2/version/3`     | Fetches data about version \#3 of Content item \#2                   |
| `PATCH  /content/objects/2/version/3`   | Updates the version \#3 draft of Content item \#2                    |
| `DELETE  /content/objects/2/version/3`  | Deletes the (draft or archived) version \#3 from Content item \#2    |
| `COPY  /content/objects/2/version/3`    | Creates a new draft version of Content item \#2 from its version \#3 |
| `PUBLISH  /content/objects/2/version/3` | Promotes the version \#3 of Content item \#2 from draft to published |
| `OPTIONS  /content/objects/2/version/3` | Lists all the verbs usable with this resource, the 5 ones above      |

!!! note "Caution with custom HTTP verbs"

    Using custom HTTP verbs, those besides the standard (GET, POST, PUT, DELETE, OPTIONS, TRACE), can cause issues with several HTTP proxies, network firewall/security solutions and simpler web servers. To avoid issues with this REST API allows you to set these using a HTTP header instead using HTTP verb POST. Example: `X-HTTP-Method-Override: PUBLISH`

In addition to the usual GET, POST, PUT, and DELETE HTTP verbs, the API supports a few custom ones:

- COPY
- [MOVE](http://tools.ietf.org/html/rfc2518)
- [PATCH](http://tools.ietf.org/html/rfc5789)
- PUBLISH

They should be recognized by most of the HTTP servers.
If the server does not recognize the custom methods you use, you can use the `POST` verb and precise the custom verb with the `X-HTTP-Method-Override` header.

**PATCH HTTP request**

```
POST /content/objects/59 HTTP/1.1
X-HTTP-Method-Override: PATCH
```

If applicable, both methods are always mentioned in the specifications.

### OPTIONS requests
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#options-requests

Any URI resource that the REST API responds to will respond to an OPTIONS request.

The response contains an `Allow` header, that as specified in [chapter 14.7 of RFC 2616](https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.7) lists the methods accepted by the resource.

```
OPTIONS /content/objects/1 HTTP/1.1
Host: api.example.net
```

```
HTTP/1.1 200 OK
Allow: PATCH,GET,DELETE,COPY
```

## Headers
https://doc.ibexa.co/en/latest/api/rest_api_guide/#other-headers

### SiteAccess
https://doc.ibexa.co/en/latest/api/general_rest_usage/#specifying-siteaccess
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#specifying-siteaccess

### Media types
https://doc.ibexa.co/en/latest/api/rest_api_guide/#media-type-headers
https://doc.ibexa.co/en/latest/api/rest_api_best_practices/#media-types

## Creating content with binary attachments
https://doc.ibexa.co/en/latest/api/creating_content_with_binary_attachments_via_rest_api/
TODO: Other example of payload/body?

## HTTP error codes
https://doc.ibexa.co/en/latest/api/general_rest_usage/#general-error-codes

## Making cross-origin HTTP requests
https://doc.ibexa.co/en/latest/api/making_cross_origin_http_requests/

## Testing the API
https://doc.ibexa.co/en/latest/api/rest_api_guide/#testing-the-api
TODO: Earlier? Merged into another section? What about PHP example(s)?
