---
description: Control the availability of content items with relation to translations by using the Default content availability flag.
---

# Content availability

The Default content availability flag enables you to control whether content is available when its translation is missing.

You can set the flag in content type definition by checking the "Make content available even with missing translations" option.
It is automatically applied to any new content item of this Type.

![Default content availability](availability_flag.png "Default content availability")

A content item with this flag will be available in its main language
even if it is not translated into the language of the current SiteAccess.

Without the flag, a content item will not be available at all if it does not have a language version
corresponding to the current SiteAccess.

!!! note

    There is currently no way in the Back Office to edit the Content availability flag
    for an already published content item.
    
    To do this via [PHP API](creating_content.md#updating-content), set the [`alwaysAvailable` property](../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentMetadataUpdateStruct.html#property_alwaysAvailable) of the Content metadata.

The Default availability flag is used for the out-of-the box content types representing content
that should always be visible to the user, such as media files or user content items.

You can also use it for organizational content types.

For example, you can assign the flag to a Blog content type which is intended to contain Blog Posts
in multiple languages. If the Blog is in English only, it would not be visible for readers
using the Norwegian or German SiteAcceses.
However, if you set the default availability flag for the Blog content type,
it will be displayed to them in English (if it is set as a main language) and will enable the users to browse individual
posts in other languages.
