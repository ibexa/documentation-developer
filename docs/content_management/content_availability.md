---
description: Control the availability of Content items with relation to translations by using the Default content availability flag.
---

# Content availability

The Default content availability flag enables you to control whether content is available when its translation is missing.

You can set the flag in Content Type definition by checking the "Make content available even with missing translations" option.
It is automatically applied to any new Content item of this Type.

![Default content availability](availability_flag.png "Default content availability")

A Content item with this flag will be available in its main language
even if it is not translated into the language of the current SiteAccess.

Without the flag, a Content item will not be available at all if it does not have a language version
corresponding to the current SiteAccess.

!!! note

    There is currently no way in the Back Office to edit the Content availability flag
    for an already published Content item.
    
    To do this via [PHP API](creating_content.md#updating-content), set the [`alwaysAvailable` property](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentMetadataUpdateStruct.php#L52) of the Content metadata.

The Default availability flag is used for the out-of-the box Content Types representing content
that should always be visible to the user, such as media files or user Content items.

You can also use it for organizational Content Types.

For example, you can assign the flag to a Blog Content Type which is intended to contain Blog Posts
in multiple languages. If the Blog is in English only, it would not be visible for readers
using the Norwegian or German SiteAcceses.
However, if you set the default availability flag for the Blog Content Type,
it will be displayed to them in English (if it is set as a main language) and will enable the users to browse individual
posts in other languages.
