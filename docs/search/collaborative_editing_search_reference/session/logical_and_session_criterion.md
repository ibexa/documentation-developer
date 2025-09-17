---
description: LogicalAnd Search Criterion
---

# LogicalAnd Criterion

The `LogicalAnd` Search Criterion matches combined sessions by the logical operator.

## Example

```php
$criteria = Ibexa\Contracts\Collaboration\Session\Query\Criterion\LogicalAnd( 
    new Ibexa\Contracts\Collaboration\Session\Query\Criterion\IsActive(), 
    new Ibexa\Contracts\Collaboration\Session\Query\Criterion\Type('content')
);

$query = new SessionQuery($criteria);
```