# Page field type

Page field type represents a page with a layout consisting of multiple zones.
Each zone can in turn contain blocks.

Page field type is only used in the page content type that is included in [[= product_name =]].

| Name          | Internal name        | Expected input  |
|---------------|----------------------|-----------------|
| `LandingPage` | `ibexa_landing_page` | `string` (JSON) |

!!! caution "Page Builder"

    If you create content type with both `ibexa_landing_page` and `ibexa_user` field types, you aren't redirected to Page Builder after selecting `Edit` or `Create`.
    This is caused by `ibexa_user` field type which requires separate handling.
    You're redirected to the standard back office edit or create mode.
