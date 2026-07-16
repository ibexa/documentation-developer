<?php

/**
 * Dump a map of PHP API classes referenced by the generated Markdown docs to
 * their vendor-relative source paths.
 *
 * Usage: php tools/llm_package/dump_class_paths.php [<site_dir>...] [<output_json>]
 *
 * Scans the MkDocs build output(s) for `php_api_reference/classes/<Slug>.html`
 * links, converts each slug to a FQCN (dashes become namespace separators;
 * PHP class names cannot contain dashes, so this is unambiguous) and resolves
 * it through this repository's Composer autoloader. The resulting JSON maps
 * FQCNs to paths relative to vendor/, e.g.
 * "Ibexa\\Contracts\\AdminUi\\Tab\\AbstractTab": "ibexa/admin-ui/src/contracts/Tab/AbstractTab.php".
 *
 * Classes that don't resolve (their package is missing from composer.json)
 * are listed on stderr and omitted from the map; build_package_docs.py keeps
 * the absolute URL for them.
 */

declare(strict_types=1);

$args = array_slice($argv, 1);
$outputPath = count($args) >= 2 ? array_pop($args) : 'class_paths.json';
$siteDirs = $args !== [] ? $args : ['site'];

$root = dirname(__DIR__, 2);
$loader = require $root . '/vendor/autoload.php';
$vendorDir = realpath($root . '/vendor');

$slugs = [];
foreach ($siteDirs as $siteDir) {
    if (!is_dir($siteDir)) {
        fwrite(STDERR, "Site directory not found: $siteDir (run mkdocs build first)\n");
        exit(1);
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($siteDir, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($iterator as $file) {
        if ($file->getExtension() !== 'md') {
            continue;
        }
        $content = file_get_contents($file->getPathname());
        if (preg_match_all('~php_api_reference/classes/([A-Za-z0-9-]+)\.html~', $content, $matches)) {
            foreach ($matches[1] as $slug) {
                $slugs[$slug] = true;
            }
        }
    }
}
ksort($slugs);

$map = [];
$unresolved = [];
foreach (array_keys($slugs) as $slug) {
    $fqcn = str_replace('-', '\\', $slug);
    $path = $loader->findFile($fqcn);
    $realPath = $path ? realpath($path) : false;
    if ($realPath === false || !str_starts_with($realPath, $vendorDir . DIRECTORY_SEPARATOR)) {
        $unresolved[] = $fqcn;
        continue;
    }
    $map[$fqcn] = str_replace(DIRECTORY_SEPARATOR, '/', substr($realPath, strlen($vendorDir) + 1));
}

file_put_contents(
    $outputPath,
    json_encode($map, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n"
);

printf("Resolved %d/%d API-referenced classes into %s\n", count($map), count($slugs), $outputPath);
if ($unresolved !== []) {
    fwrite(STDERR, "Unresolved classes (their links keep absolute URLs):\n");
    foreach ($unresolved as $fqcn) {
        fwrite(STDERR, "  $fqcn\n");
    }
}
