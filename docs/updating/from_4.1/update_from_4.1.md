---
description: Update your installation to the v4.1.latest version from an earlier v4.1.x version.
latest_tag: '4.1.6'
---

# Update from v4.1.x to v4.1.latest

This update procedure applies if you are using a v4.1 installation without the latest maintenance release.

Go through the following steps to update to the latest maintenance release of v4.1 (v[[= latest_tag =]]).

!!! note

    You can only update to the latest patch release of 4.1.x.

## Update the application

First, run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```

### v4.1.6

#### VCL configuration for Fastly

Ibexa DXP now supports Fastly shielding. If you are using Fastly and want to use shielding, you need to update your VCL files.

!!! tip

    Even if you do not plan to use Fastly shielding, it is recommended to update the VCL files for future compatibility.

1. Locate the `vendor/ibexa/fastly/fastly/ibexa_main.vcl` file and update your VCL file with the recent changes.
2. Do the same with `vendor/ibexa/fastly/fastly/ibexa_user_hash.vcl`.
3. Upload a new `snippet_re_enable_shielding.vcl` snippet file, based on `vendor/ibexa/fastly/fastly/snippet_re_enable_shielding.vcl`.
