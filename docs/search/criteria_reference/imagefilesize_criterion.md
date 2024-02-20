---
description: Image FileSize Criterion
---

# Image FileSize Criterion

The `FileSize` Search Criterion searches for image with specified size.

## Arguments

- `fieldDefIdentifier` - string representing the identifier of the Field
- (optional) `minValue` - numeric representing minimum file size expressed in MB, default: 0
- (optional) `maxValue` - numeric representing maximum file size expressed in MB, default: `null`

## Example

### PHP

``` php
$query->query = new Criterion\FileSize('image', 0, 1.5);
```

### REST API

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