---
description: Events that are triggered when working with taxonomy.
---

# Taxonomy events

The following Events are dispatched when managing [taxonomy entries](taxonomy.md).

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateTaxonomyEntryEvent`|`TaxonomyService::createEntry`|`TaxonomyEntryCreateStruct $createStruct`</br>`?TaxonomyEntry $taxonomyEntry = null`|
|`CreateTaxonomyEntryEvent`|`TaxonomyService::createEntry`|`TaxonomyEntry $taxonomyEntry`</br>`TaxonomyEntryCreateStruct $createStruct`|
|`BeforeMoveTaxonomyEntryEvent`|`TaxonomyService::moveEntry`|`TaxonomyEntry $taxonomyEntry`</br>`TaxonomyEntry $newParent`|
|`MoveTaxonomyEntryEvent`|`TaxonomyService::moveEntry`|`TaxonomyEntry $taxonomyEntry`</br>`TaxonomyEntry $newParent`|
|`BeforeMoveTaxonomyEntryRelativeToSiblingEvent`|`TaxonomyService::moveEntryRelativeToSibling`|`TaxonomyEntry $taxonomyEntry`</br>`TaxonomyEntry $sibling`</br>`string $position`|
|`MoveTaxonomyEntryRelativeToSiblingEvent`|`TaxonomyService::moveEntryRelativeToSibling`|`TaxonomyEntry $taxonomyEntry`</br>`TaxonomyEntry $sibling`</br>`string $position`|
|`BeforeRemoveTaxonomyEntryEvent`|`TaxonomyService::removeEntry`|`TaxonomyEntry $taxonomyEntry`|
|`RemoveTaxonomyEntryEvent`|`TaxonomyService::removeEntry`|`TaxonomyEntry $taxonomyEntry`|
|`BeforeUpdateTaxonomyEntryEvent`|`TaxonomyService::updateEntry`|`TaxonomyEntry $taxonomyEntry`</br>`TaxonomyEntryUpdateStruct $updateStruct`</br>`?TaxonomyEntry $updatedTaxonomyEntry = null`|
|`UpdateTaxonomyEntryEvent`|`TaxonomyService::updateEntry`|`TaxonomyEntry $updatedTaxonomyEntry`</br>`TaxonomyEntry $taxonomyEntry`</br>`TaxonomyEntryUpdateStruct $updateStruct`|
