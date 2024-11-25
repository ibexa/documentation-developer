<!-- vale VariablesVersion = NO -->

# eZ Platform v2.3

**Version number**: v2.3

**Release date**: October 5, 2018

**Release type**: Fast Track

## Notable changes

### Content scheduling

!!! note

    You can now schedule content on a Page to become visible at a specific time in the future.

    To do this you can use the **Schedule** tab in any block's configuration or a special Content Scheduler block.

    In the **Schedule** tab you can define when any block becomes visible and when it disappears from a Page.

    ![Schedule tab](2.3_schedule_tab.png)

    Content Scheduler is a special block with a queue of content items, each with its own airtime.
    The Content becomes available at the airtime, and is replaced with new content items coming in from the queue.

    ![Content Scheduler](2.3_content_scheduler.png)

    All changes to scheduled content on a Page are visible in the timeline.

    ![Timeline and list of upcoming events](2.3_timeline_list.png)

    The timeline also shows other events, such a Content published with the date-based publisher.

For more information, see [advanced publishing options](https://doc.ibexa.co/projects/userguide/en/2.5/publishing/advanced_publishing_options) in User Documentation.

### Form Builder

!!! note

    The new Form Builder enables you to create Form content items with multiple form fields.

    ![Form Builder](2.3_form_builder.png)

    You can preview and download submissions in the back office.

    ![Form Builder submissions](2.3_form_builder_submissions.png)

    See [Extending Form Builder](https://doc.ibexa.co/en/2.5/guide/extending/extending_form_builder) for information on how to modify and create Form fields.

For more information, see [forms](https://doc.ibexa.co/projects/userguide/en/2.5/creating_content_advanced/#forms) in User Documentation.

### ImageAsset field type

You can now create a single source media library with images that can be reused across the system.

For more information, see [Reusing images](https://doc.ibexa.co/en/2.5/guide/images/#reusing-images) and [ImageAsset field type reference](https://doc.ibexa.co/en/2.5/api/field_types_reference/imageassetfield).

![Set up multiple relations with image](2.3_image_asset.png)

### Regenerating URL aliases

A new `ezplatform:urls:regenerate-aliases` command enables you to regenerate all URL aliases.
You can use it after changing URL alias configuration, or in case of database corruption.

For more information, see [Regenerating URL aliases](https://doc.ibexa.co/en/2.5/guide/url_management/#regenerating-url-aliases).

### User preferences

You can now access and set user preferences in the user menu.

![User preferences screen with time zone settings](2.3_user_preferences.png)

It's covered by the `user/preferences` policy.

### Dates in preferred timezone

eZ Platform can now display dates across the system using timezone from User Settings.

### Improved selection in UDW

Selection of content in Universal Discovery Widget has seen improvements,
in particular when selecting multiple content items.

![Multiple selection on UDW](2.3_udw_selection.png)

### API improvements

Improvements to the API cover:

- [`UserPreferenceService`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.3.0/eZ/Publish/API/Repository/UserPreferenceService.php)
- [`ASSET` Relation type](https://github.com/ezsystems/ezpublish-kernel/blob/v7.3.0-rc2/eZ/Publish/Core/REST/Client/Input/Parser/Relation.php#L84)
- `TrashItem->trashed` timestamp covers when a content item was placed in Trash

#### Back office translations

There are three new ways you can now contribute to back office translations:
- translate in-context with bookmarks
- translate in-context with console
- translate directly on the Crowdin website

For more information, see [How to translate the interface using Crowdin](https://doc.ibexa.co/en/2.5/community_resources/translations/#how-to-translate-the-interface-using-crowdin).

## Full list of new features, improvements and bug fixes since v2.2.0

| eZ Platform   | eZ Enterprise  |
|--------------|------------|
| [List of changes for final of eZ Platform v2.3.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.3.0) | [List of changes for final for eZ Platform Enterprise Edition v2.3.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.3.0) |
| [List of changes for rc2 of eZ Platform v2.3.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.3.0-rc2) | [List of changes for rc2 for eZ Platform Enterprise Edition v2.3.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.3.0-rc2) |
| [List of changes for rc1 of eZ Platform v2.3.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.3.0-rc1) | [List of changes for rc1 for eZ Platform Enterprise Edition v2.3.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.3.0-rc1) |
| [List of changes for beta1 of eZ Platform v2.3.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.3.0-beta1) | [List of changes for beta1 of eZ Platform Enterprise Edition v2.3.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.3.0-beta1) |

## Installation

[Installation guide](https://doc.ibexa.co/en/2.5/getting_started/install_ez_platform)

[Technical requirements](https://doc.ibexa.co/en/2.5/getting_started/requirements)
