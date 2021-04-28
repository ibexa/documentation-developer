# Assets

## Asset files

To add assets to the front site, provide asset files (such as CSS or JS files)
in the `assets` folder, for example under `assets/css` and `assets/js`.

## Configure assets

All asset files must be added to `webpack.config.js` in the root folder
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

    After adding asset files, clear cache and run `yarn encore <dev|prod>`.

To include a single asset file in your template, for example an image, use the Twig `asset()` function:

``` html+twig
<img src="{{ asset('assets/images/logo.png') }}">
```

Place the image file in the `public/assets/images` folder.

### Assets and design engine

If you use the [design engine](design_engine/design_engine.md), pass the `ezdesign` package to the `asset()` function
to use the asset from the current design.

``` html+twig
<img src="{{ asset('assets/images/logo.png', 'ezdesign') }}">
```
