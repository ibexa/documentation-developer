<?php declare(strict_types=1);

namespace Ibexa\Tests\Documentation\Yaml;

final readonly class CodeSample
{
    public function __construct(
        public string $path,
        public int $line,
        public string $body,
    ) {
    }
}
