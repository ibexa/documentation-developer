# Package and bundle structure and namespaces

The following conventions apply to contributions to Ibexa core code, not to third party packages.

!!! note

    New code needs to follow the rules outlined here.
    They are being applied progressively to existing code.

## Root PHP namespace

Define [[= product_name =]] core PHP code in a namespace with the following prefix:

```php
namespace Ibexa;
```

A package which groups some DXP features can use an additional prefix, for example:

```php
namespace Ibexa\Commerce;
```

```php
namespace Ibexa\Personalization;
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
namespace Ibexa\Search;
```

```php
namespace Ibexa\Commerce\Shop;
```

### Bundles

The bundle class definition in the `src/bundle` directory must be:

```php
namespace Ibexa\Bundle\<PackageName>;

class IbexaPlatform[ProductGroup]<PackageName>Bundle // ...
```

Examples:


```php
namespace Ibexa\Bundle\Search;

class IbexaPlatformSearchBundle // ...
```

```php
namespace Ibexa\Bundle\Commerce\Shop;

class IbexaPlatformCommerceShopBundle // ...
```

### Contracts

A package may introduce a namespace for contracts, to be consumed by first and third party packages
and projects, which must be prefixed as:

```php
namespace Ibexa\Contracts;
```

Examples:

```php
namespace Ibexa\Contracts\Kernel;
```

```php
namespace Ibexa\Contracts\SiteFactory;
```

```php
namespace Ibexa\Contracts\Commerce\Shop;
```

That namespace needs to be mapped to the `src/contracts` directory of a package.

!!! note

    Backward compatibility for interfaces and objects defined in the `Contracts` namespace is guaranteed.
