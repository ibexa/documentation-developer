# Browsing and viewing content

To retrieve a Content item and its information, you need to make use of the [`ContentService`.](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/ContentService.php)

The service should be [injected into the constructor of your command or controller](../api/public_php_api.md#service-container).

!!! tip "Console commands"

    To learn more about commands in Symfony, refer to [Console Commands.]([[= symfony_doc =]]/console.html)

## Viewing content metadata

### ContentInfo

Basic content metadata is available through [`ContentInfo`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/Values/Content/ContentInfo.php) objects and their properties.
This value object mostly provides primitive fields, such as `contentTypeId`, `publishedDate`, or `mainLocationId`.

You can also use it to request other Content-related value objects from various services:

``` php hl_lines="13"
//...
use eZ\Publish\API\Repository\ContentService;

class ViewContentMetaDataCommand extends Command
{
    //...
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $contentId = $input->getArgument('contentId');

        try
        {
            $contentInfo = $this->contentService->loadContentInfo($contentId);

            $output->writeln("Name: $contentInfo->name");
            $output->writeln("Last modified: " . $contentInfo->modificationDate->format('Y-m-d'));
            $output->writeln("Published: ". $contentInfo->publishedDate->format('Y-m-d'));
            $output->writeln("RemoteId: $contentInfo->remoteId");
            $output->writeln("Main Language: $contentInfo->mainLanguageCode");
            $output->writeln("Always available: " . ($contentInfo->alwaysAvailable ? 'Yes' : 'No'));
        } catch //..
    }
}
```

`ContentInfo` is loaded from the [`ContentService`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/ContentService.php) (line 13).
It provides you with basic content metadata such as modification and publication dates or main language code.

!!! note "Retrieving Content information in a controller"

    To retrieve Content information in a controller, you also make use of the `ContentService`,
    but rendering specific elements (e.g. Content information or Field values)
    is relegated to [templates](../guide/templates.md).

### Locations

To get the Locations of a Content item you need to make use of the [`LocationService`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/LocationService.php):

``` php
$locations = $this->locationService->loadLocations($contentInfo);
foreach ($locations as $location) {
    $output->writeln($location->pathString);
}
```

[`LocationService::loadLocations`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/LocationService.php#L95)
uses `ContentInfo` to get all the Locations of a Content item.
This method returns an array of [`Location`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/Values/Content/Location.php) value objects.
For each Location, the code above prints out its `pathString` (the internal representation of the path).

#### URL Aliases

The [`URLAliasService`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/URLAliasService.php)
additionally enables you to retrieve the human-readable [URL alias](../guide/url_management.md#url-aliases) of each Location.

[`URLAliasService::reverseLookup`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/URLAliasService.php#L125)
gets the Location's main [URL alias](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/Values/Content/URLAlias.php):

``` php
$locations = $this->locationService->loadLocations($contentInfo);
foreach ($locations as $location) {
    $urlAlias = $this->urlAliasService->reverseLookup($location);
    $output->writeln($location->pathString ($urlAlias->path));
}
```

### Content Type

You can retrieve the Content Type of a Content item
through the [`getContentType`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/Values/Content/Content.php#L107) method of the Content object:

``` php
$content = $this->contentService->loadContent($contentId);
$output->writeln("Content Type: " . $content->getContentType()->getName());
```

### Versions

To iterate over the versions of a Content item,
use the [`ContentService::loadVersions`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/ContentService.php#L322) method, which returns an array of `VersionInfo` value objects.

``` php
$versionInfos = $this->contentService->loadVersions($contentInfo);
foreach ($versionInfos as $versionInfo) {
    $creator = $this->userService->loadUser($versionInfo->creatorId);
    $output->write("Version $versionInfo->versionNo ");
    $output->write(" by " . $creator->contentInfo->name);
    $output->writeln(" in " . $versionInfo->initialLanguageCode);
}
```

You can additionally provide the `loadVersions` method with the version status
to get only versions of a specific status, e.g.:

``` php
$versionInfoArray = $this->contentService->loadVersions($contentInfo, VersionInfo::STATUS_DRAFT);
```

!!! note

    Requesting Version data may be impossible for an anonymous user.
    Make sure to [authenticate](public_php_api.md#setting-the-repository-user) as a user with sufficient permissions.

### Relations

Content Relations are versioned.
To list Relations to and from your Content,
you need to pass a `VersionInfo` object to the [`ContentService::loadRelations`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/ContentService.php#L347) method.
You can get the current version's `VersionInfo` using [`ContentService::loadVersionInfo`.](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/ContentService.php#L80)

``` php
$versionInfo = $this->contentService->loadVersionInfo($contentInfo);
$relations = $this->contentService->loadRelations($versionInfo);
foreach ($relations as $relation) {
    $name = $relation->destinationContentInfo->name;
    $output->write('Relation to content ' . $name);
}
```

You can also specify the version number as the second argument to get Relations for a specific version:

``` php
$versionInfo = $this->contentService->loadVersionInfo($contentInfo, 2);
```

`loadRelations` provides an array of [`Relation`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/Values/Content/Relation.php) objects.
`Relation` has two main properties: `destinationContentInfo`, and `sourceContentInfo`.
It also holds the [relation type](../guide/content_management.md#content-relations),
and the optional Field this relation is made with.

### Owning user

You can use [`UserService::loadUser`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/UserService.php#L141)
with the `ownerId` property of `ContentInfo` to load the Content item's owner as a `User` value object.

``` php
$owner = $userService->loadUser($contentInfo->ownerId);
$output->writeln('Owner: ' . $owner->contentInfo->name);
```

To get the creator of the current version and not the Content item's owner,
you need to use the `creatorId` property from the current version's `VersionInfo` object.

### Section

The Section's ID can be found in the `sectionId` property of the `ContentInfo` object.
To get the matching Section value object,
you need to use the [`SectionService::loadSection`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/SectionService.php#L57) method.

``` php
$section = $sectionService->loadSection($contentInfo->sectionId);
$output->writeln("Section: $section->name");
```

!!! note

    Note that requesting Section data may be impossible for an anonymous user.
    Make sure to [authenticate](public_php_api.md#setting-the-repository-user) as a user with sufficient permissions.

### Object states

You can retrieve [Object states](../guide/admin_panel.md#object-states) of a Content item
using [`ObjectStateService::getContentState`.](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/ObjectStateService.php#L176)
You need to provide it with the Object state group.
All Object state groups can be retrieved through [`loadObjectStateGroups`.](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/ObjectStateService.php#L59)

``` php
$stateGroups = $this->objectStateService->loadObjectStateGroups();
foreach ($stateGroups as $stateGroup) {
    $state = $this->objectStateService->getContentState($contentInfo, $stateGroup);
    $output->writeln('Object state: ' . $state->identifier);
}
```

## Viewing content with Fields

To retrieve the Fields of the selected Content item, you can use the following command:

```php hl_lines="16 17 19 20 21 22 23 24"
//...
use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\ContentTypeService;
use eZ\Publish\API\Repository\FieldTypeService;

class ViewContentCommand extends Command
{
    // ...

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $contentId = $input->getArgument('contentId');

        try {
            $content = $this->contentService->loadContent($contentId);
            $contentType = $this->contentTypeService->loadContentType($content->contentInfo->contentTypeId);

            foreach ($contentType->fieldDefinitions as $fieldDefinition) {
                $output->writeln("<info>" . $fieldDefinition->identifier . "</info>");
                $fieldType = $this->fieldTypeService->getFieldType($fieldDefinition->fieldTypeIdentifier);
                $field = $content->getFieldValue($fieldDefinition->identifier);
                $valueHash = $fieldType->toHash($field);
                $output->writeln($valueHash);
            }
        } catch //...
    }
}
```

Line 16 shows how [`ContentService::loadContent`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/ContentService.php#L145) loads the Content item provided to the command.
Line 17 makes use of the [`ContentTypeService`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/ContentTypeService.php) to retrieve the Content Type of the requested item.

Lines 19-24 iterate over Fields defined by the Content Type.
For each Field they print out its identifier, and then using [`FieldTypeService`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/FieldTypeService.php) retrieve the Field's value and print it out to the console.

## Viewing content in different languages

If you do not specify any language code, a Field object is returned in the Content item's main language.

In the `getField` call you can specify the language code of the language you want to get Field value in:

``` php
$field = $content->getFieldValue($fieldDefinition->identifier, 'fre-FR');
```

If you want to take SiteAccess languages into account,
inject the [`ConfigResolver`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Bundle/EzPublishCoreBundle/DependencyInjection/Configuration/ConfigResolver.php) into your code
and provide prioritized languages when loading content.
They will be taken into account by the returned Content object when retrieving translated properties like fields, for example:

``` php
$content = $this->contentService->loadContent($contentId, $configResolver->getParameter('languages'));
```

### SiteAccess-aware Repository

The optional SiteAccess-aware Repository is an instance of the eZ Platform Repository API
which injects prioritized languages if you don't specify languages.

It is available as a private service `ezpublish.siteaccessaware.repository`,
with services corresponding to regular services, e.g. `ezpublish.siteaccessaware.service.content`,
`ezpublish.siteaccessaware.service.content_type`, etc.

It is used out of the box in parameter converters for Content and Location as well as in content view.

When using SiteAccess-aware Repository, the following code:

``` php
$content = $this->contentService->loadContent(
    42,
    $this->configResolver->getParameter('languages')
);

$name = $content->getVersionInfo()->getName();
```

becomes:

``` php
$content = $this->contentService->loadContent(42);

$name = $content->getVersionInfo()->getName();
```

## Getting all content in a subtree

To go through all the Content items contained in a subtree,
you need to use the [`LocationService`.](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/LocationService.php)

``` php hl_lines="14 23"
//...
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\Values\Content\Location;

class BrowseContentCommand extends Command

    //...

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $locationId = $input->getArgument('locationId');

        try {
            $location = $this->locationService->loadLocation($locationId);
            $this->browseLocation($location, $output);
        } catch //...
    }

    private function browseLocation(Location $location, OutputInterface $output, $depth = 0)
    {
        $output->writeln($location->contentInfo->name);

        $childLocations = $this->locationService->loadLocationChildren($location);
        foreach ($childLocations->locations as $childLocation) {
            $this->browseLocation($childLocation, $output, $depth + 1);
        }
    }
```

`loadLocation` (line 14) returns a value object, here a `Location`.

[`LocationService::loadLocationChildren`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/LocationService.php#L107) (line 23)
returns a [`LocationList`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Publish/API/Repository/Values/Content/LocationList.php) value object that you can iterate over.

!!! note

    Refer to [Searching](public_php_api_search.md) for information on more complex search queries.

## Getting content from a Location

When dealing with Location objects (and Trash objects), you can get access to Content item directly using `$location->getContent`.
In Twig this can also be accessed by `location.content`.

This is a lazy property. It will trigger loading of Content when first used.
In case of bulk of Locations coming from Search or Location Service,
the Content will also be loaded in bulk for the whole Location result set.

To learn more about this functionality see [Lazy object properties.](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/doc/specifications/api/lazy_properties.md)
