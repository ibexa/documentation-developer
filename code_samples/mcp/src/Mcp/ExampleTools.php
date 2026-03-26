<?php declare(strict_types=1);

namespace App\mcp\src\Mcp;

use Ibexa\Contracts\Mcp\Attribute\McpTool;
use Ibexa\Contracts\Mcp\McpCapabilityInterface;

final readonly class ExampleTools implements McpCapabilityInterface
{
    #[McpTool(servers: ['example'], description: 'Greet a user by name')]
    public function greet(string $name): string
    {
        return sprintf('Hello, %s!', $name);
    }
}
