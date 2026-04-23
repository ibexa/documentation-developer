<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Documentation\Markdown;

/**
 * Extracts raw YAML blocks from Markdown content.
 *
 * Handles all fence variants used in the documentation:
 * - ```yaml
 * - ``` yaml
 * - ``` yaml hl_lines="..."
 * - Blocks indented inside admonitions (4-space prefix)
 *
 * Blocks containing [[= include_file(...) =]] or --8<-- are skipped because
 * they reference code_samples/ files that are validated separately.
 */
final class MarkdownYamlExtractor
{
    /**
     * Pattern components:
     * - ^( *) captures optional leading indentation (admonitions indent by 4 spaces)
     * - ```\s*yaml matches the opening fence with optional space before language tag
     * - [^\n]* allows trailing annotations like hl_lines="1 2"
     * - (.*?) captures the block body (non-greedy)
     * - \n\1``` requires the closing fence to match the same indentation
     */
    private const string FENCE_PATTERN = '/^(?P<indent> *)```\s*yaml[^\n]*\n(?P<body>.*?)\n(?P=indent)```/ms';

    private const string SKIP_PATTERN = '/include_file\s*\(|--8<--/';

    /**
     * @return iterable<array{body: string, line: int}>
     */
    public function extract(string $content): iterable
    {
        if (!preg_match_all(self::FENCE_PATTERN, $content, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
            return;
        }

        foreach ($matches as $match) {
            $body = $match['body'][0];
            $offset = $match['body'][1];

            if (preg_match(self::SKIP_PATTERN, $body)) {
                continue;
            }

            $indent = $match['indent'][0];
            if ($indent !== '') {
                $body = $this->stripIndentation($body, strlen($indent));
            }

            $line = substr_count(substr($content, 0, $offset), "\n") + 1;

            yield ['body' => $body, 'line' => $line];
        }
    }

    private function stripIndentation(string $body, int $spaces): string
    {
        $prefix = str_repeat(' ', $spaces);
        $lines = explode("\n", $body);
        $stripped = array_map(
            static fn (string $line): string => str_starts_with($line, $prefix)
                ? substr($line, $spaces)
                : $line,
            $lines
        );

        return implode("\n", $stripped);
    }
}
