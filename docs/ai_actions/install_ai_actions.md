---
description: Install the AI Actions add-on.
---

# Install AI Actions

AI Actions are available as an add-on to the v4.6.x version of [[= product_name =]] or higher, regardless of its edition.
To use this feature you must first install the add-on and then configure it YAML configuration.

## Install AI Actions

AI Actions are available from v4.6.x of [[= product_name =]].
Run the following command to install the bundle:

``` bash
composer require ibexa/connector-ai
composer require ibexa/connector-openai
```

This command adds the code, Twig templates and configuration files required for using AI Actions, and modifies the permission system to account for the new functionality.

## Prepare configuration files

After you install AI Actions add-on, you must enable the OpenAI connector by specifying the OpenAPI token.
In the `.env` file, define a new environment variable `OPENAPI_TOKEN=` and add the token that you obtained from the AI service.