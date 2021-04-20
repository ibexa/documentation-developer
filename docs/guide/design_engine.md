# Design engine

You can provide design themes for your application, with an automatic fallback system, by using the design engine.

A *design* is a collection of themes. 
The order of themes within a design is important, because it defines the fallback order.
One design can be used per SiteAccess.

A *theme* is a collection (typically, a folder) of templates and assets. 
For example, templates located under `templates/themes/my_theme` are part of the `my_theme` theme.

When you call a given template or asset, the system looks for it in the first configured theme.
If it cannot be found, the system falls back to other configured themes for the current SiteAccess.

!!! caution

    After you create a new folder either in the project's or your bundle's `templates/themes` directory,
    clear the Symfony's cache (`php bin/console cache:clear`), even if you are working in the `dev` environment.

### Default designs

By default, the following designs are included:

- `admin` - covers templates for the Back Office, contains the `admin` theme
- `standard` - covers the default content rendering templates, contains the `standard` theme

When `ez_platform_standard_design.override_kernel_templates` is set to `true`,
the `standard` theme is automatically mapped to the directory in kernel containing the templates.

``` yaml
ez_platform_standard_design:
    override_kernel_templates: true
```

The standard design overrides the following Twig templates by prefixing them with the `@ezdesign` namespace:

- `viewbase_layout.html.twig`
- `pagelayout.html.twig`
- `default/content/full.html.twig`
- `default/content/line.html.twig`
- `default/content/text_linked.html.twig`
- `default/content/embed.html.twig`
- `default/content/embed_image.html.twig`
- `default/block/block.html.twig`
- `content_fields.html.twig`
- `fielddefinition_settings.html.twig`

## Adding a design

To define and use a design, you need to:

1. Declare it, with a name and a collection of themes to use.
1. Use it for your SiteAccess.

Define your design under the `ezdesign.design_list` key:

``` yaml
ezdesign:
    design_list:
        my_design: [theme1, theme2]
```

The design engine tries `theme1` first. 
If it cannot find a template in `theme1`, it tries `theme2`.

To indicate when to use a design, configure it under `ezplatform.system.<scope>`:

``` yaml
ezplatform:
    system:
        <scope>:
            design: my_design
```

## Referencing current design

To reference current design in your code, use the [ConfigResolver](config_dynamic.md#configresolver) service (`ezpublish.config.resolver`):

```php
$currentDesign = $this->getConfigResolver->getParameter('design');
```

## Using designs

By convention, a theme directory is located under `templates/themes/<theme_name>`.

To indicate a template from a theme, use the `@ezdesign` Twig namespace.

You can do it within templates, in content view configuration or in controllers:

```html+twig
{{ include("@ezdesign/full/home.html.twig") }}
```

```yaml
ezplatform:
    system:
        my_siteaccess:
            content_view:
                full:
                    home:
                        template: '@ezdesign/full/home.html.twig'
```

For assets, a special `ezdesign` asset package is available.

```html+twig
<script src="{{ asset("js/foo.js", "ezdesign") }}"></script>

<link rel="stylesheet" href="{{ asset("js/foo.css", "ezdesign") }}" media="screen" />

<img src="{{ asset("images/foo.png", "ezdesign") }}" alt="foo"/>
```

Using the `ezdesign` package resolves the current design with theme fallback.

By convention, an asset theme directory is located in `assets/themes/<theme_name>`.

It is also possible to use `assets` as a global override directory.
If a called asset is present directly under this directory, it is always considered first.

!!! caution

    You must have *installed* your assets with `assets:install` command, so that your public resources are
    *installed* into the `assets/` directory.


### Fallback order

The default fallback order for templates is:

- Application theme directory: `templates/themes/<theme_name>`
- Bundle theme directory: `src/<bundle_directory>/Resources/views/themes/<theme_name>`

The default fallback order for assets is:

- Application assets directory: `assets`
- Application theme directory: `assets/themes/<theme_name>`
- Bundle theme directory: `public/bundles/<bundle_directory>/themes/<theme_name>`

Calling `asset("js/scripts.js", "ezdesign")` can for example be resolved to `public/bundles/app/themes/my_theme/js/scripts.js`.

Bundles fall back in the instantiation order from `bundles.php`.

#### Additional theme paths

You can also add any Twig template folder to the theme configuration.

You can use it if you want to define templates from third-party bundles as part of one of your themes,
or when upgrading your application to use the design engine,
and if your existing templates are not yet following the convention.

Do it by setting the `ezdesign.templates_theme_paths` parameter:

```yaml
ezdesign:
    design_list:
        my_design: [my_theme]
    templates_theme_paths:
        my_theme:
            - '%kernel.project_dir%/vendor/<vendor_name>/<bundle_name>/Resources/views'
```

Directories that follow the convention have precedence over the ones defined in `templates_theme_paths`.
This ensures that it is always possible to override a template from the application.

You can also add a global override folder, by listing paths without assigning them to a theme:

```yaml
ezdesign:
    templates_override_paths:
        - '%kernel.project_dir%/src/an_override_directory'
```

### Performance and asset resolution

When using themes, paths for assets are resolved at runtime.
This is due to how the Symfony Asset component is integrated with Twig.
This can cause significant performance impact because of I/O calls when looping over all potential theme directories,
especially when using a lot of different designs and themes.

To work around this issue, assets resolution can be provisioned at compilation time.
Provisioning is the default behavior in non-debug mode (for example, in `prod` environments).
In debug mode (for example, in `dev` environments), assets are being resolved at runtime.

This behavior can, however, be controlled by the `disable_assets_pre_resolution` setting.

```yaml
# ezplatform_prod.yaml
ezdesign:
    # Force runtime resolution
    # Default value is '%kernel.debug%'
    disable_assets_pre_resolution: true
```

### PHPStorm support

`@ezdesign` Twig namespace is a *virtual* namespace, and as such is not automatically recognized by the PHPStorm Symfony plugin
for `goto` actions.

`EzPlatformDesignEngine` will generate a `ide-twig.json` file which will contain all detected theme paths for templates in your project.
It is activated by default in debug mode (`%kernel.debug%`).

By default, this config file will be stored at your project root (`%kernel.project_dir%`), but you can customize the path
if your PHPStorm project root doesn't match your Symfony project root.

!!! note

    `ide-twig.json` **must** be stored at your PHPStorm project root.

Default config:

```yaml
ezdesign:
    phpstorm:
        # Activates PHPStorm support
        enabled: '%kernel.debug%'
        # Path where to store PHPStorm configuration file for additional Twig namespaces (ide-twig.json).
        twig_config_path: '%kernel.project_dir%'
```
