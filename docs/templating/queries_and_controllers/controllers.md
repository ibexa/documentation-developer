---
description: Use controllers to customize rendering and querying content in your site.
---

# Controllers

By configuring a controller you can modify and enhance the way in which the built-in content view controller renders content.

You indicate which controller to use in the [content view configuration](template_configuration.md), under the `controller` key:

``` yaml
[[= include_file('code_samples/front/embed_content/config/packages/views.yaml', 23, 26) =]][[= include_file('code_samples/front/embed_content/config/packages/views.yaml', 28, 30) =]]
```

``` php
[[= include_file('code_samples/front/embed_content/src/Controller/RelationController.php', 2, 9) =]]
```

For a full example of using a custom controller, see [Embed content](embed_content.md#custom-controller).

If you do not want to use the default view controller and only use a custom one,
use the same configuration, but do not provide the `template` key.
You have to indicate the template to use from the controller itself.

!!! tip "Permissions for custom controllers"

    See [permission documentation](permissions.md#permissions-for-custom-controllers) for information
    about access control for custom controllers.
