# LanguageCode Criterion

The [`LanguageCode` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/Location.php)
searches for content based on whether it is translated into the selected language.

## Arguments

- `value` - string(s) representing the language codes to search for
- `matchAlwaysAvailable` - bool representing whether content with the `alwaysAvailable` flag
should be returned even if it does not contain the selected language (default `true`)

## Example

``` php
$query->query = new Criterion\LanguageCode('ger-DE', false);
```

## Use case

You can use the `LanguageCode` Criterion to search for articles that are lacking a translation
into a specific language:

``` php hl_lines="5"
$query = new LocationQuery;
$query->query = new Criterion\LogicalAnd([
    new Criterion\ContentTypeIdentifier('article'),
    new Criterion\LogicalNot(
        new Criterion\LanguageCode('ger-DE', false)
    )
    ]
);

$results = $this->searchService->findContent($query);
$articles = [];
foreach ($results->searchHits as $searchHit) {
    $articles[] = $searchHit;
}

return $this->render('list/articles_to_translate.html.twig', [
    'articles' => $articles,
]);
```
