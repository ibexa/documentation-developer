# Overriding shop templates

To override existing shop templates, first create a [design](../design_engine/design_engine.md) for your shop.

``` yaml
[[= include_file('code_samples/front/shop/override_navigation/config/packages/design.yaml') =]]
```

!!! note "Template theme paths"

    All shop bundles contain an `ez_design.yml` file which is used to define the `templates_theme_path` path to the templates.
    Without the [template theme path](../design_engine/design_engine.md#additional-theme-paths), the templates are not recognized by the design engine.

Then, in `ezplatform.yaml`, indicate that the design should be used for the relevant [scope](../../multisite/multisite_configuration.md#scope),
for example, for the `site_group` SiteAccess group:

``` yaml
        site_group:
            design: my_design
```

Finally, place your override templates in `templates/themes/<theme_name>`.

For example, to override the left menu in the product catalog view, place the template in 
`templates/themes/my_theme/Navigation/left_menu.html.twig`:

``` html+twig
[[= include_file('code_samples/front/shop/override_navigation/templates/themes/my_theme/Navigation/left_menu.html.twig') =]]
```
