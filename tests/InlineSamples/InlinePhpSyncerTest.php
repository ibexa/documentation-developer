<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Documentation\InlineSamples;

use PHPUnit\Framework\TestCase;

/**
 * Tests for InlinePhpSyncer sync-back logic.
 *
 * buildPhpFile() delegates to InlinePhpWriter (the production class) so these tests
 * exercise the same code path as the real extraction script.
 */
final class InlinePhpSyncerTest extends TestCase
{
    private InlinePhpSyncer $syncer;

    private InlinePhpWriter $writer;

    protected function setUp(): void
    {
        $this->syncer = new InlinePhpSyncer();
        $this->writer = new InlinePhpWriter();
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Delegates to InlinePhpWriter::build() — the production class — so syncer tests
     * always use the canonical file format.
     */
    private function buildPhpFile(string $sourcePath, int $bodyLine, string $mdBody): string
    {
        return $this->writer->build($sourcePath, $bodyLine, $mdBody);
    }

    /**
     * Returns the 1-based line number of the first body line for the first fenced PHP block
     * found in $md, using MarkdownExtractor.
     */
    private static function bodyLineOf(string $md): int
    {
        $extractor = new MarkdownExtractor('php');
        $blocks = iterator_to_array($extractor->extract($md));
        self::assertNotEmpty($blocks, 'No PHP blocks found in Markdown');

        return $blocks[0]['line'];
    }

    // -------------------------------------------------------------------------
    // parseSourceLocation
    // -------------------------------------------------------------------------

    public function testParseSourceLocationReturnsNullWhenCommentMissing(): void
    {
        $content = "<?php\n\$x = 1;\n";
        self::assertNull($this->syncer->parseSourceLocation($content));
    }

    public function testParseSourceLocationExtractsPathAndLine(): void
    {
        $content = $this->buildPhpFile('docs/api/example.md', 42, '$x = 1;');
        $location = $this->syncer->parseSourceLocation($content);

        self::assertNotNull($location);
        self::assertSame('docs/api/example.md', $location['path']);
        self::assertSame(42, $location['line']);
    }

    public function testParseSourceLocationToleratesDeclarationInsertedByFixer(): void
    {
        // php-cs-fixer may insert declare(strict_types=1) before the source comment.
        $content = "<?php\ndeclare(strict_types=1);\n// Source: docs/foo.md:7\n// (auto-generated ...)\n\n\$x = 1;\n";
        $location = $this->syncer->parseSourceLocation($content);

        self::assertNotNull($location);
        self::assertSame('docs/foo.md', $location['path']);
        self::assertSame(7, $location['line']);
    }

    // -------------------------------------------------------------------------
    // sync — no change cases
    // -------------------------------------------------------------------------

    public function testSyncReturnsNullForMissingSourceComment(): void
    {
        $md = "text\n\n```php\n\$x = 1;\n```\n";
        $phpFile = "<?php\n\$x = 1;\n"; // no Source comment

        self::assertNull($this->syncer->sync($phpFile, $md));
    }

    public function testSyncReturnsNullWhenBodyIsUnchanged(): void
    {
        $md = "text\n\n```php\n\$x = 1;\n```\n";
        $bodyLine = self::bodyLineOf($md);
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, '$x = 1;');

        self::assertNull($this->syncer->sync($phpFile, $md));
    }

    public function testSyncReturnsNullWhenPhpTagSnippetIsUnchanged(): void
    {
        $md = "text\n\n```php\n<?php\n\$x = 1;\n```\n";
        $bodyLine = self::bodyLineOf($md);
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, "<?php\n\$x = 1;");

