---
description: Events that are triggered when working with translations management.
edition: lts-update
page_type: reference
---

# Translations management events

The [Translations management](translations_management_guide.md) package dispatches events at two levels.

## Translation events

Translation events are dispatched for every field in each selected target language.
Use them for logging, analytics, and observability.
Both events are read-only, you can't use them to override the translation result.

| Event | Dispatched by | Dispatched when |
|---|---|---|
| [`BeforeTranslateEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Event-BeforeTranslateEvent.html) | `EventDispatchingProviderTranslator` | Before a translation request is sent to the provider |
| [`TranslateEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-AutoTranslate-Event-TranslateEvent.html) | `EventDispatchingProviderTranslator` | After a translation response is received |

## Side-by-side creation events

Side-by-side creation events are dispatched when a new translation draft is being prepared.

| Event | Dispatched by | Dispatched when |
|---|---|---|
| [`OnContentSideBySideTranslationCreateEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-SideBySide-Event-OnContentSideBySideTranslationCreateEvent.html) | `ContentTranslationCreateController` | When a draft side-by-side translation of a content item is being created |
| [`OnProductSideBySideTranslationCreateEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-TranslationsManagement-SideBySide-Event-OnProductSideBySideTranslationCreateEvent.html) | `ProductTranslationViewController` | When a draft side-by-side translation of a product is being created |
