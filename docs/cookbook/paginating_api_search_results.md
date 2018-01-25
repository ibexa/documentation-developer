# Paginating API search results

When listing content (e.g. blog posts), pagination is a very common use case and can be difficult to implement by hand.

To avoid duplicating work, it is recommended to use the [Pagerfanta library](https://github.com/whiteoctober/Pagerfanta) and [eZ Platform's adapters for it](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/Core/Pagination/Pagerfanta).

The following example shows how to use pagination on a list of all Articles in the site.

``` php
<?php

namespace AppBundle\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchAdapter;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta;

class ArticleListController extends Controller
{
    public function myContentListAction(Request $request, $locationId, $viewType, $layout = false, array $params = [])
    {
        // First build the search query.
        // Let's search for articles, sorted by publication date.
        $query = new Query();
        $query->filter = new Criterion\ContentTypeIdentifier('article');
        $query->sortClauses = [
            new SortClause\DatePublished()
        ];

        // Initialize the pager.
        // Pass the ContentSearchAdapter to it.
        // ContentSearchAdapter is built with your search query and the SearchService.
        $pager = new Pagerfanta(
            new ContentSearchAdapter($query, $this->getRepository()->getSearchService())
        );
        // Let's list only 2 articles per page, to quickly see the results
        $pager->setMaxPerPage(2);
        // Get the "page" query parameter as current page or default to page 1
        $pager->setCurrentPage($request->get('page', 1));

        return $this->render('full/article_list.html.twig', [
                'totalArticleCount' => $pager->getNbResults(),
                'pagerArticle' => $pager,
                'location' => $this->getRepository()->getLocationService()->loadLocation($locationId),
            ] + $params
        );
    }
}
```

``` php
{% block content %}
    <h1>Listing all articles: {{ totalArticleCount }} articles found.</h1>

    <div>
        <ul>
        {# Loop over the page results #}
        {% for article in pagerArticle %}
            <li><a href={{ path('ez_urlalias', {'contentId': article.contentInfo.id}) }}>{{ez_content_name( article ) }}</a></li>
        {% endfor %}
        </ul>
    </div>
 
    {# Only display Pagerfanta navigator if needed. #}
    {% if pagerArticle.haveToPaginate() %}
    <div class="pagerfanta">
        {{ pagerfanta( pagerArticle, 'twitter_bootstrap_translated', {'routeName': location} ) }}
    </div>
    {% endif %}

{% endblock %}
```

For more information and examples, have a look at [PagerFanta documentation](https://github.com/whiteoctober/Pagerfanta/blob/master/README.md).

### Adapters

|Adapter class name|Description|
|------|------|
|`eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchAdapter`|Makes a search against passed Query and returns [Content](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Content.php) objects.|
|`eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchHitAdapter`|Same as ContentSearchAdapter but returns [SearchHit](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Search/SearchHit.php) objects instead.|
|`eZ\Publish\Core\Pagination\Pagerfanta\LocationSearchAdapter`|Makes a Location search against passed Query and returns Location objects.|
|`eZ\Publish\Core\Pagination\Pagerfanta\LocationSearchHitAdapter`|Same as LocationSearchAdapter but returns [SearchHit](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Search/SearchHit.php) objects instead.|
