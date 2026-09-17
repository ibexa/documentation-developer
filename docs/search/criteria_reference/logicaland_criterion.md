---
description: LogicalAnd Search Criterion
---

# LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches content if all provided Criteria match.

When querying for products, use LogicalAnd instead.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

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
