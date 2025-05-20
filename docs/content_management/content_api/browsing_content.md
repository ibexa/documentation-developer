---
description: Use PHP API to get content items and their information, content fields, location, and others.
---

# Browsing and viewing content

To retrieve a content item and its information, you need to make use of the [`ContentService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html).

The service should be [injected into the constructor of your command or controller](php_api.md#service-container).

!!! tip "Content REST API"

    To learn how to load content items using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-load-content).

!!! tip "Console commands"

    To learn more about commands in Symfony, refer to [Console Commands]([[= symfony_doc =]]/console.html).

## Viewing content metadata

### ContentInfo

Basic content metadata is available through [`ContentInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentInfo.html) objects and their properties.
This value object provides primitive fields, such as `contentTypeId`, `publishedDate`, or `mainLocationId`, and methods for retrieving selected properties.

You can also use it to request other Content-related value objects from various services:

``` php hl_lines="9"
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 4, 5) =]]
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 20, 21) =]]
// ...
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 55, 57) =]][[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 63, 64) =]]
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 65, 71) =]]
```

`ContentInfo` is loaded from the [`ContentService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html) (line 9).
It provides you with basic content metadata such as modification and publication dates or main language code.

!!! note "Retrieving content information in a controller"

    To retrieve content information in a controller, you also make use of the `ContentService`, but rendering specific elements (for example, content information or field values) is relegated to [templates](templates.md).

### Locations

To get the locations of a content item you need to make use of the [`LocationService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 73, 77) =]]        }
```

[`LocationService::loadLocations`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html#method_loadLocations) uses `ContentInfo` to get all the locations of a content item.
This method returns an array of [`Location`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Persistence-Content-Location.html) value objects.
For each location, the code above prints out its `pathString` (the internal representation of the path).

#### URL Aliases

The [`URLAliasService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-URLAliasService.html) additionally enables you to retrieve the human-readable [URL alias](url_management.md#url-aliases) of each location.

[`URLAliasService::reverseLookup`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-URLAliasService.html#method_reverseLookup) gets the location's main [URL alias](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-URLAlias.html):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 73, 76) =]][[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 77, 80) =]]
```

### Content type

You can retrieve the content type of a content item through the [`getContentType`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentInfo.html#method_getContentType) method of the ContentInfo object:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 82, 84) =]]
```

### Versions

To iterate over the versions of a content item, use the [`ContentService::loadVersions`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_loadVersions) method, which returns an array of `VersionInfo` value objects.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 86, 92) =]]
```

You can additionally provide the `loadVersions` method with the version status to get only versions of a specific status, for example:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 93, 94) =]]
```

!!! note

    Requesting version data may be impossible for an anonymous user.
    Make sure to [authenticate](php_api.md#setting-the-repository-user) as a user with sufficient permissions.

### Relations

Content Relations are versioned.
To list Relations to and from your content, you need to pass a `VersionInfo` object to the [`ContentService::loadRelationList`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_loadRelationList) method.
This method loads only the specified subset of relations to improve performance and was created with pagination in mind.
You can get the current version's `VersionInfo` using [`ContentService::loadVersionInfo`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_loadVersionInfo).

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 105, 112) =]]
```

You can also specify the version number as the second argument to get Relations for a specific version:

``` php
$versionInfo = $this->contentService->loadVersionInfo($contentInfo, 2);
```

`loadRelationList` provides an iterable [`RelationList`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-RelationList.html) object
listing [`Relation`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Relation.html) objects.
`Relation` has two main properties: `destinationContentInfo`, and `sourceContentInfo`.
It also holds the [relation type](content_relations.md), and the optional field this relation is made with.

### Owning user

You can use the `getOwner` method of the `ContentInfo` object to load the content item's owner as a `User` value object.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 114, 115) =]]
```

To get the creator of the current version and not the content item's owner, you need to use the `creatorId` property from the current version's `VersionInfo` object.

