---
description: Image MimeType Criterion
---

# Image MimeType Criterion

The `MimeType` Search Criterion searches for image with specified mime type(s).

## Arguments

- `fielDefIdentifier` - string representing the identifier of the Field
- `type` - string(s) representing mime type(s)

## Example

### PHP

``` php
$query->query = new Criterion\MimeType('image', 'image/jpeg');
```

or 

```php
$mimeTypes = [
    'image/jpeg',
    'image/png',
];

$query->query = new Criterion\MimeType('image', $mimeTypes);
```

### REST API

=== "XML"

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

=== "JSON"

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