# Testing REST API

You can test operations in the REST API by using command line, PHP or JS code.

A standard web browser isn't sufficient to fully test the API. You can, however, try opening the root resource with it, using the session authentication: `http://example.com/api/ibexa/v2/`. Depending on how your browser understands XML, it either downloads the XML file, or opens it in the browser.

The following examples show how to interrogate the REST API with cURL, PHP or JS.

## CLI

For examples of using `curl`, refer to:

- [REST root](../rest_api_usage/index.md#rest-root)
- [OPTIONS method](../rest_requests/index.md#options-method)
- [Location header](../rest_responses/index.md#location-header)
- [ContentInfo body](../rest_responses/index.md#response-body)

## PHP

You can use [Symfony HttpClient](https://symfony.com/doc/7.4/http_client.html) to test REST API. Open a PHP shell in a terminal with `php -a` and copy-paste this code into it:

```php
$resource = 'https://api.example.com/api/ibexa/v2/content/objects/52';
require 'vendor/autoload.php';
$client = Symfony\Component\HttpClient\HttpClient::create();
$response = $client->request('GET', $resource, [
    'headers' => ['Accept: application/vnd.ibexa.api.ContentInfo+json'],
]);
var_dump($response->getStatusCode(), $response->getHeaders(), $response->toArray());
```

`$resource` URI should be edited to address the right domain.

On a freshly installed Ibexa DXP, `52` is the Content ID of the home page. If necessary, substitute `52` with the content ID of an item from your database.

For a content creation example that uses PHP, see [Creating content with binary attachments](../rest_requests/index.md#creating-content-with-binary-attachments)

## JS

The REST API can help you implement JavaScript / AJAX interaction. The following example of an AJAX call retrieves `ContentInfo` (that is, metadata) for a content item.

To test it, copy-paste this code into your browser console alongside a page from your website (to share the domain):

**Fetch API**

```javascript
const resource = '/api/ibexa/v2/content/objects/52';

fetch(resource, {
    headers: {'Accept': 'application/vnd.ibexa.api.ContentInfo+json'},
}).then((response) => {
    console.log(...response.headers);
    return response.json();
}).then((data) => {
    console.log(data);
});
```

**XMLHttpRequest**

```javascript
const resource = '/api/ibexa/v2/content/objects/52';
const request = new XMLHttpRequest();

request.open('GET', resource, true);
request.setRequestHeader('Accept', 'application/vnd.ibexa.api.ContentInfo+json');
request.onload = function () {
    console.log(request.getAllResponseHeaders(), JSON.parse(request.responseText));
};
request.send();
```

On a freshly installed Ibexa DXP, `52` is the Content ID of the home page. If necessary, substitute `52` with the Content ID of an item from your database.

You can edit the `resource` URI to address another domain, but [cross-origin requests](../rest_responses/index.md#cross-origin) must be allowed first.
