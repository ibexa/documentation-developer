<?php

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

$curl = curl_init();
$responseHeaders = [];

curl_setopt_array($curl, [
    CURLOPT_USERPWD => "$username:$password",
    CURLOPT_URL => "$baseUrl/content/objects",
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/vnd.ibexa.api.ContentCreate+json',
        'Accept: application/vnd.ibexa.api.ContentInfo+json',
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADERFUNCTION => function ($curl, $header) {
        global $responseHeaders;
        $responseHeaders[] = $header;
        return strlen($header);
    },
]);

$response = curl_exec($curl);

if ($error = curl_error($curl)) {
    echo "cURL error: $error\n";
    curl_close($curl);
    exit(3);
}

if (201 !== $responseCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE)) {
    $response = json_decode($response, true);
    if (is_array($response) && array_key_exists('ErrorMessage', $response)) {
        echo "Server error: {$response['ErrorMessage']['errorCode']} {$response['ErrorMessage']['errorMessage']}\n";
        echo "\t{$response['ErrorMessage']['errorDescription']}\n";
        curl_close($curl);
        exit(4);
    }
    $error = $responseHeaders[0] ?? $responseCode;
    echo "Server error: $error\n";
    curl_close($curl);
    exit(5);
}

$response = json_decode($response, true);

if (!(array_key_exists('Content', $response) && array_key_exists('_id', $response['Content']))) {
    echo "Response error: Unexpected response structure\n";
    curl_close($curl);
    exit(6);
}

$contentId = $response['Content']['_id'];

curl_reset($curl);
$responseHeaders = [];

curl_setopt_array($curl, [
    CURLOPT_USERPWD => "$username:$password",
    CURLOPT_URL => "$baseUrl/content/objects/$contentId/versions/1",
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'X-HTTP-Method-Override: PUBLISH',
        'Accept: application/json',
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HEADERFUNCTION => function ($curl, $header) {
        global $responseHeaders;
        $responseHeaders[] = $header;
        return strlen($header);
    },
]);

$response = curl_exec($curl);

if ($error = curl_error($curl)) {
    echo "cURL error: $error\n";
    curl_close($curl);
    exit(7);
}

if (204 !== $responseCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE)) {
    $response = json_decode($response, true);
    if (is_array($response) && array_key_exists('ErrorMessage', $response)) {
        echo "Server error: {$response['ErrorMessage']['errorCode']} {$response['ErrorMessage']['errorMessage']}\n";
        echo "\t{$response['ErrorMessage']['errorDescription']}\n";
        curl_close($curl);
        exit(8);
    }
    $error = $responseHeaders[0] ?? $responseCode;
    echo "Server error: $error\n";
    exit(9);
}

echo "Success: Image Content item created with ID $contentId and published\n";

curl_close($curl);
exit(0);
