<?php

namespace App\AutomatedTranslation;

use Ibexa\AutomatedTranslation\Exception\ClientNotConfiguredException;
use Ibexa\Contracts\AutomatedTranslation\Client\ClientInterface;

final class CustomClient implements ClientInterface
{
    private string $apiKey;

    private const SUPPORTED_LANGUAGES = ['en', 'de', 'fr'];

    public function setConfiguration(array $configuration): void
    {
        if (!isset($configuration['apiKey'])) {
            throw new ClientNotConfiguredException('apiKey is required');
        }
        $this->apiKey = $configuration['apiKey'];
    }

    public function translate(string $payload, ?string $from, string $to): string
    {
        // call your custom translation logic here
        return str_replace('foo', 'bar', $payload);
    }

    public function supportsLanguage(string $languageCode): bool
    {
        return in_array(substr($languageCode, 0, 2), self::SUPPORTED_LANGUAGES, true);
    }

    public function getServiceAlias(): string
    {
        return 'custom';
    }

    public function getServiceFullName(): string
    {
        return 'Custom Automated Translation';
    }
}
