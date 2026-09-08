# Image Height Criterion

Image Height Search Criterion

The `Height` Search Criterion searches for image with specified height.

## Arguments

- `fieldDefIdentifier` - string representing the identifier of the field
- (optional) `minValue` - int representing minimum file height expressed in pixels, default: 0
- (optional) `maxValue` - int representing maximum file height expressed in pixels, default: `null`

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\Image\Height('image', 0, 1500);
```
