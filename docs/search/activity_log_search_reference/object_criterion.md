# Object Criterion

The `ObjectCriterion` Activity Log Criterion
matches log group with a log entry about the given class name, and eventually one of the given IDs.

## Arguments

- `objectClass` - a class of the object concerned by the searched log entries
- `ids` - an optional list of object IDs

## Examples

```php
$query = new ActivityLog\Query([
    new ActivityLog\Criterion\ObjectCriterion(Ibexa\Contracts\Core\Repository\Values\Content\Content::class),
]);
```

```php
$query = new ActivityLog\Query([
    new ActivityLog\Criterion\ObjectCriterion(Ibexa\Contracts\ProductCatalog\Values\ProductVariantInterface::class, [123, 234, 345]),
]);
```
