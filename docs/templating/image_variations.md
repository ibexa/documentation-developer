---
description: Configure image variations to scale, crop and otherwise modify rendered images.
page_type: reference
---

# Image variations

With image variations you can render different versions of one image by means of scaling, cropping and other filters.

Built-in image variations include four versions that provide the image at a specific scale: `tiny`, `small`, `medium`, and `large`.

You can also create custom image variations.

See [Render images](render_images.md) for an example of variation name usage as `alias` parameter when rendering an image field.

## Custom image variations

Image variation configuration is [SiteAccess](multisite.md)-aware.
Place it under the `image_variations` [configuration key](configuration.md#configuration-files) per [scope](multisite_configuration.md#scope):

``` yaml
ibexa:
    system:
        <scope>:
            image_variations:
                <variation_name>:
                    reference: null
                    filters:
                        <filter>: <parameters>
```

Variation name must be unique.
It may contain characters, numbers, underscores (`_`) or hyphens (`-`), but no spaces.

Each variation takes the following parameters:

- `reference` - (optional) name of a reference variation to base the variation on.
If set to `null` or `~`, the variation takes the original image for reference.
- `filters` - array of variation filters and their parameters.
- `post_processors` - used to reduce the final image size and to improve load performance of assets.

## Available variation filters

In addition to [filters exposed by LiipImagineBundle](https://symfony.com/bundles/LiipImagineBundle/2.x/filters.html), the following ones are available:

| Filter name | Parameters | Description |
|--------|------|----------|
| `geometry/scaledownonly` | `[width, height]` | Scales image down to fit the provided width/height. Preserves aspect ratio. |
| `geometry/scalewidthdownonly` | `[width]` | Scales image down to fit the provided width. Preserves aspect ratio. |
| `geometry/scaleheightdownonly` | `[height]` | Scales image down to fit the provided height. Preserves aspect ratio. |
| `geometry/scalewidth` | `[width]` | Scales image width, both up and down. Preserves aspect ratio. |
| `geometry/scaleheight` | `[height]` | Scales image height, both up and down. Preserves aspect ratio. |
| `geometry/scale` | `[width, height]` | Scales image size to the provided width and height, both up and down. Preserves aspect ratio. |
| `geometry/scaleexact` | `[width, height]` | Scales image to  exactly fit the provided width and height. Doesn't preserve aspect ratio. |
| `geometry/scalepercent` | `[widthPercent, heightPercent]` | Scales width and height by the provided percent values. Doesn't preserve aspect ratio. |
| `geometry/crop` | `[width, height, startX, startY]` | Crops the image. The result has the provided width/height, starting at the provided startX/startY |
| `border` | `[thickBorderX, thickBorderY, color=#000]` | Adds a border around the image. Thickness is defined in px. Color is `#000` by default. |
| `filter/noise` | `[radius=0]` | Smooths the contours of an image (`imagick`/`gmagick` only). `radius` is in px. |
| `filter/swirl` | `[degrees=60]` | Swirls the pixels of the center of the image (`imagick`/`gmagick` only). `degrees` defaults to 60.|
| `resize` | {size: `[width, height]`} | Resize filter (provided by LiipImagineBundle). |
| `colorspace/gray` | N/A | Converts the image to grayscale. |

!!! note

    After you change the image variation configuration, remove the existing variations with the `liip:imagine:cache:remove` command and provide the variation name:

    ``` bash
    php bin/console liip:imagine:cache:remove --filter=large
    ```

    Next, clear the cache.

    You can also remove all generated image variations:

    ``` bash
    php bin/console liip:imagine:cache:remove -v
    ```

