---
description: Image Orientation Search Criterion
---

# Image Orientation Criterion

The `Orientation` Search Criterion searches for image with specified orientation(s).
Supported orientation values: landscape, portrait and square.

## Arguments

- `fielDefIdentifier` - string representing the identifier of the field
- `orientation` - strings representing orientations

## Limitations

`ImageOrientation` can be used on all search engines.

## Example

### PHP

```php
$query->query = new Criterion\Orientation('image', 'landscape');

// OR

$orientations = [
    'landscape',
    'portrait',
];

$query->query = new Criterion\Orientation('image', $orientations);
```

### REST API

=== "XML"

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

=== "JSON"

    ```json
    {
        "ViewInput": {
            "identifier": "ImageOrientationCriterionTest",
            "Query": {
                "Filter": {
                    "ImageOrientationCriterion": {
                        "fieldDefIdentifier": "image",
                        "orientation": "landscape"
                    }
                }
            }
        }
    }

    OR

    {
        "ViewInput": {
            "identifier": "ImageOrientationCriterionTest",
            "Query": {
                "Filter": {
                    "ImageOrientationCriterion": {
                        "fieldDefIdentifier": "image",
                        "orientation": ["portrait", "landscape"]
                    }
                }
            }
        }
    }
    ```
