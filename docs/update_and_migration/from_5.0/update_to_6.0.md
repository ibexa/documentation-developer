---
description: Update your installation to v6.0 from the latest v5.0 version.
month_change: false
---

# Update from v5.0 to Cohesivo v6.0

## Update from v5.0.x to v5.0.latest

Before you update to v6.0, you need to [update to the latest maintenance release of v5.0 (v[[= latest_tag_5_0 =]])](update_from_5.0.md).

## Update from v5.0.latest to v6.0.0

### Update custom code for Cohesivo v6.0

See [Cohesivo v6.0 renames, deprecations and removals](cohesivo_v6.0_deprecations.md) for the full list of changes.

#### Remove IbexaAppSwitcher bundle

The `IbexaAppSwitcherBundle` bundle, part of the `ibexa/app-switcher` package, is removed in 6.0.

Remove the entry from `config/bundles.php`:

``` diff
-     Ibexa\Bundle\AppSwitcher\IbexaAppSwitcherBundle::class => ['all' => true],
```

### Empty the background task queue

The message format used for [background task deduplication](cohesivo_v6.0_deprecations.md#ibexamessenger) changed between v5.0 and v6.0.
Before you update, process or manually remove pending messages stored in the `ibexa_messenger_messages` table, so no message in the old format remains.
