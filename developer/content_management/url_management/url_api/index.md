# URL API

The PHP API URLService enables searching for external URLs used in tech text and URL fields.

[`Ibexa\Contracts\Core\Repository\URLService`](../../../../../../ibexa/core/src/contracts/Repository/URLService.php) enables you to find, load and update external URLs used in RichText and URL fields.

To view a list of all URLs, use [`URLService::findUrls`](../../../../../../ibexa/core/src/contracts/Repository/URLService.php)

`URLService::findUrls` takes as argument a [`Ibexa\Contracts\Core\Repository\Values\URL\URLQuery`](../../../../../../ibexa/core/src/contracts/Repository/Values/URL/URLQuery.php), in which you need to specify:

- query filter, for example, Section
- Sort Clauses for URL queries
- offset for search hits, used for paging the results
- query limit. If value is `0`, search query doesn't return any search hits

```php
// ...
use Ibexa\Contracts\Core\Repository\URLService;
use Ibexa\Contracts\Core\Repository\Values\URL\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\URL\Query\SortClause;
use Ibexa\Contracts\Core\Repository\Values\URL\URLQuery;

// ...
        $query = new URLQuery();

        $query->filter = new Criterion\LogicalAnd(
            [
                new Criterion\SectionIdentifier(['standard']),
                new Criterion\Validity(true),
            ]
        );
        $query->sortClauses = [
            new SortClause\URL(SortClause::SORT_DESC),
        ];
        $query->offset = 0;
        $query->limit = 25;

        $results = $this->urlService->findUrls($query);
```

## URL search reference

For the reference of Search Criteria and Sort Clauses you can use in URL search, see [URL Search Criteria](../../../search/url_search_reference/url_search_criteria/index.md) and [URL Sort Clauses](../../../search/url_search_reference/url_search_sort_clauses/index.md).
