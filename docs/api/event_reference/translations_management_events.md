---
description: Events that are triggered when working with translations management.
edition: lts-update
page_type: reference
---

# Translations management events

The [Translations management](configure_translations_management.md) package dispatches events at two levels.

## Translation events

Translation events are thrown once per field value per translation operation.
They are used for logging, analytics, and observability.
Both events are read-only, you can't use them to override the translation result.

| Event | Dispatched by | Dispatched when | Properties |
|---|---|---|----|
| [`BeforeTranslateEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Event-BeforeTranslateEvent.html) | `EventDispatchingProviderTranslator` | Before a translation request is sent to the provider | `TranslationProviderInterface $provider`</br>`string $text`</br>`string $sourceLanguage`</br>`string $targetLanguage` |
| [`TranslateEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Event-TranslateEvent.html) | `TranslationService` | After a translation response is received | `string $result`</br>`TranslationProviderInterface $provider`</br>`string $text`</br>`string $sourceLanguage`</br>`string $targetLanguage` |

## Side-by-side creation events

Side-by-side creation events are dispatched when a new translation draft is being prepared.

| Event | Dispatched by | Dispatched when | Properties |
|---|---|---|---|
| [`OnContentSideBySideTranslationCreateEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-SideBySide-Event-OnContentSideBySideTranslationCreateEvent.html) | `ContentTranslationCreateController` | When a draft side-by-side translation of a content item is being created | `Request $request`</br>`Content $sourceContent`</br>`string $sourceLanguageCode`</br>`string $targetLanguageCode`</br>`?Content $targetDraft` |
| [`OnProductSideBySideTranslationCreateEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-SideBySide-Event-OnProductSideBySideTranslationCreateEvent.html) | `ProductTranslationViewController` | When a draft side-by-side translation of a product is being created | `Request $request`</br>`ContentAwareProductInterface $sourceProduct`</br>`ContentAwareProductInterface $targetProduct`</br>`string $sourceLanguageCode`</br>`string $targetLanguageCode`</br>`?ProductUpdateData $productUpdateData` |
