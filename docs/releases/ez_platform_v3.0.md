# eZ Platform v3.0

**Version number**: v3.0

**Release date**: TBD

**Release type**: Fast Track

## Overview

## Notable changes

### Symfony 4

The version 3.0 moves eZ Platform to Symfony 4.3 from the previously used Symfony 3.

This entails several changes to the way projects are organized.
For details, see [Symfony upgrade documentation](https://github.com/symfony/symfony/blob/master/UPGRADE-4.0.md).

### Field Type creation

You can now use [Generic Field Type](../guide/extending_field_type.md) as a template for your custom Field Types.

### Using Events instead of SignalSlots

The application now uses Symfony Events instead of SignalSlots.
The application triggers two Events per operation: one before and one after the relevant thing happens
(see for example [BookmarkEvents](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/Event/Bookmark/BookmarkEvents.php)).

To use Symfony Events, create [Event Listeners](https://symfony.com/doc/4.3/event_dispatcher.html) in your code.

### New bundles

The list of bundles in v3.0 has been extended by the following ones:

- `ezplatform-calendar`
- `ezplatform-content-comparison`
- `ezplatform-workflow`

For details, see [Bundles](../guide/bundles.md).

## New features

### Content query Field Type

The new [Content query Field Type](../api/field_type_reference.md#content-query-field-type)
enables you to configure a content query that will use parameters from a Field definition.

### Schedule calendar

You can now easily view and perform scheduling actions using the Calendar widget available in the Back Office.
By default, the widget displays Content items scheduled for future publication, but custom events can be configured as well.
You can also filter displayed events and toggle through a day, week, and month view.

### Manage planned publications with Dashboard
    
You can now reschedule or cancel planned future publications right from the Dashboard.

### Defining buttons in Online Editor toolbars

### Random sorting

The list of common Sort Clauses has been extended by the Random sorting option.

### Workflow improvements

#### Workflow actions

You can now configure your workflows to [automatically publish content](../guide/workflow.md#publishing-content-with-workflow).

#### Reviewers

When sending content through a workflow, the user can now select reviewers.
You can require the user to select reviewers when sending content through the workflow.

In the configuration, you can also set the workflow to [automatically notify the selected reviewers](../guide/workflow.md#sending-notifications).

#### Quick review

A built-in Quick Review offers a quick workflow configuration for your basic needs.

#### Custom transition color

You can configure a custom color for each of the transitions defined in the Workflow.

### Password rules

You can now set [password expiration rules](../guide/user_management.md#password-expiration)
for user passwords.

### Grouping blocks in Page Builder

You can now assign Page Builder blocks to groups using the `ezplatform_page_fieldtype.blocks.<block_name>.category` setting.

### Bulk actions in Sub-items list

You can now use the Sub-items list to quickly hide, reveal, to add Locations to multiple Content items.

## Other changes

### GraphQL

In GraphQL, you can now [query Locations and their children](../api/graphql_queries.md#querying-locations).

### Improved translating of notifications

`TranslationService` is not injected into the `NotificationService`.
You can now use `TranslatableNotificationHandlerInterface` for translated notifications.

### Renamed templates and parameters

Templates and parameters used by the Back Office have been renamed for consistency.
For A full list of changes, see [Backwards compatibility doc](ez_platform_v3.0_deprecations.md).

### HTTP Cache

HTTP cache bundle now uses FOS Cache Bundle v2.
For a full list of changes this entails, see [Backwards compatibility doc](ez_platform_v3.0_deprecations.md#ezplatform-http-cache).

### Helpers

New helper method `window.eZ.helpers.contentType.getContentTypeName` replaces deprecated `ContentTypeNames`.

### User Field Type

User data is now treated as an external storage.

### SiteAccess-aware Repository

The Repository now uses the SiteAccess-aware layer by default.
This means that Repository objects will now be loaded in the translation corresponding to the SiteAccess.

### REST API

Revealing and hiding content can now be performed via REST API.

### PHP API

New methods have been introduced to the PHP API:

`\eZ\Publish\API\Repository\Values\Content\ContentInfo::getContentType`
`\eZ\Publish\API\Repository\Values\Content\ContentInfo::getSection`
`\eZ\Publish\API\Repository\Values\Content\ContentInfo::getMainLanguage`
`\eZ\Publish\API\Repository\Values\Content\ContentInfo::getMainLocation`
`\eZ\Publish\API\Repository\Values\Content\ContentInfo::getOwner`
`\eZ\Publish\API\Repository\Values\Content\VersionInfo::getCreator`
`\eZ\Publish\API\Repository\Values\Content\VersionInfo::getInitialLanguage`
`\eZ\Publish\API\Repository\Values\Content\VersionInfo::getLanguages`
`\eZ\Publish\API\Repository\Values\Content\Location::getParentLocation`

## Deprecations and removals

### SignalSlots

SignalSlots are removed from the application.
Use [Event Listeners](https://symfony.com/doc/4.3/event_dispatcher.html) in your code instead.

### Deprecated Field Types

The deprecated `ezprice` and `ezpage` Field Types have been removed.
Nameable field type interface has been removed and replaced by `eZ\Publish\SPI\FieldType\FieldType::getName`.
For a full list of changes on Field Types, see [Backwards compatibility doc](ez_platform_v3.0_deprecations.md#field-types).

### Elastic Search

Elastic Search support has been dropped.

### REST server

REST-related code has been moved from Kernel to a new [`ezsystems/ezplatform-rest`](https://github.com/ezsystems/ezplatform-rest) package.
Following the change, the REST client has been removed from Kernel.

### Online Editor

Online Editor front-end code and assets have been moved to the `ezplatform-richtext` repository.
For a full list of resulting changes, see [Backwards compatibility doc](ez_platform_v3.0_deprecations.md#online-editor).

### Configuration through `ezplatform`

In YAML configuration, the main configuration key is now `ezplatform` instead of `ezpublish`.

### Content forms

The new `ezplatform-content-forms` package contains forms for content creation moved from `repository-forms`,
while Content Type editing has been moved to `ezplatform-admin-ui` from `repository-forms`.

## Requirements changes

eZ Platform now requires using PHP 7.3.

!!! note

    Some OS-es, such as  Ubuntu 10.x or CentoOS 8.x come with PHP 7.2.
    In such cases remember to manually update the PHP version.

## Updating

### Custom Installers

The Symfony Service definitions, providing extension point to create custom installers, have been removed.
For the upgrade details, see [eZ Platform v3.0 project update instructions](./ez_platform_v3.0_project_update.md#custom-installers).

## Full changelog
