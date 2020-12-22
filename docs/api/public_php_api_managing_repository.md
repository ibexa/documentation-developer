# Managing the Repository

## Sections

[Sections](../guide/admin_panel.md#sections) enable you to divide content into groups
which can later be used e.g. as basis for permissions.

### Creating Sections

To create a new Section, you need to make use of the [`SectionCreateStruct`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/SectionCreateStruct.php)
and pass it to the [`SectionService::createSection`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/SectionService.php#L32) method:

``` php 
$sectionCreateStruct = $this->sectionService->newSectionCreateStruct();
$sectionCreateStruct->name = 'New section';
$sectionCreateStruct->identifier = 'newsection';
$this->sectionService->createSection($sectionCreateStruct);
```

### Getting Section information

You can use `SectionService` to retrieve Section information such as whether it is in use:

``` php
$output->writeln(($this->sectionService->isSectionUsed($section) ? 'This section is in use.' : 'This section is not in use.'));
```

### Listing content in a Section

To list Content items assigned to a Section you need to make a [query](public_php_api_search.md)
for content belonging to this section, by applying the [`SearchService`.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/SearchService.php)
You can also use the query to get the total number of assigned Content items:

``` php
$query = new LocationQuery();
$query->filter = new Criterion\SectionId([
    $section->id,
]);

$result = $this->searchService->findContentInfo($query);
$output->writeln('Number of Content items in this section: ' . $result->totalCount);

foreach ($result->searchHits as $seachResult) {
    $output->writeln($seachResult->valueObject->name);
}
```

### Assigning Section to content

To assign content to a Section, use the [`SectionService::assignSection`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/SectionService.php#L110) method.
You need to provide it with the `ContentInfo` object of the Content item,
and the [`Section`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/Section.php) object:

``` php
$contentInfo = $this->contentService->loadContentInfo($contentId);
$section = $this->sectionService->loadSectionByIdentifier($sectionIdentifier);
$this->sectionService->assignSection($contentInfo, $section);
```

Note that assigning a Section to content does not automatically assign it to the Content item's children.

## Object states

[Object states](../guide/admin_panel.md#object-states)  enable you to set a custom state to any content.
States are grouped into Object state groups.

### Getting Object state information

You can use the [`ObjectStateService`](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/ObjectStateService.php)
to get information about Object state groups or Object states.

``` php
$objectStateGroup = $this->objectStateService->loadObjectStateGroupByIdentifier('ez_lock');
$output->writeln($objectStateGroup->getName());

$objectState = $this->objectStateService->loadObjectStateByIdentifier($objectStateGroup, 'locked');
$output->writeln($objectState->getName());
```

### Creating Object states

To create an Object state group and add Object states to it,
you need to make use of the [`ObjectStateService`:](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ObjectStateService.php)

``` php
$objectStateGroupStruct = $this->objectStateService->newObjectStateGroupCreateStruct('rank');
$objectStateGroupStruct->defaultLanguageCode = 'eng-GB';
$objectStateGroupStruct->names = ['eng-GB' => 'rank'];
$this->objectStateService->createObjectStateGroup($objectStateGroupStruct);
```

[`ObjectStateService::createObjectStateGroup`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ObjectStateService.php#L36)
takes as argument an [`ObjectStateGroupCreateStruct`,](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/ObjectState/ObjectStateGroupCreateStruct.php)
in which you need to specify the identifier, default language and at least one name for the group.

To create an Object state inside a group,
use [`ObjectStateService::newObjectStateCreateStruct`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ObjectStateService.php#L210)
and provide it with an `ObjectStateCreateStruct`:

``` php
$objectStateGroup = $this->objectStateService->loadObjectStateGroup($objectStateGroupId);

$stateRegularStruct = $this->objectStateService->newObjectStateCreateStruct('regular');
$stateRegularStruct->defaultLanguageCode = 'eng-GB';
$stateRegularStruct->names = ['eng-GB' => 'regular'];
$this->objectStateService->createObjectState($objectStateGroup, $stateRegularStruct);

$stateSpecialStruct = $this->objectStateService->newObjectStateCreateStruct('special');
$stateSpecialStruct->defaultLanguageCode = 'eng-GB';
$stateSpecialStruct->names = ['eng-GB' => 'special'];
$this->objectStateService->createObjectState($objectStateGroup, $stateSpecialStruct);
```

### Assigning Object state

To assign an Object state to a Content item,
use [`ObjectStateService::setContentState`.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/ObjectStateService.php#L164)
Provide it with a `ContentInfo` object of the Content item, the Object state group and the Object state:

``` php
$contentInfo = $this->contentService->loadContentInfo($contentId);
$objectStateGroup = $this->objectStateService->loadObjectStateGroup($objectStateGroupId);
$objectState = $this->objectStateService->loadObjectState($objectStateId);

$this->objectStateService->setContentState($contentInfo, $objectStateGroup, $objectState);
```

## Workflow

### Getting workflow information

To get information about a specific workflow for a Content item, use `WorkflowServiceInterface::loadWorkflowMetadataForContent`:

``` php
$workflowMetadata = $this->workflowService->loadWorkflowMetadataForContent($content, $workflowName);
foreach ($workflowMetadata->markings as $marking) {
    $output->writeln($content->getName() . ' is in stage ' . $marking->name . ' in workflow ' . $workflowMetadata->workflow->getName());
}
```

!!! tip

    `marking`, a term from [Symfony Workflow,](https://symfony.com/doc/5.0/components/workflow.html)
    refers to a state in a workflow.

To get a list of all workflows that can be used for a given Content item, use `WorkflowRegistry`:

``` php
$supportedWorkflows = $this->workflowRegistry->getSupportedWorkflows($content);
```

### Applying workflow transitions

To place a Content item in a workflow, use `WorkflowService::start`:

``` php
$this->workflowService->start($content, $workflowName);
```

To apply a transition to a Content item, use `WorkflowService::apply`.
Additionally, you can check if the transition is possible for the given object using `WorkflowService::can`:

``` php
if ($this->workflowService->can($workflowMetadata, $transitionName)) {
    $this->workflowService->apply($workflowMetadata, $transitionName, 'Please review');
}
```

## Bookmarks

[`BookmarkService`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/BookmarkService.php)
enables you to read, add and remove bookmarks from content.

To view a list of all bookmarks, use [`BookmarkService::loadBookmarks`:](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/BookmarkService.php#L54)

``` php
$bookmarkList = $this->bookmarkService->loadBookmarks();

$output->writeln('Total bookmarks: ' . $bookmarkList->totalCount);

foreach ($bookmarkList->items as $bookmark) {
    $output->writeln($bookmark->getContentInfo()->name);
}
```

You can add a bookmark to a Content item by providing its Location object
to the [`BookmarkService::createBookmark`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/BookmarkService.php#L31) method:

``` php
$location = $this->locationService->loadLocation($locationId);

$this->bookmarkService->createBookmark($location);
```

You can remove a bookmark from a Location with [`BookmarkService::deleteBookmark`:](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/BookmarkService.php#L42)

``` php
$this->bookmarkService->deleteBookmark($location);
```

## Languages

### Getting language information

To get a list of all languages in the system use [`LanguageService::loadLanguages`:](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/LanguageService.php#L81)

``` php
$languageList = $this->languageService->loadLanguages();

foreach ($languageList as $language) {
    $output->writeln($language->languageCode . ': ' . $language->name);
}
```

### Creating a language

To create a new language, you need to create a [`LanguageCreateStruct`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/LanguageCreateStruct.php)
and provide it with the language code and language name.
Then, use [`LanguageService::createLanguage`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/LanguageService.php#L29) and pass the `LanguageCreateStruct` to it:

``` php
$languageCreateStruct = $this->languageService->newLanguageCreateStruct();
$languageCreateStruct->languageCode = 'ger-DE';
$languageCreateStruct->name = 'German';
$this->languageService->createLanguage($languageCreateStruct);
```
