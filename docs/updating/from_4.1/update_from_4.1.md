---
description: Update your installation to the v4.1.latest version from an earlier v4.1.x version.
latest_tag: '4.1.5'
---

# Update from v4.1.x to v4.1.latest

This update procedure applies if you are using a v4.1 installation without the latest maintenance release.

Go through the following steps to update to the latest maintenance release of v4.1 (v[[= latest_tag =]]).

!!! note

    You can only update to the latest patch release of 4.1.x.

## Update the application

First, run:

=== "Ibexa Content"

    ``` bash
    composer require ibexa/content:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```

=== "Ibexa Experience"

    ``` bash
    composer require ibexa/experience:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```

=== "Ibexa Commerce"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag =]] --with-all-dependencies --no-scripts
    ```
