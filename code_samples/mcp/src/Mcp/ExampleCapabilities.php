<?php declare(strict_types=1);

namespace App\Mcp;

use Ibexa\Contracts\Mcp\Attribute\McpPrompt;
use Ibexa\Contracts\Mcp\Attribute\McpTool;
use Ibexa\Contracts\Mcp\McpCapabilityInterface;
use Mcp\Capability\Attribute\Schema;
use Mcp\Schema\Icon;
use Mcp\Schema\ToolAnnotations;

final readonly class ExampleCapabilities implements McpCapabilityInterface
{
    #[McpTool(
        servers: ['example'],
        name: 'greet',
        description: 'Greet a user by name',
        annotations: new ToolAnnotations(
            readOnlyHint: true,
            destructiveHint: false,
            idempotentHint: true,
            openWorldHint: false,
        ),
        icons: [new Icon(
            src: 'https://openmoji.org/data/color/svg/1F44B.svg',
        )],
    )]
    public function greetByName(
        #[Schema(
            description: 'the name of the person to greet'
        )]
        string $name
    ): string {
        return sprintf('Hello, %s!', $name);
    }

    /**
     * @param string $name The name you want to be greeted by
     *
     * @return array<string, mixed>
     */
    #[McpPrompt(
        servers: ['example'],
        name: 'greet',
        description: 'Prompt to be greeted by the `greet` tool',
        icons: [new Icon(
            src: 'https://openmoji.org/data/color/svg/1F91D.svg',
        )],
    )]
    public function getGreetPrompt(string $name): array
    {
        return [
            'role' => 'user',
            'content' => [
                'type' => 'text',
                'text' => "Hi. Please, greet me. My name is $name.",
            ],
        ];
    }
}
