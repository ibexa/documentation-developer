<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Documentation\InlineSamples;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Integration tests for the full inline-PHP pipeline:
 *
 *   Markdown code block
 *     → MarkdownExtractor::extract()          [identifies blocks and their line numbers]
 *     → InlinePhpWriter::build()              [produces the _inline_php/ file content]
 *     → (optional) simulate cs-fixer changes  [body text substitution]
 *     → InlinePhpSyncer::sync()               [patches the Markdown with the fixed body]
 *     → assert updated Markdown               [verify correctness and idempotency]
 *
 * These tests treat the three classes as a single unit and verify observable outcomes
 * rather than implementation details.  Edge cases that require isolated unit testing
 * are covered by InlinePhpWriterTest and InlinePhpSyncerTest respectively.
 */
final class InlinePhpPipelineTest extends TestCase
{
    private MarkdownExtractor $extractor;

    private InlinePhpWriter $writer;

    private InlinePhpSyncer $syncer;

    protected function setUp(): void
    {
        $this->extractor = new MarkdownExtractor('php');
        $this->writer = new InlinePhpWriter();
        $this->syncer = new InlinePhpSyncer();
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Runs the full pipeline for the first block found in $md.
     *
     * @param array<string, string> $fixerReplacements str_replace()-style substitutions applied
     *                                                 to the built file content to simulate cs-fixer.
     *
     * @return string|null Updated Markdown, or null when the pipeline produced no change.
     */
    private function pipeline(string $md, array $fixerReplacements = []): ?string
    {
        $blocks = iterator_to_array($this->extractor->extract($md));
        self::assertNotEmpty($blocks, 'No PHP blocks found in Markdown');

        $block = $blocks[0];
        $phpFile = $this->writer->build('docs/test.md', $block['line'], $block['body']);

        if ($fixerReplacements !== []) {
            $phpFile = strtr($phpFile, $fixerReplacements);
        }

        return $this->syncer->sync($phpFile, $md);
    }

    /**
     * Runs the pipeline for ALL blocks in $md, applying the same fixer replacements to each,
     * and patches the Markdown accumulating all changes (highest line first, as the real
     * script does).
     *
     * @param array<string, string> $fixerReplacements
     */
    private function pipelineAll(string $md, array $fixerReplacements = []): string
    {
        $blocks = iterator_to_array($this->extractor->extract($md));
        self::assertNotEmpty($blocks);

        // Collect per-block PHP files and sort by descending line (highest first).
        $items = array_map(
            fn (array $block): array => [
                'line' => $block['line'],
                'phpFile' => strtr(
                    $this->writer->build('docs/test.md', $block['line'], $block['body']),
                    $fixerReplacements,
                ),
            ],
            $blocks,
        );
        usort($items, static fn (array $a, array $b): int => $b['line'] <=> $a['line']);

        foreach ($items as ['phpFile' => $phpFile, 'line' => $line]) {
            $updated = $this->syncer->sync($phpFile, $md);
            if ($updated !== null) {
                $md = $updated;
            }
        }

        return $md;
    }

    // -------------------------------------------------------------------------
    // No-op: pipeline returns null when cs-fixer changes nothing
    // -------------------------------------------------------------------------

    public function testNoOpForPlainSnippet(): void
    {
        $md = "text\n\n```php\n\$x = 1;\n```\n";
        self::assertNull($this->pipeline($md));
    }

    public function testNoOpForSnippetWithPhpTag(): void
    {
        $md = "text\n\n```php\n<?php\n\$x = 1;\n```\n";
        self::assertNull($this->pipeline($md));
    }

    public function testNoOpForSnippetWithPhpTagAndBlankLine(): void
    {
        // The blank line between <?php and the body must not trigger a spurious diff.
        $md = "text\n\n```php\n<?php\n\n\$x = 1;\n```\n";
        self::assertNull($this->pipeline($md));
    }

    public function testNoOpForIndentedSnippet(): void
    {
        $md = "!!! note\n\n    ```php\n    \$x = 1;\n    ```\n";
        self::assertNull($this->pipeline($md));
    }

    public function testNoOpForIndentedSnippetWithPhpTagAndBlankLine(): void
    {
        $md = "!!! note\n\n    ```php\n    <?php\n\n    \$x = 1;\n    ```\n";
        self::assertNull($this->pipeline($md));
    }

    // -------------------------------------------------------------------------
    // Changes are applied correctly
    // -------------------------------------------------------------------------

    public function testChangeAppliedToPlainSnippet(): void
    {
        $md = "text\n\n```php\n\$x=1;\n```\n";
        $result = $this->pipeline($md, ['$x=1;' => '$x = 1;']);

        self::assertNotNull($result);
        self::assertStringContainsString('$x = 1;', $result);
        self::assertStringNotContainsString('$x=1;', $result);
    }

    public function testChangeAppliedPreservesPhpTag(): void
    {
        $md = "text\n\n```php\n<?php\n\$x=1;\n```\n";
        $result = $this->pipeline($md, ['$x=1;' => '$x = 1;']);

        self::assertNotNull($result);
        self::assertStringContainsString("<?php\n\$x = 1;", $result);
        self::assertSame(1, substr_count($result, '<?php'));
    }

    public function testChangeAppliedPreservesBlankLineAfterPhpTag(): void
    {
        $md = "text\n\n```php\n<?php\n\n\$x=1;\n```\n";
        $result = $this->pipeline($md, ['$x=1;' => '$x = 1;']);

        self::assertNotNull($result);
        self::assertStringContainsString("<?php\n\n\$x = 1;", $result);
    }

    public function testChangeAppliedToIndentedSnippet(): void
    {
        $md = "!!! note\n\n    ```php\n    \$x=1;\n    ```\n";
        $result = $this->pipeline($md, ['$x=1;' => '$x = 1;']);

        self::assertNotNull($result);
        self::assertStringContainsString('    $x = 1;', $result);
    }

    public function testChangeAppliedToIndentedSnippetWithPhpTagAndBlankLine(): void
    {
        $md = "!!! note\n\n    ```php\n    <?php\n\n    \$x=1;\n    ```\n";
        $result = $this->pipeline($md, ['$x=1;' => '$x = 1;']);

        self::assertNotNull($result);
        self::assertStringContainsString("    <?php\n\n    \$x = 1;", $result);
    }

    public function testMultiLineChangePreservesStructure(): void
    {
        $body = "<?php\n\nnamespace App;\n\nuse B\\Baz;\nuse A\\Bar;\n\n\$x = 1;";
        $md = "text\n\n```php\n{$body}\n```\n";

        // Simulate cs-fixer reordering imports
        $result = $this->pipeline($md, [
            "use B\\Baz;\nuse A\\Bar;" => "use A\\Bar;\nuse B\\Baz;",
        ]);

        self::assertNotNull($result);
        self::assertStringContainsString("use A\\Bar;\nuse B\\Baz;", $result);
        self::assertStringContainsString("<?php\n\nnamespace App;", $result);
    }

    // -------------------------------------------------------------------------
    // Idempotency: a second pipeline pass produces no further change
    // -------------------------------------------------------------------------

    /**
     * @param array<string, string> $fixerReplacements
     */
    #[DataProvider('provideIdempotencyCases')]
    public function testPipelineIsIdempotent(string $md, array $fixerReplacements): void
    {
        // First pass (may or may not change the Markdown).
        $updated = $this->pipeline($md, $fixerReplacements) ?? $md;

        // Second pass: re-extract from the updated Markdown; fixer makes no further changes.
        $blocks = iterator_to_array($this->extractor->extract($updated));
        self::assertNotEmpty($blocks);

        $block = $blocks[0];
        $phpFile = $this->writer->build('docs/test.md', $block['line'], $block['body']);

        self::assertNull(
            $this->syncer->sync($phpFile, $updated),
            'A second sync after no fixer changes must return null',
        );
    }

    /**
     * @return iterable<string, array{string, array<string, string>}>
     */
    public static function provideIdempotencyCases(): iterable
    {
        yield 'plain snippet, no change' => ["text\n\n```php\n\$x = 1;\n```\n", []];
        yield 'plain snippet, spacing fixed' => ["text\n\n```php\n\$x=1;\n```\n", ['$x=1;' => '$x = 1;']];
        yield '<?php, no change' => ["text\n\n```php\n<?php\n\$x = 1;\n```\n", []];
        yield '<?php, spacing fixed' => ["text\n\n```php\n<?php\n\$x=1;\n```\n", ['$x=1;' => '$x = 1;']];
        yield '<?php + blank line, no change' => ["text\n\n```php\n<?php\n\n\$x = 1;\n```\n", []];
        yield '<?php + blank line, spacing fixed' => ["text\n\n```php\n<?php\n\n\$x=1;\n```\n", ['$x=1;' => '$x = 1;']];
        yield 'indented, no change' => ["!!! note\n\n    ```php\n    \$x = 1;\n    ```\n", []];
        yield 'indented, spacing fixed' => ["!!! note\n\n    ```php\n    \$x=1;\n    ```\n", ['$x=1;' => '$x = 1;']];
    }

    // -------------------------------------------------------------------------
    // Multiple blocks in the same Markdown file
    // -------------------------------------------------------------------------

    public function testAllBlocksUpdatedInMultiBlockFile(): void
    {
        $md = implode("\n", [
            'intro',
            '',
            '```php',
            '$a=1;',
            '```',
            '',
            'middle',
            '',
            '```php',
            '$b=2;',
            '```',
            '',
        ]);

        $result = $this->pipelineAll($md, ['$a=1;' => '$a = 1;', '$b=2;' => '$b = 2;']);

        self::assertStringContainsString('$a = 1;', $result);
        self::assertStringContainsString('$b = 2;', $result);
    }

    public function testLaterBlockCorrectAfterEarlierBlockAddsLines(): void
    {
        // First block gains a line (blank line restored between <?php and code).
        // Without descending-order processing the second block's line number would be wrong.
        $md = implode("\n", [
            '```php',
            '<?php',
            '$a=1;',
            '```',
            '',
            '```php',
            '$b=2;',
            '```',
            '',
        ]);

        // cs-fixer adds a blank line after <?php in the first block and fixes spacing everywhere.
        // We simulate this by fixing spacing; the blank line restoration is handled by InlinePhpSyncer.
        $result = $this->pipelineAll($md, ['$a=1;' => '$a = 1;', '$b=2;' => '$b = 2;']);

        self::assertStringContainsString('$a = 1;', $result);
        // Second block must still be in its own php fence.
        self::assertMatchesRegularExpression('/```php\n\$b = 2;\n```/', $result);
    }

    public function testMultiBlockIdempotent(): void
    {
        $md = implode("\n", [
            '```php',
            '$a=1;',
            '```',
            '',
            '```php',
            '$b=2;',
            '```',
            '',
        ]);

        // First pass with fixer changes.
        $updated = $this->pipelineAll($md, ['$a=1;' => '$a = 1;', '$b=2;' => '$b = 2;']);

        // Second pass: no fixer changes — everything should stay the same.
        $blocks = iterator_to_array($this->extractor->extract($updated));
        $items = array_map(
            fn (array $block): array => [
                'line' => $block['line'],
                'phpFile' => $this->writer->build('docs/test.md', $block['line'], $block['body']),
            ],
            $blocks,
        );
        usort($items, static fn (array $a, array $b): int => $b['line'] <=> $a['line']);

        foreach ($items as ['phpFile' => $phpFile]) {
            self::assertNull(
                $this->syncer->sync($phpFile, $updated),
                'No change expected on second pass',
            );
        }
    }

    // -------------------------------------------------------------------------
    // Surrounding Markdown content is never modified
    // -------------------------------------------------------------------------

    public function testSurroundingMarkdownIsUntouched(): void
    {
        $md = "# Heading\n\nSome prose.\n\n```php\n\$x=1;\n```\n\nMore prose.\n\n> A blockquote.\n";
        $result = $this->pipeline($md, ['$x=1;' => '$x = 1;']);

        self::assertNotNull($result);
        self::assertStringContainsString('# Heading', $result);
        self::assertStringContainsString('Some prose.', $result);
        self::assertStringContainsString('More prose.', $result);
        self::assertStringContainsString('> A blockquote.', $result);
    }

    public function testFenceLanguageTagIsPreserved(): void
    {
        $md = "```php\n\$x=1;\n```\n";
        $result = $this->pipeline($md, ['$x=1;' => '$x = 1;']);

        self::assertNotNull($result);
        self::assertStringContainsString('```php', $result);
    }

    public function testFenceWithHlLinesAnnotationIsPreserved(): void
    {
        $md = "```php hl_lines=\"1 2\"\n\$x=1;\n\$y=2;\n```\n";
        $result = $this->pipeline($md, ['$x=1;' => '$x = 1;', '$y=2;' => '$y = 2;']);

        self::assertNotNull($result);
        self::assertStringContainsString('```php hl_lines="1 2"', $result);
    }
}
