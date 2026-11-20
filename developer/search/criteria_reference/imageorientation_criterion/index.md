# Image Orientation Criterion

Image Orientation Search Criterion

The `Orientation` Search Criterion searches for image with specified orientation(s). Supported orientation values: landscape, portrait and square.

## Arguments

- `fielDefIdentifier` - string representing the identifier of the field
- `orientation` - strings representing orientations

## Example

### PHP

#### Single orientation value

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Image\Orientation;

$query = new Query();
$query->query = new Orientation('image', 'landscape');
```

#### Multiple orientation values

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Image\Orientation;

$query = new Query();
$orientations = [
    'landscape',
    'portrait',
];

$query->query = new Orientation('image', $orientations);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <ImageOrientationCriterion>
            <fieldDefIdentifier>image</fieldDefIdentifier>
            <orientation>landscape</orientation>
        </ImageOrientationCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "ImageOrientationCriterion": {
            "fieldDefIdentifier": "image",
            "orientation": "landscape"
        }
    }
}

OR

"Query": {
    "Filter": {
        "ImageOrientationCriterion": {
            "fieldDefIdentifier": "image",
            "orientation": ["portrait", "landscape"]
        }
    }
}
```
