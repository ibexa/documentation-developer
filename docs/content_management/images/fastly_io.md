---
description: Configure Fastly Image Optimizer.
---

# Fastly Image Optimizer (Fastly IO)

The Fastly Image Optimizer (Fastly IO) is an external service that provides real-time image optimisation for multiple input and output formats.
It serves and caches image requests from your origin server, making your website faster and more efficient.

To be able to configure this feature you need:

- [Platform.sh project](https://docs.platform.sh/guides/ibexa/deploy.html)
- [Fastly IO subscription](https://docs.fastly.com/en/guides/about-fastly-image-optimizer)

## Enable shielding

To use Fastly Image Optimizer, you need shielding,
to enable it follow steps in Fastly documentation, [Enabling and disabling shielding](https://developer.fastly.com/learning/concepts/shielding/).

Before proceeding, make sure that you have the [`snippet_re_enable_shielding.vcl`](https://github.com/ibexa/fastly/blob/main/fastly/snippet_re_enable_shielding.vcl) added.

You can add it using Fastly CLI: 
 
```bash
- fastly vcl snippet create --name="Re-Enable shielding on restart" --version=active --autoclone --priority 100 --type recv --content=vendor/ibexa/fastly/fastly/snippet_re_enable_shielding.vcl
- fastly service-version activate --version=latest
```

Next, you need to choose the [Shield location](https://developer.fastly.com/learning/concepts/shielding/#choosing-a-shield-location) from the Shielding menu in Fastly web interface as specified in [Fastly IO documentation](https://docs.fastly.com/en/guides/shielding#enabling-shielding).

## VCL configuration

To manipulate your Fastly VCL configuration directly from the command line,
you need to:
- [install Fastly CLI](https://developer.fastly.com/learning/tools/cli#installing),
- define `FASTLY_SERVICE_ID` and `FASTLY_KEY` environmental variables,
- set restrictions on optimiser by using [ibexa_image_optimizer.vcl](https://github.com/ibexa/fastly/blob/main/fastly/ibexa_image_optimizer.vcl). 

This is an example VCL snippet uploaded by using `vcl_recv` hook:

```bash
fastly vcl custom create --name="Ibexa VCL" --main --version=latest --autoclone  --content=vendor/ibexa/fastly/fastly/ez_main.vcl
fastly vcl snippet create --name="Shielding" --version=active --autoclone --type recv --content=vendor/ibexa/fastly/fastly/snippet_re_enable_shielding.vcl
```

Fastly passes requests through the image optimizer by adding the `x-fastly-imageopto-api` header in `vcl_recv`.
You need to restrict optimizer by file path and extension to only apply to image requests:

```vcl
if (req.url.ext ~ "(?i)^(gif|png|jpe?g|webp)$") {
    if (req.url.path ~ "^/var/([a-zA-Z0-9_-]+)/storage/images") {
        set req.http.x-fastly-imageopto-api = "fastly";
    }
}
```

You can define what image formats will be included, for example: `gif|png|jpe?g|webp`
and which paths should be used as a source of images, for example: `^/var/([a-zA-Z0-9_-]+)/storage/images`.
For more configuration options, see [Enabling image optimization](https://developer.fastly.com/reference/io/#enabling-image-optimization).

After you save this snippet or create your own, you can upload it from the command line using:

```bash
fastly vcl snippet create --name="Shielding" --version=active --autoclone --type recv --content=vendor/ibexa/fastly/fastly/snippet_re_enable_shielding.vcl
```

## Define SiteAccess for Fastly IO

Fastly IO configuration is SiteAccess aware.
You can define what handler should be used for a specific SiteAccess under `variation_handler_identifier`.
You need to set it up as `fastly`, so Fastly IO can generate all image links.
By default, it is set as `alias`, and it points to a built-in image optimizer.

```yaml
ibexa:
    system:
        my_siteaccess:
            variation_handler_identifier: 'fastly'
```

## Image configuration

When you define image variation keys for Fastly IO keep in mind
that they should reflect variations in your original setup.
The built-in image optimizer serves as backup to Fastly IO in case of misconfiguration,
because of that it needs to be able to serve the same image variations.

Fastly IO image filters are not compatible with our built-in filters,
because of that you will not be able to reflect your original filters accurately with Fastly.
The script below will help you find replacement filters within Fastly configuration for the basic filters.
For more optimization options on Fastly side, see [Fastly IO reference](https://developer.fastly.com/reference/io/).

To generate your original image configuration run:

```bash
php bin/console ibexa:fastly:migrate-configuration
```

Paste the configuration to `config/packages/ibexa.yaml` to define the same variations for Fastly IO:

```yaml
ibexa:
    system:
        default:
            fastly_variations:
                reference:
                    reference: original
                    configuration:
                        width: 600
                        height: 600
                        fit: bounds
                small:
                    reference: reference
                    configuration:
                        width: 100
                        height: 100
                        fit: bounds
                tiny:
                    reference: reference
                    configuration:
                        width: 30
                        height: 30
                        fit: bounds
                medium:
                    reference: reference
                    configuration:
                        width: 200
                        height: 200
                        fit: bounds
                large:
                    reference: reference
                    configuration:
                        width: 300
                        height: 300
                        fit: bounds
                gallery:
                    reference: original
                    configuration: { }
                ezplatform_admin_ui_profile_picture_user_menu:
                    reference: reference
                    configuration:
                        width: 30
                        height: 30
                        fit: bounds
                        crop: '30,30,x0,y0'
```

You can select defined image variations during Content item creation in the image options.
Variations can include different sizing options and other filters that are applied to the image.

![Fastly Image Variations](img/fastly_variations.png)



