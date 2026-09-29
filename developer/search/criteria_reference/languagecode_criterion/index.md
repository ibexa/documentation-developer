# LanguageCode Criterion

LanguageCode Search Criterion

The [`LanguageCode` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/Location.php) searches for content based on whether it's translated into the selected language.

## Arguments

- `value` - string(s) representing the language codes to search for
- (optional) `matchAlwaysAvailable` - bool representing whether content with the `alwaysAvailable` flag should be returned even if it doesn't contain the selected language (default `true`)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\LanguageCode('ger-DE', false);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <LanguageCodeCriterion>eng-GB</LanguageCodeCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "LanguageCodeCriterion": "eng-GB"
    }
}
```

## Use case

You can use the `LanguageCode` Criterion to search for articles that are lacking a translation into a specific language:

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new LocationQuery();
$query->query = new Criterion\LogicalAnd(
    [
    new Criterion\ContentTypeIdentifier('article'),
    new Criterion\LogicalNot(
        new Criterion\LanguageCode('ger-DE', false)
    ),
    ]
);

/** @var \Ibexa\Contracts\Core\Repository\SearchService $searchService */
$results = $searchService->findContent($query);
$articlesToTranslate = [];
foreach ($results->searchHits as $searchHit) {
    $articlesToTranslate[] = $searchHit;
}

return $articlesToTranslate;
```
