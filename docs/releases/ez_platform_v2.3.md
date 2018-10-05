# eZ Platform v2.3

**Version number**: v2.3

**Release date**: October 5, 2018

**Release type**: Fast Track

## Notable changes

### Content scheduling

!!! enterprise

    You can now schedule content on a Page to become visible at a specific time in the future.

    To do this you can use the Schedule tab in any block's configuration or a special Content Scheduler block.

    In the Schedule tab you can define when any block becomes visible and when it disappears from a Page.

    ![Schedule tab](img/2.3_schedule_tab.png)

    Content Scheduler is a special block with a queue of Content items, each with its own airtime.
    The Content becomes available at the airtime, and is replaced with new Content items coming in from the queue.

    ![Content Scheduler](img/2.3_content_scheduler.png)

    All changes to scheduled content on a Page are visible in the timeline.

    ![Timeline and list of upcoming events](img/2.3_timeline_list.png)

    The timeline also shows other events, such a Content published using the date-based publisher.

### Form Builder

!!! enterprise

    The new Form Builder enables you to create Form Content items with multiple form fields.

    ![Form Builder](img/2.3_form_builder.png)

    You can preview and download submissions in the Back Office.

    ![Form Builder submissions](img/2.3_form_builder_submissions.png)

    See [Extending Form Builder](../guide/extending_form_builder.md) for information on how to modify and create Form fields.

### ImageAsset Field Type

You can now create a single source media library with images that can be reused across the system.

See [Reusing images](../guide/images.md#reusing-images) and [ImageAsset Field Type reference](../api/field_type_reference.md#imageasset-field-type) for more information.

![Set up multiple relations with image](img/2.3_image_asset.png)

### Regenerating URL aliases

A new `ezplatform:urls:regenerate-aliases` command enables you to regenerate all URL aliases.
You can use it after changing URL alias configuration, or in case of database corruption.

See [Regenerating URL aliases](../guide/url_management.md#regenerating-url-aliases) for more information.

### User preferences

You can now access and set user preferences in the user menu.

![User preferences screen with time zone settings](img/2.3_user_preferences.png)

It is covered by the `user/preferences` Policy.

### Dates in preferred timezone

eZ Platform can now display dates across the system using timezone from User Settings.

### Improved selection in UDW

Selection of content in Universal Discovery Widget has seen improvements,
in particular when selecting multiple Content items.

![Multiple selection on UDW](img/2.3_udw_selection.png)

### API improvements

Improvements to the API cover:

- [`UserPreferenceService`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/UserPreferenceService.php)
- [`ASSET` Relation type](https://github.com/ezsystems/ezpublish-kernel/blob/v7.3.0-rc2/eZ/Publish/Core/REST/Client/Input/Parser/Relation.php#L84)
- `TrashItem->trashed` timestamp covers when a Content item was placed in Trash

#### Back Office translations

There are three new ways you can now contribute to Back Office translations:
- translate in-context with bookmarks
- translate in-context with console
- translate directly on the Crowdin website

See [How to translate the interface using Crowdin](../community_resources/translations.md#how-to-translate-the-interface-using-crowdin) for more information.

## Full list of new features, improvements and bug fixes since v2.2.0

| eZ Platform   | eZ Enterprise  |
|--------------|------------|
| [List of changes for final of eZ Platform v2.3.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.3.0) | [List of changes for final for eZ Platform Enterprise Edition v2.3.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.3.0) |
| [List of changes for rc2 of eZ Platform v2.3.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.3.0-rc2) | [List of changes for rc2 for eZ Platform Enterprise Edition v2.3.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.3.0-rc2) |
| [List of changes for rc1 of eZ Platform v2.3.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.3.0-rc1) | [List of changes for rc1 for eZ Platform Enterprise Edition v2.3.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.3.0-rc1) |
| [List of changes for beta1 of eZ Platform v2.3.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.3.0-beta1) | [List of changes for beta1 of eZ Platform Enterprise Edition v2.3.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.3.0-beta1) |

## Installation

[Installation Guide](../getting_started/install_ez_platform.md)

[Technical Requirements](../getting_started/requirements_and_system_configuration.md)
