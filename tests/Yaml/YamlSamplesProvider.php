<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Documentation\Yaml;

use Ibexa\Tests\Documentation\Markdown\MarkdownYamlExtractor;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Iterates over all YAML content in a documentation repository:
 *   - fenced YAML blocks extracted from .md files under docs/
 *
 * Each item is an associative array with keys:
 *   - path (string)  — absolute filesystem path to the source file
 *   - line (int)     — starting line of the block
 *   - body (string)  — raw YAML text
 */
final class YamlSamplesProvider
{
    private const string DOCS_DIR = __DIR__ . '/../../docs';

    /**
     * @return iterable<CodeSample>
     */
    public function getCodeSampleYaml(): iterable
    {
        yield from $this->iterateMarkdownYamlBlocks();
    }

    /**
     * Yields every fenced YAML block found in .md files under docs/.
     *
     * @return iterable<CodeSample>
     */
    private function iterateMarkdownYamlBlocks(): iterable
    {
        $extractor = new MarkdownYamlExtractor();
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
