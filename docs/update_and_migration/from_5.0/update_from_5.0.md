---
description: Update your installation to the latest v5.0 version from an earlier v5.0 version.
month_change: true
---

# Update from v5.0.x to v5.0.latest

To update from v4.6.x, see [Update from v4.6 to v5.0](update_to_5.0.md).
To update from an older version, visit [the update page](update_ibexa_dxp.md) and choose the applicable path.

## Update the application

Note which version you actually have before starting.

First, run:

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

Then execute the instructions below starting from the version you're upgrading from.

<!-- vale Ibexa.VariablesVersion = NO -->

## v5.0.1

Some packages increase their type hinting strictness.
You can run [Ibexa DXP Rector](https://github.com/ibexa/rector/blob/v5.0.1/README.md) to update your code.
