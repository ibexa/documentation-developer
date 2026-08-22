# Cohesivo v6.0 renames, deprecations and removals

Adapt your project for the Cohesivo v6.0 release.

## Cohesivo v6.0

> **Note: Cohesivo v6.0 isn't released yet**
>
> This page is published ahead of the Cohesivo v6.0 release to give you time to prepare your code for the upcoming changes.
>
> As the work on Cohesivo 6.0 is in progress, this page **isn't exhaustive and will evolve with time**.

As announced during Ibexa Summit 2026, [Ibexa DXP will be renamed to Cohesivo](https://www.ibexa.co/blog/redefining-the-dxp-from-execution-to-orchestration) to support the new [orchestration platform approach](https://www.ibexa.co/blog/the-orchestration-era).

To learn more about the new brand, visit the [Cohesivo official site](https://cohesivo.com).

To make the update process between v5 and v6 easier, there are no plans for a large-scale renaming of `Ibexa` to `Cohesivo` in the code, database, or other parts of the product.

This page lists backwards compatibility breaks introduced in Cohesivo v6.0.

## PHP API changes

### ibexa/http-cache

| Deprecated since | Entity                                                                                                                                                       | Change                                                                                                                                                                                                                                                           |
| ---------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| N/A              | `\Ibexa\HttpCache\ResponseTagger\Delegator\DispatcherTagger`                                                                                                 | With `kernel.debug` enabled, [`DispatcherTagger`](../../infrastructure_and_maintenance/cache/http_cache/content_aware_cache/index.md#dispatchertagger) will throw an exception when you pass an unsupported value instead of silently ignoring it. |
| v5.0.7           | [`ResponseTagger::supports`](../../../../../ibexa/http-cache/src/contracts/ResponseTagger/ResponseTagger.php) | Method added to the interface. All implementations must specify [the value they support for tagging](../../infrastructure_and_maintenance/cache/http_cache/content_aware_cache/index.md#delegator-and-value-taggers).                              |

### ibexa/core

| Deprecated since | Entity                                                                                                                                                                                           | Change                                                                                                                                                                                                                                                                                                                 |
| ---------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| N/A              | [`ValidationError::getTranslatableMessage`](../../../../../ibexa/core/src/contracts/FieldType/ValidationError.php) | Return type narrowed from [`Ibexa\Contracts\Core\Repository\Values\Translation`](../../../../../ibexa/core/src/contracts/Repository/Values/Translation.php) to [`Ibexa\Contracts\Core\Repository\Values\Translation\Message`](../../../../../ibexa/core/src/contracts/Repository/Values/Translation/Message.php) |

### ibexa/messenger

| Deprecated since | Entity                                                                                                                                                                         | Change                                                                                                                                                                                                                                                                                                                                                              |
| ---------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| v5.0.9           | [`\Ibexa\Contracts\Messenger\Stamp\SudoStamp`](../../infrastructure_and_maintenance/background_tasks/index.md#sudostamp)                                         | No longer attached automatically to every dispatched message. For messages that should be processed without taking permissions into account, always attach the SudoStamp manually.                                                                                                                                                                                  |
| v5.0.9           | `\Ibexa\Bundle\Messenger\Stamp\DeduplicateStamp`                                                                                                                               | Moved to [`\Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`](../../../../../ibexa/messenger/src/contracts/Stamp/DeduplicateStamp.php). Covered by [Ibexa Rector](../../resources/rector/index.md) refactoring rules.                                                                        |
| v5.0.10          | [`\Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`](../../../../../ibexa/messenger/src/contracts/Stamp/DeduplicateStamp.php) | Replaced in v6.0 with [`\Symfony\Component\Messenger\Stamp\DeduplicateStamp`](https://symfony.com/doc/7.4/messenger.html#message-deduplication). A Rector rule will be available for the Cohesivo 6.0 upgrade. Until then, keep using the deprecated `\Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`, as Ibexa DXP 5.0 doesn't handle the native Symfony stamp. |
