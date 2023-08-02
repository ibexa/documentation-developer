---
description: You can test operations in the REST API by using command line, PHP or JS code.
---

# Testing REST API

A standard web browser is not sufficient to fully test the API.
You can, however, try opening the root resource with it, using the session authentication: `http://example.com/api/ibexa/v2/`.
Depending on how your browser understands XML, it either downloads the XML file, or opens it in the browser.

The following examples show how to interrogate the REST API using cURL, PHP or JS.

To test further, you can use browser extensions, like [Advanced REST client for Chrome](https://chrome.google.com/webstore/detail/advanced-rest-client/hgmloofddffdnphfgcellkdfbfbjeloo) or [RESTClient for Firefox](https://addons.mozilla.org/firefox/addon/restclient/), or dedicated tools. For command line users, [HTTPie](https://github.com/jkbr/httpie) is a good tool.

## CLI

For examples of using `curl`, refer to:

- [REST root](rest_api_usage.md#rest-root)
- [OPTIONS method](rest_requests.md#options-method)
- [Location header](rest_responses.md#location-header)
- [ContentInfo body](rest_responses.md#response-body)

## PHP

To test REST API with PHP, [cURL](https://www.php.net/manual/en/book.curl.php) or the [Symfony HttpClient](https://symfony.com/doc/5.4/http_client.html) can be used. Open a PHP shell in a terminal with <nobr>`php -a`</nobr> and copy-paste this code into it:

=== "cURL"

    ``` php
    [[= include_file('code_samples/api/rest_api/load_content.php', 4, 18, '    ') =]]
    ```

=== "HttpClient"

    ``` php
    [[= include_file('code_samples/api/rest_api/load_content.php', 21, 28, '    ') =]]
    ```

`$resource` URI should be edited to address the right domain.

On a freshly installed Ibexa DXP, `52` is the Content ID of the home page. If necessary, substitute `52` with the Content ID of an item from your database.

For a content creation example using PHP, see [Creating content with binary attachments](rest_requests.md#creating-content-with-binary-attachments)

## JS

The REST API can help you implement JavaScript / AJAX interaction.
The following example of an AJAX call retrieves `ContentInfo` (that is, metadata) for a Content item:

To test it, copy-paste this code into your browser console alongside a page from your website (to share the domain):

```javascript
var resource = '/api/ibexa/v2/content/objects/52',
    request = new XMLHttpRequest();

request.open('GET', resource, true);
request.setRequestHeader('Accept', 'application/vnd.ibexa.api.ContentInfo+json');
request.onload = function () {
    console.log(request.getAllResponseHeaders(), JSON.parse(request.responseText));
};
request.send();
```

On a freshly installed Ibexa DXP, `52` is the Content ID of the home page. If necessary, substitute `52` with the Content ID of an item from your database.

You can edit the `resource` URI to address another domain, but [cross-origin requests](rest_responses.md#cross-origin) must be allowed first.
