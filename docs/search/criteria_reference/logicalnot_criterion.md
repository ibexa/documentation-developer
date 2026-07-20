---
description: LogicalNot Search Criterion
---

# LogicalNot Criterion

The [`LogicalNot` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-LogicalNot.html) matches content URL if the provided Criterion doesn't match.

It takes only one Criterion in the array parameter.

## Arguments

- `criterion` - represents the Criterion that should be negated

## Example

``` php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$contentTypeIdentifier = 'article';

$query = new Query();
$query->filter = new Criterion\LogicalNot(
    new Criterion\ContentTypeIdentifier($contentTypeIdentifier)
);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Criterion>
            <LogicalNotCriterion>
                <ContentTypeIdentifierCriterion>article</ContentTypeIdentifierCriterion>
            </LogicalNotCriterion>
        </Criterion>
    </Query>
    ```

=== "JSON"

    ```json
    {
      "Query": {
        "Criterion": {
          "LogicalNotCriterion": {
            "ContentTypeIdentifierCriterion": "article"
          }
        }
      }
    }
    ```
