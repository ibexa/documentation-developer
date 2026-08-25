<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Exception\UnsupportedLanguageException;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\LanguageNormalizer\LanguageNormalizerInterface;
use Ibexa\Contracts\TranslationsManagement\AutoTranslate\Provider\TranslationProviderInterface;

final class MyCustomLanguageCodeNormalizer implements LanguageNormalizerInterface
{
    private const array LANGUAGE_MAP = [
        'eng-GB' => 'en-GB',
        'ger-DE' => 'de',
        'fre-FR' => 'fr',
    ];

    public function supports(TranslationProviderInterface $provider): bool
    {
        return $provider->getIdentifier() === 'my_custom_ai_provider';
    }

    public function normalize(
        TranslationProviderInterface $provider,
        string $languageCode
    ): string {
        if (isset(self::LANGUAGE_MAP[$languageCode])) {
            return self::LANGUAGE_MAP[$languageCode];
        }

        throw new UnsupportedLanguageException(
            $languageCode,
            $provider->getIdentifier(),
            array_values(self::LANGUAGE_MAP)
        );
    }
}
