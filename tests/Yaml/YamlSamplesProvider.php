<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Documentation\Yaml;

use Ibexa\Tests\Documentation\InlineSamples\MarkdownExtractor;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Iterates over all YAML content in a documentation repository:
 *   - standalone .yaml files under code_samples/
 *   - fenced YAML blocks extracted from .md files under docs/
 *
 * Each item is an associative array with keys:
 *   - path (string)  — absolute filesystem path to the source file
 *   - line (int)     — starting line of the block (0 for standalone YAML files)
 *   - body (string)  — raw YAML text
 */
final class YamlSamplesProvider
{
    private const string CODE_SAMPLES_DIR = __DIR__ . '/../../code_samples';
    private const string DOCS_DIR = __DIR__ . '/../../docs';

    /**
     * @return iterable<CodeSample>
     */
    public function getCodeSampleYaml(): iterable
    {
        yield from $this->iterateCodeSampleYaml();
        yield from $this->iterateMarkdownYamlBlocks();
    }

    /**
     * Yields every .yaml file found recursively under code_samples/.
     *
     * @return iterable<CodeSample>
     */
    private function iterateCodeSampleYaml(): iterable
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(self::CODE_SAMPLES_DIR, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        /** @var \SplFileInfo $file */
        foreach ($iterator as $file) {
            if (!$file->isFile() || $file->getExtension() !== 'yaml') {
                continue;
            }

            $body = file_get_contents($file->getRealPath());

            if ($body === false) {
                continue;
            }

            yield new CodeSample($file->getRealPath(), 0, $body);
        }
    }

    /**
     * Yields every fenced YAML block found in .md files under docs/.
     *
     * @return iterable<CodeSample>
     */
    private function iterateMarkdownYamlBlocks(): iterable
    {
        $extractor = new MarkdownExtractor('yaml');
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(self::DOCS_DIR, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        /** @var \SplFileInfo $file */
        foreach ($iterator as $file) {
            if (!$file->isFile() || $file->getExtension() !== 'md') {
                continue;
            }

            $path = $file->getRealPath();
            $content = file_get_contents($path);

            if ($content === false) {
                continue;
            }

            foreach ($extractor->extract($content) as $block) {
                yield new CodeSample($path, $block['line'], $block['body']);
            }
        }
    }
}
