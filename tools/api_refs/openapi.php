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

function removeBadges(array &$openApi): void
{
    foreach ($openApi['paths'] as $path => &$pathMethods) {
        foreach ($pathMethods as $method => &$methodDefinition) {
            unset($methodDefinition['x-badges']);
        }
    }
}

/** Removes the paths not available on SaaS, their tags, and the schemas only they were using. */
function removeUnavailablePaths(array &$openApi, array $pathPrefixes, array $tags): void
{
    $referencedSchemasBefore = collectSchemaReferences($openApi);
    foreach (array_keys($openApi['paths']) as $path) {
        foreach ($pathPrefixes as $pathPrefix) {
            if ($path === $pathPrefix || str_starts_with($path, "$pathPrefix/")) {
                unset($openApi['paths'][$path]);
            }
        }
    }
    if (array_key_exists('tags', $openApi)) {
        $openApi['tags'] = array_values(array_filter($openApi['tags'], static fn (array $tag): bool => !in_array($tag['name'], $tags, true)));
    }
    // Removing a schema can orphan the schemas it references, so repeat until nothing changes.
    do {
        $orphanedSchemas = array_diff($referencedSchemasBefore, collectSchemaReferences($openApi));
        $orphanedSchemas = array_intersect($orphanedSchemas, array_keys($openApi['components']['schemas']));
        foreach ($orphanedSchemas as $schema) {
            unset($openApi['components']['schemas'][$schema]);
        }
    } while (!empty($orphanedSchemas));
}

/** @return string[] Names of the schemas referenced from the paths and from the schemas themselves */
function collectSchemaReferences(array $node): array
{
    $references = [];
    array_walk_recursive($node, static function ($value, $key) use (&$references): void {
        if ('$ref' === $key && str_starts_with($value, '#/components/schemas/')) {
            $references[substr($value, strlen('#/components/schemas/'))] = true;
        }
    });

    return array_keys($references);
}

/** Sets the SaaS title, and empties the version (a required field) so that Redocly doesn't display it next to the title. */
function setSaasInfo(array &$openApi): void
{
    $openApi['info']['title'] = 'Cohesivo SaaS REST API';
    $openApi['info']['version'] = '';
}

function fixOpenApi(array &$openApi): void
{
    setSaasInfo($openApi);
    sortOpenApiContent($openApi);
    removeBadges($openApi);
    removeUnavailablePaths($openApi, ['/corporate'], ['Corporate Account']);
}

$openApi = yaml_parse_file('openapi.yaml');
fixOpenApi($openApi);
yaml_emit_file('openapi.yaml', $openApi);

$openApiJson = json_decode(file_get_contents('openapi.json'), true);
fixOpenApi($openApiJson);
file_put_contents('openapi.json', json_encode($openApiJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
