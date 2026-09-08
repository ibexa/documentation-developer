---
description: LogicalOr Search Criterion
---

# LogicalOr Criterion

The `LogicalOr` Search Criterion matches content if at least one of the provided Criteria matches.

When querying for products, use LogicalOr instead.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

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
