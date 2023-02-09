---
description: Design engine allows you to use different SiteAccess-aware themes in your site.
---

# Design engine

You can use multiple different designs (theme lists) in your installation.
You can set up different designs per SiteAccess or SiteAccess group.

Designs are configured under the `ibexa_design_engine.design_list` key:

``` yaml
ibexa_design_engine:
    design_list:
        my_design: [theme2, theme1, theme0]
        another_design: [theme3, theme0]
```

To indicate when to use a design, configure it under `ibexa.system.<scope>`:

``` yaml
ibexa:
    system:
        <scope>:
            design: my_design
```

Each scope can use only one design.

## Design theme list

A theme is a set of directories to look for templates in. At application level, theme's templates are placed in a directory under `templates/themes` which has the same name as the theme.
For example, templates placed in `templates/themes/standard` directory are automatically added to the `standard` theme.

!!! caution

    After you create a new directory with a theme in `templates/themes`,
    you must clear the cache (`php bin/console cache:clear`), even if you work in the dev environment.

The order of themes in a design is important.
The design engine attempts to apply the first theme in configuration (for example, `theme2`).
If it cannot find the required template or asset in this theme, it proceeds to the next theme in the list (for example, `theme1` then `theme0` and finally the default `standard`).

The `@ibexadesign` keyword in template paths is the way to use this feature.
When the design engine finds `@ibexadesign`, it loops over the theme list of the current design and checks whether the template for the given theme exists in its paths.
For example, `@ibexadesign/pagelayout.html.twig` means that this template is searched at locations like `templates/themes/theme2/pagelayout.html.twig`, `templates/themes/theme1/pagelayout.html.twig`, `templates/themes/theme0/pagelayout.html.twig` and then `templates/themes/standard/pagelayout.html.twig`.

You can use this behavior to override only some templates from the main theme of your website.
Do this, for example, when you create a SiteAccess with a special design for a campaign.

!!! tip

    You can check the final design theme lists with the following command:
    ```shell
    php bin/console debug:container --parameter=ibexa.design.list --format=json
    ```

## Additional configuration

### Additional theme paths

You can add any Twig template directory to the theme configuration.

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

Theme directories that you define have priority over the ones defined in `templates_theme_paths`.
This ensures that it is always possible to override a template at the application level.

You can also add a global override directory, by listing paths without assigning them to a theme:

``` yaml
ibexa_design_engine:
    templates_override_paths:
        - '%kernel.project_dir%/src/<an_override_directory>'
```

!!! tip

    You can check the final template directory list per theme with the following command:
    ```shell
    php bin/console debug:container --parameter=ibexa.design.templates.path_map --format=json
    ```
    `_override` is a theme added at the beginning of the current design theme list at template path resolution time.

### Asset resolution

In production environments, to improve performance, asset resolution is done at compilation time.
In development environments, assets are resolved at runtime.

You can change this behavior by setting `disable_assets_pre_resolution`:

``` yaml
ibexa_design_engine:
    disable_assets_pre_resolution: true
```
