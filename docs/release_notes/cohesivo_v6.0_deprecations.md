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

## Removed packages

- The `ibexa/app-switcher` package, and its `IbexaAppSwitcherBundle`, is no longer part of the 6.0.
- The `ibexa/automated-translation` package is no longer available as an opt-in. Use [Translations management](configure_translations_management.md) instead.

## PHP API changes

### ibexa/automated-translations

| Deprecated since | Entity                                                                   | Change                                                                                                                                                                                                    |
| --- |---------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| v5.0.10 | `\Ibexa\Contracts\AutomatedTranslation`  | The `ibexa/automated-translation` package is replaced by `ibexa/translations-management`. For Translations management API, see [`Ibexa\Contracts\TranslationsManagement`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-translationsmanagement.html). |

### ibexa/http-cache

| Deprecated since | Entity                                                                   | Change                                                                                                                                                                                                    |
| --- |---------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| N/A | `\Ibexa\HttpCache\ResponseTagger\Delegator\DispatcherTagger`  | With `kernel.debug` enabled, [`DispatcherTagger`](content_aware_cache.md#dispatchertagger) will throw an exception when you pass an unsupported value instead of silently ignoring it. |
| v5.0.7 | [`ResponseTagger::supports`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-HttpCache-ResponseTagger-ResponseTagger.html#) | Method added to the interface. All implementations must specify [the value they support for tagging](content_aware_cache.md#delegator-and-value-taggers). |

### ibexa/core

| Deprecated since | Entity                                                                                                                                                      | Change                                                                                                                                                          |
| --- |-------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| N/A | <nobr>[`ValidationError::getTranslatableMessage`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-FieldType-ValidationError.html#method_getTranslatableMessage)</nobr> | Return type narrowed from [`Translation`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Translation.html) to [`Message`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Translation-Message.html) \| [`Plural`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Translation-Plural.html). Custom `ValidationError` implementations must update their return type. |

### ibexa/messenger

| Deprecated since | Entity                                                                          | Change                                              |
| --- |------------------------------------------------------------------------------------|-----------------------------------------------------------|
| v5.0.9 | [`\Ibexa\Contracts\Messenger\Stamp\SudoStamp`](background_tasks.md#sudostamp)     | No longer attached automatically to every dispatched message. For messages that should be processed without taking permissions into account, always attach the SudoStamp manually.                                             |
| v5.0.9 | <nobr>`\Ibexa\Bundle\Messenger\Stamp\DeduplicateStamp`</nobr>                                     | Moved to [`\Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Stamp-DeduplicateStamp.html). Covered by [[[= product_name_base =]] Rector](../resources/rector.md) refactoring rules. |
| v5.0.10 | <nobr>[`\Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Stamp-DeduplicateStamp.html)</nobr>                               | Replaced in v6.0 with [`\Symfony\Component\Messenger\Stamp\DeduplicateStamp`]([[= symfony_doc =]]/messenger.html#message-deduplication). A Rector rule will be available for the Cohesivo 6.0 upgrade. Until then, keep using the deprecated `\Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`, as Ibexa DXP 5.0 doesn't handle the native Symfony stamp. |

### ibexa/user

| Deprecated since | Entity                                                    | Change                                                                                                                       |
| --- |----------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------|
| N/A | `\Ibexa\User\UserSetting\Group\LocationGroup`                   | Renamed to `\Ibexa\User\UserSetting\Group\LocaleGroup`. The [user setting](add_user_setting.md) group identifier `location` is renamed to `locale`. Custom settings registered under the `location` identifier must be updated to use `locale` instead. |

## Configuration keys

| Old name | New name / Comment |
| --- | --- |
| `ibexa_system_info.system_info.powered_by.release` | Removed. See [X-Powered-By header](devops.md#x-powered-by-header) for how the header works in Cohesivo v6.0. |
