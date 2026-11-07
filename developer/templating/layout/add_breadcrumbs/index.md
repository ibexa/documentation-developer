# Add breadcrumbs

Add and render a breadcrumbs element on your site.

To add breadcrumbs to your website, first prepare a general layout template in a `templates/themes/<theme_name>/pagelayout.html.twig` file.

This template can contain things such as header, menu, footer, and [assets](../../assets/index.md) for the whole site, and all other templates [extend](../../templates/templates/index.md#connecting-templates) it.

Then, to render breadcrumbs, create a `BreadcrumbController.php` file in `src/Controller`:

```php
<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Bundle\Core\Controller;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Symfony\Component\HttpFoundation\Response;

class BreadcrumbController extends Controller
{
    public function __construct(
        private readonly LocationService $locationService,
        private readonly SearchService $searchService
    ) {
    }

    public function showBreadcrumbsAction($locationId): Response
    {
        $query = new LocationQuery();
        $query->query = new Criterion\Ancestor([$this->locationService->loadLocation($locationId)->pathString]);

        $results = $this->searchService->findLocations($query);
        $breadcrumbs = [];
        foreach ($results->searchHits as $searchHit) {
            $breadcrumbs[] = $searchHit;
        }

        return $this->render(
            '@ibexadesign/parts/breadcrumbs.html.twig',
            [
                'breadcrumbs' => $breadcrumbs,
            ]
        );
    }
}
```

The controller uses the [Ancestor Search Criterion](../../../search/criteria_reference/ancestor_criterion/index.md) to find all Ancestors of the current Location (line 27). It then places the ancestors in the `breadcrumbs` variable that you can use in the template.

Next, call this controller from the page layout template and pass the current location ID as a parameter:

```html+twig
{{ render(
    controller(
        "App\\Controller\\BreadcrumbController::showBreadcrumbsAction",
        {
            'locationId': locationId,
        }
    )
) }}
```

Finally, create a breadcrumb template in `templates/themes/<theme_name>/parts/breadcrumbs.html.twig`, as indicated in the controller (line 34). In this template, iterate over all breadcrumbs and render links to them:

```html+twig
{% for breadcrumb in breadcrumbs %}
    {% if not loop.first %} -> {% endif %}
    {% if not loop.last %}
        <a href="{{ ibexa_path( breadcrumb.valueObject ) }}">{{ breadcrumb.valueObject.contentInfo.name }}</a>
    {% else %}
        {{ breadcrumb.valueObject.contentInfo.name }}
    {% endif %}
{% endfor %}
```
