---
description: Image Criterion
---

# Image Criterion

The `Image` Search Criterion searches for image by specified image attributes.

## Arguments

- `fieldDefIdentifier` - string representing the identifier of the Field
- `imageCriteriaData` - array representing image attributes. All attributes are optional.

## Example

### PHP

``` php

$imageCriteriaData = [
    'mimeTypes' => [
        'image/png',
    ],
    'orientation' => [
        'image/png',
    ],
    'width' => [
        'min' => 0, // (default: 0, optional)
        'max' => 1000, // (default: null, optional)
    ],
    'height' => [
        'min' => 0, // (default: 0, optional)
        'max' => 1000, // (default: null, optional)
    ],
    'size' => [
        'min' => 0, // (default: 0, optional)
        'max' => 2, // (default: null, optional)
    ],
];
$query->query = new Criterion\Image('image', $imageCriteriaData);
```

### REST API

=== "XML"

    ```xml
    <Query>
        <Filter>
            <ImageCriterion>
               <fieldDefIdentifier>image</fieldDefIdentifier>
               <mimeTypes>image/png</mimeTypes>
               <size>
                  <min>0</min>
                  <max>2</max>
               </size>
               <width>
                  <min>100</min>
                  <max>1000</max>
               </width>
               <height>
                  <min>500</min>
                  <max>1500</max>
               </height>
               <orientation>portrait</orientation>
            </ImageCriterion>
         </Filter>
      </Query>
    ```

=== "JSON"

    ```json
    "Query": {
       "Filter": {
          "ImageCriterion": {
             "fieldDefIdentifier": "image",
             "mimeTypes": "image/png",
             "size": {
                "max": 1.5
             },
             "width": {
                "max": 1000
             },
             "height": {
                "max": 1500
             },
             "orientation": "portrait"
          }
       }
    }

    OR

    "Query": {
       "Filter": {
          "ImageCriterion": {
             "fieldDefIdentifier": "image",
             "mimeTypes": [
                "image/png",
                "image/jpeg"
             ],
             "size": {
                "min": 0,
                "max": 2
             },
             "width": {
                "min": 100,
                "max": 1000
             },
             "height": {
                "min": 500,
                "max": 1500
             },
             "orientation": [
                "portrait",
                "landscape"
             ]
          }
       }
    }
    ```
