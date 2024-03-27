# FullText Criterion

The [`FullText` Search Criterion](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-FullText.html)
searches for content based on the full text content of its Fields.

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

\*\*\* Asteriks may only be located at the beginning or end of a query.


## Limitations

When using the Legacy search engine, a full text query performs an OR query by default, and
supports asterisks as wildcards located at the beginning or end of a query.

When using the Elasticsearch search engine, a full text query performs an OR query by default, while the OR and AND operators return unexpected results.

The `FullText` Criterion is not available in [Repository filtering](search_api.md#repository-filtering).

## Example

### PHP

``` php
$query->query = new Criterion\FullText('victory');
```

Using double quotes to indicate a phrase:

``` php
$query->query = new Criterion\FullText('"world cup"');
```

Using the AND operator and parenthesis to search for both words at the same time:

``` php
$query->query = new Criterion\FullText('baseball AND cup');
```

### REST API

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

Assume the following search query:

``` php
$query->query = new Criterion\FullText('(cup AND ba*ball) "breaking news"');
```

It will return content containing phrases such as "Breaking news", "Baseball world cup", "Basketball cup",
or "Breaking news: Baseball world cup victory".

It will not return content with phrases such as "Football world cup" or "Breaking sports news".
