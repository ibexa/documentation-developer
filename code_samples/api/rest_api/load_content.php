<?php declare(strict_types=1);

// cURL

$resource = 'https://api.example.com/api/ibexa/v2/content/objects/52';
$curl = curl_init($resource);
curl_setopt_array($curl, [
    CURLOPT_HTTPHEADER => ['Accept: application/vnd.ibexa.api.ContentInfo+json'],
    CURLOPT_HEADERFUNCTION => static function ($curl, $header) {
        if (!empty($cleanedHeader = trim($header))) {
            var_dump($cleanedHeader);
        }

        return strlen($header);
    },
    CURLOPT_RETURNTRANSFER => true,
]);
var_dump(json_decode(curl_exec($curl), true));

// Symfony HttpClient

$resource = 'https://api.example.com/api/ibexa/v2/content/objects/52';
require 'vendor/autoload.php';
$client = Symfony\Component\HttpClient\HttpClient::create();
$response = $client->request('GET', $resource, [
    'headers' => ['Accept: application/vnd.ibexa.api.ContentInfo+json'],
]);
var_dump($response->getStatusCode(), $response->getInfo('response_headers')[0], $response->getHeaders(false), $response->toArray(false));
