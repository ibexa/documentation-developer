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

$results = $this->URLService->findUrls($urlQuery);
```

## URL criteria

|URL criteria|URL based on|
|------------|------------|
|LogicalAnd||
|LogicalNot||
|LogicalOperator||
|LogicalOr||
|MatchAll||
|MatchNone||
|Matcher||
|Pattern|Matches URLs which contain the pattern.|
|SectionId|Matches URLs which used by content placed in specified section ids.|
|SectionIdentifier|Matches URLs which used by content placed in specified section identifiers.|
|Validity|Matches URLs based on validity flag.|
|VisibleOnly|Matches URLs which are used in published content.|

## URL sort clauses

