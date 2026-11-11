# Browsing and viewing content

Use PHP API to get content items and their information, content fields, location, and others.

To retrieve a content item and its information, you need to make use of the [`Ibexa\Contracts\Core\Repository\ContentService`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php).

The service should be [injected into the constructor of your command or controller](../../../api/php_api/php_api/index.md#service-container).

> **Tip: Content REST API**
>
> To learn how to load content items using the REST API, see [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Objects/operation/api_contentobjects_contentId_get).

> **Tip: Console commands**
>
> To learn more about commands in Symfony, refer to [Console Commands](https://symfony.com/doc/7.4/console.html).

## Viewing content metadata

### ContentInfo

Basic content metadata is available through [`Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentInfo.php) objects and their properties. This value object provides primitive fields, such as `contentTypeId`, `publishedDate`, or `mainLocationId`, and methods for retrieving selected properties.

You can also use it to request other content-related value objects from various services:

```php
<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;

// …
class ViewContentMetaDataCommand extends Command
{
    // …
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contentInfo = $this->contentService->loadContentInfo($contentId);

        $output->writeln("Name: $contentInfo->name");
        $output->writeln('Last modified: ' . $contentInfo->modificationDate->format('Y-m-d'));
        $output->writeln('Published: ' . $contentInfo->publishedDate->format('Y-m-d'));
        $output->writeln("RemoteId: $contentInfo->remoteId");
        $output->writeln("Main Language: $contentInfo->mainLanguageCode");
        $output->writeln('Always available: ' . ($contentInfo->alwaysAvailable ? 'Yes' : 'No'));

        return self::SUCCESS;
    }
}
```

`ContentInfo` is loaded from the [`Ibexa\Contracts\Core\Repository\ContentService`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php) (line 13). It provides you with basic content metadata such as modification and publication dates or main language code.

> **Note: Retrieving content information in a controller**
>
> To retrieve content information in a controller, you also make use of the `ContentService`, but rendering specific elements (for example, content information or field values) is relegated to [templates](../../../templating/templates/templates/index.md).

### Locations

To get the locations of a content item you need to make use of the [`Ibexa\Contracts\Core\Repository\LocationService`](../../../../../../ibexa/core/src/contracts/Repository/LocationService.php):

```php
$locations = $this->locationService->loadLocations($contentInfo);

foreach ($locations as $location) {
    $output->writeln('Location: ' . $location->pathString);
}
```

[`LocationService::loadLocations`](../../../../../../ibexa/core/src/contracts/Repository/LocationService.php) uses `ContentInfo` to get all the locations of a content item. This method returns an array of [`Ibexa\Contracts\Core\Persistence\Content\Location`](../../../../../../ibexa/core/src/contracts/Persistence/Content/Location.php) value objects. For each location, the code above prints out its `pathString` (the internal representation of the path).

#### URL Aliases

The [`Ibexa\Contracts\Core\Repository\URLAliasService`](../../../../../../ibexa/core/src/contracts/Repository/URLAliasService.php) additionally enables you to retrieve the human-readable [URL alias](../../url_management/url_management/index.md#url-aliases) of each location.

[`URLAliasService::reverseLookup`](../../../../../../ibexa/core/src/contracts/Repository/URLAliasService.php) gets the location's main [URL alias](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/URLAlias.php):

```php
$locations = $this->locationService->loadLocations($contentInfo);

foreach ($locations as $location) {
    $urlAlias = $this->urlAliasService->reverseLookup($location);
    $output->writeln('URL alias: ' . $urlAlias->path);
}
```

### Content type

You can retrieve the content type of a content item through the [`getContentType`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentInfo.php) method of the ContentInfo object:

```php
$content = $this->contentService->loadContent($contentId);
$output->writeln('Content type: ' . $content->getContentType()->getName());
```

### Versions

To iterate over the versions of a content item, use the [`ContentService::loadVersions`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php) method, which returns an array of `VersionInfo` value objects.

```php
$versionInfos = $this->contentService->loadVersions($contentInfo);
foreach ($versionInfos as $versionInfo) {
    $output->write("Version $versionInfo->versionNo");
    $output->write(' by ' . $versionInfo->getCreator()->getName());
    $output->writeln(' in ' . $versionInfo->getInitialLanguage()->name);
}
```

You can additionally provide the `loadVersions` method with the version status to get only versions of a specific status, for example:

```php
$versionInfoArray = iterator_to_array($this->contentService->loadVersions($contentInfo, VersionInfo::STATUS_ARCHIVED));
```

> **Note: Note**
>
> Requesting version data may be impossible for an anonymous user. Make sure to [authenticate](../../../api/php_api/php_api/index.md#setting-the-repository-user) as a user with sufficient permissions.

### Relations

Content Relations are versioned. To list Relations to and from your content, you can:

- pass a `VersionInfo` object to the [`ContentService::loadRelationList` method](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php) which returns a slice of the relation list thanks to pagination arguments
- use the [`Ibexa\Contracts\Core\Repository\Iterator\BatchIteratorAdapter\RelationListIteratorAdapter`](../../../../../../ibexa/core/src/contracts/Repository/Iterator/BatchIteratorAdapter/RelationListIteratorAdapter.php) within a [`Ibexa\Contracts\Core\Repository\Iterator\BatchIterator`](../../../../../../ibexa/core/src/contracts/Repository/Iterator/BatchIterator.php) which allow traversing the whole relation list

See [Processing large result sets](../../../search/search_api/index.md#process-large-result-sets) for more information about the `BatchIterator`.

You can get the current version's `VersionInfo` using [`ContentService::loadVersionInfo`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php).

```php
$versionInfo = $this->contentService->loadVersionInfo($contentInfo);
$relationListIterator = new BatchIterator(
    new RelationListIteratorAdapter(
        $this->contentService,
        $versionInfo
    )
);
foreach ($relationListIterator as $relationListItem) {
    $name = $relationListItem->hasRelation() ? $relationListItem->getRelation()->destinationContentInfo->name : '(Unauthorized)';
    $output->writeln("Relation to content '$name'");
}
```

You can also specify the version number as the second argument to get Relations for a specific version:

```php
/**
 * @var \Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo $contentInfo
 * @var \Ibexa\Contracts\Core\Repository\ContentService $contentService
 */
$versionInfo = $contentService->loadVersionInfo($contentInfo, 2);
```

`loadRelationList` provides an iterable [`Ibexa\Contracts\Core\Repository\Values\Content\RelationList`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/RelationList.php) object listing [`Ibexa\Contracts\Core\Repository\Values\Content\Relation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Relation.php) objects. `Relation` has two main properties: `destinationContentInfo`, and `sourceContentInfo`. It also holds the [relation type](../../content_relations/index.md), and the optional field this relation is made with.

### Owning user

You can use the `getOwner` method of the `ContentInfo` object to load the content item's owner as a `User` value object.

```php
$output->writeln('Owner: ' . $contentInfo->getOwner()->getName());
```

To get the creator of the current version and not the content item's owner, you need to use the `creatorId` property from the current version's `VersionInfo` object.

### Section

You can find the section to which a content item belongs through the [`getSection`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentInfo.php) method of the ContentInfo object:

```php
$output->writeln('Section: ' . $contentInfo->getSection()->name);
```

> **Note: Note**
>
> Requesting section data may be impossible for an anonymous user. Make sure to [authenticate](../../../api/php_api/php_api/index.md#setting-the-repository-user) as a user with sufficient permissions.

### Object states

You can retrieve [object states](../../../administration/content_organization/object_states/index.md) of a content item using [`ObjectStateService::getContentState`](../../../../../../ibexa/core/src/contracts/Repository/ObjectStateService.php). You need to provide it with the object state group. All object state groups can be retrieved through [`loadObjectStateGroups`](../../../../../../ibexa/core/src/contracts/Repository/ObjectStateService.php).

```php
$stateGroups = $this->objectStateService->loadObjectStateGroups();
foreach ($stateGroups as $stateGroup) {
    $state = $this->objectStateService->getContentState($contentInfo, $stateGroup);
    $output->writeln("Object state: $state->identifier");
}
```

## Viewing field definitions of content types

To retrieve the content type's field definitions of a selected content item, you can use the following command:

```php
<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\FieldTypeService;

// …
class ViewContentCommand extends Command
{
    // …
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contentId = (int) $input->getArgument('contentId');

        $content = $this->contentService->loadContent($contentId);
        $contentType = $this->contentTypeService->loadContentType($content->contentInfo->contentTypeId);

        foreach ($contentType->fieldDefinitions as $fieldDefinition) {
            $output->writeln('Field: ' . $fieldDefinition->identifier);
            $fieldType = $this->fieldTypeService->getFieldType($fieldDefinition->fieldTypeIdentifier);
            $field = $content->getFieldValue($fieldDefinition->identifier);
            $valueHash = $fieldType->toHash($field);
            $output->writeln('Value:');
            $output->writeln($valueHash);
        }

        return self::SUCCESS;
    }
}
```

Line 17 shows how [`ContentService::loadContent`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php) loads the content item provided to the command. Line 18 makes use of the [`Ibexa\Contracts\Core\Repository\ContentTypeService`](../../../../../../ibexa/core/src/contracts/Repository/ContentTypeService.php) to retrieve the content type of the requested item.

Lines 20-27 iterate over fields defined by the content type. For each field definition they print out its identifier, and then using [`Ibexa\Contracts\Core\Repository\FieldTypeService`](../../../../../../ibexa/core/src/contracts/Repository/FieldTypeService.php) retrieve the field definition's value and print it out to the console.

## Viewing content in different languages

The repository is SiteAccess-aware, so languages defined by the SiteAccess are automatically taken into account when loading content.

To load a specific language, provide its language code when loading the content item:

```php
/**
 * @var int $contentId
 * @var \Ibexa\Contracts\Core\Repository\ContentService $contentService
 */
$content = $contentService->loadContent($contentId, ['ger-DE']);
```

To load all languages as a prioritized list, use `Language::ALL`:

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Language;

/**
 * @var \Ibexa\Contracts\Core\Repository\ContentService $contentService
 * @var \Ibexa\Contracts\Core\Repository\Values\Content\Content $content
 */
$contentService->loadContent($content->id, Language::ALL);
```

## Getting all content in a subtree

To go through all the content items contained in a subtree, you need to use the [`Ibexa\Contracts\Core\Repository\LocationService`](../../../../../../ibexa/core/src/contracts/Repository/LocationService.php).

```php
private function browseLocation(Location $location, OutputInterface $output, int $depth = 0): void
{
    $output->writeln($location->contentInfo->name);

    $children = $this->locationService->loadLocationChildren($location);
    foreach ($children->locations as $child) {
        $this->browseLocation($child, $output, $depth + 1);
    }
}

protected function execute(InputInterface $input, OutputInterface $output): int
{
    $locationId = (int) $input->getArgument('locationId');

    $location = $this->locationService->loadLocation($locationId);
    $this->browseLocation($location, $output);

    return self::SUCCESS;
}
```

`loadLocation` (line 15) returns a value object, here a `Location`.

[`LocationService::loadLocationChildren`](../../../../../../ibexa/core/src/contracts/Repository/LocationService.php) (line 5) returns a [`Ibexa\Contracts\Core\Repository\Values\Content\LocationList`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/LocationList.php) value object that you can iterate over.

> **Note: Note**
>
> Refer to [Searching](../../../search/search_api/index.md) for information on more complex search queries.

## Getting parent location

To get the parent location of content, you first need to determine which location is the main one, in case the content item has multiple locations. You can do it through the `getMainLocation` method of the ContentInfo object.

Next, use the `getParentLocation` method of the location object to access the parent location:

```php
/** @var \Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo $contentInfo */
$mainLocation = $contentInfo->getMainLocation();
$parentLocation = $mainLocation?->getParentLocation();
if ($parentLocation !== null) {
    $message = 'Parent Location: ' . $parentLocation->pathString;
}
```

## Getting content from a location

When dealing with location objects (and Trash objects), you can get access to content item directly using `$location->getContent`. In Twig this can also be accessed by `location.content`. This is a lazy property. It triggers loading of content when first used. In case of bulk of locations coming from Search or location Service, the content is also loaded in bulk for the whole location result set.

## Comparing content versions

You can compare two versions of a content item using the `VersionComparisonService`. The versions must have the same language.

For example, to get the comparison between the `name` field of two versions:

```php
/**
 * @var \Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo $contentInfo
 * @var int $versionFromId
 * @var int $versionToId
 * @var \Ibexa\Contracts\Core\Repository\ContentService $contentService
 * @var \Ibexa\Contracts\VersionComparison\Service\VersionComparisonServiceInterface $comparisonService
 */
$versionFrom = $contentService->loadVersionInfo($contentInfo, $versionFromId);
$versionTo = $contentService->loadVersionInfo($contentInfo, $versionToId);

$nameComparison = $comparisonService->compare($versionFrom, $versionTo)->getFieldValueDiffByIdentifier('name')->getComparisonResult();
```

`getComparisonResult` returns a `ComparisonResult` object, which depends on the field type being compared. In the example of a Text Line (ibexa_string) field, it's an array of `StringDiff` objects.

Each diff contains a section of the field to compare (for example, a part of a text line) and its status, which can be "unchanged", "added" or "removed".
