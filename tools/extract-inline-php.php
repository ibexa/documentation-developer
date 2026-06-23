#!/usr/bin/env php
<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

/**
 * Extracts inline PHP code blocks from docs/ Markdown files and writes them
 * as standalone .php files under code_samples/_inline_php/.
 *
 * Run automatically before PHPStan via `composer phpstan`.
 * The output directory is gitignored — it is regenerated on every run.
 *
 * Path mapping:
 *   docs/{sub/path/to/file.md} block with body content C
 *   → code_samples/_inline_php/{sub/path/to/file}/{sha256(C)}.php
 *
 * The filename is derived from the SHA-256 hash of the raw snippet body so that
 * it remains stable when surrounding Markdown changes shift the block's line number.
 * The // Source: comment inside each file still records the exact line for sync-back.
 *
 * Each generated file receives:
 *   - A <?php opening tag (if the original snippet lacks one)
 *   - A source-location comment for traceability in PHPStan output
 */

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Ibexa\Tests\Documentation\InlineSamples\InlinePhpWriter;
use Ibexa\Tests\Documentation\InlineSamples\MarkdownExtractor;

const REPO_ROOT = __DIR__ . '/..';
const DOCS_DIR = REPO_ROOT . '/docs';
const OUTPUT_DIR = REPO_ROOT . '/code_samples/_inline_php';

/**
 * Recursively removes all files and directories under $dir, then removes $dir itself.
 */
function removeDirectory(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST,
    );

    foreach ($iterator as $item) {
        if ($item->isDir()) {
            rmdir($item->getRealPath());
        } else {
            unlink($item->getRealPath());
        }
    }

    rmdir($dir);
}

// Clean up the output directory from the previous run to avoid stale files
// (e.g. from docs that were renamed, moved, or had snippets removed).
removeDirectory(OUTPUT_DIR);

// Always recreate the root output directory so downstream tools (Rector,
// PHP-CS-Fixer) that receive it as a path argument don't fail when there
// happen to be zero snippets to extract.
if (!mkdir(OUTPUT_DIR, 0755, true) && !is_dir(OUTPUT_DIR)) {
    fwrite(STDERR, 'ERROR: Could not create directory: ' . OUTPUT_DIR . "\n");
    exit(1);
}

$extractor = new MarkdownExtractor('php');
$writer = new InlinePhpWriter();

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(DOCS_DIR, RecursiveDirectoryIterator::SKIP_DOTS),
);

$fileCount = 0;
$snippetCount = 0;

/** @var SplFileInfo $file */
foreach ($iterator as $file) {
    if (!$file->isFile() || $file->getExtension() !== 'md') {
        continue;
    }

    $mdPath = $file->getRealPath();
    $content = file_get_contents($mdPath);

    if ($content === false) {
        continue;
    }

    $blocks = iterator_to_array($extractor->extract($content));

    if (empty($blocks)) {
        continue;
    }

    // Relative path from docs/ root, e.g. "commerce/cart/cart_api.md"
    $relativeFromDocs = ltrim(substr($mdPath, strlen(realpath(DOCS_DIR))), DIRECTORY_SEPARATOR);

    // Strip .md extension and use as subdirectory name
    $subDir = OUTPUT_DIR . DIRECTORY_SEPARATOR . substr($relativeFromDocs, 0, -3);

    if (!is_dir($subDir) && !mkdir($subDir, 0755, true) && !is_dir($subDir)) {
        fwrite(STDERR, "ERROR: Could not create directory: $subDir\n");
        exit(1);
    }

    // Relative path used in the source comment, e.g. "docs/commerce/cart/cart_api.md"
    $sourceRelPath = 'docs/' . str_replace(DIRECTORY_SEPARATOR, '/', $relativeFromDocs);

    foreach ($blocks as $block) {
        $line = $block['line'];
        $body = $block['body'];

        $hash = hash('sha256', $body);
        $outputFile = $subDir . DIRECTORY_SEPARATOR . "{$hash}.php";

        file_put_contents($outputFile, $writer->build($sourceRelPath, $line, $body));
        ++$snippetCount;
    }

    ++$fileCount;
}

echo sprintf(
    "Extracted %d PHP snippet%s from %d Markdown file%s → code_samples/_inline_php/\n",
    $snippetCount,
    $snippetCount !== 1 ? 's' : '',
    $fileCount,
    $fileCount !== 1 ? 's' : '',
);
