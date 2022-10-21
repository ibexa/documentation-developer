---
description: Using the PHP API you can browse taxonomy entries, get their information and manage them.
---

# Taxonomy API

To manage taxonomies, use `Ibexa\Contracts\Taxonomy\Service\TaxonomyServiceInterface`.

## Getting taxonomy entries

To get a single taxonomy entry, you can use `TaxonomyServiceInterface::loadEntryByIdentifier()`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TaxonomyCommand.php', 40, 43) =]]
```

To get all entries in a taxonomy, use `TaxonomyServiceInterface::loadAllEntries()` and provide it with the taxonomy identifier:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TaxonomyCommand.php', 38, 39) =]]
```

To get all children of a specific taxonomy entry, use `TaxonomyServiceInterface::loadEntryChildren()`. You provide it with the entry object, and optionally limit of results and their offset:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TaxonomyCommand.php', 44, 49) =]]
```

## Managing taxonomy entries

You can move a taxonomy entry to a different parent by using `TaxonomyServiceInterface::moveEntry`.
Provide the method with two objects: the entry that you want to move and the new parent entry:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/TaxonomyCommand.php', 50, 54) =]]
```
