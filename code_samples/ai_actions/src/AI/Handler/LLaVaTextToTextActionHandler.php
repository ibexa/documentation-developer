<?php

declare(strict_types=1);

namespace App\AI\Handler;

use Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\Response\TextResponse;
use Ibexa\Contracts\ConnectorAi\Action\TextToText\Action as TextToTextAction;
use Ibexa\Contracts\ConnectorAi\ActionInterface;
use Ibexa\Contracts\ConnectorAi\ActionResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class LLaVaTextToTextActionHandler implements ActionHandlerInterface
{
    private HttpClientInterface $client;

    private string $host;

    public const IDENTIFIER = 'LLaVATextToText';

    public function __construct(HttpClientInterface $client, string $host = 'http://localhost:8080')
    {
        $this->client = $client;
        $this->host = $host;
    }

    public function supports(ActionInterface $action): bool
    {
        return $action instanceof TextToTextAction;
    }

    public function handle(ActionInterface $action, array $context = []): ActionResponseInterface
    {
        /** @var \Ibexa\Contracts\ConnectorAi\Action\DataType\Text */
        $input = $action->getInput();
        $text = $this->sanitizeInput($input->getText());

        $systemMessage = $action->hasActionContext() ? $action->getActionContext()->getActionHandlerOptions()->get('system_prompt', '') : '';

        $response = $this->client->request(
            'POST',
            sprintf('%s/v1/chat/completions', $this->host),
            [
                'headers' => [
                    'Authorization: Bearer no-key',
                ],
                'json' => [
                    'model' => 'LLaMA_CPP',
                    'messages' => [
                        (object)[
                            'role' => 'system',
                            'content' => $systemMessage,
                        ],
                        (object)[
                            'role' => 'user',
                            'content' => $text,
                        ],
                    ],
                    'temperature' => 0.7,
                ],
            ]
        );

        $output = strip_tags(json_decode($response->getContent(), true)['choices'][0]['message']['content']);

        return new TextResponse(new Text([$output]));
    }

    public static function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    private function sanitizeInput(string $text): string
    {
        return str_replace(["\n", "\r"], ' ', $text);
    }
}
