# LanguageCode Criterion

The [`LanguageCode` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Location.html)
searches for content based on whether it is translated into the selected language.

## Arguments

- `value` - string(s) representing the language codes to search for
- (optional) `matchAlwaysAvailable` - bool representing whether content with the `alwaysAvailable` flag
should be returned even if it does not contain the selected language (default `true`)

## Example

### PHP

``` php
$query->query = new Criterion\LanguageCode('ger-DE', false);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <LanguageCodeCriterion>eng-GB</LanguageCodeCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "LanguageCodeCriterion": "eng-GB"
        }
    }
    ```

## Use case

You can use the `LanguageCode` Criterion to search for articles that are lacking a translation
into a specific language:

``` php hl_lines="5"
$query = new Query();
$query->query = new Criterion\LogicalAnd([
    new Criterion\ContentTypeIdentifier('article'),
    new Criterion\LogicalNot(
        new Criterion\LanguageCode('ger-DE', false)
    )
]);

$results = $this->searchService->findContent($query);
$articles = [];
foreach ($results->searchHits as $searchHit) {
    $articles[] = $searchHit;
}

return $this->render('list/articles_to_translate.html.twig', [
    'articles' => $articles,
]);
```

You can use the `LanguageCode` Criterion to search in
several languages while ensuring result have a translation in one language:

```php
$query = new Query(['query' =>
    new Criterion\LogicalAnd([
        new Criterion\FullText($text),
        new Criterion\LanguageCode(['eng-GB'], false)
    ])
]);

$results = $this->searchService->findContent($query, ['eng-GB', 'fre-FR', 'ger-DE']);

foreach ($results->searchHits as $searchHit) {
    /** @var $content \Ibexa\Core\Repository\Values\Content\Content */
    $content = $searchHit->valueObject;
    dump($content->getName('eng-GB'));
}
```
