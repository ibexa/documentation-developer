---
description: Adapt your project for the Cohesivo v6.0 release.
month_change: true
---

<!-- vale Ibexa.VariablesVersion = NO -->
<!-- vale Ibexa.VariablesGlobal = NO -->

# Cohesivo v6.0 renames, deprecations and removals

## Cohesivo v6.0

!!! note "Cohesivo v6.0 isn't released yet"

    This page is published ahead of the Cohesivo v6.0 release to give you time to prepare your code for the upcoming changes.

    As the work on Cohesivo 6.0 is in progress, this page **isn't exhaustive and will evolve with time**.

As announced during Ibexa Summit 2026, [Ibexa DXP will be renamed to Cohesivo](https://www.ibexa.co/blog/redefining-the-dxp-from-execution-to-orchestration) to support the new [orchestration platform approach](https://www.ibexa.co/blog/the-orchestration-era).

To learn more about the new brand, visit the [Cohesivo official site](https://cohesivo.com).

To make the update process between v5 and v6 easier, there are no plans for a large-scale renaming of `Ibexa` to `Cohesivo` in the code, database, or other parts of the product.

This page lists backwards compatibility breaks introduced in Cohesivo v6.0.

## PHP API changes

### ibexa/http-cache

| Deprecated since | Entity                                                                   | Change                                                                                                                                                                                                    |
| --- |---------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| N/A | `\Ibexa\HttpCache\ResponseTagger\Delegator\DispatcherTagger`  | With `kernel.debug` enabled, [`DispatcherTagger`](https://doc.ibexa.co/en/5.0/infrastructure_and_maintenance/cache/http_cache/content_aware_cache/#dispatchertagger) will throw an exception when you pass an unsupported value instead of silently ignoring it. |
| v5.0.7 | [`ResponseTagger::supports`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-HttpCache-ResponseTagger-ResponseTagger.html#) | Method added to the interface. All implementations must specify [the value they support for tagging](https://doc.ibexa.co/en/5.0/infrastructure_and_maintenance/cache/http_cache/content_aware_cache/#delegator-and-value-taggers). |

### ibexa/core

| Deprecated since | Entity                                                                                                                                                      | Change                                                                                                                                                          |
| --- |-------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| N/A | <nobr>[`ValidationError::getTranslatableMessage`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-FieldType-ValidationError.html#method_getTranslatableMessage)</nobr> | Return type narrowed from [`Translation`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Translation.html) to [`Message`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Translation-Message.html) \| [`Plural`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Translation-Plural.html). Custom `ValidationError` implementations must update their return type. |

### ibexa/messenger

| Deprecated since | Entity                                                                          | Change                                              |
| --- |------------------------------------------------------------------------------------|-----------------------------------------------------------|
| v5.0.9 | [`\Ibexa\Contracts\Messenger\Stamp\SudoStamp`](https://doc.ibexa.co/en/5.0/infrastructure_and_maintenance/background_tasks/#sudostamp)     | No longer attached automatically to every dispatched message. For messages that should be processed without taking permissions into account, always attach the SudoStamp manually.                                             |
| v5.0.9 | <nobr>`\Ibexa\Bundle\Messenger\Stamp\DeduplicateStamp`</nobr>                                     | Moved to [`\Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Stamp-DeduplicateStamp.html). Covered by [[[= product_name_base =]] Rector](https://doc.ibexa.co/en/5.0/resources/rector/) refactoring rules. |
| v5.0.10 | <nobr>[`\Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Stamp-DeduplicateStamp.html)</nobr>                               | Replaced in v6.0 with [`\Symfony\Component\Messenger\Stamp\DeduplicateStamp`]([[= symfony_doc =]]/messenger.html#message-deduplication). A Rector rule will be available for the Cohesivo 6.0 upgrade. Until then, keep using the deprecated `\Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`, as Ibexa DXP 5.0 doesn't handle the native Symfony stamp. |
