# Image MimeType Criterion

Image MimeType Search Criterion

The `MimeType` Search Criterion searches for image with specified mime type(s).

## Arguments

- `fielDefIdentifier` - string representing the identifier of the field
- `type` - string(s) representing mime type(s)

## Example

### PHP

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$query->query = new Criterion\Image\MimeType('image', 'image/jpeg');
```

or

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;

$query = new Query();
$mimeTypes = [
    'image/jpeg',
    'image/png',
];

$query->query = new Criterion\Image\MimeType('image', $mimeTypes);
```

### REST API

**XML**

```xml
<Query>
    <Filter>
        <ImageMimeTypeCriterion>
            <fieldDefIdentifier>image</fieldDefIdentifier>
            <type>image/png</type>
        </ImageMimeTypeCriterion>
    </Filter>
</Query>
```

**JSON**

```json
"Query": {
    "Filter": {
        "ImageMimeTypeCriterion": {
            "fieldDefIdentifier": "image",
            "type": "image/png"
        }
    }
}

OR

"Query": {
    "Filter": {
        "ImageMimeTypeCriterion": {
            "fieldDefIdentifier": "image",
            "type": ["image/png", "image/jpeg"]
        }
    }
}
```
