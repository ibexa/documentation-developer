# eZ Platform v3.0 deprecations and BC breaks


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

### Elastic Search

Elastic Search support has been dropped.


## Deprecations
