<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Documentation\InlineSamples;

/**
 * Extracts fenced code blocks of a given language from Markdown content.
 *
 * Handles all fence variants used in the documentation:
 * - ```<lang>
 * - ``` <lang>
 * - ``` <lang> hl_lines="..."
 * - Blocks indented inside admonitions (4-space prefix)
 *
 * Blocks containing [[= include_file(...) =]], [[= include_code(...) =]], or --8<-- are skipped
 * because they reference code_samples/ files that are validated separately.
 *
 * Blocks whose opening fence contains the marker "skip-validation" are also
 * skipped, e.g.:  ```php {skip-validation}
 * The marker uses pymdownx superfences' attribute injection syntax ({...}) so that
 * it is silently ignored during rendering (bare hyphenated tokens break superfences).
 */
final class MarkdownExtractor
{
    /**
     * Pattern components:
     * - ^( *) captures optional leading indentation (admonitions indent by 4 spaces)
     * - ```\s*<lang> matches the opening fence with optional space before language tag
     * - (?P<info>[^\n]*) captures the rest of the opening line (hl_lines, custom markers…)
     * - (.*?) captures the block body (non-greedy)
     * - \n\1``` requires the closing fence to match the same indentation
     */
    private string $fencePattern;

    private const string SKIP_PATTERN = '/include_(?:file|code)\s*\(|--8<--/';

    private const string SKIP_VALIDATION_MARKER = 'skip-validation';

    public function __construct(string $language)
    {
        $this->fencePattern = '/^(?P<indent> *)```\s*' . preg_quote($language, '/') . '(?P<info>[^\n]*)\n(?P<body>.*?)\n(?P=indent)```/ms';
    }

    /**
     * @return iterable<array{body: string, line: int}>
     */
    public function extract(string $content): iterable
    {
        if (!preg_match_all($this->fencePattern, $content, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE)) {
            return;
        }

        foreach ($matches as $match) {
            $info = $match['info'][0];
            $body = $match['body'][0];
            $offset = $match['body'][1];

            if (str_contains($info, self::SKIP_VALIDATION_MARKER)) {
                continue;
            }

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
