# IsProductBased Criterion

IsProductBased Search Criterion

The `IsProductBased` Search Criterion searches for content that plays the role of a Product.

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new \Ibexa\Contracts\ProductCatalog\Values\Content\Query\Criterion\IsProductBased();
```
