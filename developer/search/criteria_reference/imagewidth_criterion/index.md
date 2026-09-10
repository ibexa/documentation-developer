# Image Width Criterion

Image Width Search Criterion

The `Width` Search Criterion searches for image with specified width.

## Arguments

- `fieldDefIdentifier` - string representing the identifier of the field
- (optional) `minValue` - int representing minimum file width expressed in pixels, default: 0
- (optional) `maxValue` - int representing maximum file width expressed in pixels, default: `null`

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\Image\Width('image', 150, 1000);
```
