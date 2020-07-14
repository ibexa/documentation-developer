# FullText Criterion

The [`FullText` Search Criterion](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Query/Criterion/FullText.php)
searches for content based on the full text content of its Fields.

## Arguments

- `value` - string to search for

## Limitations

When using Legacy search engine, basic full text query is performed.

Basic query by default performs an OR query.
It supports basic wildcards using asterisks (\*) at the beginning or end of a query.

Advanced full text query is available when using Solr search engine.
It additionally enables the use of:

- Boolean operators: AND (&&), OR (||), NOT (!)
- Required/prohibit operators: +, -
- Grouping through parentheses
- Phrases using double quotes
- Wild cards using asterisks also in the middle of a query

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
