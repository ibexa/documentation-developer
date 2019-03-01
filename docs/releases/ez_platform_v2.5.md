# eZ Platform v2.5

**Version number**: v2.5

**Release date**: March 29, 2019

**Release type**: Long Term Supported

## Notable changes

### Content Tree

### Webpack Encore

### PostgreSQL

### User Settings

The User Settings menu has been expanded with the following options:

- Preferred language of the Back Office
- Preferred date format
- Preference to collapse or expand content preview

TODO screenshot

### User bundle

The new [ezplatform-user](https://github.com/ezsystems/ezplatform-user) bundle now centralizes
all features related to user management, such as user accounts, registering, changing passwords, etc.

### Workflow improvements

You can now preview a diagram of the configured workflows in the Admin panel.

TODO screenshot

After selecting configured workflow administrator user is now able to see all Content items under review for it.

![Content under review](img/workflow_content_under_review.png)

### eZ Commerce clean Installer

### Online editor

Anchors in Richtext

Inline Custom tags

### Back Office improvements

Several Back Office improvements to facilitate editorial experience, including:

- Icons for Content Types and the ability to define them
- Ability to collapse and expand content preview to have easier access to the Sub-items list
- Responsive Sub-items table with selectable column layout
- Simpler assigning of Object States to content

TODO screenshot

### eZMatrix Field Type

### GraphQL

### API improvements

New API improvements include:

- `sudo()` exposed to skip permission checks
- `AssignSectionToSubtreeSignal` to assign Sections to subtrees

As a Developer I possibility to load several languages at once
As a Developer I'd like API for bulk loading Content Info Items

### BC breaks and important behavior changes

### Requirements changes

Due to using Webpack Encore installing and updating eZ Platform now [requires Node.js and yarn](updating_ez_platform.md#3-update-the-app).

This release also changes support for versions of third-party software:

- Solr 4 is no longer supported. Use Solr 6 instead.
- Apache 2.2 is no longer supported. Use Apache 2.4 instead.
- Varnish 4 is no longer supported. Use Varnish 5.1 or higher.

For full list of supported versions see [Requirements](../getting_started/requirements.md).

## Full list of new features, improvements and bug fixes since v2.4

| eZ Platform  | eZ Enterprise  |
|--------------|------------|
| [List of changes for final of eZ Platform v2.5.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.5.0) | [List of changes for final for eZ Platform Enterprise Edition v2.5.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.5.0) |
| [List of changes for rc1 of eZ Platform v2.5.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.5.0-rc1) | [List of changes for rc1 for eZ Platform Enterprise Edition v2.5.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.5.0-rc1) |
| [List of changes for beta1 of eZ Platform v2.5.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v2.5.0-beta1) | [List of changes for beta1 of eZ Platform Enterprise Edition v2.5.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v2.5.0-beta1) |
