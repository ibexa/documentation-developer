# Design engine

You can use multiple different designs (themes) in your installation.
You can set up different designs per SiteAccess or SiteAccess group.

Designs are configured under the `ibexadesign.design_list` key:

``` yaml
ibexa_design_engine:
    design_list:
        my_design: [theme1, theme2]
        another_design: [theme3]
```

To indicate when to use a design, configure it under `ibexa.system.<scope>`:

``` yaml
ibexa:
    system:
        <scope>:
            design: my_design
```

Each scope can use only one design.

!!! caution

    After you create a new folder with a design in `templates/themes`,
    you must clear the cache (`php bin/console cache:clear`), even if you work in the dev environment.

## Order of themes

The order of themes in a design is important.
The design engine attempts to apply the first theme in configuration (for example, `theme1`).
If it cannot find the required template or asset in this theme, it proceeds to the next theme in the list (for example, `theme2`).

You can use this behavior to override only some templates from the main theme of your website.
Do this, for example, when you create a SiteAccess with a special design for a campaign.

## Additional configuration

### Additional theme paths

You can add any Twig template folder to the theme configuration.

You can use it if you want to define templates from third-party bundles as part of one of your themes.

To do it, set the `ibexadesign.templates_theme_paths` parameter:

``` yaml
ibexa_design_engine:
    design_list:
        my_design: [my_theme]
    templates_theme_paths:
        my_theme:
            - '%kernel.project_dir%/vendor/<vendor_name>/<bundle_name>/Resources/views'
```

Theme folders that you define have priority over the ones defined in `templates_theme_paths`.
This ensures that it is always possible to override a template at the application level.

You can also add a global override folder, by listing paths without assigning them to a theme:

``` yaml
ibexa_design_engine:
    templates_override_paths:
        - '%kernel.project_dir%/src/<an_override_directory>'
```

### Asset resolution

In production environments, to improve performance, asset resolution is done at compilation time.
In development environments, assets are resolved at runtime.

You can change this behavior by setting `disable_assets_pre_resolution`:

``` yaml
ibexa_design_engine:
    disable_assets_pre_resolution: true
```
