---
description: Adapt your project for the Cohesivo v6.0 release.
month_change: true
---

<!-- vale VariablesVersion = NO -->

# Cohesivo v6.0 renames, deprecations and removals

## Cohesivo v6.0

!!! note "Cohesivo v6.0 isn't released yet"

    This page is published ahead of the Cohesivo v6.0 release to give you time to prepare your code for the upcoming changes.

    As the work on Cohesivo 6.0 is in progress, this page **isn't exhaustive and will evolve with time**.

As announced during Ibexa Summit 2026, [Ibexa DXP will be renamed to Cohesivo](https://www.ibexa.co/blog/redefining-the-dxp-from-execution-to-orchestration) to support the new [orchestration platform approach](https://www.ibexa.co/blog/the-orchestration-era).

This page lists backwards compatibility breaks introduced in Cohesivo v6.0.

## PHP API changes

### ibexa/http-cache

| Deprecated since | Entity                                                                   | Change                                                                                                                                                                                                    |
| --- |---------------------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| N/A | `\Ibexa\HttpCache\ResponseTagger\Delegator\DispatcherTagger`  | With `kernel.debug` enabled, [`DispatcherTagger`](content_aware_cache.md#dispatchertagger) will throw an exception when you pass an unsupported value instead of silently ignoring it. |
| v5.0.7 | <nobr>`\Ibexa\Contracts\HttpCache\ResponseTagger\ResponseTagger::supports`</nobr> | Method added to the interface. All implementations must specify [the value they support for tagging](content_aware_cache.md#delegator-and-value-taggers). |


### ibexa/messenger

| Deprecated since | Entity                                                                          | Change                                              |
| --- |------------------------------------------------------------------------------------|-----------------------------------------------------------|
| v5.0.9 | [`SudoStamp`](background_tasks.md#sudostamp)     | No longer attached automatically to every dispatched message. For messages that should be processed without taking permissions into account, always attach the SudoStamp manually.                                             |
| v5.0.9 | <nobr>`\Ibexa\Bundle\Messenger\Stamp\DeduplicateStamp`</nobr>                                     | Moved to [`\Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Stamp-DeduplicateStamp.html). Covered by [[[= product_name_base =]] Rector](../resources/rector.md) refactoring rules. |
