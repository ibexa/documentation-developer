# Section API

PHP API enables you to create sections, assign content to them, and get various information about the section.

[Sections](../../../administration/content_organization/sections/index.md) enable you to divide content into groups which can later be used, for example, as basis for permissions.

You can manage sections by using the PHP API by using `SectionService`.

> **Tip: Section REST API**
>
> To learn how to manage sections using the REST API, see [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Section).

## Creating sections

To create a new section, you need to make use of the [`Ibexa\Contracts\Core\Repository\Values\Content\SectionCreateStruct`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/SectionCreateStruct.php) and pass it to the [`SectionService::createSection`](../../../../../../ibexa/core/src/contracts/Repository/SectionService.php) method:

```php
$sectionCreateStruct = $this->sectionService->newSectionCreateStruct();
$sectionCreateStruct->name = $sectionName;
$sectionCreateStruct->identifier = $sectionIdentifier;
$this->sectionService->createSection($sectionCreateStruct);
```

## Getting section information

You can use `SectionService` to retrieve section information such as whether it's in use:

```php
$output->writeln((
    $this->sectionService->isSectionUsed($section)
    ? 'This section is in use.'
    : 'This section is not in use.'
));
```

## Listing content in a section

To list content items assigned to a section you need to make a [query](../../../search/search_api/index.md) for content belonging to this section, by applying the [`Ibexa\Contracts\Core\Repository\SearchService`](../../../../../../ibexa/core/src/contracts/Repository/SearchService.php). You can also use the query to get the total number of assigned content items:

```php
        $query = new LocationQuery();
        $query->filter = new Criterion\SectionId([
            $section->id,
        ]);

        $result = $this->searchService->findContentInfo($query);

        foreach ($result->searchHits as $searchResult) {
            $output->writeln('* ' . $searchResult->valueObject->name);
        }
```

## Assigning section to content

To assign content to a section, use the [`SectionService::assignSection`](../../../../../../ibexa/core/src/contracts/Repository/SectionService.php) method. You need to provide it with the `ContentInfo` object of the content item, and the [`Ibexa\Contracts\Core\Repository\Values\Content\Section`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Section.php) object:

```php
$section = $this->sectionService->loadSectionByIdentifier($sectionIdentifier);
$contentInfo = $this->contentService->loadContentInfo($contentId);
$this->sectionService->assignSection($contentInfo, $section);
```

Assigning a section to content doesn't automatically assign it to the content item's children.
