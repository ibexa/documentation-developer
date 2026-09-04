---
description: All code contributions to Cohesivo must follow package and bundle structure and namespace standards.
---

# Package and bundle structure and namespaces

If you wish to contribute to [[= product_name =]] development, you need to adhere to the package and bundle structure and namespace standards.

The following conventions apply to contributions to [[= product_name =]] core code, not to third party packages.

!!! note

    New code needs to follow the rules outlined here.
    They're being applied progressively to existing code.

## Root PHP namespace

Define [[= product_name =]] core PHP code in a namespace with the following prefix:

``` php {skip-validation}
namespace Ibexa;
```

A package which groups some [[= product_name =]] features can use an additional prefix:

``` php {skip-validation}
namespace Ibexa\<FeatureGroup>;
```

## Packages

The general package directory structure and corresponding PHP namespace mapping are:

```text
.
+-- src
|   +-- bundle (`Ibexa\Bundle\<PackageName>`)
|   +-- contracts (`Ibexa\Contracts\<PackageName>`)
|   +-- lib (`Ibexa\<PackageName>`)
+-- tests
|   +-- bundle (`Ibexa\Tests\Bundle\<PackageName>`)
|   +-- integration (`Ibexa\Tests\Integration\<PackageName>`)
|   +-- lib (`Ibexa\Tests\<PackageName>`)
```

If a package doesn't contain some of the described parts, you can skip those directories.

### Implementation (lib)

The `src/lib` directory and its corresponding `Ibexa\<PackageName>` namespace are meant for internal implementation not tied to the Symfony Framework.

Examples:

``` php {skip-validation}
namespace Ibexa\Search;
```

### Bundles

The bundle class definition in the `src/bundle` directory must be:

``` php {skip-validation}
namespace Ibexa\Bundle\<PackageName>;

class Ibexa[ProductGroup]<PackageName>Bundle // ...
```

Examples:

``` php {skip-validation}
namespace Ibexa\Bundle\Search;

class IbexaSearchBundle // ...
```

### Contracts

A package may introduce a namespace for contracts, to be consumed by first and third party packages and projects, which must be prefixed as:

``` php {skip-validation}
namespace Ibexa\Contracts;
```

Examples:

``` php {skip-validation}
namespace Ibexa\Contracts\Kernel;
```

``` php {skip-validation}
namespace Ibexa\Contracts\SiteFactory;
```

That namespace needs to be mapped to the `src/contracts` directory of a package.

!!! note

    Backward compatibility for interfaces and objects defined in the `Contracts` namespace is guaranteed.
