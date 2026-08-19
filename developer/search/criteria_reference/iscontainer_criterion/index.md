# IsContainer Criterion

IsContainer Search Criterion

The [`IsContainer` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/IsContainer.php) searches for content items based on whether they are containers (i.e., can contain other content items).

## Arguments

- `value` – boolean (optional, default: `true`). If `true`, searches for content that is a container. If `false`, searches for content that is not a container.

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\IsContainer(); // Finds containers
$query->query = new Criterion\IsContainer(false); // Finds non-containers
```
