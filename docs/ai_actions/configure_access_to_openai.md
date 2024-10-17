---
description: Configure alt text generation to match your needs.
---

# Configure access to Open AI

With this feature you can enhance accessibility and streamline your content creation process by generating alternative text for images in `ezimage` and `ezimageasset` fields by using the image analysis AI.
Before you can use the feature, you must enable automated alt text generation by setting up a connection with an external AI service.

## Get authentication parameters

First, either you or another [[= product_name_base =]] user responsible for managing the [[= product_name =]] instance must ...

## Ensure you account has credits

...

## Set up API key

When you receive the credentials, add them to your configuration.
In the root folder of your project, edit the `<ADD FILE NAME>` file by adding the following lines with your customer ID and license key: 

```
...
...
```

!!! note "Configuring user credentials for different servces"

    If your installation supports [multiple AI services](extend_ai_actions.md) that perform the same AI action, you must provide credentials for each of these services.
    Otherwise some of the AI Actions will remain inactive.

## ...