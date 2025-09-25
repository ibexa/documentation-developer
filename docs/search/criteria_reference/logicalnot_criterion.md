---
description: LogicalNot Search Criterion
---

# LogicalNot Criterion

The [`LogicalNot` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-LogicalNot.html) matches content if the provided Criterion doesn't match.

It takes only one Criterion in the array parameter.

## Arguments

- `criterion` - represents the Criterion that should be negated

## Limitations

`LogicalNot` can be used on all search engines.

## Example

### PHP

```php
$query->filter = new Criterion\LogicalNot(
    new Criterion\ContentTypeIdentifier($contentTypeId)
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
