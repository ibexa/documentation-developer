<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\TranslationProviderInterface;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\TranslationDataInterface;

final readonly class MyCustomProvider implements TranslationProviderInterface
{
    /**
     * Replace MyApiClient with your HTTP client, SDK wrapper, or any service
     * that communicates with the external translation API.
     */
    public function __construct(
        private MyApiClient $apiClient,
    ) {
    }

    public function getIdentifier(): string
    {
        return 'my_custom_provider';
    }

    public function getName(): string
    {
        return 'My Translation Service';
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
        return ['en_GB', 'de_DE', 'fr_FR'];
    }
}
