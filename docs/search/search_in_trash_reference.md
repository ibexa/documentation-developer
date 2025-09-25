---
description: Trash Search Criteria and Sort Clauses help define and fine-tune search queries for content in trash.
page_type: reference
month_change: false
---

# Search in trash reference

When you [search for content items that are held in trash](search_api.md#searching-in-trash), you can apply only a limited subset of Search Criteria and Sort Clauses
which can be used by [`Ibexa\Contracts\Core\Repository\TrashService::findTrashItems`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-TrashService.html#method_findTrashItems).
Some sort clauses are exclusive to trash search.

!!! note

    Searching through the trashed content items operates directly on the database, therefore you cannot use external search engines, such as Solr or Elasticsearch, and it's impossible to reindex the data.

!!! caution

    Make sure that you set the Criterion on the `filter` property.
    It's impossible to use the `query` property, because the search in trash operation filters the database instead of querying.

For detailed information about available search options, see:

- [Trash Search Criteria](search_in_trash_reference/trash_criteria.md)
- [Trash Search Sort Clauses](search_in_trash_reference/trash_sort_clauses.md)
