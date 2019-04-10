# Step 2 - Creating a Dashboard tab

The Dashboard is the front page that you visit after logging in to the Back Office.
By default it contains two blocks: "Me" and "Everyone", which list Content items and Media.
The "Me" block additionally lists the current user's drafts.

![Unmodified dashboard](img/dashboard.png)

In this step you will add a new tab to the "Everyone" block in the Dashboard.
This tab, called "Articles", will list ten most recently modified Content items of the Content Type `article`.

!!! tip

    To be able to view the results of this step, create a few Content items of the type "Article".

## Register a service

First, add the following block to `src/EzSystems/ExtendingTutorialBundle/Resources/config/services.yml`,
which was created when [the bundle was generated](1_creating_a_bundle.md). Place the block indented, under the `services` key:

``` yml
EzSystems\ExtendingTutorialBundle\Tab\Dashboard\Everyone\EveryoneArticleTab:
    autowire: true
    autoconfigure: true
    public: false
    tags:
        - { name: ezplatform.tab, group: dashboard-everyone }
```

The tags indicate that this is a Dashboard tab that will be placed in the "Everyone" block.

This configuration points to the `EveryoneArticleTab.php` file, which you now need to create.

## Create a tab

Create an `EveryoneArticleTab.php` file in `src/EzSystems/ExtendingTutorialBundle/Tab/Dashboard/Everyone`:

``` php hl_lines="17 47"
<?php

namespace EzSystems\ExtendingTutorialBundle\Tab\Dashboard\Everyone;

use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchAdapter;
use EzSystems\EzPlatformAdminUi\Tab\AbstractTab;
use EzSystems\EzPlatformAdminUi\Tab\OrderedTabInterface;
use EzSystems\EzPlatformAdminUi\Tab\Dashboard\PagerContentToDataMapper;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Environment;

class EveryoneArticleTab extends AbstractTab implements OrderedTabInterface
{
    /** @var PagerContentToDataMapper */
    protected $pagerContentToDataMapper;

    /** @var SearchService */
    protected $searchService;

    public function __construct(
        Environment $twig,
        TranslatorInterface $translator,
        PagerContentToDataMapper $pagerContentToDataMapper,
        SearchService $searchService
    ) {
        parent::__construct($twig, $translator);

        $this->pagerContentToDataMapper = $pagerContentToDataMapper;
        $this->searchService = $searchService;
    }

    public function getIdentifier(): string
    {
        return 'everyone-article';
    }

    public function getName(): string
    {
        return 'Articles';
    }

    public function getOrder(): int
    {
        return 300;
    }

    public function renderView(array $parameters): string
    {
        $page = 1;
        $limit = 10;

        $query = new LocationQuery();

        $query->sortClauses = [new SortClause\DateModified(LocationQuery::SORT_DESC)];
        $query->query = new Criterion\LogicalAnd([
            new Criterion\ContentTypeIdentifier('article'),
        ]);

        $pager = new Pagerfanta(
            new ContentSearchAdapter($query,
                $this->searchService
            )
        );
        $pager->setMaxPerPage($limit);
        $pager->setCurrentPage($page);

        return $this->twig->render('EzPlatformAdminUiBundle:dashboard/tab:all_content.html.twig', [
            'data' => $this->pagerContentToDataMapper->map($pager),
        ]);
    }
}
```

!!! tip

    The tab extends `AbstractTab`.
    There are also [other tab types that you can extend](../../guide/extending_ez_platform.md#adding-a-new-tab).

The tab also implements `OrderedTabInterface` (see line 17), which enables you to define the order in which the tab is displayed in the Dashboard.
This is done using the `getOrder` method (see line 47).

The rendering is done using the built-in `all_content.html.twig` template,
which ensures the tab looks the same as the existing tabs.

## Check results

!!! tip

    If you cannot see the results or encounter an error, clear the cache and reload the application.

At this point you can go to the Dashboard in the Back Office.
In the "Everyone" block you can see the new "Articles" tab with the first ten articles in the Repository.

![Articles tab in the Dashboard](img/dashboard_articles_tab.png "Articles tab in the Dashboard")
