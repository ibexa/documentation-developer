# eZ Platform v3.0

**Version number**: v3.0

**Release date**:

**Release type**: Fast Track

## Overview

## Notable changes

### Symfony 4

Version v3.0 moves eZ Platform to Symfony 4.3 from the previously used Symfony 3.

This entails several changes to the way projects are organized.
Refer to [Symfony upgrade documentation](https://github.com/symfony/symfony/blob/master/UPGRADE-4.0.md)
for details of all changes.

### Field Type creation

You can now use [Generic Field Type](../guide/extending_field_type.md) as a template for your custom Field Types.

### Using Events instead of SignalSlots

The application now uses Symfony Events instead of SignalSlots.
The application triggers two Events per operation: one before and one after the relevant thing happens
(see for example [BookmarkEvents](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/Event/Bookmark/BookmarkEvents.php)).

To use them, create [Event Listeners](https://symfony.com/doc/4.3/event_dispatcher.html) in your code.

## New features

### Schedule calendar

### Manage planned publications with Dashboard
    
You can now reschedule or cancel planned future publications right from the Dashboard.

### Defining buttons in Online Editor toolbars

### Random sorting

The list of common Sort Clauses has been extended by the Random sorting option.

### Custom Workflow transition color

You can configure a custom color for each of the transitions defined in the Workflow.

### Password rules

You can now set [password expiration rules](../guide/user_management.md#password-expiration)
for user passwords.

## Other changes

### GraphQL

In GraphQL you can now [query Locations and their children](../api/graphql_queries.md#querying-locations).

### Improved translating of notifications

`TranslationService` is not injected into the `NotificationService`.
You can now use `TranslatableNotificationHandlerInterface` for translated notifications.

### Renamed templates and parameters

Templates and parameters used by the Back Office have been renamed for consistency.
Refer to [Backwards compatibility doc](ez_platform_v3.0_deprecations.md) for full list of changes.

### HTTP Cache

HTTP cache bundle now uses FOS Cache Bundle v2.
Refer to [Backwards compatibility doc](ez_platform_v3.0_deprecations.md#http-cache-bundle)
for full list of changes this entails.

### Helpers

New helper method `window.eZ.helpers.contentType.getContentTypeName` replaces deprecated `ContentTypeNames`.

### User Field Type

User data is now treated as an external storage.

### SiteAccess-aware Repository

The Repository now uses the SiteAccess-aware layer by default.
This means Repository objects will now be loaded in the translation corresponding to the SiteAccess.

### REST API

Revealing and hiding content can now be performed via REST API.

## Deprecations and removals

### SignalSlots

SignalSlots are removed from the application.
Use [Event Listeners](https://symfony.com/doc/4.3/event_dispatcher.html) in your code instead.

### Deprecated Field Types

Deprecated `ezprice` and `ezpage` Field Types have been removed.
Nameable field type interface has been removed and replaced by `eZ\Publish\SPI\FieldType\FieldType::getName`.
Refer to [Backwards compatibility doc](ez_platform_v3.0_deprecations.md#field-types) for full list of changes on Field Types.

### Elastic Search

Elastic Search support has been dropped.

### REST server

REST-related code has been moved from Kernel to a new [`ezsystems/ezplatform-rest`](https://github.com/ezsystems/ezplatform-rest) package.
This also removed the REST client from Kernel.

### Online Editor

Online Editor front-end code and assets have been moved to the `ezplatform-richtext` repository.
Refer to [Backwards compatibility doc](ez_platform_v3.0_deprecations.md#online-editor) for full list of resulting changes.

### Configuration through `ezplatform`

In YAML configuration, `ezplatform` is now used instead of `ezpublish` as the main configuration key.

### Content forms

The new `ezplatform-content-forms` package contains forms for content creation moved from `repository-forms`,
while Content Type editing has been moved to `ezplatform-admin-ui` from `repository-forms`.

## Requirements changes

eZ Platform now requires using PHP 7.3.

!!! note

    Some OS-es, such as  Ubuntu 10.x or CentoOS 8.x come with PHP 7.2.
    In such cases remember to update PHP version manually.

## Updating

### Custom Installers

The Symfony Service definitions, providing extension point to create custom installers, have been removed.
See [eZ Platform v3.0 project update instructions](./ez_platform_v3.0_project_update.md#custom-installers) for upgrade details.

## Full changelog
