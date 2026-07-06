<!-- vale VariablesVersion = NO -->

# Cohesivo v6.0 renames, deprecations and removals

## About Cohesivo 6.0

!!! note "Cohesivo v6.0 is not released yet"

    This page is published ahead of the Cohesivo v6.0 release to give you time to prepare your code for the upcoming changes.

    As the work on Cohesivo 6.0 is in progress, this page **isn't exhaustive and will evolve with time**.

As announced during Ibexa Summit 2026, [Ibexa DXP will be renamed to Cohesivo](https://www.ibexa.co/blog/redefining-the-dxp-from-execution-to-orchestration) to support the new [orchestration platform approach](https://www.ibexa.co/blog/the-orchestration-era).

This page lists backwards compatibility breaks and deprecations introduced in Cohesivo v6.0.

## PHP API changes

### ibexa/http-cache

| Class                                                                   | Change                                                                                                                                                                                                    |
|:---------------------------------------------------------------------------|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| <nobr>`\Ibexa\Contracts\HttpCache\ResponseTagger\ResponseTagger::supports`</nobr>       | Method added to the interface. All implementations must now specify the value they support for tagging.                                                                                           |
| `\Ibexa\HttpCache\ResponseTagger\Delegator\DispatcherTagger`  | `DispatcherTagger` will now log a warning (in Symfony `prod` environment) or throw an exception (in Symfony `dev` environment) when an unsupported value is passed instead of silently ignoring it. |

### ibexa/messenger

| Class                                                                          | Change                                              |
|:------------------------------------------------------------------------------------|:-----------------------------------------------------------|
| [`SudoStamp`](background_tasks.md#sudostamp)     | No longer attached automatically to every dispatched message. For messages that should be processed without taking permissions into account, always attach the SudoStamp manually.                                             |
| <nobr>`\Ibexa\Bundle\Messenger\Stamp\DeduplicateStamp`</nobr>                                     | Moved to [`\Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Stamp-DeduplicateStamp.html). Covered by [[[= product_name_base =]] Rector](../resources/rector.md) refactoring rules. |
