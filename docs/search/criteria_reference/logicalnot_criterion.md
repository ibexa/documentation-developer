---
description: LogicalNot Search Criterion
---

# LogicalNot Criterion

The `LogicalNot` Search Criterion matches content URL if the provided Criterion doesn't match.

It takes only one Criterion in the array parameter.

## Arguments

- `criterion` - represents the Criterion that should be negated

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

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
