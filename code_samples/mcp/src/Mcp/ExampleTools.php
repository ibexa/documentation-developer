<?php declare(strict_types=1);

namespace App\Mcp;

use Ibexa\Contracts\Mcp\Attribute\McpTool;
use Ibexa\Contracts\Mcp\McpCapabilityInterface;
use Mcp\Schema\Icon;
use Mcp\Schema\ToolAnnotations;

final readonly class ExampleTools implements McpCapabilityInterface
{
    #[McpTool(
        name: 'greet',
        description: 'Greet a user by name',
        icons: [new Icon(
            src: 'https://openmoji.org/data/color/svg/1F44B.svg',
        )],
        annotations: new ToolAnnotations(
            readOnlyHint: true,
            destructiveHint: false,
            idempotentHint: true,
            openWorldHint: false,
        ),
        servers: ['example'],
    )]
    public function greetByName(string $name): string
    {
        return sprintf('Hello, %s!', $name);
    }
}