### Section

You can find the section to which a content item belongs through the [`getSection`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentInfo.html#method_getSection) method of the ContentInfo object:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 117, 118) =]]
```

!!! note

    Requesting section data may be impossible for an anonymous user.
    Make sure to [authenticate](php_api.md#setting-the-repository-user) as a user with sufficient permissions.

### Object states

You can retrieve [object states](object_states.md) of a content item using [`ObjectStateService::getContentState`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ObjectStateService.html#method_getContentState).
You need to provide it with the object state group.
All object state groups can be retrieved through [`loadObjectStateGroups`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ObjectStateService.html#method_loadObjectStateGroups).

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentMetaDataCommand.php', 115, 120) =]]
```

## Viewing content with fields

To retrieve the fields of the selected content item, you can use the following command:

```php hl_lines="13-14 16-22"
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentCommand.php', 4, 7) =]]    // ...
[[= include_file('code_samples/api/public_php_api/src/Command/ViewContentCommand.php', 37, 55) =]]
}
```

Line 9 shows how [`ContentService::loadContent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html#method_loadContent) loads the content item provided to the command.
Line 14 makes use of the [`ContentTypeService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentTypeService.html) to retrieve the content type of the requested item.

Lines 12-19 iterate over fields defined by the content type.
For each field they print out its identifier, and then using [`FieldTypeService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-FieldTypeService.html) retrieve the field's value and print it out to the console.

## Viewing content in different languages

The repository is SiteAccess-aware, so languages defined by the SiteAccess are automatically taken into account when loading content.

To load a specific language, provide its language code when loading the content item:

``` php
$content = $this->contentService->loadContent($contentId, ['ger-DE']);
```

To load all languages as a prioritized list, use `Language::ALL`:

``` php
$contentService->loadContent($content->id, Language::ALL);
```

## Getting all content in a subtree

To go through all the content items contained in a subtree, you need to use the [`LocationService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html).

``` php hl_lines="5 15"
[[= include_file('code_samples/api/public_php_api/src/Command/BrowseLocationsCommand.php', 30, 49) =]]
```

`loadLocation` (line 15) returns a value object, here a `Location`.

[`LocationService::loadLocationChildren`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html#method_loadLocationChildren) (line 5) returns a [`LocationList`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-LocationList.html) value object that you can iterate over.

!!! note

    Refer to [Searching](search_api.md) for information on more complex search queries.

## Getting parent location

To get the parent location of content, you first need to determine which location is the main one, in case the content item has multiple locations.
You can do it through the `getMainLocation` method of the ContentInfo object.

Next, use the `getParentLocation` method of the location object to access the parent location:

``` php
$mainLocation = $contentInfo->getMainLocation();
$output->writeln("Parent Location: " . $mainLocation->getParentLocation()->pathString);
```

## Getting content from a location

When dealing with location objects (and Trash objects), you can get access to content item directly using `$location->getContent`.
In Twig this can also be accessed by `location.content`.
This is a lazy property.
It triggers loading of content when first used.
In case of bulk of locations coming from Search or location Service, the content is also loaded in bulk for the whole location result set.

## Comparing content versions

You can compare two versions of a content item using the `VersionComparisonService`.
The versions must have the same language.

For example, to get the comparison between the `name` field of two versions:

```php
$versionFrom = $this->contentService->loadVersionInfo($contentInfo, $versionFromId);
$versionTo = $this->contentService->loadVersionInfo($contentInfo, $versionToId);

$nameComparison = $this->comparisonService->compare($versionFrom, $versionTo)->getFieldValueDiffByIdentifier('name')->getComparisonResult();
```

`getComparisonResult` returns a `ComparisonResult` object, which depends on the field type being compared.
In the example of a Text Line (ezstring) field, it's an array of `StringDiff` objects.

Each diff contains a section of the field to compare (for example, a part of a text line) and its status, which can be "unchanged", "added" or "removed".
