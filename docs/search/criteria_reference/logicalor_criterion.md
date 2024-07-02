# LogicalOr Criterion

The [`LogicalOr` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-LogicalOr.html)
matches content if at least one of the provided Criteria matches.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
$query->filter = new Criterion\LogicalOr([
        new Criterion\ContentTypeIdentifier('article'),
        new Criterion\SectionIdentifier(['sports', 'news']);
    ]
);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <OR>
                <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
                <SectionIdentifierCriterion>news</SectionIdentifierCriterion>
            </OR>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    {
        "Query": {
            "Filter": {
                "OR": {
                    "ContentTypeIdentifierCriterion": "article",
                    "SectionIdentifierCriterion": "news"
                }
            }
        }
    }
    ```