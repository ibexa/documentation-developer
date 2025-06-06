<?php declare(strict_types=1);

namespace App\AutomatedTranslation;

use Ibexa\AutomatedTranslation\Exception\ClientNotConfiguredException;
use Ibexa\Contracts\AutomatedTranslation\Client\ClientInterface;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\RuntimeContext;
use Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceInterface;
use Ibexa\Contracts\ConnectorAi\ActionServiceInterface;

final class AiClient implements ClientInterface
{
    /** @var array<string> */
    private array $supportedLanguages;

    private ActionServiceInterface $actionService;

    private ActionConfigurationServiceInterface $actionConfigurationService;

    public function __construct(ActionServiceInterface $actionService, ActionConfigurationServiceInterface $actionConfigurationService)
    {
        $this->actionService = $actionService;
        $this->actionConfigurationService = $actionConfigurationService;
    }

    public function setConfiguration(array $configuration): void
    {
        if (!array_key_exists('languages', $configuration)) {
            throw new ClientNotConfiguredException('List of supported languages is missing in the configuration under the "languages" key');
        }
        $this->supportedLanguages = $configuration['languages'];
    }

    public function translate(string $payload, ?string $from, string $to): string
    {
        $action = new TranslateAction(new Text([$payload]));
        $action->setRuntimeContext(
            new RuntimeContext(
                [
                    'from' => $from,
                    'to' => $to,
                ]
            )
        );
        $actionConfiguration = $this->actionConfigurationService->getActionConfiguration('translate');
        $actionResponse = $this->actionService->execute($action, $actionConfiguration)->getOutput();

        assert($actionResponse instanceof Text);

        return $actionResponse->getText();
    }

    public function supportsLanguage(string $languageCode): bool
    {
        return in_array($languageCode, $this->supportedLanguages, true);
    }

    public function getServiceAlias(): string
    {
        return 'aiclient';
    }

    public function getServiceFullName(): string
    {
        return 'Custom AI Automated Translation';
    }
}
