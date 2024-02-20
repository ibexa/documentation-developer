---
description: Image Dimensions Criterion
---

# Image Dimension Criterion

The `Dimensions` Search Criterion searches for image with specified dimensions.

## Arguments

- `fieldDefIdentifier` - string representing the identifier of the Field
- `imageCriteriaData` - an array representing minimum and maximum values for width and height, expressed in pixels
## Example

### PHP

``` php

$imageCriteriaData = [
     'width' => [
         'min' => 100, // (default: 0, optional)
         'max' => 1000, // (default: null, optional)
     ],
     'height' => [
         'min' => 500, // (default: 0, optional)
         'max' => 1500, // (default: null, optional)
     ],
 ];

$query->query = new Criterion\Dimensions('image', $imageCriteriaData);

```

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