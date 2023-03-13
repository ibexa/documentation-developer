---
description: A Content Type is a base for new Content items.
---

# Content Types

A Content Type is a base for new Content items.
It defines what Fields will be available in the Content item.

![Content Types](admin_panel_content_types.png "Content Types")

For example, a new Content Type called *Article* can have Fields such as title, author, body, image, etc.
Based on this Content Type, you can create any number of Content items.
Content Types are organized into groups.

![Content Type groups](admin_panel_content_type_groups.png "Content Type groups")

You can add your own groups here to keep your Content Types in better order.

For a full tutorial, see [Create a Content Type](first_steps.md#create-a-content-type) or follow [user documentation](https://doc.ibexa.co/projects/userguide/en/latest/organizing_the_site/#content-types).
For a detailed overview of the content model, see [Content model overview](content_model.md).

## Content Type metadata

Each Content Type is characterized by a set of metadata which define the general behavior of its instances:

**Name** – a user-friendly name that describes the Content Type. This name is used in the interface, but not internally by the system. It can consist of letters, digits, spaces and special characters; the maximum length is 255 characters. (Mandatory.)

!!! note

    Note that even if your Content Type defines a Field intended as a name for the Content item (for example, a title of an article or product name), do not confuse it with this Name, which is a piece of metadata, not a Field.

**Identifier** – an identifier for internal use in configuration files, templates, PHP code, etc. It must be unique, can only contain lowercase letters, digits and underscores; the maximum length is 50 characters. (Mandatory.)

**Description** – a detailed description of the Content Type. (Optional.)

<a id="content-name-pattern"></a>**Content name pattern** – a pattern that defines what name a new Content item based on this Content Type gets. The pattern usually consists of Field identifiers that tell the system which Fields it should use when generating the name of a Content item. Each Field identifier has to be surrounded with angle brackets. Text outside the angle brackets will be included literally. If no pattern is provided, the system will automatically use the first Field. (Optional.)

**URL alias name pattern** – a pattern which controls how the virtual URLs of the Locations will be generated when Content items are created based on this Content Type. Note that only the last part of the virtual URL is affected. The pattern works in the same way as the Content name pattern. Text outside the angle brackets will be converted using the selected method of URL transformation. If no pattern is provided, the system will automatically use the name of the Content item itself. (Optional.)

!!! tip "Changing URL alias and Content name patterns"

    If you change the Content name pattern or the URL alias name pattern,
    existing Content items will not be modified automatically.
    The new pattern will only be applied after you modify the Content item and save a new version.

    The old URL aliases will continue to redirect to the same Content items.

**Container** – a flag which indicates if Content items based on this Content Type are allowed to have sub-items or not.

!!! note

    This flag was added for convenience and only affects the interface. In other words, it doesn't control any actual low-level logic, it simply controls the way the graphical user interface behaves.

**Sort children by default by** – rule for sorting sub-items. If the instances of this Content Type can serve as containers, their children will be sorted according to what is selected here.

**Sort children by default in order** – another rule for sorting sub-items. This decides the sort order for the criterion chosen above.

<a id="default-content-availability"></a>**Make content available even with missing translations** – a flag which indicates if Content items of this Content Type should be available even without a corresponding language version. See [Content availability](content_availability.md).

![Creating a new Content Type](admin_panel_new_content_type.png)

## Field definitions

Aside from the metadata, a Content Type may contain any number of Field definitions (but has to contain at least one).
They determine what Fields of what Field Types will be included in all Content items based on this Content Type.

![Diagram of an example Content Type](content_model_type_diagram.png)

!!! note

    You can assign each Field defined in a Content Type to a group by selecting one of the groups in the Category drop-down. [Available groups can be configured in the content repository](repository_configuration.md).

!!! caution

    In case of Content Types containing many Field Types you should be aware of possible memory-related issues with publishing/editing.
    They are caused by the limitation of how many `$_POST` input variables can be accepted.

    The easiest way to fix them is by increasing the `max_input_vars` value in the `php.ini` configuration file.
    Note that this solution is not universally recommended and you're proceeding on your own risk.

    Setting the limit inappropriately may damage your project or cause other issues.
    You may also experience performance problems with such large Content Types, in particular when you have many Content items.
    If you're experincing too many issues, consider rearranging your project to avoid them.

## Modifying Content Types

A Content Type and its Field definitions can be modified after creation,
even if there are already Content items based on it in the system.
When a Content Type is modified, each of its instances will be changed as well.
If a new Field definition is added to a Content Type, this Field will appear (empty) in every relevant Content item.
If a Field definition is deleted from the Content Type, all the corresponding Fields will be removed from Content items of this type.

## Removing Content Types

System Content Types are by default used for the File Uploads and removing them will cause errors.

If you decide to remove a `file` or `image` Content Type, or change their identifiers,
you will need to change the configuration, so it reflects the available Content Types.

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