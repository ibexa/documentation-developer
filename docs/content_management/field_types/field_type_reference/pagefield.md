# Page field type

Page field type represents a page with a layout consisting of multiple zones.
Each zone can in turn contain blocks.


| Name          | Internal name        |
|---------------|----------------------|
| `LandingPage` | `ibexa_landing_page` |

## Field value

The field value is an object holding the serialized page structure: the layout identifier, the zones of that layout, and the blocks placed in each zone.
Its exact shape depends on the layout and on the [page blocks](page_blocks.md) used.

Pages are normally built with Page Builder rather than assembled by hand.

!!! caution "Page Builder"

    If you create content type with both `ibexa_landing_page` and `ibexa_user` field types, you aren't redirected to Page Builder after selecting `Edit` or `Create`.
    This is caused by `ibexa_user` field type which requires separate handling.
    You're redirected to the standard back office edit or create mode.

