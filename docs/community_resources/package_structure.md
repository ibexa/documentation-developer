# Package and bundle structure, namespaces

**Target audience**: Symfony backend Ibexa Community Contributors and Ibexa Engineers.

This specification **IS NOT meant** for 3rd party packages or projects.

What needs to be emphasised is that the conventions described here are meant to be applied as an evolution.
It means that while the existing code won't be changed at once (or at all in some cases), the new code
needs to follow the rules outlined here.

## Root PHP namespace

eZ Platform by Ibexa core PHP code needs to be defined in a namespace with the following prefix:

```php
namespace Ibexa\Platform;
```

## Packages

The general package directory structure and corresponding PHP namespace mapping is as follows.
```
.
+-- src
|   +-- bundle (`Ibexa\Platform\Bundle\<PackageName>`)
|   +-- contracts (`Ibexa\Platform\Contracts\<PackageName>`)
|   +-- lib (`Ibexa\Platform\<PackageName>`)
+-- tests
|   +-- bundle (`Ibexa\Platform\Tests\Bundle\<PackageName>`)
|   +-- integration (`Ibexa\Platform\Tests\Integration\<PackageName>`)
|   +-- lib (`Ibexa\Platform\Tests\<PackageName>`)
```

If a package does not contain some of the described parts, te directories MAY BE skipped.

### Implementation (lib)

The **`src/lib`** directory and its corresponding namespace:
```php
namespace Ibexa\Platform\<PackageName>;
```
is meant for internal implementation not tied to the Symfony Framework.

Example:

```php
namespace Ibexa\Platform\Search;
```

A package which groups some DXP features MAY use an additional prefix, for example:

```php
namespace Ibexa\Commerce\Shop;
```

### Bundles

The bundle class definition in the **`src/bundle`** directory MUST BE as follows:

```php
namespace Ibexa\Platform\Bundle\<PackageName>;

class Ibexa<ProductName><PackageName>Bundle // ...
```

Example:
```php
namespace Ibexa\Platform\Bundle\Search;

class IbexaPlatformSearchBundle // ...
```

### Contracts

A package MAY introduce a namespace for contracts, to be consumed by 1st and 3rd party packages
and projects, which MUST be prefixed as:

```php
namespace Ibexa\Platform\Contracts;
```

Examples:

```php
namespace Ibexa\Platform\Contracts\Kernel;
```

```php
namespace Ibexa\Platform\Contracts\SiteFactory;
```

That namespace needs to be mapped to the **`src/contracts`** directory of a package.
