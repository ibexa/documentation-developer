---
description: Update your installation to v5.0 from the latest v4.6 version.
month_change: true
---

# Update from v4.6 to v5.0

## Update from v4.6.x to v4.6.latest

Before you update to v5.0, you need to [update to the latest maintenance release of v4.6 (v[[= latest_tag_4_6 =]])](update_from_4.6.md).

## Update from v4.6.latest to v5.0.TODO

When you have the last version of 4.6, you can update to v5.0.

First, check v5.0's [requirements](requirements.md).
It supports only PHP 8.3 and above.

### Update custom code for PHP 8.3 (TODO: 8.3+?)

If your DXP 4.6 is running on a PHP below 8.3, start migrating it to PHP 8.3.

Use Ibexa Rector to help yourself to upgrade PHP code for 8.3,
see [`ibexa/rector`'s README](https://github.com/ibexa/rector?tab=readme-ov-file#ibexa-dxp-rector) for more information about installation and usage.

TODO: Example with our own code samples?
TODO: list of features deprecated in 4.6 removed in 5.0?

### TODO: Other updates like moving from any deprecated stuff?

### Update [[= product_name =]] application

=== "[[= product_name_headless =]]"

    ``` bash
    composer require ibexa/headless:[[= latest_tag_5_0 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/headless --force -v
    ```
=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_5_0 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```
=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_5_0 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

### composer.json

#### Sort commands

Recipe appends a command to `composer.json`'s `auto-scripts`.
You have to manually resort the commands so the `tsconfig.json` file
is created by `yarn ibexa-generate-tsconfig`
before being used by `ibexa:encore:compile`.
Your `auto-scripts` entry should look like this:

```json
        "auto-scripts": {
            "cache:clear": "symfony-cmd",
            "assets:install %PUBLIC_DIR%": "symfony-cmd",
            "yarn install": "script",
            "ibexa:encore:compile --config-name app": "symfony-cmd",
            "bazinga:js-translation:dump %PUBLIC_DIR%/assets --merge-domains": "symfony-cmd",
            "yarn ibexa-generate-tsconfig": "script",
            "ibexa:encore:compile": "symfony-cmd"
        },
```

#### Clean-up

If you have required 4.6 LTS Update packages,
they're included by default in 5.0.
You can now remove them from your composer.json
so you won't have to maintain which of their versions your composer.json is referring to. 

TODO: Do it earlier?
TODO: A reminding list of removable LTS Update packages

### Update database

Apply the following database update script:

TODO: Fix SQL file path

### [[= product_name =]]

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.6.latest-to-5.0.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.6.latest-to-5.0.0.sql
    ```

TODO: Migration files?

Many tables names have changed. If you have custom code directly querying these tables, you will need to update them.

TODO: old name/new name table

TODO: Compatibility "views" layers? Even if there is this layer to save time, it is recommended to update your code to use the new tables.

### Update custom code for [[= product_name =]] 5.0

TODO: Rector again, this time with 5.0 rules.

### Update Back Office extensions

TODO: Update JS, templates, CSS…
TODO: Some old deprecated Webpack file names were supported in 4.6 for backward compatibility; They aren't in 5.0
TODO: Conversion tables
