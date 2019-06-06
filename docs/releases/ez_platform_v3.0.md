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


## Deprecations and removals

### SignalSlots

### Deprecated Field Types

### Elastic Search

### REST server

REST-related code has been moved from Kernel to a new [`ezsystems/ezplatform-rest`](https://github.com/ezsystems/ezplatform-rest) package.
This also removed the REST client from Kernel.


## Backwards compatibility breaks

### Symfony 4

### ConfigResolver

### Field Types

### SignalSlots

### Template and parameter names

### Twig helper names

### JavaScript event names and code cleanup

### Online Editor

### REST server

Removal of REST code from Kernel to a separate package results in the following change:

`eZ\Publish\Core\REST` and `eZ\Publish\Core\REST\Common\` namespaces are replaced by `EzSystems\EzPlatformRest`.

REST client has been dropped.

### User Field Type

### HTTP cache bundle

### Deprecated Field Types


## Requirements changes


## Updating


## Full changelog
