---
month_change: false
description: Configure custom icons to use for content types.
---

# Custom icons

## Customize content type icons

To add custom icons for existing content types or custom content types in [[= product_name =]], use the following configuration under the `ibexa.system.<scope>.content_type` [configuration key](configuration.md#configuration-files):

```yaml
ibexa:
    system:
        default:
            content_type:
                article:
                    thumbnail: /assets/images/custom_icon.svg#custom
                category:
                    thumbnail: /bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#folder
```

Place the icon in `public/assets/images` and run `yarn encore <dev|prod>` after adding it.

!!! note "Icons format"

    To ensure proper display in the back office, all icons should have SVG format with `symbol`.

Use the [scope](multisite_configuration.md#scope) if you want different icons for different SiteAccesses.
