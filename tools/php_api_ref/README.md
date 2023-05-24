PHP API Ref
===========

## Install/Dependencies

Requires [`jq`](https://stedolan.github.io/jq/download/)

## Usage

`tools/php_api_ref/phpdoc.sh` is a script generating PHP API Reference, by default, under `docs/api/php_api/php_api_reference/`.

- For Composer, if you do not use a global authentication to retrieve _Commerce_ edition, a path to an auth.json file can be given as first argument. For example:
  ```
  tools/php_api_ref/phpdoc.sh ~/www/ibexa-dxp-commerce/auth.json
  ```
- The second argument can be a path to an output directory to use instead of the default one. For example, using the Composer global authentication file as first argument and the path to directory (which will be created if it doesn't exist yet):
  ```
  tools/php_api_ref/phpdoc.sh ~/.composer/auth.json ./docs/api/php_api/php_api_reference-TMP
  ```

## Templates

The phpDocumentor 3.3.1's default theme is used as a base.

Our custom templates are located in tools/php_api_ref/.phpdoc/template

They [replace](https://docs.phpdoc.org/3.3/guide/features/theming/custom-styling.html#replacing-whole-objects-or-components) the [phpDocumentor 3.3.1 default template set](https://github.com/phpDocumentor/phpDocumentor/tree/v3.3.1/data/templates/default) by having the same file tree and names.

### Customizations per template:

* …/template/
  - base.html.twig sets the "global" Twig variable `usesPackages` to `false`, and some JavaScript to animate the tree.
  - index.html.twig adds the introduction.
  - edition-tag.html.twig defines a `edition_tag` macro imported by *-title.html.twig templates.
  - package-edition-map.html.twig defines a `package_edition_map` variable used by the `edition_tag` macro, this template is extended by each template needing this macro.
  - components/
    - class-title.html.twig adds the edition tag.
    - element-found-in.html.twig replaces the link to a summary of the elements found in a file (generally just one class) by a copy of the file path to the reader's clipboard.
    - header-title.html.twig adds the Ibexa logo linking to the PHP API introduction in the main documentation.
    - interface-title.html.twig adds the edition tag.
    - menu.html.twig sorts alphabetically the second-level namespaces in the left sidebar.
    - method-response.html.twig doesn't display a return type for a `__construct` method, and doesn't add a dash if there is no return description behind it.
    - method-signature.html.twig doesn't display a return type for a `__construct` method.
    - sidebar.html.twig removes several entries from left sidebar: no more Packages, Reports/Errors, Reports/Markers nor Indices/Files.
    - table-of-contents-entry.html.twig doesn't display a return type for a `__construct` method.
    - tags.html.twig groups tag of the same name, skips the `@todo` tags, and doesn't display a `@uses` or `@see` tag if it's not a link.
  - css/
    - custom.css.twig stylizes.
