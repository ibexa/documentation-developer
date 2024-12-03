---
description: Image Orientation Search Criterion
---

# Image Orientation Criterion

The `Orientation` Search Criterion searches for image with specified orientation(s).
Supported orientation values: landscape, portrait and square.

## Arguments

- `fielDefIdentifier` - string representing the identifier of the field
- `orientation` - strings representing orientations

## Example

### PHP

``` php
$query->query = new Criterion\Orientation('image', 'landscape');

OR

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