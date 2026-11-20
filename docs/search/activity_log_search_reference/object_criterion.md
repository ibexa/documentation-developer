# Object Criterion

The `ObjectCriterion` Activity Log Criterion matches log group with a log entry about the given class name, and eventually one of the given IDs.

## Arguments

- `objectClass` - a class of the object concerned by the searched log entries
- `ids` - an optional list of object IDs

## Examples

``` php
use Ibexa\Contracts\ActivityLog\Values\ActivityLog as ActivityLog;
use Ibexa\Contracts\Core\Repository\Values\Content\Content;

$query = new ActivityLog\Query([
    new ActivityLog\Criterion\ObjectCriterion(Content::class),
]);
```

``` php
use Ibexa\Contracts\ActivityLog\Values\ActivityLog as ActivityLog;
use Ibexa\Contracts\ProductCatalog\Values\ProductVariantInterface;

$query = new ActivityLog\Query([
    new ActivityLog\Criterion\ObjectCriterion(ProductVariantInterface::class, ['123', '234', '345']),
]);
```
