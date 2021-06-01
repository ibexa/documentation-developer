# Other extensibility

!!! enterprise

    ## Block templates

    All Landing Page blocks, both those that come out of the box and custom ones, can have multiple templates. This allows you to create different styles for each block and let the editor choose them when adding the block from the UI. The templates are defined in your configuration files like in the following example, with `simplelist` and `special` being the template names:

    ``` yaml
    # app/config/block_templates.yml
    blocks:
        contentlist:
            views:
                simplelist:
                    template: blocks/contentlist_simple.html.twig
                    name: Simple Content List
                special:
                    template: blocks/contentlist_special.html.twig
                    name: Special Content List
    ```

    Some blocks can have slightly more complex configuration. An example is the Collection block, which requires an `options` key.
    This key defines which Content Types can be added to it.
    See [this example from the Studio Demo](https://github.com/ezsystems/ezstudio-demo-bundle/blob/master/Resources/config/default_layouts.yml#L160):

    ``` yaml
    blocks:
        collection:
            views:
                content:
                    template: eZStudioDemoBundle:blocks:collection.content.html.twig
                    name: Content List View
                    options:
                        match: [article, blog_post]
                gallery:
                    template: eZStudioDemoBundle:blocks:collection.content.html.twig
                    name: Gallery View
                    options:
                        match: [image]
    ```

## Custom Content Type icons

The Content Type to which a Content item belongs is represented graphically using an icon near the Content item name. Essentially, the Content Types are project-specific so the icons can be easily configured and extended by integrators.

### Font icons + CSS

Icons in the PlatformUI interface are provided by an icon font. For Content Types, the idea is to expand that concept so that while generating the interface, we end up with a code similar to:

``` html
<h1 class="ez-contenttype-icon ez-contenttype-icon-folder">Folder Name</h1>
```

With such classes, the `h1` is specified to display a Content Type icon. The class `ez-contenttype-icon` makes sure the element is styled for that and gets the default Content Type icon. The second class is specific to the Content Type based on its identifier and if it's defined in one of the CSS files, the element will get the custom Content Type icon defined there.

### Adding new Content Type icons

The extensibility of Content Type icons is tackled differently depending on the use case, but it relies on the ability to embed a custom CSS file in PlatformUI with `css.yml`.

To prevent the need to configure/extend the system, we provide several pre-configured icons for very common Content Types such as:

- `product`
- `author`
- `category`
- `gallery` / `portfolio`
- `blog_post` / `blogpost` / `post`
- `blog` / `weblog`
- `news`
- `pdf`
- `document`
- `photo`
- `comment`
- `wiki`
- `wiki_page` / `wikipage`

There are three ways of choosing Content Type icons:

#### Pick an icon for a custom Content Type from existing icons

In such a case you need to pick the icon code using an icon font. In these examples we use [the Icomoon application](https://icomoon.io/app/). To ease that process and the readability of the code, we'll use ligatures in the font icon so that the CSS code for a custom Content Type could look like:

``` css
 /* in a custom CSS file included with `css.yml` */
.ez-contenttype-icon-mycontenttypeidentifier:before {
    content: "product"; /* because this icon matches the usage of such content
    items */
}
```

#### Add custom icons

If the icons we provide do not fit a custom Content Type, then a new custom icon font has to be added. To generate the icon, the Icomoon app can be used (or another icon font generation tool). Then, using a custom CSS stylesheet, this font can be included and the `ez-contenttype-icon-<content type identifier>` can be configured to use that font.

Example:

``` css
/* in a custom CSS file included with `css.yml` */
@font-face {
    font-family: 'my-icon-font';
    src:url('../../fonts/my-icon-font.eot');
    src:url('../../fonts/my-icon-font.eot?#iefix') format('embedded-opentype'),
        url('../../fonts/my-icon-font.woff') format('woff'),
        url('../../fonts/my-icon-font.ttf') format('truetype'),
        url('../../fonts/my-icon-font.svg#my-icon-font') format('svg');
    font-weight: normal;
    font-style: normal;
}
.ez-contenttype-icon-myidentifier:before {
    font-family: 'my-icon-font';
    content: "myiconcode";
}
/* repeated as many times as needed for each custom Content Type */
```

#### Completely override the icon set

The solution for this use case is very close to the previous one. A custom icon font will have to be produced, loaded with a custom CSS file, and then the `ez-contenttype-icon` style has to be changed to use that new font.

Example:

``` css
/* in a custom CSS file included with `css.yml` */
@font-face {
    font-family: 'my-icon-font';
    src:url('../../fonts/my-icon-font.eot');
    src:url('../../fonts/my-icon-font.eot?#iefix') format('embedded-opentype'),
        url('../../fonts/my-icon-font.woff') format('woff'),
        url('../../fonts/my-icon-font.ttf') format('truetype'),
        url('../../fonts/my-icon-font.svg#my-icon-font') format('svg');
    font-weight: normal;
    font-style: normal;
}
.ez-contenttype-icon:before {
    font-family: 'my-icon-font'; /* replaces ez-platformui-icomoon */
    /* no further change needed if the custom icon font uses the same
     * codes/ligatures
     */
}
```

## Custom Javascript

Custom Javascript can be added to PlatformUI using the following configuration block:

``` yaml
ez_platformui:
    system:
        default:
            javascript:
                files:
                   - '<path to js file>'
```
