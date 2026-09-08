---
description: Image Dimensions Search Criterion
---

# Image Dimension Criterion

The `Dimensions` Search Criterion searches for image with specified dimensions.

## Arguments

- `fieldDefIdentifier` - string representing the identifier of the field
- `imageCriteriaData` - an array representing minimum and maximum values for width and height, expressed in pixels

## Example

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ImageDimensionsCriterion>
                <fieldDefIdentifier>image</fieldDefIdentifier>
                <width>
                    <min>100</min>
                    <max>1000</max>
                </width>
                <height>
                    <min>500</min>
                    <max>1500</max>
                </height>
            </ImageDimensionsCriterion>
        </Filter>
    </Query>
    ```

=== "JSON"

    ```json
    "Query": {
        "Filter": {
            "ImageDimensionsCriterion": {
                "fieldDefIdentifier": "image",
                "width": {
                    "min": 100,
                    "max": 1000
                },
                "height": {
                    "min": 500,
                    "max": 1500
                }
            }
        }
    }
    ```
