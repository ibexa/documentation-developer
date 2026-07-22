<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Documentation\Markdown;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MarkdownYamlExtractorTest extends TestCase
{
    private MarkdownYamlExtractor $extractor;

    protected function setUp(): void
    {
        $this->extractor = new MarkdownYamlExtractor();
    }

    public function testExtractsNothing(): void
    {
        self::assertEmpty(iterator_to_array($this->extractor->extract('No code blocks here.')));
        self::assertEmpty(iterator_to_array($this->extractor->extract('')));
    }

    public function testIgnoresNonYamlFences(): void
    {
        $content = <<<'MD'
            ```php
            $x = 1;
            ```

            ```json
            {"key": "value"}
            ```
            MD;

        self::assertEmpty(iterator_to_array($this->extractor->extract($content)));
    }

    public function testExtractsSingleBlock(): void
    {
        $content = <<<'MD'
            Some text.

            ```yaml
            foo: bar
            ```

            More text.
            MD;

        $blocks = iterator_to_array($this->extractor->extract($content));

        self::assertCount(1, $blocks);
        self::assertSame('foo: bar', $blocks[0]['body']);
    }

    public function testExtractsMultipleBlocks(): void
    {
        $content = <<<'MD'
            ```yaml
            first: 1
            ```

            ```yaml
            second: 2
            ```
            MD;

        $blocks = iterator_to_array($this->extractor->extract($content));

        self::assertCount(2, $blocks);
        self::assertSame('first: 1', $blocks[0]['body']);
        self::assertSame('second: 2', $blocks[1]['body']);
    }

    public function testReportsCorrectLineNumber(): void
    {
        $content = "line1\nline2\nline3\n```yaml\nfoo: bar\n```\n";

        $blocks = iterator_to_array($this->extractor->extract($content));

        self::assertCount(1, $blocks);
        // The body starts on line 5 (after 4 preceding newlines inside the fence open)
        self::assertSame(5, $blocks[0]['line']);
    }

    public function testAcceptsSpaceBeforeLanguageTag(): void
    {
        $content = "``` yaml\nfoo: bar\n```\n";

        $blocks = iterator_to_array($this->extractor->extract($content));

        self::assertCount(1, $blocks);
        self::assertSame('foo: bar', $blocks[0]['body']);
    }

    public function testAcceptsTrailingAnnotations(): void
    {
        $content = "```yaml hl_lines=\"1 2\"\nfoo: bar\n```\n";

        $blocks = iterator_to_array($this->extractor->extract($content));

        self::assertCount(1, $blocks);
        self::assertSame('foo: bar', $blocks[0]['body']);
    }

    public function testStripsAdmonitionIndentation(): void
    {
        $content = <<<'MD'
            !!! note

                ```yaml
                foo: bar
                baz: qux
                ```
            MD;

        $blocks = iterator_to_array($this->extractor->extract($content));

        self::assertCount(1, $blocks);
        self::assertSame("foo: bar\nbaz: qux", $blocks[0]['body']);
    }

    public function testSkipsBlocksWithIncludeFile(): void
    {
        $content = <<<'MD'
            ```yaml
            [[= include_file('some/file.yaml') =]]
            ```
            MD;

        self::assertEmpty(iterator_to_array($this->extractor->extract($content)));
    }

    public function testSkipsBlocksWithIncludeCode(): void
    {
        $content = <<<'MD'
            ```yaml
            [[= include_code('some/file.yaml', 1, 10) =]]
            ```
            MD;

        self::assertEmpty(iterator_to_array($this->extractor->extract($content)));
    }

    public function testSkipsBlocksWithSnippetMarker(): void
    {
        $content = <<<'MD'
            ```yaml
            --8<--
            some/file.yaml
            --8<--
            ```
            MD;

        self::assertEmpty(iterator_to_array($this->extractor->extract($content)));
    }

    public function testSkipsOnlyMatchingBlocksWhenMixed(): void
    {
        $content = <<<'MD'
            ```yaml
            [[= include_file('foo.yaml') =]]
            ```

            ```yaml
            [[= include_code('bar.yaml', 1, 5) =]]
            ```

            ```yaml
            real: config
            ```
            MD;

        $blocks = iterator_to_array($this->extractor->extract($content));

        self::assertCount(1, $blocks);
        self::assertSame('real: config', $blocks[0]['body']);
    }

    /**
     * @param array<array{body: string, line: int}> $expected
     */
    #[DataProvider('provideMultilineBlocks')]
    public function testExtractsMultilineBody(string $content, array $expected): void
    {
        $blocks = iterator_to_array($this->extractor->extract($content));

        self::assertCount(count($expected), $blocks);
        foreach ($expected as $i => $exp) {
            self::assertSame($exp['body'], $blocks[$i]['body'], "body at index $i");
            self::assertSame($exp['line'], $blocks[$i]['line'], "line at index $i");
        }
    }

    /**
     * @return iterable<string, array{string, array<array{body: string, line: int}>}>
     */
    public static function provideMultilineBlocks(): iterable
    {
        yield 'nested mapping' => [
            "```yaml\nparent:\n    child: value\n```\n",
            [['body' => "parent:\n    child: value", 'line' => 2]],
        ];

        yield 'sequence' => [
            "```yaml\nlist:\n  - a\n  - b\n```\n",
            [['body' => "list:\n  - a\n  - b", 'line' => 2]],
        ];

        yield 'two blocks with correct lines' => [
            "```yaml\nfoo: 1\n```\n\nsome text\n\n```yaml\nbar: 2\n```\n",
            [
                ['body' => 'foo: 1', 'line' => 2],
                ['body' => 'bar: 2', 'line' => 8],
            ],
        ];
    }
}
