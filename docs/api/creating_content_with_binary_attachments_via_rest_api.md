# Creating content with binary attachments via REST API

This page shows how to create content via the REST API on the example of uploading an image file.

## Creating a draft

A draft is created with a POST request to `/api/ezp/v2/content/objects`.
Its body should contain all of the required data in the structured format (see [Creating content: data property](field_type_reference.md#creating-content-data-property)).
As for the response, it's possible to use either JSON or XML in input.
The following examples use JSON (and assume [HTTP Basic Auth](general_rest_usage.md#http-basic-authentication) is enabled).

``` php
// URL to [[= product_name =]] installation
$base_url = "http://127.0.0.1";
// User credentials
$username = "admin";
$password = "publish";

if ($argc < 2) {
    // Print script usage
    echo "Usage: php $argv[0] <FILE_PATH>\n";
    exit(1);
}

// Request payload
$data = [
    'ContentCreate' => [
        'ContentType' => [
            // "Image" content type
            '_href' => "/api/ezp/v2/content/types/5",
        ],
        'mainLanguageCode' => 'eng-GB',
        'LocationCreate' => [
            'ParentLocation' => [
                // Destination location ("Media" root location in this case)
                '_href' => "/api/ezp/v2/content/locations/1/43",
            ],
            'sortField' => 'PATH',
            'sortOrder' => 'ASC',
        ],
        'Section' => [
            // "Media" section
            '_href' => "/api/ezp/v2/content/sections/3",
        ],
        'fields' => [
            'field' => [
                [
                    'fieldDefinitionIdentifier' => 'name',
                    'fieldValue' => 'File uploaded via REST API',
                ],
                [
                    'fieldDefinitionIdentifier' => 'image',
                    'fieldValue' => [
                        // Original file name
                        'fileName' => pathinfo($argv[1], PATHINFO_BASENAME),
                        // File size in bytes
                        'fileSize' => filesize($argv[1]),
                        // File content must be encoded as BASE64
                        'data' => base64_encode(file_get_contents($argv[1])),
                    ],
                ],
            ],
        ],
    ],
];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "$base_url/api/ezp/v2/content/objects",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_USERPWD => "$username:$password",
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "cache-control: no-cache",
        "content-type: application/vnd.ez.api.ContentCreate+json",
    ],
]);

$response = curl_exec($curl);

if (($err = curl_error($curl))) {
    echo "cURL Error #:" . $err;
} else {
    echo $response;
}

curl_close($curl);
```

## Publishing the image

To publish the image use the following code:

``` php
// URL to [[= product_name =]] installation
$base_url = "http://127.0.0.1";
// User credentials
$username = "admin";
$password = "publish";

if ($argc < 2) {
   // Print script usage
   echo "Usage: php $argv[0] <ID>\n";
   exit(1);
}

$id = $argv[1];

// Publish the draft
$curl = curl_init();

curl_setopt_array($curl, [
   CURLOPT_URL => "$base_url/api/ezp/v2/content/objects/$id/versions/1",
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => "",
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 30,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => "POST",
   CURLOPT_USERPWD => "$username:$password",
   CURLOPT_HTTPHEADER => []
       "accept: application/json",
       "cache-control: no-cache",
       "x-http-method-override: PUBLISH"
   ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
   echo "cURL Error #:" . $err;
} else {
   echo $response;
}
```
