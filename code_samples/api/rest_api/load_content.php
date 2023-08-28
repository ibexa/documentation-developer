<?php declare(strict_types=1);

$resource = 'https://api.example.com/api/ibexa/v2/content/objects/52';
require 'vendor/autoload.php';
$client = Symfony\Component\HttpClient\HttpClient::create();
$response = $client->request('GET', $resource, [
    'headers' => ['Accept: application/vnd.ibexa.api.ContentInfo+json'],
]);
var_dump($response->getStatusCode(), $response->toArray());
