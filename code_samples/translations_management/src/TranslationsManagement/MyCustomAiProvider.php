<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\AiTranslationProviderInterface;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\TranslationDataInterface;

final readonly class MyCustomAiProvider implements AiTranslationProviderInterface
{
    /**
     * Replace MyApiClient with your HTTP client, SDK wrapper, or any service
     * that communicates with the external AI translation API.
     */
    public function __construct(
        private MyApiClient $apiClient,
        private string $actionConfigurationIdentifier,
    ) {
    }

    public function getIdentifier(): string
    {
        return 'my_custom_ai_provider';
    }

    public function getName(): string
    {
        return 'My AI Translation Service';
    }

    public function getVendorName(): string
    {
        return 'My Company Ltd';
    }

    public function translate(TranslationDataInterface $translationData): string
    {
        return $this->apiClient->translate(
            $translationData->getText(),
            $translationData->getSourceLanguage(),
            $translationData->getTargetLanguage()
        );
    }

    /** @return array<string> */
    public function getSupportedLanguageCodes(): array
    {
        return ['eng-GB', 'ger-DE', 'fre-FR'];
    }

    /** @return array<string, mixed> */
    public function getConfiguration(): array
    {
        return [
            'actionConfigurationIdentifier' => $this->actionConfigurationIdentifier,
        ];
    }

    public function isConfigured(): bool
    {
        return $this->actionConfigurationIdentifier !== '';
    }
}
