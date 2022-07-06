---
description: Events that are triggered when working with Sections.
---

# Section events

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateSectionEvent`|`SectionService::createSection`|`SectionCreateStruct $sectionCreateStruct`</br>`Section|null $section`|
|`CreateSectionEvent`|`SectionService::createSection`|`SectionCreateStruct $sectionCreateStruct`</br>`Section $section`|
|`BeforeDeleteSectionEvent`|`SectionService::deleteSection`|`Section $section`|
|`DeleteSectionEvent`|`SectionService::deleteSection`|`Section $section`|
|`BeforeUpdateSectionEvent`|`SectionService::updateSection`|`Section $section`</br>`SectionUpdateStruct $sectionUpdateStruct`</br>`Section|null $updatedSection`|
|`UpdateSectionEvent`|`SectionService::updateSection`|`Section $section`</br>`SectionUpdateStruct $sectionUpdateStruct`</br>`Section $updatedSection`|

## Assigning Sections

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeAssignSectionEvent`|`SectionService::assignSection`|`ContentInfo $contentInfo`</br>`Section $section`|
|`AssignSectionEvent`|`SectionService::assignSection`|`ContentInfo $contentInfo`</br>`Section $section`|
|`BeforeAssignSectionToSubtreeEvent`|`SectionService::assignSectionToSubtree`|`Location $location`</br>`Section $section`|
|`AssignSectionToSubtreeEvent`|`SectionService::assignSectionToSubtree`|`Location $location`</br>`Section $section`|
