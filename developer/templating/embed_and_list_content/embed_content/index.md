# Embed related content

Embed a content item in another using query types or controllers.

To embed content in another content item, you query for it in the repository. There are two ways to query for a content item:

- by using a [Query type](#embed-siblings-with-query-type)
- by writing a [custom controller](#embed-relations-with-a-custom-controller)

## Embed siblings with Query type

To render the Siblings of a content item (other content under the same parent Location), use the [Siblings Query type](../../queries_and_controllers/built-in_query_types/index.md#siblings).

To do it, use the built-in `ibexa_query` controller's `contentQueryAction`:

```yaml
            content_view:
                full:
                    blog_post:
                        controller: ibexa_query::contentQueryAction
                        template: '@ibexadesign/full/blog_post.html.twig'
                        params:
                            query:
                                query_type: 'Siblings'
                                parameters:
                                    content: '@=content'
                                    limit: 3
                                    sort: 'date_published desc'
                                assign_results_to: items
                        match:
                            Identifier\ContentType: blog_post
```

The results of the Siblings query are placed in the `items` variable, which you can use in the template:

```html+twig
{{ ibexa_content_name(content) }}
{% for item in items.searchHits %}
    {{ ibexa_render(item.valueObject, {'viewType': 'line'}) }}
{% endfor %}
```

## Embed Relations with a custom controller

You can use a custom controller for any situation where Query types aren't sufficient.

```yaml
                    article:
                        controller: App\Controller\RelationController::showContentAction
                        template: '@ibexadesign/full/article.html.twig'
                        params:
                            accepted_content_types: [ 'article', 'test_target', 'test_source' ]
                        match:
                            Identifier\ContentType: article
```

This configuration points to a custom `RelationController` that should render all Articles with the `showContentAction()` method.

```php
<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Core\MVC\Symfony\View\View;

class RelationController
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly LocationService $locationService
    ) {
    }

    public function showContentAction(View $view, $locationId): View
    {
        $acceptedContentTypes = $view->getParameter('accepted_content_types');

        $location = $this->locationService->loadLocation($locationId);
        $contentInfo = $location->getContentInfo();
        $versionInfo = $this->contentService->loadVersionInfo($contentInfo);
        $relationList = $this->contentService->loadRelationList($versionInfo);

        $items = [];

        foreach ($relationList as $relationListItem) {
            if ($relationListItem->hasRelation() && in_array($relationListItem->getRelation()->getDestinationContentInfo()->getContentType()->identifier, $acceptedContentTypes)) {
                $items[] = $this->contentService->loadContentByContentInfo($relationListItem->getRelation()->getDestinationContentInfo());
            }
        }

        $view->addParameters([
            'items' => $items,
        ]);

        return $view;
    }
}
```

This controller uses the Public PHP API to get [the Relations of a content item](../../../content_management/content_api/browsing_content/index.md#relations) (lines 27-28).

The controller takes the custom parameter called `accepted_content_types` (line 23), which is an array of content type identifiers that are rendered.

This way you can control which content types you want to show or exclude.

Finally, the controller returns the view with the results that were provided in the `items` parameter. You can use this parameter as a variable in the template:

```html+twig
{% block content %}
<h1>{{ ibexa_content_name(content) }}</h1>
<ul>
    {% for item in items %}
        {{ ibexa_render(item, {'viewType': 'embed'} ) }}
    {% endfor %}
</ul>
{% endblock %}
```
