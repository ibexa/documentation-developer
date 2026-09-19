# Create custom Sort Clause

Create custom Sort Clause to use with Solr and Elasticsearch search engines.

To create a custom Sort Clause, do the following.

## Create Sort Clause class

First, add a `ScoreSortClause.php` file with the Sort Clause class:

```php
<?php

declare(strict_types=1);

namespace App\Query\SortClause;

use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

final class ScoreSortClause extends SortClause
{
    public function __construct(string $sortDirection = Query::SORT_ASC)
    {
        parent::__construct('_score', $sortDirection);
    }
}
```

## Create Sort Clause visitor

Then, add a `ScoreVisitor` class that implements `SortClauseVisitor`:

**Solr**

```php
<?php

declare(strict_types=1);

namespace App\Query\SortClause\Solr;

use App\Query\SortClause\ScoreSortClause;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Solr\Query\SortClauseVisitor;

class ScoreVisitor extends SortClauseVisitor
{
    public function canVisit(SortClause $sortClause): bool
    {
        return $sortClause instanceof ScoreSortClause;
    }

    public function visit(SortClause $sortClause): string
    {
        return 'score ' . $this->getDirection($sortClause);
    }
}
```

**Elasticsearch**

```php
<?php

declare(strict_types=1);

namespace App\Query\SortClause\Elasticsearch;

use App\Query\SortClause\ScoreSortClause;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Elasticsearch\Query\LanguageFilter;
use Ibexa\Contracts\Elasticsearch\Query\SortClauseVisitor;

final class ScoreVisitor implements SortClauseVisitor
{
    public function supports(SortClause $sortClause, LanguageFilter $languageFilter): bool
    {
        return $sortClause instanceof ScoreSortClause;
    }

    public function visit(SortClauseVisitor $visitor, SortClause $sortClause, LanguageFilter $languageFilter): array
    {
        $order = $sortClause->direction === Query::SORT_ASC ? 'asc' : 'desc';

        return [
            '_score' => [
                'order' => $order,
            ],
        ];
    }
}
```

The `supports()` method checks if the implementation can handle the given Sort Clause. The `visit()` method contains the logic that translates Sort Clause information into data understandable by the search engine. The `visit()` method takes the Sort Clause visitor, the Sort Clause itself and the language filter as arguments.

Finally, register the visitor as a service.

Sort Clauses can be valid for both content and Location search. To choose the search type, use either `content` or `location` in the tag when registering the visitor as a service:

**Solr**

```yaml
services:
    App\Query\SortClause\Solr\ScoreVisitor:
    tags:
        - { name: ibexa.search.solr.query.content.sort_clause.visitor }
        - { name: ibexa.search.solr.query.location.sort_clause.visitor }
```

**Elasticsearch**

```yaml
services:
    App\Query\SortClause\Elasticsearch\ScoreVisitor:
    tags:
        - { name: ibexa.search.elasticsearch.query.content.sort_clause.visitor }
        - { name: ibexa.search.elasticsearch.query.location.sort_clause.visitor }
```
