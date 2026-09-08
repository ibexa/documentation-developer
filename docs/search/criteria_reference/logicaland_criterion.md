---
description: LogicalAnd Search Criterion
---

# LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches content if all provided Criteria match.

When querying for products, use LogicalAnd instead.

## Arguments

- `criterion` - a set of Criteria combined by the logical operator

## Example

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
