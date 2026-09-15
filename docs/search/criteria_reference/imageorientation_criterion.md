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

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

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
