# Design engine

You can provide design themes for your eZ application, with an automatic fallback system
using the design engine from the [ezplatform-design-engine](https://github.com/ezsystems/ezplatform-design-engine) bundle.
It is very similar to the [eZ Publish legacy design fallback system](https://doc.ez.no/eZ-Publish/Technical-manual/5.x/Concepts-and-basics/Designs/Design-combinations).

When you call a given template or asset, the system will look for it in the first configured theme.
If it cannot be found, the system will fall back to all other configured themes for your current SiteAccess.

Under the hood, the theming system uses Twig namespaces. As such, Twig is the only supported template engine.
For assets, the system uses the Symfony Asset component with asset packages.

## Terminology

- **Theme**: A labeled collection of templates and assets.

  Typically a directory containing templates. For example, templates located under `app/Resources/views/themes/my_theme`
  or `src/AppBundle/Resources/views/themes/my_theme` are part of `my_theme` theme.

- **Design**: A collection of themes.

  The order of themes within a design is important as it defines the fallback order.
  A design is identified with a name. One design can be used per SiteAccess.

### Default designs

By default two designs are included:

`admin` covers templates for the Back Office. It contains the `admin` theme.

`standard` covers the default content rendering templates. It contains the `standard` theme.
This theme is automatically mapped to the directory in kernel containing the templates.
The following templates are covered:

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

## Configuration

To define and use a design, you need to:

1. Declare it, with a name and a collection of themes to use
1. Use it for your SiteAccess

Here is a simple example:

```yaml
# ezplatform.yml
ezdesign:
    # You declare all available designs under "design_list".
    design_list:
        # my_design will be composed of "theme1" and "theme2"
        # "theme1" will be tried first. If a template cannot be found in "theme1", "theme2" will be tried out.
        my_design: [theme1, theme2]

ezpublish:
    # ...
    system:
        my_siteaccess:
            # my_siteaccess will use "my_design"
            design: my_design
```

!!! note

    Default design for a SiteAccess is `standard` which contains no themes.
    If you use the `@ezdesign` Twig namespace and/or the `ezdesign` asset package, the system will always fall back to
    application level and override directories for templates/assets lookup.

## Referencing current design

It is possible to reference current design in order to inject it into a service.
To do so, you just need to reference the `$design$` dynamic setting:

```yaml
services:
    my_service:
        class: Foo\Bar
        arguments: ["$design$"]
```

It is also possible to use the `ConfigResolver` service (`ezpublish.config.resolver`):

```php
// In a controller
$currentDesign = $this->getConfigResolver->getParameter('design');
```

## Design usage with assets

For assets, a special **`ezdesign` asset package** is available.

```jinja
<script src="{{ asset("js/foo.js", "ezdesign") }}"></script>

<link rel="stylesheet" href="{{ asset("js/foo.css", "ezdesign") }}" media="screen" />

<img src="{{ asset("images/foo.png", "ezdesign") }}" alt="foo"/>
```

Using the `ezdesign` package will resolve current design with theme fallback.

By convention, an asset theme directory can be located in:
- `<bundle_directory>/Resources/public/themes/`
- `web/assets/themes/`

Typical paths can be for example:
- `<bundle_directory>/Resources/public/themes/foo/` => Assets will be part of the `foo` theme.
- `<bundle_directory>/Resources/public/themes/bar/` => Assets will be part of the `bar` theme.
- `web/assets/themes/biz/` => Assets will be part of the `biz` theme.

It is also possible to use `web/assets` as a global override directory.
If called asset is present **directly under this directory**, it will always be considered first.

!!! caution

    You must have *installed* your assets with `assets:install` command, so that your public resources are
    *installed* into the `web/` directory.

### Fallback order

The default fallback order is:
- Application assets directory: `web/assets/`
- Application theme directory: `web/assets/themes/<theme_name>/`
- Bundle theme directory: `web/bundles/<bundle_directory>/themes/<theme_name>/`

Calling `asset("js/foo.js", "ezdesign")` can for example be resolved to `web/bundles/app/themes/my_theme/js/foo.js`.

### Performance and asset resolution

When using themes, paths for assets are resolved at runtime.
This is due to how the Symfony Asset component is integrated with Twig.
This can cause significant performance impact because of I/O calls when looping over all potential theme directories,
especially when using a lot of different designs and themes.

To work around this issue, assets resolution can be provisioned at compilation time.
Provisioning is the **default behavior in non-debug mode** (e.g. `prod` environment).
In debug mode (e.g. `dev` environment), assets are being resolved at runtime.

This behavior can, however, be controlled by the `disable_assets_pre_resolution` setting.

```yaml
# ezplatform_prod.yml
ezdesign:
    # Force runtime resolution
    # Default value is '%kernel.debug%'
    disable_assets_pre_resolution: true
```

## Design usage with templates

By convention, a theme directory must be located under `<bundle_directory>/Resources/views/themes/` or global
`app/Resources/views/themes/` directories.

Typical paths can be for example:
- `app/Resources/views/themes/foo/` => Templates will be part of the `foo` theme.
- `app/Resources/views/themes/bar/` => Templates will be part of the `bar` theme.
- `src/AppBundle/Resources/views/themes/foo/` => Templates will be part of the `foo`theme.
- `src/Acme/TestBundle/Resources/views/themes/the_best/` => Templates will be part of `the_best` theme.

In order to use the configured design with templates, you need to use the **`@ezdesign`** special **Twig namespace**.

```jinja
{# Will load 'some_template.html.twig' directly under one of the specified theme directories #}
{{ include("@ezdesign/some_template.html.twig") }}

{# Will load 'another_template.html.twig', located under 'full/' directory, which is located under one of the specified theme directories #}
{{ include("@ezdesign/full/another_template.html.twig") }}
```

You can also use `@ezdesign` notation in your eZ template selection rules:

```yaml
ezpublish:
    system:
        my_siteaccess:
            content_view:
                full:
                    home:
                        template: "@ezdesign/full/home.html.twig"
```

!!! tip

    You may also use this notation in controllers.

### Fallback order

The default fallback order is:
- Application view directory: `app/Resources/views/`
- Application theme directory: `app/Resources/views/themes/<theme_name>/`
- Bundle theme directory: `src/<bundle_directory>/Resources/views/themes/<theme_name>/`

!!! note

    Bundle fallback order is the instantiation order in `AppKernel`.

#### Additional theme paths

In addition to the convention described above, it is also possible to add arbitrary Twig template directories
to a theme from configuration. This can be useful when you want to define templates from third-party bundles
as part of one of your themes, or when upgrading your application in order to use eZ Platform design engine,
when your existing templates are not yet following the convention.

```yaml
ezdesign:
    design_list:
        my_design: [my_theme, some_other_theme]
    templates_theme_paths:
        # FOSUserBundle templates will be part of "my_theme" theme
        my_theme:
            - '%kernel.root_dir%/../vendor/friendsofsymfony/user-bundle/Resources/views'
```

!!! note "Paths precedence"

    Directories following the convention will **always** have precedence over the ones defined
    in config. This ensures that it is always possible to override a template from the application.

#### Additional override paths

It is possible to add additional global override directories, similar to `app/Resources/views/`.

```yaml
ezdesign:
    templates_override_paths:
        - "%kernel.root_dir%/another_override_directory"
        - "/some/other/directory"
```

!!! note

    `app/Resources/views/` will **always** be the top level override directory.

### PHPStorm support

`@ezdesign` Twig namespace is a *virtual* namespace, and as such is not automatically recognized by the PHPStorm Symfony plugin
for `goto` actions.

`EzPlatformDesignEngine` will generate a `ide-twig.json` file which will contain all detected theme paths for templates in your project.
It is activated by default in debug mode (`%kernel.debug%`).

By default, this config file will be stored at your project root (`%kernel.root_dir%/..`), but you can customize the path
if your PHPStorm project root doesn't match your Symfony project root.

!!! note

    `ide-twig.json` **must** be stored at your PHPStorm project root.

Default config:

```yaml
ezdesign:
    phpstorm:

        # Activates PHPStorm support
        enabled:              '%kernel.debug%'

        # Path where to store PHPStorm configuration file for additional Twig namespaces (ide-twig.json).
        twig_config_path:     '%kernel.root_dir%/..'
```
