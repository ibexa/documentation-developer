---
description: Image MimeType Search Criterion
---

# Image MimeType Criterion

The `MimeType` Search Criterion searches for image with specified mime type(s).

## Arguments

- `fielDefIdentifier` - string representing the identifier of the field
- `type` - string(s) representing mime type(s)

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

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
