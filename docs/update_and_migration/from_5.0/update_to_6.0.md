---
description: Update your installation to v6.0 from the latest v5.0 version.
month_change: false
---

# Update from v5.0 to Cohesivo v6.0

!!! note "Cohesivo v6.0 isn't released yet"

    This page is published ahead of the Cohesivo v6.0 release to give you time to prepare your code for the upcoming changes.

    As the work on Cohesivo 6.0 is in progress, this page **isn't exhaustive and will evolve with time**.

## Update from v5.0.x to v5.0.latest

Before you update to v6.0, you need to [update to the latest maintenance release of v5.0 (v[[= latest_tag_5_0 =]])](update_from_5.0.md).

## Update from v5.0.latest to v6.0.0

### Update custom code for Cohesivo v6.0

See [Cohesivo v6.0 renames, deprecations and removals](/release_notes/cohesivo_v6.0_deprecations.md) for the full list of changes.

#### X-Powered-By header

The `ibexa_system_info.system_info.powered_by.release` configuration option is removed.
Remove it from your configuration, if present.
See [X-Powered-By header](/infrastructure_and_maintenance/devops.md#x-powered-by-header) for how the header works in Cohesivo v6.0.

```diff
 ibexa_system_info:
     system_info:
         powered_by:
-            release: major
             enabled: true
```
