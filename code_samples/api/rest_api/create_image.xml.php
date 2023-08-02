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
    if (!empty($response->getContent(false)) && @$doc->loadXML($response->getContent(false)) && 'ErrorMessage' === $doc->firstChild->nodeName) {
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
    if (!empty($response->getContent(false)) && @$doc->loadXML($response->getContent(false)) && 'ErrorMessage' === $doc->firstChild->nodeName) {
        echo "Server error: {$doc->getElementsByTagName('errorCode')->item(0)->nodeValue} {{$doc->getElementsByTagName('errorMessage')->item(0)->nodeValue}\n";
        echo "\t{$doc->getElementsByTagName('errorDescription')->item(0)->nodeValue}\n";
        exit(8);
    }
    $responseHeaders = $response->getInfo('response_headers');
    $error = $responseHeaders[0] ?? $responseCode;
    echo "Server error: $error\n";
    exit(9);
}

echo "Success: Image Content item created with ID $contentId and published.\n";

exit(0);
