# Create dashboard tab

Add a new tab to the back office dashboard that welcomes every user after logging in.

To create a new tab in the dashboard, create an `EveryoneArticleTab.php` file in `src/Tab/Dashboard/Everyone`. This adds a tab to the **Common content** dashboard block that displays all articles in the repository.

```php
<?php declare(strict_types=1);

namespace App\Tab\Dashboard\Everyone;

use Ibexa\AdminUi\Tab\Dashboard\PagerLocationToDataMapper;
use Ibexa\Contracts\AdminUi\Tab\AbstractTab;
use Ibexa\Contracts\AdminUi\Tab\OrderedTabInterface;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Core\Pagination\Pagerfanta\LocationSearchAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class EveryoneArticleTab extends AbstractTab implements OrderedTabInterface
{
    public function __construct(
        Environment $twig,
        TranslatorInterface $translator,
        protected PagerLocationToDataMapper $pagerLocationToDataMapper,
        protected SearchService $searchService
    ) {
        parent::__construct($twig, $translator);
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
            new LocationSearchAdapter(
                $query,
                $this->searchService
            )
        );
        $pager->setMaxPerPage($limit);
        $pager->setCurrentPage($page);

        return $this->twig->render('@ibexadesign/ui/dashboard/tab/all_content.html.twig', [
            'data' => $this->pagerLocationToDataMapper->map($pager, true),
        ]);
    }
}
```

This tab searches for content with content type "Article" (lines 50-53) and uses the built-in `all_content.html.twig` template to render the results, which ensures that the tab looks the same as the existing tabs (lines 64-66).

The tab also implements [`Ibexa\Contracts\AdminUi\Tab\OrderedTabInterface`](../../../../../../../ibexa/admin-ui/src/contracts/Tab/OrderedTabInterface.php) (line 17), which enables you to define the order in which the tab is displayed on the dashboard page. It's done with the `getOrder()` method (line 38).

Register this tab as a service:

```yaml
services:
    App\Tab\Dashboard\Everyone\EveryoneArticleTab:
        autowire: true
        autoconfigure: true
        public: false
        tags:
            - { name: ibexa.admin_ui.tab, group: dashboard-everyone }
```
