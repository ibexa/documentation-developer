# REST requests

REST API requests can have a generic or a custom header. It defines additional options in the request, such as the accepted content type of response.

## Request method

Depending on the HTTP method used, different actions are possible on the same resource. Example:

| Action                                  | Description                                                        |
| --------------------------------------- | ------------------------------------------------------------------ |
| `GET /content/objects/2/versions/3`     | Fetches data about version #3 of content item #2                   |
| `PATCH /content/objects/2/versions/3`   | Updates the version #3 draft of content item #2                    |
| `DELETE /content/objects/2/versions/3`  | Deletes the (draft or archived) version #3 from content item #2    |
| `COPY /content/objects/2/versions/3`    | Creates a new draft version of content item #2 from its version #3 |
| `PUBLISH /content/objects/2/versions/3` | Promotes the version #3 of content item #2 from draft to published |
| `OPTIONS /content/objects/2/versions/3` | Lists all the methods usable with this resource, the 5 ones above  |

The following list of available methods gives an overview of the kind of action a method triggers on a resource, if available. For method action details per resource, see the [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html).

| HTTP method                                                          | Status   | Description            | Safe |
| -------------------------------------------------------------------- | -------- | ---------------------- | ---- |
| [OPTIONS](https://datatracker.ietf.org/doc/html/rfc2616#section-9.2) | Standard | List available methods | Yes  |
| [GET](https://datatracker.ietf.org/doc/html/rfc2616#section-9.3)     | Standard | Collect data           | Yes  |
| [HEAD](https://datatracker.ietf.org/doc/html/rfc2616#section-9.4)    | Standard | Check existence        | Yes  |
| [POST](https://datatracker.ietf.org/doc/html/rfc2616#section-9.5)    | Standard | Create an item         | No   |
| [PATCH](https://datatracker.ietf.org/doc/html/rfc5789)               | Custom   | Update an item         | No   |
| COPY                                                                 | Custom   | Duplicate an item      | No   |
| [MOVE](https://datatracker.ietf.org/doc/html/rfc2518)                | Custom   | Move an item           | No   |
| SWAP                                                                 | Custom   | Swap two locations     | No   |
| PUBLISH                                                              | Custom   | Publish an item        | No   |
| [DELETE](https://datatracker.ietf.org/doc/html/rfc2616#section-9.7)  | Standard | Remove an item         | No   |

> **Note: Caution with custom HTTP methods**
>
> Using custom HTTP methods can cause issues with several HTTP proxies, network firewall/security solutions and simpler web servers. To avoid such issuess, REST API allows you to set these by using the HTTP header `X-HTTP-Method-Override` alongside the standard `POST` method instead of using a custom HTTP method. For example: `X-HTTP-Method-Override: PUBLISH`
>
> If applicable, both methods are always mentioned in the specifications.

Unsafe methods require a CSRF token if [session-based authentication](../../rest_api_authentication/index.md#session-based-authentication) is used.

### OPTIONS method

Any REST API URI responds to an `OPTIONS` request.

The response contains an [`Allow` header](https://www.rfc-editor.org/rfc/rfc9110.html#name-allow), which lists the methods accepted by the resource.

```bash
curl -IX OPTIONS https://api.example.com/api/ibexa/v2/content/objects/1
```

```http
OPTIONS /content/objects/1 HTTP/1.1
Host: api.example.com
```

```http
HTTP/1.1 200 OK
Allow: PATCH,GET,DELETE,COPY
```

```bash
curl -IX OPTIONS https://api.example.com/api/ibexa/v2/content/locations/1/2
```

```http
OPTIONS /content/locations/1/2 HTTP/1.1
Host: api.example.com
```

```http
HTTP/1.1 200 OK
Allow: GET,PATCH,DELETE,COPY,MOVE,SWAP
```

## Request headers

You can use the following HTTP headers with a REST request:

- [`Accept`](https://datatracker.ietf.org/doc/html/rfc2616#section-14.1) describing the desired response type and format
- [`Content-Type`](https://datatracker.ietf.org/doc/html/rfc2616#section-14.17) describing the payload type and format
- [`X-Siteaccess`](#siteaccess) specifying the target SiteAccess
- `X-HTTP-Method-Override` allowing to pass a custom method while using `POST` method as previously seen in [HTTP method](#request-method)
- [`Destination`](#destination) specifying where to move an item
- [`X-Expected-User`](#expected-user) specifying the user needed for the request execution

Other headers related to authentication methods can be found in [REST API authentication](../../rest_api_authentication/index.md).

### SiteAccess

To specify a SiteAccess when communicating with the REST API, provide a custom `X-Siteaccess` header. Otherwise, the default SiteAccess is used.

The following example shows what could be a SiteAccess called `restapi` dedicated to REST API accesses:

```http
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ibexa.api.Root+json
X-Siteaccess: restapi
```

One of the principles of REST is that the same resource (such as content item, location, content type) should be unique. It allows caching your REST API with a reverse proxy such as Varnish. If the same resource is available in multiple locations, cache purging is noticeably more complex. This is why SiteAccess matching with REST isn't enabled at URL level (or domain).

### Media types

On top of methods, HTTP request headers allow you to personalize the request's behavior. On every resource, you can use the `Accept` header to indicate which format you want to communicate in, JSON or XML. This header is also used to specify the response type you want the server to send when multiple types are available.

- `Accept: application/vnd.ibexa.api.Content+xml` to get `Content` (full data, fields included) as **[XML](https://www.w3.org/XML/)**
- `Accept: application/vnd.ibexa.api.ContentInfo+json` to get `ContentInfo` (metadata only) as **[JSON](https://www.json.org/)**

Media types are also used with the [`Content-Type` header](../rest_responses/index.md#content-type-header) to characterize a [request body](#request-body) or a [response body](../rest_responses/index.md#response-body). See [Creating content with binary attachments](#creating-content-with-binary-attachments) below. Also see [Creating session](../../rest_api_authentication/index.md#creating-session) examples.

If the resource only returns one media type, it's also possible to skip it and to specify the format with `application/xml` or `application/json`.

A response indicates `href`s to related resources and their media types.

### Destination

The `Destination` request header is the request counterpart of the `Location` response header. It's used for a `COPY`, `MOVE` or `SWAP` operation to indicate where the resource should be moved, copied to or swapped with by using the ID of the parent or target location.

Examples of such requests are:

- [copying a Content](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-copy-content)
- [moving a Location and its subtree](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-move-subtree)
- [swapping a Location with another](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-swap-location)

### Expected user

The `X-Expected-User` header specifies the user needed for the request execution. With this header, if the current username on server side isn't equal to `X-Expected-User` value, a `401 Unauthorized` error is returned. Without this header, the request is executed with the current user who might be unexpected (like the Anonymous user if a previous authentication has expired) and an ambiguous response might be returned as a success not informing about a wrong user.

For example, it prevents a Content request to be executed with Anonymous user in the case of an expired authentication, and the response being a `200 OK` but missing content items due to access rights difference with the expected user.

## Request body

You can pass some short scalar parameters in the URIs or as GET parameters, but other resources need heavier structured payloads passed in the request body, in particular the ones to create (`POST`) or update (`PATCH`) items. In the [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html), request payload examples are given when needed.

One example is the [creation of an authentication session](../../rest_api_authentication/index.md#establishing-session).

When creating a content item, a special payload is needed if the content type has some [Image](../../../../content_management/field_types/field_type_reference/imagefield/index.md) or [BinaryFile](../../../../content_management/field_types/field_type_reference/binaryfilefield/index.md) fields as files need to be attached. See the example of a [script uploading images](#creating-content-with-binary-attachments) below.

When searching for content items (or locations), the query grammar is also particular. See the [Search section](#search-views) below.

### Creating content with binary attachments

The example below is a command-line script to upload images. It's based on the [Symfony HttpClient](https://symfony.com/doc/7.4/http_client.html).

This script:

- receives an image path and optionally a name as command-line arguments,
- uses the [HTTP basic authentication](../../rest_api_authentication/index.md#http-basic-authentication), if it's enabled,
- creates a draft in the /Media/Images folder by posting (`POST`) data to [`/content/objects`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Objects/operation/api_contentobjects_post),
- and, publishes (`PUBLISH`) the draft through [`/content/objects/{contentId}/versions/{versionNo}`](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-publish-a-content-version).

**XML**

```php
<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception as HttpException;

if ($argc < 2) {
    // Print script usage
    echo "Usage: php {$argv[0]} <FILE_PATH> [<IMAGE_NAME>]\n";
    exit(1);
}

if (!is_file($argv[1])) {
    echo "{$argv[1]} doesn't exist or is not a file.\n";
    exit(2);
}

// URL to Ibexa DXP installation and its REST API
$host = 'api.example.com';
$scheme = 'https';
$api = '/api/ibexa/v2';
$baseUrl = "{$scheme}://{$host}{$api}";

// User credentials
$username = 'admin';
$password = 'publish';

// Targets
$contentTypeId = 5; // "Image"
$parentLocationPath = '1/43/51'; // "Media > Images"
$sectionId = 3; // "Media"

$fileName = basename($argv[1]);
$fileSize = filesize($argv[1]);
$fileContent = base64_encode(file_get_contents($argv[1]));
$name = $argv[2] ?? $fileName;

// Request payload
$data = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<ContentCreate>
  <ContentType href="$api/content/types/$contentTypeId" />
  <mainLanguageCode>eng-GB</mainLanguageCode>
  <LocationCreate>
    <ParentLocation href="$api/content/locations/$parentLocationPath" />
    <sortField>PATH</sortField>
    <sortOrder>ASC</sortOrder>
  </LocationCreate>
  <Section href="$api/content/sections/$sectionId" />
  <fields>
    <field>
      <fieldDefinitionIdentifier>name</fieldDefinitionIdentifier>
      <fieldValue>$name</fieldValue>
    </field>
    <field>
      <fieldDefinitionIdentifier>caption</fieldDefinitionIdentifier>
      <fieldValue>
        <value key="xml"><![CDATA[<section xmlns="http://ibexa.co/namespaces/ezpublish5/xhtml5/edit"><h1>$name</h1></section>]]></value>
      </fieldValue>
    </field>
    <field>
      <fieldDefinitionIdentifier>image</fieldDefinitionIdentifier>
      <fieldValue>
        <value key="fileName">$fileName</value>
        <value key="fileSize">$fileSize</value>
        <value key="data"><![CDATA[$fileContent]]></value>
      </fieldValue>
    </field>
  </fields>
</ContentCreate>
XML;

$client = HttpClient::createForBaseUri($baseUrl, [
    'auth_basic' => [$username, $password],
]);
$doc = new DOMDocument();

try {
    $response = $client->request('POST', "$baseUrl/content/objects", [
        'headers' => [
            'Content-Type: application/vnd.ibexa.api.ContentCreate+xml',
            'Accept: application/vnd.ibexa.api.ContentInfo+xml',
        ],
        'body' => $data,
    ]);
} catch (HttpException\TransportExceptionInterface $exception) {
    echo "Client error: {$exception->getMessage()}\n";
    exit(3);
}

if (201 !== $responseCode = $response->getStatusCode()) {
    if (!empty($response->getContent(false)) && $doc->loadXML($response->getContent(false)) && 'ErrorMessage' === $doc->firstChild->nodeName) {
        echo "Server error: {$doc->getElementsByTagName('errorCode')->item(0)->nodeValue} {$doc->getElementsByTagName('errorMessage')->item(0)->nodeValue}\n";
        echo "\t{$doc->getElementsByTagName('errorDescription')->item(0)->nodeValue}\n";
        exit(4);
    }
    $responseHeaders = $response->getInfo('response_headers');
    $error = $responseHeaders[0] ?? $responseCode;
    echo "Server error: $error\n";
    exit(5);
}

$doc->loadXML($response->getContent());

if ('Content' !== $doc->firstChild->nodeName || !$doc->firstChild->hasAttribute('id')) {
    echo "Response error: Unexpected response structure\n";
    exit(6);
}

$contentId = $doc->firstChild->getAttribute('id');

try {
    $response = $client->request('PUBLISH', "$baseUrl/content/objects/$contentId/versions/1", [
        'headers' => [
            'Accept: application/xml',
        ],
    ]);
} catch (HttpException\TransportExceptionInterface $exception) {
    echo "Client error: {$exception->getMessage()}\n";
    exit(7);
}

if (204 !== $responseCode = $response->getStatusCode()) {
    if (!empty($response->getContent(false)) && $doc->loadXML($response->getContent(false)) && 'ErrorMessage' === $doc->firstChild->nodeName) {
        echo "Server error: {$doc->getElementsByTagName('errorCode')->item(0)->nodeValue} {{$doc->getElementsByTagName('errorMessage')->item(0)->nodeValue}\n";
        echo "\t{$doc->getElementsByTagName('errorDescription')->item(0)->nodeValue}\n";
        exit(8);
    }
    $responseHeaders = $response->getInfo('response_headers');
    $error = $responseHeaders[0] ?? $responseCode;
    echo "Server error: $error\n";
    exit(9);
}

echo "Success: Image content item created with ID $contentId and published.\n";

exit(0);
```

**JSON**

```php
<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception as HttpException;

if ($argc < 2) {
    // Print script usage
    echo "Usage: php {$argv[0]} <FILE_PATH> [<IMAGE_NAME>]\n";
    exit(1);
}

if (!is_file($argv[1])) {
    echo "{$argv[1]} doesn't exist or is not a file.\n";
    exit(2);
}

// URL to Ibexa DXP installation and its REST API
$host = 'api.example.com';
$scheme = 'https';
$api = '/api/ibexa/v2';
$baseUrl = "{$scheme}://{$host}{$api}";

// User credentials
$username = 'admin';
$password = 'publish';

// Targets
$contentTypeId = 5; // "Image"
$parentLocationPath = '1/43/51'; // "Media > Images"
$sectionId = 3; // "Media"

// Request payload
$data = [
    'ContentCreate' => [
        'ContentType' => [
            '_href' => "$api/content/types/$contentTypeId",
        ],
        'mainLanguageCode' => 'eng-GB',
        'LocationCreate' => [
            'ParentLocation' => [
                '_href' => "$api/content/locations/$parentLocationPath",
            ],
            'sortField' => 'PATH',
            'sortOrder' => 'ASC',
        ],
        'Section' => [
            '_href' => "$api/content/sections/$sectionId",
        ],
        'fields' => [
            'field' => [
                [
                    'fieldDefinitionIdentifier' => 'name',
                    'fieldValue' => $argv[2] ?? basename($argv[1]),
                ],
                [
                    'fieldDefinitionIdentifier' => 'image',
                    'fieldValue' => [
                        // Original file name
                        'fileName' => basename($argv[1]),
                        // File size in bytes
                        'fileSize' => filesize($argv[1]),
                        // File content must be encoded as Base64
                        'data' => base64_encode(file_get_contents($argv[1])),
                    ],
                ],
            ],
        ],
    ],
];

$client = HttpClient::createForBaseUri($baseUrl, [
    'auth_basic' => [$username, $password],
]);

try {
    $response = $client->request('POST', "$baseUrl/content/objects", [
        'headers' => [
            'Content-Type: application/vnd.ibexa.api.ContentCreate+json',
            'Accept: application/vnd.ibexa.api.ContentInfo+json',
        ],
        'json' => $data,
    ]);
} catch (HttpException\TransportExceptionInterface $exception) {
    echo "Client error: {$exception->getMessage()}\n";
    exit(3);
}

if (201 !== $responseCode = $response->getStatusCode()) {
    try {
        $responseArray = $response->toArray(false);
        if (array_key_exists('ErrorMessage', $responseArray)) {
            echo "Server error: {$responseArray['ErrorMessage']['errorCode']} {$responseArray['ErrorMessage']['errorMessage']}\n";
            echo "\t{$responseArray['ErrorMessage']['errorDescription']}\n";
            exit(4);
        }
    } catch (HttpException\DecodingExceptionInterface) {
    }
    $responseHeaders = $response->getInfo('response_headers');
    $error = $responseHeaders[0] ?? $responseCode;
    echo "Server error: $error\n";
    exit(5);
}

$response = $response->toArray();

if (!(array_key_exists('Content', $response) && array_key_exists('_id', $response['Content']))) {
    echo "Response error: Unexpected response structure\n";
    exit(6);
}

$contentId = $response['Content']['_id'];

try {
    $response = $client->request('PUBLISH', "$baseUrl/content/objects/$contentId/versions/1", [
        'headers' => [
            'Accept: application/json',
        ],
    ]);
} catch (HttpException\TransportExceptionInterface $exception) {
    echo "Client error: {$exception->getMessage()}\n";
    exit(7);
}

if (204 !== $responseCode = $response->getStatusCode()) {
    try {
        $responseArray = $response->toArray(false);
        if (array_key_exists('ErrorMessage', $responseArray)) {
            echo "Server error: {$responseArray['ErrorMessage']['errorCode']} {$responseArray['ErrorMessage']['errorMessage']}\n";
            echo "\t{$responseArray['ErrorMessage']['errorDescription']}\n";
            exit(8);
        }
    } catch (HttpException\DecodingExceptionInterface) {
    }
    $responseHeaders = $response->getInfo('response_headers');
    $error = $responseHeaders[0] ?? $responseCode;
    echo "Server error: $error\n";
    exit(9);
}

echo "Success: Image content item created with ID $contentId and published.\n";

exit(0);
```

### Search (`/views`)

The `/views` route allows you to [search in the repository](../../../../search/search/index.md). It works similarly to its [PHP API counterpart](../../../../search/search_api/index.md).

The model allows combining criteria using the logical operators `AND`, `OR` and `NOT`.

Most [Search Criteria](../../../../search/criteria_reference/search_criteria_reference/index.md#search-criteria) are available in REST API. The suffix `Criterion` is added when used with REST API.

Most [Sort Clauses](../../../../search/sort_clause_reference/sort_clause_reference/index.md#sort-clauses) are available too. They require no additional prefix or suffix.

The search request has a `Content-Type: application/vnd.ibexa.api.ViewInput+xml` or `+json` header to specify the format of its body's payload. The root node is `<ViewInput>` and it has two mandatory children: `<identifier>` and `<Query>`.

You can add `version=1.1` to the `Content-Type` header to support the distinction between `ContentQuery` and `LocationQuery` instead of `Query` which implicitly looks only for content items.

The following examples search for `article` and `news` typed content items everywhere or for content items of all types directly under location `123`. All those content items must be in the `standard` section.

**XML**

```http
POST /views HTTP/1.1
Content-Type: application/vnd.ibexa.api.ViewInput+xml
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<ViewInput>
  <identifier>test</identifier>
  <Query>
    <Filter>
        <AND>
            <OR>
                <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
                <ContentTypeIdentifierCriterion>news</ContentTypeIdentifierCriterion>
                <ParentLocationIdCriterion>123</ParentLocationIdCriterion>
            </OR>
            <SectionIdentifierCriterion>standard</SectionIdentifierCriterion>
        </AND>
    </Filter>
    <limit>10</limit>
    <offset>0</offset>
    <SortClauses>
      <ContentName>ascending</ContentName>
    </SortClauses>
  </ContentQuery>
</ViewInput>
```

**XML; 1.1**

```http
POST /views HTTP/1.1
Content-Type: application/vnd.ibexa.api.ViewInput+xml; version=1.1
```

```xml
<?xml version="1.0" encoding="UTF-8"?>
<ViewInput>
  <identifier>test</identifier>
  <ContentQuery>
    <Filter>
        <AND>
            <OR>
                <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
                <ContentTypeIdentifierCriterion>news</ContentTypeIdentifierCriterion>
                <ParentLocationIdCriterion>123</ParentLocationIdCriterion>
            </OR>
            <SectionIdentifierCriterion>standard</SectionIdentifierCriterion>
        </AND>
    </Filter>
    <limit>10</limit>
    <offset>0</offset>
    <SortClauses>
      <ContentName>ascending</ContentName>
    </SortClauses>
  </ContentQuery>
</ViewInput>
```

**JSON**

```http
POST /views HTTP/1.1
Content-Type: application/vnd.ibexa.api.ViewInput+json
```

```json
{
  "ViewInput": {
    "identifier": "test",
    "Query": {
      "Filter": {
        "AND": {
          "OR": {
            "ContentTypeIdentifierCriterion": [
              "article",
              "news"
            ],
            "ParentLocationIdCriterion": 123
          },
          "SectionIdentifierCriterion": "standard"
        }
      },
      "limit": "10",
      "offset": "0",
      "SortClauses": { "ContentName": "ascending" }
    }
  }
}
```

**JSON; 1.1**

```http
POST /views HTTP/1.1
Content-Type: application/vnd.ibexa.api.ViewInput+json; version=1.1
```

```json
{
  "ViewInput": {
    "identifier": "test",
    "ContentQuery": {
      "Filter": {
        "AND": {
          "OR": {
            "ContentTypeIdentifierCriterion": [
              "article",
              "news"
            ],
            "ParentLocationIdCriterion": 123
          },
          "SectionIdentifierCriterion": "standard"
        }
      },
      "limit": "10",
      "offset": "0",
      "SortClauses": { "ContentName": "ascending" }
    }
  }
}
```

> **Note: Note**
>
> In JSON, the structure for `ContentTypeIdentifierCriterion` with multiple values has a slightly different format as keys must be unique. In JSON, if there is only one item in `SortClauses`, it can be passed directly without an array to wrap it.

You can omit logical operators. If Criteria are of mixed types, they're wrapped in an implicit `AND`. If they're of the same type, they're wrapped in an implicit `OR`.

For example, the `AND` operator from previous example's `Filter` could be removed.

**XML ExplicitAND**

```xml
<Filter>
    <AND>
        <OR>
            <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
            <ContentTypeIdentifierCriterion>news</ContentTypeIdentifierCriterion>
            <ParentLocationIdCriterion>123</ParentLocationIdCriterion>
        </OR>
        <SectionIdentifierCriterion>standard</SectionIdentifierCriterion>
    </AND>
</Filter>
```

**XML ImplicitAND**

```xml
<Filter>
    <OR>
        <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
        <ContentTypeIdentifierCriterion>news</ContentTypeIdentifierCriterion>
        <ParentLocationIdCriterion>123</ParentLocationIdCriterion>
    </OR>
    <SectionIdentifierCriterion>standard</SectionIdentifierCriterion>
</Filter>
```

**JSON ExplicitAND**

```json
"Filter": {
  "AND": {
    "OR": {
       "ContentTypeIdentifierCriterion": [
        "article",
        "news"
      ],
      "ParentLocationIdCriterion": 123
    },
    "SectionIdentifierCriterion": "standard"
  }
},
```

**JSON ImplicitAND**

```json
"Filter": {
  "OR": {
     "ContentTypeIdentifierCriterion": [
      "article",
      "news"
    ],
    "ParentLocationIdCriterion": 123
  },
  "SectionIdentifierCriterion": "standard"
},
```
