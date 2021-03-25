# SpecificationsType

This Field Type stores a structured list of attributes for products.

!!! caution "Field naming"

    A Field of the SpecificationsType must have `ses_specifications` as its Field identifier.

The data is stored in JSON format.

``` json
[
  {
    "name": "marketing",
    "data": [
      {
        "label": "Brand",
        "value": "MG"
      },
      {
        "label": "Warranty",
        "value": "2yrs"
      }
    ]
  },
  {
    "name": "technic",
    "data": [
      {
        "label": "Size",
        "value": "12cm"
      },
      {
        "label": "color",
        "value": "red"
      }
    ]
  }
]
```
