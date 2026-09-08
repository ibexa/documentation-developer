# Order Identifier Criterion

Order Identifier Search Criterion

Editions: Commerce

The `IdentifierCriterion` Search Criterion searches for orders based on the order identifier.

## Arguments

- `identifier` - string that represents the order identifier

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;

$query = new OrderQuery(
    new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\IdentifierCriterion('f7578972-e7f4-4cae-85dc-a7c74610204e')
);
```
