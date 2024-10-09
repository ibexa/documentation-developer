---
description: A content type is a base for new content items.
---

# Content types

A content type is a base for new content items.
It defines what Fields will be available in the content item.

![Content types](admin_panel_content_types.png "Content types")

For example, a new content type called *Article* can have Fields such as title, author, body, image, etc.
Based on this content type, you can create any number of content items.
content types are organized into groups.

![Content type groups](admin_panel_content_type_groups.png "Content type groups")

You can add your own groups here to keep your content types in better order.

For a full tutorial, see [Add a content type](first_steps.md#add-a-content-type) or follow [user documentation](https://doc.ibexa.co/projects/userguide/en/latest/content_management/create_edit_content_types/).
For a detailed overview of the content model, see [Content model overview](content_model.md).

## Content type metadata

Each content type is characterized by a set of metadata which define the general behavior of its instances:

**Name** – a user-friendly name that describes the content type. This name is used in the interface, but not internally by the system. It can consist of letters, digits, spaces and special characters; the maximum length is 255 characters. (Mandatory.)

!!! note

    Note that even if your content type defines a Field intended as a name for the content item (for example, a title of an article or product name), do not confuse it with this Name, which is a piece of metadata, not a Field.

**Identifier** –
an identifier for internal use in configuration files, templates, PHP code, etc.
It must be unique, can only contain lowercase letters, digits, and underscores.
The maximum length is 50 characters. (Mandatory.)

**Description** –
a detailed description of the content type. (Optional.)

<a id="content-name-pattern"></a>
**Content name pattern** –
a pattern that defines what name a new content item based on this content type gets.
The pattern usually consists of Field identifiers that tell the system which Fields it should use when generating the name of a content item.
Each Field identifier has to be surrounded with angle brackets.
Text outside the angle brackets is included literally.
If no pattern is provided, the system will automatically use the first Field. (Optional.)

??? note "Pattern examples"

    The following pattern takes the value of the field with the identifier `title` (which is required):
    ```
    <title>
    ```

    The following pattern combines several field values:
    ```
    <firstname> <lastname>
    ```

    The following pattern takes the value of the field with the identifier `seo_title` (which is optional) if not empty,
    else the value of the field with the identifier `short_title` (which is optional),
    else it takes the one with identifier `title` (which is required):
    ```
    <seo_title|short_title|title>
    ```

    The following pattern takes the value of the field with the identifier `nickname` if not empty,
    else it takes the ones with identifiers `firstname` and `lastname` with a space inbetween:
    ```
    <nickname|(<firstname> <lastname>)>
    ```

    - Input-output example:
        - `fistname`: "*Alice*"
        - `lastname`: "*Doe*"
        - `nickname`: "" (empty)
        - Generated content name: "*Alice Doe*"
    - Input-output example:
        - `fistname`: "*Robert*"
        - `lastname`: "*Doe*"
        - `nickname`: "*Bob*"
        - Generated content name: "*Bob*"

    **Notice that you won't be able to obtain a vertical bar `|`  or parentheses in the generated names as they are special characters.**


**URL alias name pattern** –
a pattern which controls how the virtual URLs of the Locations is generated when content items are created based on this content type.
Only the last part of the virtual URL is affected. The pattern works in the same way as the Content name pattern.
Text is converted using the selected method of URL transformation.
If no pattern is provided, the system automatically uses the name of the content item itself. (Optional.)

!!! tip "Changing URL alias and Content name patterns"

    If you change the Content name pattern or the URL alias name pattern,
    existing content items will not be modified automatically.
    The new pattern will only be applied after you modify the content item and save a new version.

    The old URL aliases will continue to redirect to the same content items.

**Container** –
a flag which indicates if content items based on this content type are allowed to have sub-items or not
(mainly relevant for actions via the UI, not validated by every PHP API).

!!! note

    This flag was added for convenience and only affects the interface.
    In other words, it doesn't control any actual low-level logic,
    it simply controls the way the graphical user interface behaves.

**Sort children by default by** –
rule for sorting sub-items.
If the instances of this content type can serve as containers,
their children are sorted according to what is selected here.

**Sort children by default in order** –
another rule for sorting sub-items.
This decides the sort order for the criterion chosen above.

<a id="default-content-availability"></a>
**Make content available even with missing translations** –
a flag which indicates if content items of this content type should be available even without a corresponding language version.
See [Content availability](content_availability.md).

![Creating a new content type](admin_panel_new_content_type.png)

## Field definitions

Aside from the metadata, a content type may contain any number of Field definitions (but has to contain at least one).
They determine what Fields of what Field Types will be included in all content items based on this content type.

![Field definitions](admin_panel_field_definitions.png)

![Diagram of an example content type](content_model_type_diagram.png)

!!! note

    You can assign each Field defined in a content type to a group by selecting one of the groups in the Category drop-down. [Available groups can be configured in the content repository](repository_configuration.md).

!!! caution

    In case of content types containing many Field Types you should be aware of possible memory-related issues with publishing/editing.
    They are caused by the limitation of how many `$_POST` input variables can be accepted.

    The easiest way to fix them is by increasing the `max_input_vars` value in the `php.ini` configuration file.
    Note that this solution is not universally recommended and you're proceeding on your own risk.

    Setting the limit inappropriately may damage your project or cause other issues.
    You may also experience performance problems with such large content types, in particular when you have many content items.
    If you're experincing too many issues, consider rearranging your project to avoid them.

## Modifying content types

A content type and its Field definitions can be modified after creation,
even if there are already content items based on it in the system.
When a content type is modified, each of its instances will be changed as well.
If a new Field definition is added to a content type, this Field will appear (empty) in every relevant content item.
If a Field definition is deleted from the content type, all the corresponding Fields will be removed from content items of this type.

## Removing content types

System content types are by default used for the File Uploads and removing them will cause errors.

If you decide to remove a `file` or `image` content type, or change their identifiers,
you will need to change the configuration, so it reflects the available content types.

Example configuration:

```yaml
parameters:
    ibexa.multifile_upload.location.default_mappings:
        # Image
        - mime_types:
            - image/jpeg
            - image/jpg
            - image/pjpeg
            - image/pjpg
            - image/png
            - image/bmp
            - image/gif
            - image/tiff
            - image/x-icon
            - image/webp
          content_type_identifier: custom_image_contenttype
          content_field_identifier: image
          name_field_identifier: name
        # File
        - mime_types:
            - image/svg+xml
            - application/msword
            - application/vnd.openxmlformats-officedocument.wordprocessingml.document
            - application/vnd.ms-excel
            - application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
            - application/vnd.ms-powerpoint
            - application/vnd.openxmlformats-officedocument.presentationml.presentation
            - application/pdf
          content_type_identifier: custom_file_contenttype
          content_field_identifier: file
          name_field_identifier: name
    ibexa.multifile_upload.fallback_content_type:
        content_type_identifier: custom_file_contenttype
        content_field_identifier: file
        name_field_identifier: name
```
