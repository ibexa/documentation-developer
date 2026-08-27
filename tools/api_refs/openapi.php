<?php

function sortOpenApiContent(array &$openApi): void
{
    foreach ($openApi['paths'] as $path => &$pathMethods) {
        foreach ($pathMethods as $method => &$methodDefinition) {
            if (array_key_exists('requestBody', $methodDefinition) && array_key_exists('content', $methodDefinition['requestBody'])) {
                ksort($methodDefinition['requestBody']['content']);
            }
            foreach ($methodDefinition['responses'] as $responseCode => &$responseDefinition) {
                if (array_key_exists('content', $responseDefinition)) {
                    ksort($responseDefinition['content']);
                }
            }
        }
    }
}

$openApi = yaml_parse_file('openapi.yaml');
sortOpenApiContent($openApi);
yaml_emit_file('openapi.yaml', $openApi);

$openApiJson = json_decode(file_get_contents('openapi.json'), true);
sortOpenApiContent($openApiJson);
file_put_contents('openapi.json', json_encode($openApiJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
