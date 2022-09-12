---
description: Use PHP API to get Content items and their information, as well as content Fields, Location, and others.
---

# Browsing and viewing content

To retrieve a Content item and its information, you need to make use of the [`ContentService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php).

The service should be [injected into the constructor of your command or controller](php_api.md#service-container).

!!! tip "Content REST API"

    To learn how to load Content items using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-load-content).

!!! tip "Console commands"

    To learn more about commands in Symfony, refer to [Console Commands]([[= symfony_doc =]]/console.html).

## Viewing content metadata

### ContentInfo

Basic content metadata is available through [`ContentInfo`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentInfo.php) objects and their properties.
This value object provides primitive fields, such as `contentTypeId`, `publishedDate`, or `mainLocationId`,
as well as methods for retrieving selected properties.

You can also use it to request other Content-related value objects from various services:

``` php hl_lines="9"
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 8, 9) =]]
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 16, 17) =]]
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 50, 52) =]][[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 58, 59) =]]
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 60, 66) =]]
```

`ContentInfo` is loaded from the [`ContentService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php) (line 9).
It provides you with basic content metadata such as modification and publication dates or main language code.

!!! note "Retrieving content information in a controller"

    To retrieve content information in a controller, you also make use of the `ContentService`,
    but rendering specific elements (e.g. content information or Field values)
    is relegated to [templates](templates.md).

### Locations

To get the Locations of a Content item you need to make use of the [`LocationService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 68, 72) =]]
```

[`LocationService::loadLocations`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php#L94)
uses `ContentInfo` to get all the Locations of a Content item.
This method returns an array of [`Location`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Location.php) value objects.
For each Location, the code above prints out its `pathString` (the internal representation of the path).

#### URL Aliases

The [`URLAliasService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/URLAliasService.php)
additionally enables you to retrieve the human-readable [URL alias](url_management.md#url-aliases) of each Location.

[`URLAliasService::reverseLookup`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/URLAliasService.php#L146)
gets the Location's main [URL alias](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/URLAlias.php):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 68, 71) =]][[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 72, 75) =]]
```

### Content Type

You can retrieve the Content Type of a Content item
through the [`getContentType`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentInfo.php#L188) method of the ContentInfo object:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 77, 79) =]]
```

### Versions

To iterate over the versions of a Content item,
use the [`ContentService::loadVersions`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L360) method, which returns an array of `VersionInfo` value objects.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 81, 87) =]]
```

You can additionally provide the `loadVersions` method with the version status
to get only versions of a specific status, e.g.:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 88, 89) =]]
```

!!! note

    Requesting version data may be impossible for an anonymous user.
    Make sure to [authenticate](php_api.md#setting-the-repository-user) as a user with sufficient permissions.

### Relations

Content Relations are versioned.
To list Relations to and from your content,
you need to pass a `VersionInfo` object to the [`ContentService::loadRelations`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L385) method.
You can get the current version's `VersionInfo` using [`ContentService::loadVersionInfo`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L82)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 100, 106) =]]
```

You can also specify the version number as the second argument to get Relations for a specific version:

``` php
$versionInfo = $this->contentService->loadVersionInfo($contentInfo, 2);
```

`loadRelations` provides an array of [`Relation`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Relation.php) objects.
`Relation` has two main properties: `destinationContentInfo`, and `sourceContentInfo`.
It also holds the [relation type](content_relations.md),
and the optional Field this relation is made with.

### Owning user

You can use the `getOwner` method of the `ContentInfo` object to load the Content item's owner as a `User` value object.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 108, 109) =]]
```

To get the creator of the current version and not the Content item's owner,
you need to use the `creatorId` property from the current version's `VersionInfo` object.

### Section

You can find the Section to which a Content item belongs through
the [`getSection`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentInfo.php#L193) method
of the ContentInfo object:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 111, 112) =]]
```

!!! note

    Note that requesting Section data may be impossible for an anonymous user.
    Make sure to [authenticate](php_api.md#setting-the-repository-user) as a user with sufficient permissions.

### Object states

You can retrieve [Object states](admin_panel.md#object-states) of a Content item
using [`ObjectStateService::getContentState`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php#L176)
You need to provide it with the Object state group.
All Object state groups can be retrieved through [`loadObjectStateGroups`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php#L59)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 114, 119) =]]
```

## Viewing content with Fields

To retrieve the Fields of the selected Content item, you can use the following command:

```php hl_lines="13-14 16-22"
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentCommand.php', 8, 14) =]]    // ...
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentCommand.php', 38, 57) =]]
}
```

Line 16 shows how [`ContentService::loadContent`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php#L147) loads the Content item provided to the command.
Line 17 makes use of the [`ContentTypeService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentTypeService.php) to retrieve the Content Type of the requested item.

Lines 19-24 iterate over Fields defined by the Content Type.
For each Field they print out its identifier, and then using [`FieldTypeService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/FieldTypeService.php) retrieve the Field's value and print it out to the console.

## Viewing content in different languages

The Repository is SiteAccess-aware, so languages defined by the SiteAccess are automatically taken into account when loading content.

To load a specific language, provide its language code when loading the Content item:

``` php
$content = $this->contentService->loadContent($contentId, ['ger-DE']);
```

To load all languages as a prioritized list, use `Language::ALL`:

``` php
$contentService->loadContent($content->id, Language::ALL);
```

## Getting all content in a subtree

To go through all the Content items contained in a subtree,
you need to use the [`LocationService`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php)

``` php hl_lines="5 15"
[[= include_file('code_samples/api/public_php_api/src/Command/BrowseLocationsCommand.php', 30, 49) =]]
```

`loadLocation` (line 14) returns a value object, here a `Location`.

[`LocationService::loadLocationChildren`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php#L106) (line 23)
returns a [`LocationList`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/LocationList.php) value object that you can iterate over.

!!! note

    Refer to [Searching](search_api.md) for information on more complex search queries.

## Getting parent Location

To get the parent Location of content, you first need to determine which Location is the main one,
in case the Content item has multiple Locations.
You can do it through the `getMainLocation` method of the ContentInfo object.

Next, use the `getParentLocation` method of the Location object to access the parent Location:

``` php
$mainLocation = $contentInfo->getMainLocation();
$output->writeln("Parent Location: " . $mainLocation->getParentLocation()->pathString);
```

## Getting content from a Location

When dealing with Location objects (and Trash objects), you can get access to Content item directly using `$location->getContent`.
In Twig this can also be accessed by `location.content`.

This is a lazy property. It will trigger loading of content when first used.
In case of bulk of Locations coming from Search or Location Service,
the Content will also be loaded in bulk for the whole Location result set.

## Comparing content versions

You can compare two versions of a Content item using the `VersionComparisonService`.
The versions must have the same language.

For example, to get the comparison between the `name` Field of two versions:

```php
$versionFrom = $this->contentService->loadVersionInfo($contentInfo, $versionFromId);
$versionTo = $this->contentService->loadVersionInfo($contentInfo, $versionToId);

$nameComparison = $this->comparisonService->compare($versionFrom, $versionTo)->getFieldValueDiffByIdentifier('name')->getComparisonResult();
```

`getComparisonResult` returns a `ComparisonResult` object, which depends on the Field Type being compared.
In the example of a Text Line (ezstring) Field, it is an array of `StringDiff` objects.

Each diff contains a section of the Field to compare (e.g. a part of a text line)
and its status, which can be "unchanged", "added" or "removed".
