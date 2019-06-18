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

### Using Events instead of SignalSlots

The application now uses Symfony Events instead of SignalSlots.
The application triggers two Events per operation: one before and one after the relevant thing happens
(see for example [BookmarkEvents](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/Event/Bookmark/BookmarkEvents.php)).

To use them, create [Event Listeners](https://symfony.com/doc/4.3/event_dispatcher.html) in your code.

## New features

### Schedule calendar

### Custom attributes in Rich Text elements

### Defining buttons in Online Editor toolbars

### Solr Cloud

### Random sorting


## Other changes

### Improved translating of notifications

`TranslationService` is not injected into the `NotificationService`.
You can now use `TranslatableNotificationHandlerInterface` for translated notifications.

### Renamed templates and parameters

Templates and parameters used by the Back Office have been renamed for consistency.
Refer to [Backwards compatibility doc]() for full list of changes.

## Deprecations and removals

### SignalSlots

SignalSlots are removed from the application.
Use [Event Listeners](https://symfony.com/doc/4.3/event_dispatcher.html) in your code instead.

### Deprecated Field Types

### Elastic Search

Elastic Search support has been dropped.

### REST server

REST-related code has been moved from Kernel to a new [`ezsystems/ezplatform-rest`](https://github.com/ezsystems/ezplatform-rest) package.
This also removed the REST client from Kernel.


## Requirements changes


## Updating


## Full changelog
