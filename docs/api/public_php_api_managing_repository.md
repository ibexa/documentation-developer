# Repository API

## Sections

[Sections](../guide/admin_panel.md#sections) enable you to divide content into groups
which can later be used e.g. as basis for permissions.

### Creating Sections

To create a new Section, you need to make use of the [`SectionCreateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/SectionCreateStruct.php)
and pass it to the [`SectionService::createSection`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SectionService.php#L32) method:

``` php 
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 58, 62) =]]
```

### Getting Section information

You can use `SectionService` to retrieve Section information such as whether it is in use:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 76, 80) =]]
```

### Listing content in a Section

To list Content items assigned to a Section you need to make a [query](public_php_api_search.md)
for content belonging to this section, by applying the [`SearchService`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SearchService.php)
You can also use the query to get the total number of assigned Content items:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 69, 75) =]][[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 82, 85) =]]
```

### Assigning Section to content

To assign content to a Section, use the [`SectionService::assignSection`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SectionService.php#L110) method.
You need to provide it with the `ContentInfo` object of the Content item,
and the [`Section`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Section.php) object:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 64, 67) =]]
```

Note that assigning a Section to content does not automatically assign it to the Content item's children.

## Object states

[Object states](../guide/admin_panel.md#object-states)  enable you to set a custom state to any content.
States are grouped into Object state groups.

### Getting Object state information

You can use the [`ObjectStateService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php)
to get information about Object state groups or Object states.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 48, 53) =]]
```

### Creating Object states

To create an Object state group and add Object states to it,
you need to make use of the [`ObjectStateService`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 57, 61) =]]
```

[`ObjectStateService::createObjectStateGroup`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php#L34)
takes as argument an [`ObjectStateGroupCreateStruct`,](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/ObjectState/ObjectStateGroupCreateStruct.php)
in which you need to specify the identifier, default language and at least one name for the group.

To create an Object state inside a group,
use [`ObjectStateService::newObjectStateCreateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php#L210)
and provide it with an `ObjectStateCreateStruct`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 64, 68) =]]
```

### Assigning Object state

To assign an Object state to a Content item,
use [`ObjectStateService::setContentState`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php#L180)
Provide it with a `ContentInfo` object of the Content item, the Object state group and the Object state:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 78, 83) =]]
```

## Workflow

### Getting workflow information

To get information about a specific [workflow](../guide/workflow/workflow.md) for a Content item, use `WorkflowServiceInterface::loadWorkflowMetadataForContent`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 53, 57) =]]
```

!!! tip

    `marking`, a term from [Symfony Workflow,]([[= symfony_doc =]]/components/workflow.html)
    refers to a state in a workflow.

To get a list of all workflows that can be used for a given Content item, use `WorkflowRegistry`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 47, 48) =]]
```

### Applying workflow transitions

To place a Content item in a workflow, use `WorkflowService::start`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 52, 53) =]]
```

To apply a transition to a Content item, use `Workflow::apply`.
Additionally, you can check if the transition is possible for the given object using `WorkflowService::can`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/WorkflowCommand.php', 59, 62) =]]    }
```

!!! tip

    `Ibexa\Workflow\Value\WorkflowMetadata` object contains all 
    information about a workflow, such as ID, name, transitions and current stage.
    `Ibexa\Workflow\Value\WorkflowMetadata::$workflow` gives you direct 
    access to native Symfony Workflow object.

## Bookmarks

[`BookmarkService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/BookmarkService.php)
enables you to read, add and remove bookmarks from content.

To view a list of all bookmarks, use [`BookmarkService::loadBookmarks`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/BookmarkService.php#L54)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 43, 50) =]]
```

You can add a bookmark to a Content item by providing its Location object
to the [`BookmarkService::createBookmark`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/BookmarkService.php#L31) method:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 37, 40) =]]
```

You can remove a bookmark from a Location with [`BookmarkService::deleteBookmark`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/BookmarkService.php#L42)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/BookmarkCommand.php', 52, 53) =]]
```

## Languages

### Getting language information

To get a list of all languages in the system use [`LanguageService::loadLanguages`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LanguageService.php#L79)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/AddLanguageCommand.php', 37, 42) =]]
```

### Creating a language

To create a new language, you need to create a [`LanguageCreateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/LanguageCreateStruct.php)
and provide it with the language code and language name.
Then, use [`LanguageService::createLanguage`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LanguageService.php#L27) and pass the `LanguageCreateStruct` to it:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/AddLanguageCommand.php', 43, 47) =]]
```
