# eZ Platform v2.2.0

**Version number**: v2.2.0

**Release date**: June 29, 2018

**Release type**: Fast Track

## Notable changes

### Page Builder

This version introduces the **Page Builder** which replaces the Landing Page editor from earlier versions.

![Page Builder](img/2.2_page_builder.png)

!!! note

    The Page Builder does not offer all blocks that Landing Page editor did.
    The removed blocks include Schedule and Form blocks.
    They will be included again in a future release.

    The Places Page Builder block has been removed from the clean installation and will only be available in the demo out of the box.
    If you had been using this block in your site, re-apply its configuration based on [the demo](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.2.2/app/config/blocks.yml).

#### Modifying the Page Content Type

You can edit the new Page Content Type by adding Fields, as well as create new Content Types with the Page Field Type.

![Editing Fields in Page Builder](img/2.2_page_builder_edit_fields.png)

#### Page block design

In the Page block config you can now specify the CSS class with its own style for the specific block:

![Setting the styling in Block configuration](img/2.2_block_settings_styling.png)

!!! caution "Updating to 2.2"

    Refer to [Updating eZ Platform](../updating/4_update_2.2.md) for a database update script.

    To update to 2.2 with existing Content you will need a [dedicated script for converting the Landing Page into the new Page](../updating/4_update_2.2.md#migrate-landing-pages).

### Bookmarks

Bookmark service allows you to create bookmarks for Locations by selecting a star located next to the Content Type name as shown in the screenshot below. Each Location can only be bookmarked once, multiple bookmarks on one Location will cause an error.

![Bookmark](img/bookmark.png)

You can find the list of all bookmarks in *Browse content* section. There, you can manage bookmarks by deleting them or by checking if specific Location has been bookmarked.

### Image placeholders

[Placeholder generator](../guide/images.md#setting-placeholder-generator) enables you to replace any missing image with downloaded or generated image placeholder. It can be used when you are working on an existing database and you are not able to download uploaded images to your local development environment because of their large size.

![Placeholder GenericProvider](img/placeholder_generic_provider.png)

### Standard design

eZ Platform now comes with two designs using the [design engine](../guide/design_engine.md): `standard` for content view and `admin` for the Back Office.
See [default designs](../guide/design_engine.md#default-designs) for more information.

!!! caution

    If you encounter problems during upgrading, disable the override
    by setting `ez_platform_standard_design.override_kernel_templates` to `false`.

### Previewing User and User Group permissions

When viewing User or User Group Content items you can now preview what permissions are assigned to them.

![Preview of permissions assigned to a User](img/2.2_permissions_in_user_view.png)

You can also [select which Content Types are treated the same way as User of User Group](../guide/configuration.md#user-identifiers) for these purposes.

### Change from UTF8 to UTF8MB4

Database charset is changed from UTF8 to UTF8MB4, in order to support 4-byte characters.

!!! caution

    To cover this change when upgrading, follow the instructions in the [update guide](../updating/4_update_2.2.md).

### URL generation pattern

You can now select the pattern that will be used to generate URL patterns.

See [URL alias patterns](../guide/url_management.md#url-alias-patterns) for more information about the available settings.

!!! caution "Default URL generation pattern"

    The default URL generation pattern changes from `urlalias` to `urlalias_lowercase`.
    This change will only apply to new Content.
    Pay attention to the new `url_alias.slug_converter.transformation` setting in the meta-repository when updating your installation.

### Choosing installation types

Installation types used with the `ezplatform:install` command are now more consistent:

- `ezplatform-clean`
- `ezplatform-demo`
- `ezplatform-ee-clean`
- `ezplatform-ee-demo`

You can also use the new `composer ezplatform-install` command which automatically chooses a correct installation type for the given meta-repository.

## API changes

### Notifications

[Notification Bundle](https://github.com/ezsystems/ezstudio-notifications) is now moved into CoreBundle of [EzPublishKernel](https://github.com/ezsystems/ezpublish-kernel).  This allows whole community to get access to eZ notification system.

### Bookmarks

New Bookmark service had been added. Bookmark operations are now available via the REST API.

### Simplified use of Content and languages in API

This release introduces a few notable simplifications to API use. Here are some highlights:

- [Location object now gives access to Content](../api/public_php_api_browsing.md#location-object-with-access-to-content)
- [Optional SiteAccessAware Repository](../api/public_php_api_browsing.md#siteaccess-aware-repository-optional)

## Full list of new features, improvements and bug fixes since v2.1.0

| eZ Platform   | eZ Enterprise  |
|--------------|------------|
| [List of changes for final of eZ Platform v2.2.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.2.0) | [List of changes for final for eZ Platform Enterprise Edition v2.2.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.2.0) |
| [List of changes for rc1 of eZ Platform v2.2.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.2.0-rc1) | [List of changes for rc1 for eZ Platform Enterprise Edition v2.2.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.2.0-rc1) |
| [List of changes for beta1 of eZ Platform v2.2.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.2.0-beta1) | [List of changes for beta1 of eZ Platform Enterprise Edition v2.2.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.2.0-beta1) |

## Installation

[Installation Guide](../getting_started/install_ez_platform.md)

[Technical Requirements](../getting_started/requirements.md)
