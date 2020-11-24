# Package and bundle structure and namespaces

The following conventions apply to contributions to Ibexa core code, not to third party packages.

!!! note

    New code needs to follow the rules outlined here.
    They are being applied progressively to existing code.

## Root PHP namespace

Define [[= product_name =]] core PHP code in a namespace with the following prefix:

```php
namespace Ibexa\Platform;
```

A package which groups some DXP features can use an additional prefix, for example:

```php
namespace Ibexa\Platform\Commerce;
```

```php
namespace Ibexa\Platform\Personalization;
```

## Packages

The general package directory structure and corresponding PHP namespace mapping are:

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

If a package does not contain some of the described parts, you can skip those directories.

### Implementation (lib)

The `src/lib` directory and its corresponding `Ibexa\Platform\<PackageName>` namespace are meant for internal implementation not tied to the Symfony Framework.

Examples:

```php
namespace Ibexa\Platform\Search;
```

```php
namespace Ibexa\Platform\Commerce\Shop;
```

### Bundles

The bundle class definition in the `src/bundle` directory must be:

```php
namespace Ibexa\Platform\Bundle\<PackageName>;

class IbexaPlatform[ProductGroup]<PackageName>Bundle // ...
```

Examples:


```php
namespace Ibexa\Platform\Bundle\Search;

class IbexaPlatformSearchBundle // ...
```

```php
namespace Ibexa\Platform\Bundle\Commerce\Shop;

class IbexaPlatformCommerceShopBundle // ...
```

### Contracts

A package may introduce a namespace for contracts, to be consumed by first and third party packages
and projects, which must be prefixed as:

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

```php
namespace Ibexa\Platform\Contracts\Commerce\Shop;
```

That namespace needs to be mapped to the `src/contracts` directory of a package.
