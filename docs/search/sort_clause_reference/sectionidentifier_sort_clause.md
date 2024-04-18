# SectionIdentifier Sort Clause

The [`SectionIdentifier` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/SectionIdentifier.php)
sorts search results by the Section IDs of the content items.

## Arguments

[[= include_file('docs/snippets/sort_direction.md') =]]

!!! note

    Solr search engine uses the `Query::SORT_DESC` sort direction by default.

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\SectionIdentifier()];
```
