# eZ Platform v3.0

**Version number**: v3.0

**Release date**:

**Release type**: Fast Track

## Overview


## Notable changes

### Symfony 4

### Field Type creation

### Using events instead of SignalSlots


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

### Deprecated Field Types

### Elastic Search

Elastic Search support has been dropped.

### REST server

REST-related code has been moved from Kernel to a new [`ezsystems/ezplatform-rest`](https://github.com/ezsystems/ezplatform-rest) package.
This also removed the REST client from Kernel.


## Requirements changes


## Updating


## Full changelog