        self::assertNull($this->syncer->sync($phpFile, $md));
    }

    public function testSyncReturnsNullWhenBlankLineSnippetIsUnchanged(): void
    {
        // The blank line after <?php must be detected and not falsely trigger a diff.
        $md = "text\n\n```php\n<?php\n\n\$x = 1;\n```\n";
        $bodyLine = self::bodyLineOf($md);
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, "<?php\n\n\$x = 1;");

        self::assertNull($this->syncer->sync($phpFile, $md));
    }

    public function testSyncReturnsNullWhenDeclareSnippetIsUnchanged(): void
    {
        // Canonical form has a blank line between <?php and declare — syncer must not
        // report a diff when the snippet already matches that convention.
        $md = "text\n\n```php\n<?php\n\ndeclare(strict_types=1);\n\n\$x = 1;\n```\n";
        $bodyLine = self::bodyLineOf($md);
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, "<?php\n\ndeclare(strict_types=1);\n\n\$x = 1;");

        self::assertNull($this->syncer->sync($phpFile, $md));
    }

    // -------------------------------------------------------------------------
    // sync — body line out of range
    // -------------------------------------------------------------------------

    public function testSyncReturnsNullForBodyLineOutOfRange(): void
    {
        $md = "one line\n";
        // Line 999 does not exist in this tiny Markdown.
        $phpFile = $this->buildPhpFile('docs/test.md', 999, '$x = 1;');

        self::assertNull($this->syncer->sync($phpFile, $md));
    }

    // -------------------------------------------------------------------------
    // sync — simple code changes
    // -------------------------------------------------------------------------

    public function testSyncAppliesSimpleCodeChange(): void
    {
        $md = "text\n\n```php\n\$x=1;\n```\n";
        $bodyLine = self::bodyLineOf($md);
        // Simulate cs-fixer adding spaces around =
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, '$x = 1;');

        $result = $this->syncer->sync($phpFile, $md);

        self::assertNotNull($result);
        self::assertStringContainsString('$x = 1;', $result);
        // Surrounding Markdown structure is preserved
        self::assertStringContainsString('text', $result);
        self::assertStringContainsString('```php', $result);
    }

    public function testSyncAppliesMultiLineCodeChange(): void
    {
        $md = "```php\n\$a=1;\n\$b=2;\n```\n";
        $bodyLine = self::bodyLineOf($md);
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, "\$a = 1;\n\$b = 2;");

        $result = $this->syncer->sync($phpFile, $md);

        self::assertNotNull($result);
        self::assertStringContainsString("\$a = 1;\n\$b = 2;", $result);
    }

    public function testSyncWorksWhenBlankSeparatorRemovedByRefactoringTool(): void
    {
        // Rector (and similar tools) may remove the blank line between the auto-generated
        // header and the body. The syncer must not produce an empty body in that case.
        $md = "```php\n\$x = 1;\n```\n";
        $bodyLine = self::bodyLineOf($md);

        // Build a normal file then strip the blank separator to simulate Rector's behaviour.
        $normalFile = $this->buildPhpFile('docs/test.md', $bodyLine, '$x = 1;');
        $fileWithoutBlank = str_replace(
            "// (auto-generated by tools/extract-inline-php.php — do not edit)\n\n",
            "// (auto-generated by tools/extract-inline-php.php — do not edit)\n",
            $normalFile,
        );

        // A refactoring tool also changed the body.
        $fileWithChange = str_replace('$x = 1;', '$x = 2;', $fileWithoutBlank);

        $result = $this->syncer->sync($fileWithChange, $md);

        self::assertNotNull($result);
        self::assertStringContainsString('$x = 2;', $result);
    }

    // -------------------------------------------------------------------------
    // sync — <?php opening tag handling
    // -------------------------------------------------------------------------

    public function testSyncPreservesPhpOpeningTag(): void
    {
        $md = "text\n\n```php\n<?php\n\$x=1;\n```\n";
        $bodyLine = self::bodyLineOf($md);
        // cs-fixer fixed the spacing; the <?php tag was stripped before writing the file
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, "<?php\n\$x = 1;");

        $result = $this->syncer->sync($phpFile, $md);

        self::assertNotNull($result);
        self::assertStringContainsString("<?php\n\$x = 1;", $result);
        // Must appear exactly once
        self::assertSame(1, substr_count($result, '<?php'));
    }

    public function testSyncDoesNotAddPhpTagWhenOriginalHadNone(): void
    {
        $md = "text\n\n```php\n\$x=1;\n```\n";
        $bodyLine = self::bodyLineOf($md);
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, '$x = 1;');

        $result = $this->syncer->sync($phpFile, $md);

        self::assertNotNull($result);
        self::assertStringNotContainsString('<?php', $result);
    }

    // -------------------------------------------------------------------------
    // sync — blank line after <?php
    // -------------------------------------------------------------------------

    public function testSyncPreservesBlankLineAfterPhpTagWhenApplyingChange(): void
    {
        // Original snippet: <?php + blank line + code (blank line must survive the sync).
        $md = "text\n\n```php\n<?php\n\n\$x=1;\n```\n";
        $bodyLine = self::bodyLineOf($md);
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, "<?php\n\n\$x=1;");

        // cs-fixer fixed spacing
        $fixedPhpFile = str_replace('$x=1;', '$x = 1;', $phpFile);

        $result = $this->syncer->sync($fixedPhpFile, $md);

        self::assertNotNull($result);
        self::assertStringContainsString("<?php\n\n\$x = 1;", $result);
    }

    public function testSyncDoesNotAddBlankLineWhenOriginalHadNone(): void
    {
        $md = "text\n\n```php\n<?php\n\$x=1;\n```\n";
        $bodyLine = self::bodyLineOf($md);
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, "<?php\n\$x=1;");

        $fixedPhpFile = str_replace('$x=1;', '$x = 1;', $phpFile);

        $result = $this->syncer->sync($fixedPhpFile, $md);

        self::assertNotNull($result);
        // The fixed body must come immediately after <?php (no extra blank line).
        self::assertStringContainsString("<?php\n\$x = 1;", $result);
        self::assertStringNotContainsString("<?php\n\n", $result);
    }

    // -------------------------------------------------------------------------
    // sync — admonition indentation
    // -------------------------------------------------------------------------

    public function testSyncHandlesAdmonitionIndentation(): void
    {
        $md = "!!! note\n\n    ```php\n    \$x=1;\n    ```\n";
        $bodyLine = self::bodyLineOf($md);
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, '$x = 1;');

        $result = $this->syncer->sync($phpFile, $md);

        self::assertNotNull($result);
        // The 4-space indent must be re-applied to the body line.
        self::assertStringContainsString('    $x = 1;', $result);
    }

    public function testSyncHandlesIndentedBlockWithPhpTagAndBlankLine(): void
    {
        $md = "!!! note\n\n    ```php\n    <?php\n\n    \$x=1;\n    ```\n";
        $bodyLine = self::bodyLineOf($md);
        $phpFile = $this->buildPhpFile('docs/test.md', $bodyLine, "<?php\n\n\$x=1;");

        $fixedPhpFile = str_replace('$x=1;', '$x = 1;', $phpFile);

        $result = $this->syncer->sync($fixedPhpFile, $md);

        self::assertNotNull($result);
        // Both the indent and the blank line must be preserved.
        self::assertStringContainsString("    <?php\n\n    \$x = 1;", $result);
    }

    // -------------------------------------------------------------------------
    // Roundtrip tests (MarkdownExtractor → buildPhpFile → sync)
    // -------------------------------------------------------------------------

    /**
     * @param array<string, string> $replacements Simulated cs-fixer changes: old => new.
     *
     * @dataProvider provideRoundtripCases
     */
    public function testRoundtripAppliesChangesAndIsIdempotent(
        string $md,
        array $replacements,
        string $expectedSnippet
    ): void {
        $extractor = new MarkdownExtractor('php');

        // --- First pass: extract, simulate fix, sync ---
        $blocks = iterator_to_array($extractor->extract($md));
        self::assertNotEmpty($blocks);

        $block = $blocks[0];
        $phpFile = $this->buildPhpFile('docs/test.md', $block['line'], $block['body']);

        $fixedPhpFile = strtr($phpFile, $replacements);
        $hasChange = $fixedPhpFile !== $phpFile;

        $updatedMd = $this->syncer->sync($fixedPhpFile, $md);

        if (!$hasChange) {
            self::assertNull($updatedMd, 'No change by fixer; sync must return null');

            return;
        }

        self::assertNotNull($updatedMd);
        self::assertStringContainsString($expectedSnippet, $updatedMd);

        // --- Second pass: idempotency check ---
        // Re-extract from the updated Markdown; cs-fixer produces no further changes this time.
        $blocks2 = iterator_to_array($extractor->extract($updatedMd));
        self::assertNotEmpty($blocks2);

        $block2 = $blocks2[0];
        $phpFile2 = $this->buildPhpFile('docs/test.md', $block2['line'], $block2['body']);

        self::assertNull(
            $this->syncer->sync($phpFile2, $updatedMd),
            'Second sync on an already-updated Markdown must return null (idempotent)',
        );
    }

    /**
     * @return iterable<string, array{string, array<string, string>, string}>
     */
    public static function provideRoundtripCases(): iterable
    {
        yield 'plain snippet, spacing fix' => [
            "text\n\n```php\n\$x=1;\n```\n",
            ['$x=1;' => '$x = 1;'],
            '$x = 1;',
        ];

        yield 'snippet with <?php, spacing fix' => [
            "text\n\n```php\n<?php\n\$x=1;\n```\n",
            ['$x=1;' => '$x = 1;'],
            "<?php\n\$x = 1;",
        ];

        yield 'snippet with <?php and blank line, spacing fix' => [
            "text\n\n```php\n<?php\n\n\$x=1;\n```\n",
            ['$x=1;' => '$x = 1;'],
            "<?php\n\n\$x = 1;",
        ];

        yield 'no fixer change, sync returns null' => [
            "text\n\n```php\n\$x = 1;\n```\n",
            [], // no replacements
            '$x = 1;',
        ];

        yield 'indented snippet, spacing fix' => [
            "!!! note\n\n    ```php\n    \$x=1;\n    ```\n",
            ['$x=1;' => '$x = 1;'],
            '    $x = 1;',
        ];

        yield 'multiline snippet, import ordering' => [
            "```php\n<?php\n\nuse B\\Foo;\nuse A\\Bar;\n```\n",
            ['use B\\Foo;' . "\n" . 'use A\\Bar;' => 'use A\\Bar;' . "\n" . 'use B\\Foo;'],
            "use A\\Bar;\nuse B\\Foo;",
        ];

        yield 'snippet with declare(strict_types=1), spacing fix' => [
            "text\n\n```php\n<?php\n\ndeclare(strict_types=1);\n\n\$x=1;\n```\n",
            ['$x=1;' => '$x = 1;'],
            "<?php\n\ndeclare(strict_types=1);\n\n\$x = 1;",
        ];
    }

    // -------------------------------------------------------------------------
    // Line-number stability: blocks from the same file, processed high→low
    // -------------------------------------------------------------------------

    public function testLaterBlockUnaffectedWhenEarlierBlockShrinks(): void
    {
        // Two PHP blocks in the same Markdown. The first block will have a line removed
        // (blank line after <?php dropped) which shifts all subsequent line numbers.
        // Processing second block AFTER first would use wrong line if naively ordered.
        $md = implode("\n", [
            'intro',
            '',
            '```php',
            '<?php',
            '',
            '$a = 1;',
            '```',
            '',
            'middle',
            '',
            '```php',
            '$b=2;',
            '```',
            '',
        ]);

        $extractor = new MarkdownExtractor('php');
        $blocks = iterator_to_array($extractor->extract($md));
        self::assertCount(2, $blocks);

        [$blockA, $blockB] = $blocks;

        $phpFileA = $this->buildPhpFile('docs/test.md', $blockA['line'], $blockA['body']);
        // Simulate cs-fixer removing the blank line after <?php (by using the stripped body).
        // No actual change to body content — but ltrim already stripped it,
        // so fixedBody == phpFileA in this case, and sync would return null.
        // Instead, also fix $a spacing to trigger a real change:
        $fixedPhpFileA = str_replace('$a = 1;', '$a=99;', $phpFileA);

        $phpFileB = $this->buildPhpFile('docs/test.md', $blockB['line'], $blockB['body']);
        $fixedPhpFileB = str_replace('$b=2;', '$b = 2;', $phpFileB);

        // Apply block A first (it changes line count), then block B.
        // Block B must still land in the right place.
        $md1 = $this->syncer->sync($fixedPhpFileA, $md) ?? $md;
        $md2 = $this->syncer->sync($fixedPhpFileB, $md1) ?? $md1;

        self::assertStringContainsString('$a=99;', $md2);
        self::assertStringContainsString('$b = 2;', $md2);
        // The second block must still be in a php fence
        self::assertMatchesRegularExpression('/```php\n\$b = 2;\n```/', $md2);
    }
}
