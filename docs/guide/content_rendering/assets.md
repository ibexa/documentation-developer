---
description: Add assets (CSS, JS, image and other files) to your site and manage them using Webpack Encore.
---

# Assets

Assets enable you to add CSS, JS, image or other files to your project,
to style and customize its look and behavior.

## Asset files

To add assets to the project, provide asset files (such as CSS or JS files)
in the `assets` folder, for example under `assets/css` and `assets/js`.

## Configure assets

All asset files must be added to `webpack.config.js` in the root folder,
so that Webpack Encore can use them.
To do it, use `Encore.addStyleEntry` for CSS files and `Encore.addEntry` for other files, such as JS:

``` js
Encore.addStyleEntry('style', [
    path.resolve(__dirname, './assets/css/style.css'),
]);

Encore.addEntry('script', [
    path.resolve(__dirname, './assets/js/script.js'),
]);
```

## Include assets in templates

To include assets in your templates, add them to the template's `<head>` tag,
and provide the name of the asset entry you configured in `webpack.config.js`, for example:

``` html+twig
{{ encore_entry_link_tags('style') }}

{{ encore_entry_script_tags('script') }}
```

!!! note

    After you add the asset files, clear the cache and run `yarn encore <dev|prod>`.

To include a single asset file in your template, for example an image,
use the [`asset()`]([[= symfony_doc =]]/reference/twig_reference.html#asset) Twig function:

``` html+twig
<img src="{{ asset('assets/images/logo.png') }}">
```

Place the image file in the `public/assets/images` folder.
