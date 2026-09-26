# Order CompanyName Criterion

Order CompanyName Search Criterion

Editions: Commerce

The `CompanyNameCriterion` Search Criterion searches for orders based on the name of the company.

## Arguments

- `company_name` - string that represents a name of the company

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\OrderManagement\Value\Order\OrderQuery;

$query = new OrderQuery(
    new \Ibexa\Contracts\OrderManagement\Value\Order\Query\Criterion\CompanyNameCriterion('IBM')
);
```
