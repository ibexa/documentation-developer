---
description: PHP API enables you to create Sections, assign content to them as well as get various information about the Section.
---

# Section API

[Sections](sections.md) enable you to divide content into groups
which can later be used, for example, as basis for permissions.

You can manage Sections by using the PHP API by using `SectionService`.

!!! tip "Section REST API"

    To learn how to manage Sections using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-get-sections).

## Creating Sections

To create a new Section, you need to make use of the [`SectionCreateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/SectionCreateStruct.php)
and pass it to the [`SectionService::createSection`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SectionService.php#L32) method:

``` php 
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 58, 62) =]]
```

## Getting Section information

You can use `SectionService` to retrieve Section information such as whether it is in use:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 76, 81) =]]
```

## Listing content in a Section

To list content items assigned to a Section you need to make a [query](search_api.md)
for content belonging to this section, by applying the [`SearchService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SearchService.php).
You can also use the query to get the total number of assigned content items:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 69, 75) =]][[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 82, 86) =]]
```

## Assigning Section to content

To assign content to a Section, use the [`SectionService::assignSection`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SectionService.php#L110) method.
You need to provide it with the `ContentInfo` object of the content item,
and the [`Section`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Section.php) object:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 64, 67) =]]
```

Note that assigning a Section to content does not automatically assign it to the content item's children.
