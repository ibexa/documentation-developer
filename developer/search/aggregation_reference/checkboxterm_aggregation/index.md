# CheckboxTermAggregation

CheckboxTermAggregation

The field-based [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Field\CheckboxTermAggregation`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Aggregation/Field/CheckboxTermAggregation.php) aggregates search results by the value of the Checkbox field.

## Arguments

- `name` - name of the Aggregation
- `contentTypeIdentifier` - string representing the content type identifier
- `fieldDefinitionIdentifier` - string representing the Field Definition identifier

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation;

$query = new Query();
$query->aggregations[] = new Aggregation\Field\CheckboxTermAggregation('checkbox', 'article', 'enable_comments');
```

## Settings

You can define additional limits to the results using the `setLimit()` and `setMinCount()` methods. The following example limits the number of terms returned to 5 and only considers terms that have 10 or more results:

```php
$aggregation = new //...
$aggregation->setLimit(5);
$aggregation->setMinCount(10);
```
