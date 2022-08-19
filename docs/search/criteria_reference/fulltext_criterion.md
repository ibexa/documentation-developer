# FullText Criterion

The [`FullText` Search Criterion](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Criterion/FullText.php)
searches for content based on the full text content of its Fields.

## Arguments

- `value` - string to search for

## Supported syntax

All features of full text search syntax are available when using Solr search engine.
You can use the following features:

- Boolean operators: AND (&&), OR (||), NOT (!)
- Require/exclude operators: +, -
- Grouping with parentheses
- Phrase search with double quotes
- Asterisks (\*) as wildcards, located anywhere within a query

## Limitations

When using the Legacy search engine, a full text query performs an OR query by default, and
supports asterisks as wildcards located at the beginning or end of a query.

When using the Elasticsearch search engine, a full text query performs an OR query by default, while the OR and AND operators return unexpected results.

The `FullText` Criterion is not available in [Repository filtering](search_api.md#repository-filtering).

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
