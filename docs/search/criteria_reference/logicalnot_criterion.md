# LogicalNot Criterion

The [`LogicalNot` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-LogicalNot.html)
matches content URL if the provided Criterion does not match.

It takes only one Criterion in the array parameter.

## Arguments

- `criterion` - represents the Criterion that should be negated

## Example

``` php
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