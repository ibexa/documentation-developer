---
description: PHP API enables you to create sections, assign content to them, and get various information about the section.
---

# Section API

[Sections](sections.md) enable you to divide content into groups which can later be used, for example, as basis for permissions.

You can manage sections by using the PHP API by using `SectionService`.

!!! tip "Section REST API"

    To learn how to manage sections using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-get-sections).

## Creating sections

To create a new section, you need to make use of the [`SectionCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-SectionCreateStruct.html) and pass it to the [`SectionService::createSection`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SectionService.html#method_createSection) method:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 58, 62) =]]
```

## Getting section information

You can use `SectionService` to retrieve section information such as whether it's in use:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 76, 81) =]]
```

## Listing content in a section

To list content items assigned to a section you need to make a [query](search_api.md) for content belonging to this section, by applying the [`SearchService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SearchService.html).
You can also use the query to get the total number of assigned content items:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 69, 75) =]][[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 82, 86) =]]
```

## Assigning section to content

To assign content to a section, use the [`SectionService::assignSection`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SectionService.html#method_assignSection) method.
You need to provide it with the `ContentInfo` object of the content item, and the [`Section`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Section.html) object:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/SectionCommand.php', 64, 67) =]]
```

Assigning a section to content doesn't automatically assign it to the content item's children.
