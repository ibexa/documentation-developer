---
description: Update your installation to v6.0 from the latest v5.0 version.
month_change: false
---

# Update from v5.0 to Cohesivo v6.0

## Update from v5.0.x to v5.0.latest

Before you update to v6.0, you need to [update to the latest maintenance release of v5.0 (v[[= latest_tag_5_0 =]])](update_from_5.0.md).

TODO: Do Ibexa DXP 5.0 Headless to Ibexa DXP 5.0 Experience should be done first or Ibexa DXP 5.0 Headless to Cohesivo 6.0 can be done directly?

### TODO: Doctrine migrations

Ensure your Database schema is maintained by [Doctrine migrations that was introduced in v5.0.11](update_from_5.0.md#database-update_5).

```bash
php bin/console ibexa:doctrine:migrations:up-to-date
php bin/console ibexa:doctrine:migrations:migrate --no-interaction
```

## Update from v5.0.latest to v6.0.0

### Rebranding and repackaging

Cohesivo 6.0 isn't distributed in various editions like Ibexa DXP used to be.

- Ibexa DXP 5.0 Experience evolved into Cohesivo 6.0.
- Ibexa DXP 5.0 Headless is included in Cohesivo 6.0 too.
- Ibexa DXP 5.0 Commerce is covered by Cohesivo 6.0 with the Commerce SDK package.

![Mapping Ibexa DXP 5.0 editions to Cohesivo 6.0 and Commerce SDK](editions-mapping.png)

### Match Cohesivo 6.0 requirements

Your infrastructure must match the [Cohesivo 6.0 requirements](requirements.md).

PHP 8.5 is the minimum required version for Cohesivo 6.0. Upgrade your webserver.

TODO: What about PHP 8.6?

### Update composer.json

- Increase the minimal PHP version constraint to `>=8.5`.
- Increase Symfony packages and `extra.symfony.require` constraints to `8.1.*`.
- Change the Ibexa DXP edition package to a Cohesivo package:
    - Replace `ibexa/headless` or `ibexa/experience` with `ibexa/cohesivo`
    - Replace `ibexa/commerce` with `ibexa/cohesivo-commerce-sdk`

| Before (5.0) | After (6.0) |
| --- | --- |
| `"php": ">=8.3"` | `"php": ">=8.5"` |
| `"symfony\/([^"]+)": "7.4.*"` | `"symfony\/\1": "8.1.*"` |
| `"require": "7.4.*"` | `"require": "8.1.*"` |
| `"ibexa\/(headless|experience)": "[^"]+"` | `"ibexa\/cohesivo": "6.0.0"` |
| `"ibexa\/commerce": "[^"]+"` | `"ibexa\/cohesivo-commerce-sdk": "6.0.0"` |

TODO: Update packages, recipes, config:

```bash
composer update
composer sync-recipes --reset --force --yes --no-interaction
```

### Check config/bundles.php

The recipes can update the `config/bundles.php` file, but bundle declaration could be incomplete or need sorting.

- Ensure `TwigBundle` is before `GregwarCaptchaBundle` in the list. If not, move that last one down.

TODO: Merge "Remove IbexaAppSwitcher bundle" into this

### TODO: Doctrine migrations

TODO: right position? Maybe latter. After custom code update?

```bash
php bin/console ibexa:doctrine:migrations:migrate --no-interaction
```

TODO: Missing experience content when comming from headless

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

TODO: add how-to
