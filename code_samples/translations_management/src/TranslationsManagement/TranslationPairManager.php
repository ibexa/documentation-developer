<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\Core\Repository\LanguageService;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\TranslationProviderInterface;
use Ibexa\TranslationsManagement\AutoTranslate\LanguagePair\LanguagePairInterface;
use Ibexa\TranslationsManagement\AutoTranslate\LanguagePair\LanguagePairServiceInterface;

final readonly class TranslationPairManager
{
    public function __construct(
        private LanguagePairServiceInterface $languagePairService,
        private LanguageService $languageService,
    ) {
    }

    public function addPair(
        string $sourceLanguageCode,
        string $targetLanguageCode,
        TranslationProviderInterface $provider,
        bool $replaceExisting = false,
    ): LanguagePairInterface {
        $sourceLanguage = $this->languageService->loadLanguage($sourceLanguageCode);
        $targetLanguage = $this->languageService->loadLanguage($targetLanguageCode);

        return $this->languagePairService->createLanguagePair(
            $sourceLanguage,
            $targetLanguage,
            $provider,
            $replaceExisting,
        );
    }
}
