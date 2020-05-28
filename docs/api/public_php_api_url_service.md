# URLService

[`URLService`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/URLService.php)
enables you to find, load and update external URLs used in RichText and URL Fields.

To view a list of all URLs, use [`URLService::findUrls`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/URLService.php#L38)

`URLService::findUrls` takes as argument a [`URLQuery`,](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/URL/URLQuery.php)
in which you need to specify:

- query filter e.g. Section
- Sort Clauses for URL queries
- offset for search hits, used for paging the results
- query limit. If value is `0`, search query will not return any search hits

```php
use eZ\Publish\API\Repository\Values\URL\URLQuery;
use eZ\Publish\API\Repository\Values\URL\Query\Criterion;
use eZ\Publish\API\Repository\Values\URL\Query\SortClause; 

# ...

$urlQuery = new URLQuery();
$urlQuery->filter = new Criterion\LogicalAnd([
    new Criterion\SectionIdentifier(['standard']),
    new Criterion\Validity(true),
]);
$urlQuery->sortClauses = [
    new SortClause\URL(SortClause::SORT_DESC)
];
$urlQuery->offset = 0;
$urlQuery->limit = 25;

$results = $urlService->findUrls($urlQuery);
```

## URL criteria reference

|URL criteria|URL based on|
|------------|------------|
|[LogicalAnd](url_reference/logicaland_criterion.md)|This criterion implements a logical AND criterion. It matches if ALL of the provided criteria match.|
|[LogicalNot](url_reference/logicalnot_criterion.md)|This criterion implements a logical NOT criterion. It matches if the provided criterion doesn't match.|
|[LogicalOr](url_reference/logicalor_criterion.md)|This criterion implements a logical OR criterion. It matches if at least one of the provided criteria match.|
|[MatchAll](url_reference/matchall_criterion.md)|Returns all URL results.|
|[MatchNone](url_reference/matchnone_criterion.md)|Returns no URL results.|
|[Pattern](url_reference/pattern_criterion.md)|Matches URLs that contain a pattern.|
|[SectionId](url_reference/sectionid_criterion.md)|Matches URLs from a content placed in a specified Section ID.|
|[SectionIdentifier](url_reference/sectionidentifier_criterion.md)|Matches URLs from a content placed in a specified Section identifiers.|
|[Validity](url_reference/validity_criterion.md)|Matches URLs based on validity flag.|
|[VisibleOnly](url_reference/visibleonly_criterion.md)|Matches URLs from published content.|

## URL Sort Clauses reference

Sort Clauses are the sorting options for URLs.

All Sort Clauses can take the following optional argument:

- `sortDirection` - the direction of the sorting, either `\eZ\Publish\API\Repository\Values\URL\Query\SortClause::SORT_ASC` (default) or `\eZ\Publish\API\Repository\Values\URL\Query\SortClause::SORT_DESC`

#### Sort Clauses 

| Sort Clause | Sorting based on |
|-----|-----|
|[Id](url_reference/id_sort_clause.md)|URL ID|
|[URL](url_reference/url_sort_clause.md)|URL address|
