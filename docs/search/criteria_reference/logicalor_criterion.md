---
description: LogicalOr Search Criterion
---

# LogicalOr Criterion

The `LogicalOr` Search Criterion matches content if at least one of the provided Criteria matches.

When querying for products, use LogicalOr instead.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

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
