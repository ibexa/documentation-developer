---
description: Full-Text Search Criterion
---

# Full-Text Criterion

The `FullText` Search Criterion searches for content based on the full text content of its fields.

## Arguments

- `value` - string to search for

## Supported syntax

A full-text query supports the following syntax:

- Boolean operators: `AND` (`&&`), `OR` (`||`), `NOT` (`!`)
- Require and exclude operators: `+`, `-`
- Grouping with parentheses
- Phrase search with double quotes
- Asterisks (`*`) as wildcards

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <FullTextCriterion>victory</FullTextCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "FullTextCriterion": "victory"
        }
    }
    ```

## Use cases

Assume a full-text search for `(cup AND ba*ball) "breaking news"`,
which combines grouping, the `AND` operator, a wildcard, and a quoted phrase.

It returns content containing phrases such as "Breaking news", "Baseball world cup", "Basketball cup",
or "Breaking news: Baseball world cup victory".

It doesn't return content with phrases such as "Football world cup" or "Breaking sports news".
