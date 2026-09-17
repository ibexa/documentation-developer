---
description: Image FileSize Search Criterion
---

# Image FileSize Criterion

The `FileSize` Search Criterion searches for image with specified size.

## Arguments

- `fieldDefIdentifier` - string representing the identifier of the field
- (optional) `minValue` - numeric representing minimum file size expressed in MB, default: 0
- (optional) `maxValue` - numeric representing maximum file size expressed in MB, default: `null`

## Example

You can use this Search Criterion over the REST API, in the payload of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ImageFileSizeCriterion>
                <fieldDefIdentifier>image</fieldDefIdentifier>
                <size>
                    <min>0</min>
                    <max>1.5</max>
                </size>
            </ImageFileSizeCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ImageFileSizeCriterion":{
                "fieldDefIdentifier": "image",
                "size": {
                    "min": 0,
                    "max": 1.5
                }
            }
        }
    }
    ```
