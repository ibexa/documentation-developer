---
description: Using the PHP API you can browse taxonomy entries, get their information and manage them.
---

# Taxonomy API

To manage taxonomies, use `Ibexa\Contracts\Taxonomy\Service\TaxonomyServiceInterface`.

## Getting taxonomy entries

To get a single taxonomy entry, you can use `TaxonomyServiceInterface::loadEntryById()`,
and provide it with the numerical entry ID.
Or pass entry identifier (with optionally a taxonomy identifier),
and use `TaxonomyServiceInterface::loadEntryByIdentifier()`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TaxonomyCommand.php', 43, 46) =]]
```

!!! note

    A taxonomy entry identifier is unique per taxonomy. If you have [several taxonomies](taxonomy.md#customize-taxonomy-structure), you can increase code readability by always passing the taxonomy identifier even when it's the default one. The default taxonomy is `tags` if it exists, else the first configured taxonomy (see `\Ibexa\Taxonomy\Service\TaxonomyConfiguration::getDefaultTaxonomyName` for details).
    ``` php
    $springs[] = $this->taxonomyService->loadEntryByIdentifier('spring', 'tags');
    $springs[] = $this->taxonomyService->loadEntryByIdentifier('spring', 'events');
    $springs[] = $this->taxonomyService->loadEntryByIdentifier('spring', 'devices');
    ```

You can also get a taxonomy entry from the ID of its underlying content item, by using `TaxonomyServiceInterface::loadEntryByContentId()`.

To get the root (main) entry of a given taxonomy, use `TaxonomyServiceInterface::loadRootEntry()`
and provide it with the taxonomy name.

To get all entries in a taxonomy, use `TaxonomyServiceInterface::loadAllEntries()`, provide it with the taxonomy identifier,
and optionally specify the limit of results and their offset.
The default taxonomy identifier is given by `TaxonomyConfiguration::getDefaultTaxonomyName` and is `'tags'` on a fresh installation.
The default limit is 30.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TaxonomyCommand.php', 41, 42) =]]
```

To see how many entries is there, use `TaxonomyServiceInterface::countAllEntries()` with optionally a taxonomy identifier.

To get all children of a specific taxonomy entry, use `TaxonomyServiceInterface::loadEntryChildren()`,
provide it with the entry object, and optionally specify the limit of results and their offset.
The default limit is 30:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TaxonomyCommand.php', 48, 53) =]]
```

## Managing taxonomy entries

You can move a taxonomy entry to a different parent by using `TaxonomyServiceInterface::moveEntry()`.
Provide the method with two objects: the entry that you want to move and the new parent entry:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TaxonomyCommand.php', 54, 58) =]]
```

You can also move a taxonomy entry by passing its target sibling entry to `TaxonomyServiceInterface::moveEntry()`.
The method takes as parameters the entry you want to move, the future sibling,
and a `position` parameter, which is either `TaxonomyServiceInterface::MOVE_POSITION_NEXT` or `TaxonomyServiceInterface::MOVE_POSITION_PREV`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TaxonomyCommand.php', 59, 61) =]]
```

!!! note

    Taxonomy entry management functions triggers events you can listen to.
    For more information, see [Taxonomy events](taxonomy_events.md).
