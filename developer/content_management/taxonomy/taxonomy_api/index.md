# Taxonomy API

Using the PHP API you can browse taxonomy entries, get their information and manage them.

To manage taxonomies, use [`Ibexa\Contracts\Taxonomy\Service\TaxonomyServiceInterface`](../../../../../../ibexa/taxonomy/src/contracts/Service/TaxonomyServiceInterface.php).

## Getting taxonomy entries

To get a single taxonomy entry, you can use `TaxonomyServiceInterface::loadEntryById()`, and provide it with the numerical entry ID. Or pass entry identifier (with optionally a taxonomy identifier), and use `TaxonomyServiceInterface::loadEntryByIdentifier()`:

```php
$entry = $this->taxonomyService->loadEntryByIdentifier('desks');

$output->writeln($entry->name . ' with parent ' . $entry->parent->name);
```

> **Note: Note**
>
> A taxonomy entry identifier is unique per taxonomy. If you have [several taxonomies](../taxonomy/index.md#customize-taxonomy-structure), you can increase code readability by always passing the taxonomy identifier even when it's the default one. The default taxonomy is `tags` if it exists, else the first configured taxonomy (see `\Ibexa\Taxonomy\Service\TaxonomyConfiguration::getDefaultTaxonomyName` for details).
>
> ```php
> /**
>  * @var array<int, \Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry> $springs
>  * @var \Ibexa\Contracts\Taxonomy\Service\TaxonomyServiceInterface $taxonomyService
>  */
> $springs[] = $taxonomyService->loadEntryByIdentifier('spring', 'tags');
> $springs[] = $taxonomyService->loadEntryByIdentifier('spring', 'events');
> $springs[] = $taxonomyService->loadEntryByIdentifier('spring', 'devices');
> ```

You can also get a taxonomy entry from the ID of its underlying content item, by using `TaxonomyServiceInterface::loadEntryByContentId()`.

To get the root (main) entry of a given taxonomy, use `TaxonomyServiceInterface::loadRootEntry()` and provide it with the taxonomy name.

To get all entries in a taxonomy, use `TaxonomyServiceInterface::loadAllEntries()`, provide it with the taxonomy identifier, and optionally specify the limit of results and their offset. The default taxonomy identifier is given by `TaxonomyConfiguration::getDefaultTaxonomyName` and is `'tags'` on a fresh installation. The default limit is 30.

```php
$allEntries = $this->taxonomyService->loadAllEntries(null, 50);
```

To see how many entries is there, use `TaxonomyServiceInterface::countAllEntries()` with optionally a taxonomy identifier.

To get all children of a specific taxonomy entry, use `TaxonomyServiceInterface::loadEntryChildren()`, provide it with the entry object, and optionally specify the limit of results and their offset. The default limit is 30:

```php
$entryChildren = $this->taxonomyService->loadEntryChildren($entry, 10);

foreach ($entryChildren as $child) {
    $output->writeln($child->name);
}
```

## Managing taxonomy entries

You can move a taxonomy entry to a different parent by using `TaxonomyServiceInterface::moveEntry()`. Provide the method with two objects: the entry that you want to move and the new parent entry:

```php
$entryToMove = $this->taxonomyService->loadEntryByIdentifier('standing_desks');
$newParent = $this->taxonomyService->loadEntryByIdentifier('desks');

$this->taxonomyService->moveEntry($entryToMove, $newParent);
```

You can also move a taxonomy entry by passing its target sibling entry to `TaxonomyServiceInterface::moveEntry()`. The method takes as parameters the entry you want to move, the future sibling, and a `position` parameter, which is either `TaxonomyServiceInterface::MOVE_POSITION_NEXT` or `TaxonomyServiceInterface::MOVE_POSITION_PREV`:

```php
$sibling = $this->taxonomyService->loadEntryByIdentifier('school_desks');
$this->taxonomyService->moveEntryRelativeToSibling($entryToMove, $sibling, TaxonomyServiceInterface::MOVE_POSITION_PREV);
```

> **Note: Note**
>
> Taxonomy entry management functions triggers events you can listen to. For more information, see [Taxonomy events](../../../api/event_reference/taxonomy_events/index.md).

## Search

You can search for content based on its taxonomy entry assignments by using the standard [`SearchService`](../../../search/search_api/index.md) with taxonomy-specific Search Criteria:

| Criterion                                                                                               | Description                                                         |
| ------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------- |
| [TaxonomyEntryId](../../../search/criteria_reference/taxonomy_entry_id/index.md)     | Find content assigned to a specific taxonomy entry                  |
| [TaxonomyNoEntries](../../../search/criteria_reference/taxonomy_no_entries/index.md) | Find content that has no entries assigned from a given taxonomy     |
| [TaxonomySubtree](../../../search/criteria_reference/taxonomy_subtree/index.md)      | Find content assigned to a taxonomy entry or any of its descendants |

You can also use the [TaxonomyEntryId Aggregation](../../../search/aggregation_reference/taxonomyentryid_aggregation/index.md) to count content items per taxonomy entry.
