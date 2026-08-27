# Controllers

Use controllers to customize rendering and querying content in your site.

By configuring a controller you can modify and enhance the way in which the built-in content view controller renders content.

You indicate which controller to use in the [content view configuration](../../templates/template_configuration/index.md), under the `controller` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
                    article:
                        controller: App\Controller\RelationController::showContentAction
                        template: '@ibexadesign/full/article.html.twig'
                        match:
                            Identifier\ContentType: article
```

```php
<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Core\MVC\Symfony\View\View;

class RelationController
{
    public function showContentAction(View $view, $locationId): View
    {
        return $view;
    }
}
```

For a full example of using a custom controller, see [Embed content](../../embed_and_list_content/embed_content/index.md#embed-relations-with-a-custom-controller).

If you don't want to use the default view controller and only use a custom one, use the same configuration, but don't provide the `template` key. You have to indicate the template to use from the controller itself.

> **Tip: Permissions for custom controllers**
>
> See [permission documentation](../../../permissions/permission_overview/index.md#permissions-for-custom-controllers) for information about access control for custom controllers.
