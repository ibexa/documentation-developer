---
description: LanguageCode Search Criterion
---

# LanguageCode Criterion

The [`LanguageCode` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Location.html) searches for content based on whether it's translated into the selected language.

## Arguments

- `value` - string(s) representing the language codes to search for
- (optional) `matchAlwaysAvailable` - bool representing whether content with the `alwaysAvailable` flag should be returned even if it doesn't contain the selected language (default `true`)

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

## Use cases

You can use the `LanguageCode` Criterion to search for articles that are lacking a translation
into a specific language:

``` php hl_lines="5"
[[= include_file('code_samples/search/language/src/Controller/ArticlesToTranslateController.php', 24, 41) =]]
```

You can use the `LanguageCode` Criterion to search in
several languages while ensuring results have a translation in one specific language:

``` php hl_lines="3 6"
[[= include_file('code_samples/search/language/src/Command/SearchTestCommand.php', 35, 47) =]]
```
