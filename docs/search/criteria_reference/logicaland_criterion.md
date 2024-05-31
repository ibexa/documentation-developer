# LogicalAnd Criterion

The [`LogicalAnd` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-LogicalAnd.html)
matches content if all provided Criteria match.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

### PHP

``` php
$query->query = new Criterion\LogicalAnd([
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
            <AND>
                <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
                <SectionIdentifierCriterion>news</SectionIdentifierCriterion>
            </AND>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    {
        "Query": {
            "Filter": {
                "AND": {
                    "ContentTypeIdentifierCriterion": "article",
                    "SectionIdentifierCriterion": "news"
                }
            }
        }
    }
    ```