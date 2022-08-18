---
description: Add and render a breadcrumbs element on your site.
---

# Add breadcrumbs

To add breadcrumbs to your website, first prepare a general layout template in a `templates/themes/<theme_name>/pagelayout.html.twig` file.

This template can contain things such as header, menu, footer, as well as [assets](assets.md) for the whole site,
and all other templates [extend](templates.md#connecting-templates) it.

Then, to render breadcrumbs, create a `BreadcrumbController.php` file in `src/Controller`:

``` php hl_lines="26 34"
[[= include_file('code_samples/front/layouts/breadcrumbs/src/Controller/BreadcrumbController.php') =]]
```

The controller uses the [Ancestor Search Criterion](ancestor_criterion.md)
to find all Ancestors of the current Location (line 26).
It then places the ancestors in the `breadcrumbs` variable that you can use in the template.

Next, call this controller from the page layout template and pass the current Location ID as a parameter:

``` html+twig
[[= include_file('code_samples/front/layouts/breadcrumbs/templates/themes/my_theme/pagelayout.html.twig', 0, 8) =]]
```

Finally, create a breadcrumb template in `templates/themes/<theme_name>/parts/breadcrumbs.html.twig`, as indicated in the controller (line 34).
In this template, iterate over all breadcrumbs and render links to them:

``` html+twig
[[= include_file('code_samples/front/layouts/breadcrumbs/templates/themes/my_theme/parts/breadcrumbs.html.twig') =]]
```
