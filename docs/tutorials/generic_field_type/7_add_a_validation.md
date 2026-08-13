---
description: Learn how to validate custom field data.
---

# Step 7 - Add basic validation

To provide basic validation that ensures both coordinates are provided, add assertions to the `src/FieldType/Point2D/Value.php`:

``` php hl_lines="12 14"
[[= include_code('code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Value.php') =]]
```

As a result, if a user tries to publish the Point 2D with one value, they receive an error message.

![Point 2D validation](point2d_validation.png)
