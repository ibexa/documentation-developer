---
description: LanguageCode Search Criterion
---

# LanguageCode Criterion

The `LanguageCode` Search Criterion searches for content based on whether it's translated into the selected language.

## Arguments

- `value` - string(s) representing the language codes to search for
- (optional) `matchAlwaysAvailable` - bool representing whether content with the `alwaysAvailable` flag should be returned even if it doesn't contain the selected language (default `true`)

## Example

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
into a specific language, by negating it and setting `matchAlwaysAvailable` to `false`.
