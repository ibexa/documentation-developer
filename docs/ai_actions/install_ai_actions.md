---
description: Install the AI Actions add-on.
---

# Install AI Actions

AI Actions are available as an add-on to the v4.6.x version of [[= product_name =]] or higher, regardless of its edition.
To use this feature you must first install the add-on and then configure it YAML configuration.

## Install AI Actions

AI Actions are available from v4.6.x of [[= product_name =]].
Run the following command to install the bundle:

`composer require ibexa/connector-ai`

This command adds the code, Twig templates and configuration files required for using AI Actions, and modifies the permission system to account for the new functionality.

To check for the presence of AI Actions in your application, run the following command:

`composer show | grep "ibexa/connector-ai"`

## Prepare configuration files

When you install AI Actions add-on, it modifies the YAML configuration files by adding configuration keys similar to this example:

```yaml
...

```