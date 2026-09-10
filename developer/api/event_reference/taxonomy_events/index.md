# Taxonomy events

Events that are triggered when working with taxonomy.

The following Events are dispatched when managing [taxonomy entries](../../../content_management/taxonomy/taxonomy/index.md).

| Event                                           | Dispatched by                                 | Properties                                                                                                             |
| ----------------------------------------------- | --------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------- |
| `BeforeCreateTaxonomyEntryEvent`                | `TaxonomyService::createEntry`                | `TaxonomyEntryCreateStruct $createStruct` `?TaxonomyEntry $taxonomyEntry = null`                                       |
| `CreateTaxonomyEntryEvent`                      | `TaxonomyService::createEntry`                | `TaxonomyEntry $taxonomyEntry` `TaxonomyEntryCreateStruct $createStruct`                                               |
| `BeforeMoveTaxonomyEntryEvent`                  | `TaxonomyService::moveEntry`                  | `TaxonomyEntry $taxonomyEntry` `TaxonomyEntry $newParent`                                                              |
| `MoveTaxonomyEntryEvent`                        | `TaxonomyService::moveEntry`                  | `TaxonomyEntry $taxonomyEntry` `TaxonomyEntry $newParent`                                                              |
| `BeforeMoveTaxonomyEntryRelativeToSiblingEvent` | `TaxonomyService::moveEntryRelativeToSibling` | `TaxonomyEntry $taxonomyEntry` `TaxonomyEntry $sibling` `string $position`                                             |
| `MoveTaxonomyEntryRelativeToSiblingEvent`       | `TaxonomyService::moveEntryRelativeToSibling` | `TaxonomyEntry $taxonomyEntry` `TaxonomyEntry $sibling` `string $position`                                             |
| `BeforeRemoveTaxonomyEntryEvent`                | `TaxonomyService::removeEntry`                | `TaxonomyEntry $taxonomyEntry`                                                                                         |
| `RemoveTaxonomyEntryEvent`                      | `TaxonomyService::removeEntry`                | `TaxonomyEntry $taxonomyEntry`                                                                                         |
| `BeforeUpdateTaxonomyEntryEvent`                | `TaxonomyService::updateEntry`                | `TaxonomyEntry $taxonomyEntry` `TaxonomyEntryUpdateStruct $updateStruct` `?TaxonomyEntry $updatedTaxonomyEntry = null` |
| `UpdateTaxonomyEntryEvent`                      | `TaxonomyService::updateEntry`                | `TaxonomyEntry $updatedTaxonomyEntry` `TaxonomyEntry $taxonomyEntry` `TaxonomyEntryUpdateStruct $updateStruct`         |
