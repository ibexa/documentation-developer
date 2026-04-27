<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Documentation;

/**
 * Reads yaml-validation-baseline.yaml and answers whether a given failure is
 * a known, expected one that should be suppressed rather than reported.
 *
 * Baseline entries are matched by:
 *   - path    (required) — relative path from repo root; suffix match supported
 *   - line    (optional) — exact line number
 *   - message (optional) — regex pattern matched against the error message
 */
final class ValidationBaseline
{
    /** @var list<array{path: string, line?: int, message?: string}>|null */
    private ?array $entries = null;

    public function __construct(
        private readonly string $baselineFile,
        private readonly string $repoRoot,
    ) {
    }

    public function isInBaseline(string $relativePath, ?int $line, string $errorMessage): bool
    {
        foreach ($this->getEntries() as $entry) {
            $entryPath = $entry['path'] ?? '';

            // Path: exact match or trailing-suffix match (allows glob-like partial paths)
            if ($relativePath !== $entryPath && !str_ends_with($relativePath, ltrim($entryPath, '/'))) {
                continue;
            }

            // Line (optional): must match exactly when provided
            if (isset($entry['line']) && $line !== null && (int) $entry['line'] !== $line) {
                continue;
            }

            // Message (optional): treated as a regex pattern
            if (isset($entry['message']) && !preg_match($entry['message'], $errorMessage)) {
                continue;
            }

            return true;
        }

        return false;
    }

    /**
     * @return list<array{path: string, line?: int, message?: string}>
     */
    private function getEntries(): array
    {
        if ($this->entries !== null) {
            return $this->entries;
        }

        if (!file_exists($this->baselineFile)) {
            return $this->entries = [];
        }

        $parsed = \Symfony\Component\Yaml\Yaml::parseFile($this->baselineFile);

        return $this->entries = $parsed['ignoreErrors'] ?? [];
    }
}
