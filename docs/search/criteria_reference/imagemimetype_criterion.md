---
description: Image MimeType Search Criterion
---

# Image MimeType Criterion

The `MimeType` Search Criterion searches for image with specified mime type(s).

## Arguments

- `fielDefIdentifier` - string representing the identifier of the field
- `type` - string(s) representing mime type(s)

## Example

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
