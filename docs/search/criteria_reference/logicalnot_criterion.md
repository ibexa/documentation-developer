---
description: LogicalNot Search Criterion
---

# LogicalNot Criterion

The `LogicalNot` Search Criterion matches content URL if the provided Criterion doesn't match.

It takes only one Criterion in the array parameter.

## Arguments

- `criterion` - represents the Criterion that should be negated

## Example

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
