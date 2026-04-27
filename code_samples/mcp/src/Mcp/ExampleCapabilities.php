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
    /**
     * @param string $name The name of the person to greet
     *
     * @return array<string, string>
     */
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
        outputSchema: [
            'type' => 'object',
            'properties' => [
                'general' => [
                    'type' => 'string',
                    'description' => 'the safe way to greet someone',
                ],
                'close' => [
                    'type' => 'string',
                    'description' => 'when you\'re close to the person, like friends or relatives',
                ],
                'morning' => [
                    'type' => 'string',
                    'description' => 'when it\'s in the morning',
                ],
                'afternoon' => [
                    'type' => 'string',
                    'description' => 'when it\'s the afternoon',
                ],
                'evening' => [
                    'type' => 'string',
                    'description' => 'when it\'s late in the day',
                ],
            ],
        ],
    )]
    public function greetByName(string $name): array {
        return [
            'general' => sprintf('Hello, %s!', $name),
            'close' => sprintf('Hey, %s!', $name),
            'morning' => sprintf('Good morning, %s!', $name),
            'afternoon' => sprintf('Good afternoon, %s!', $name),
            'evening' => sprintf('Good evening, %s!', $name),
        ];
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
                'text' => "Hi. My name is $name. Please, greet me.",
            ],
        ];
    }
}
