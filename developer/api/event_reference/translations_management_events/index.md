# Translations management events

Events that are triggered when working with translations management.

Editions: LTS Update

The [Translations management](../../../multisite/translations_management/translations_management_guide/index.md) package dispatches events at two levels.

## Translation events

Translation events are dispatched for every field in each selected target language. Use them for logging, analytics, and observability. Both events are read-only, you can't use them to override the translation result.

| Event                                                                                                                                                                            | Dispatched by                        | Dispatched when                                      |
| -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------ | ---------------------------------------------------- |
| [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Event\BeforeTranslateEvent`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Event/BeforeTranslateEvent.php) | `EventDispatchingProviderTranslator` | Before a translation request is sent to the provider |
| [`Ibexa\Contracts\TranslationsManagement\AutoTranslate\Event\TranslateEvent`](../../../../../../ibexa/translations-management/src/contracts/AutoTranslate/Event/TranslateEvent.php)             | `EventDispatchingProviderTranslator` | After a translation response is received             |

## Side-by-side creation events

Side-by-side creation events are dispatched when preparing a new translation draft.

| Event                                                                                                                                                                                                                   | Dispatched by                        | Dispatched when                                                  |
| ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------ | ---------------------------------------------------------------- |
| [`Ibexa\Contracts\TranslationsManagement\SideBySide\Event\OnContentSideBySideTranslationCreateEvent`](../../../../../../ibexa/translations-management/src/contracts/SideBySide/Event/OnContentSideBySideTranslationCreateEvent.php) | `ContentTranslationCreateController` | When creating a draft side-by-side translation of a content item |
| [`Ibexa\Contracts\TranslationsManagement\SideBySide\Event\OnProductSideBySideTranslationCreateEvent`](../../../../../../ibexa/translations-management/src/contracts/SideBySide/Event/OnProductSideBySideTranslationCreateEvent.php) | `ProductTranslationViewController`   | When creating a draft side-by-side translation of a product      |
