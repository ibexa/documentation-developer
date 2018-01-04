# Paginating API search results

## Description

When listing content (e.g. blog posts), pagination is a very common use case and is usually painful to implement by hand.

For this purpose eZ Platform recommends the use of [Pagerfanta library](https://github.com/whiteoctober/Pagerfanta) and [proposes adapters for it](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/Core/Pagination/Pagerfanta).

## Solution

``` php
<?php

namespace Acme\TestBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchAdapter;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta;

class DefaultController extends Controller
{
    public function myContentListAction(Request $request, $locationId, $viewType, $layout = false, array $params = [])
    {
        // First build the search query.
        // Let's search for folders, sorted by publication date.
        $query = new Query();
        $query->filter = new Criterion\ContentTypeIdentifier('folder');
        $query->sortClauses = [
            new SortClause\DatePublished()
        ];

        // Initialize the pager.
        // We pass the ContentSearchAdapter to it.
        // ContentSearchAdapter is built with your search query and the SearchService.
        $pager = new Pagerfanta(
            new ContentSearchAdapter($query, $this->getRepository()->getSearchService())
        );
        // Let's list 2 folders per page, even if it doesn't really make sense ;-)
        $pager->setMaxPerPage(2);
        // Defaults to page 1 or get "page" query parameter
        $pager->setCurrentPage($request->get('page', 1));

        return $this->render('AcmeTestBundle::my_template.html.twig', [
                'totalFolderCount' => $pager->getNbResults(),
                'pagerFolder' => $pager,
                'location' => $this->getRepository()->getLocationService()->loadLocation($locationId),
            ] + $params
        );
    }
}
```

``` php
// my_template.html.twig
{% block content %}
    <h1>Listing folder content objects: {{ totalFolderCount }} objects found.</h1>

    <div>
        <ul>
        {# Loop over the page results #}
        {% for folder in pagerFolder %}
            <li>{{ ez_content_name( folder ) }}</li>
        {% endfor %}
        </ul>
    </div>
 
    {# Only display pagerfanta navigator if needed. #}
    {% if pagerFolder.haveToPaginate() %}
    <div class="pagerfanta">
        {{ pagerfanta( pagerFolder, 'twitter_bootstrap_translated', {'routeName': location} ) }}
    </div>
    {% endif %}

{% endblock %}
```

For more information and examples, have a look at [PagerFanta documentation](https://github.com/whiteoctober/Pagerfanta/blob/master/README.md).

### Adapters

|Adapter class name|Description|
|------|------|
|`eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchAdapter`|Makes the search against passed Query and returns [Content](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Content.php) objects.|
|`eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchHitAdapter`|Same as ContentSearchAdapter but returns instead [SearchHit](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Search/SearchHit.php) objects.|
|`eZ\Publish\Core\Pagination\Pagerfanta\LocationSearchAdapter`|Makes a Location search against passed Query and returns Location objects.|
|`eZ\Publish\Core\Pagination\Pagerfanta\LocationSearchHitAdapter`|Same as LocationSearchAdapter but returns instead [SearchHit](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Search/SearchHit.php) objects.|
