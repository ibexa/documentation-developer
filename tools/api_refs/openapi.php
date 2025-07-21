<?php

$openApi = yaml_parse_file('openapi.yaml');

foreach ($openApi['paths'] as $path => &$pathMethods) {
    foreach ($pathMethods as $method => &$methodDefinition) {
        if (array_key_exists('requestBody', $methodDefinition) && array_key_exists('content', $methodDefinition['requestBody'])) {
            //foreach ($methodDefinition['requestBody']['content'] as $contentType => &$contentDefinition) {}
            ksort($methodDefinition['requestBody']['content']);
        }/* */elseif (array_key_exists('requestBody', $methodDefinition)) {
                echo "$method $path\n";
            }/**/
        foreach ($methodDefinition['responses'] as $responseCode => &$responseDefinition) {
            if (array_key_exists('content', $responseDefinition)) {
                //foreach ($responseDefinition['content'] as $contentType => &$contentDefinition) {}
                ksort($responseDefinition['content']);
            }/* * /else {
                echo "$method $path: $responseCode\n";
            }/**/
        }
    }
}

yaml_emit_file('openapi.yaml', $openApi);
