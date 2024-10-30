<?php declare(strict_types=1);

namespace App\AI\Handler;

use Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\TextToText\Action as TextToTextAction;
use Ibexa\Contracts\ConnectorAi\Action\TextToText\ActionResponse as TextToTextActionResponse;
use Ibexa\Contracts\ConnectorAi\ActionInterface;
use Ibexa\Contracts\ConnectorAi\ActionResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class LLamaTextToTextActionHandler implements ActionHandlerInterface
{
    private HttpClientInterface $client;

    private string $host;

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
        $text = str_replace(array("\n", "\r"), ' ', $input->getText());

        $handlerOptions = $action->getActionContext()?->getActionHandlerOptions();

        if ($handlerOptions !== null) {
            $systemMessage = $handlerOptions->has('system_prompt') ? $handlerOptions->get('system_prompt') : '';
            $prompt = $handlerOptions->has('prompt') ? $handlerOptions->get('prompt') : '';
            $system = $systemMessage . $prompt;
        } else {
            $system = '';
        }

        $content = $text;

        $body = <<<BODY
{
    "model": "LLaMA_CPP",
    "messages": [
        {
            "role": "system",
            "content": "$system"
        },
        {
            "role": "user",
            "content": "$content"
        }
    ],
    "temperature": 2.0
}
BODY;

        $response = $this->client->request(
            'POST',
            sprintf('%s/v1/chat/completions', $this->host),
            [
                'headers' => [
                    'Content-Type' => 'Content-Type: application/json',
                    'Authorization: Bearer no-key',
                ],
                'body' => $body,
            ]
        );

        $output = strip_tags(json_decode($response->getContent(), true)['choices'][0]['message']['content']);

        return new TextToTextActionResponse(new Text([$output]));
    }

    public static function getIdentifier(): string
    {
        return 'LLamaTextToText';
    }
}
