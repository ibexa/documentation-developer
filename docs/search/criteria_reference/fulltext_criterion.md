---
description: Full-Text Search Criterion
---

# Full-Text Criterion

The `FullText` Search Criterion searches for content based on the full text content of its fields.

## Arguments

- `value` - string to search for

## Supported syntax

| Feature                                              | Elasticsearch | Apache Solr | Legacy Search Engine (SQL) |
|------------------------------------------------------|---------------|-------------|----------------------------|
| Boolean operators:<br/>AND (&&), OR ( \|\|), NOT (!) | No\*          | Yes         | No\*\*                     |
| Require/exclude operators: +, -                      | No            | Yes         | No                         |
| Grouping with parentheses                            | No            | Yes         | No                         |
| Phrase search with double quotes                     | No            | Yes         | No                         |
| Asterisks (\*) as wildcards                          | No            | Yes         | Yes, limited\*\*\*         |

\* When using the Elasticsearch search engine, a full text query performs an OR query by default, while the OR and AND operators return unexpected results.

\*\* When using the Legacy search engine, a full text query performs an OR query.

\*\*\* Asterisk may only be located at the beginning or end of a query.

## Limitations

When using the Legacy search engine, a full text query performs an OR query by default, and
supports asterisks as wildcards located at the beginning or end of a query.

When using the Elasticsearch search engine, a full text query performs an OR query by default, while the OR and AND operators return unexpected results.

## Example

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
