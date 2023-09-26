# FullText Criterion

The [`FullText` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/FullText.php)
searches for content based on the full text content of its Fields.

## Arguments

- `value` - string to search for

## Supported syntax

| Feature                                              | Elasticsearch | Apache Solr | Legacy Search Engine (SQL) |
|------------------------------------------------------|---------------|-------------|----------------------------|
| Boolean operators:<br/>AND (&&), OR ( \|\|), NOT (!) | no\*          | yes         | no\*\*                     |
| Require/exclude operators: +, -                      | no            | yes         | no                         |
| Grouping with parentheses                            | no            | Yes         | no                         |
| Phrase search with double quotes                     | no            | yes         | no                         |
| Asterisks (\*) as wildcards                          | no            | Yes         | Yes, limited\*\*\*         |

\* When using the Elasticsearch search engine, a full text query performs an OR query by default, while the OR and AND operators return unexpected results.
\*\* When using the Legacy search engine, a full text query performs an OR query.
\*\*\* Asteriks may only be located at beginning or end of a query.


## Limitations

The `FullText` Criterion is not available in [Repository filtering](../../../api/public_php_api_search.md#repository-filtering).

## Example

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

## Use cases

Assume the following search query:

``` php
$query->query = new Criterion\FullText('(cup AND ba*ball) "breaking news"');
```

It will return content containing phrases such as "Breaking news", "Baseball world cup", "Basketball cup",
or "Breaking news: Baseball world cup victory".

It will not return content with phrases such as "Football world cup" or "Breaking sports news".
