# Custom Field Criterion

Custom Field Search Criterion

The [`CustomField` Search Criterion](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/CustomField.php) searches for content or locations based on the contents of the search index fields.

The allowed syntax and operator support might differ between search engines and the type of queried field.

## Arguments

- `target` - string representing the identifier of the search index field
- `operator` - one of [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Criterion/Operator.php) constants
- `value` - the value to query for

## Limitations

The `CustomField` Criterion isn't available in [Repository filtering](../../search_api/index.md#repository-filtering).

## Example

### PHP

```php
<?php declare(strict_types=1);

use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator;

$query = new Query();

// Example Solr query: find content items with "content_name_s" starting with "Ibexa"
$query->query = new Query\Criterion\CustomField('content_name_s', Operator::EQ, '/Ibexa.*/');

/** @var \Ibexa\Contracts\Core\Repository\SearchService $searchService */
$searchService->findContent($query);
```
