# Section events

Events that are triggered when working with sections.

| Event                      | Dispatched by                   | Properties                                                                               |
| -------------------------- | ------------------------------- | ---------------------------------------------------------------------------------------- |
| `BeforeCreateSectionEvent` | `SectionService::createSection` | `SectionCreateStruct $sectionCreateStruct` `?Section $section`                           |
| `CreateSectionEvent`       | `SectionService::createSection` | `SectionCreateStruct $sectionCreateStruct` `Section $section`                            |
| `BeforeDeleteSectionEvent` | `SectionService::deleteSection` | `Section $section`                                                                       |
| `DeleteSectionEvent`       | `SectionService::deleteSection` | `Section $section`                                                                       |
| `BeforeUpdateSectionEvent` | `SectionService::updateSection` | `Section $section` `SectionUpdateStruct $sectionUpdateStruct` `?Section $updatedSection` |
| `UpdateSectionEvent`       | `SectionService::updateSection` | `Section $section` `SectionUpdateStruct $sectionUpdateStruct` `Section $updatedSection`  |

## Assigning sections

| Event                               | Dispatched by                            | Properties                                    |
| ----------------------------------- | ---------------------------------------- | --------------------------------------------- |
| `BeforeAssignSectionEvent`          | `SectionService::assignSection`          | `ContentInfo $contentInfo` `Section $section` |
| `AssignSectionEvent`                | `SectionService::assignSection`          | `ContentInfo $contentInfo` `Section $section` |
| `BeforeAssignSectionToSubtreeEvent` | `SectionService::assignSectionToSubtree` | `Location $location` `Section $section`       |
| `AssignSectionToSubtreeEvent`       | `SectionService::assignSectionToSubtree` | `Location $location` `Section $section`       |
