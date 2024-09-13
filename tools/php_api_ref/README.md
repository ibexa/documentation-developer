# PHP API Ref

## Install/Dependencies

Requires [`jq`](https://stedolan.github.io/jq/download/)

## Basic usage

`tools/php_api_ref/phpdoc.sh` is a script generating PHP API Reference, by default, under `docs/api/php_api/php_api_reference/`.

- For Composer, if you do not use a global authentication to retrieve _Commerce_ edition, a path to an auth.json file can be given as first argument. For example:
  ```
  tools/php_api_ref/phpdoc.sh ~/www/ibexa-dxp-commerce/auth.json
  ```
- The second argument can be a path to an output directory to use instead of the default one. For example, using the Composer global authentication file as first argument and the path to directory (which is created if it doesn't exist yet):
  ```
  tools/php_api_ref/phpdoc.sh ~/.composer/auth.json ./docs/api/php_api/php_api_reference-TMP
  ```

## Rebuild example

```bash
tools/php_api_ref/phpdoc.sh
git add docs/api/php_api/php_api_reference/
git commit -m "Rebuild PHP API Ref's HTML"
git push
```

## Maintenance

In `tools/php_api_ref/phpdoc.sh`:

`PHPDOC_VERSION` should always target the last version of phpDocumentor.

`DXP_VERSION` should target the version of Ibexa DXP Commerce corresponding to the main doc's branch.

### Templates

Custom templates are located in `tools/php_api_ref/.phpdoc/template/` directory.
They are overriding the default templates from a phpDocumentor version.
The default templates version is not always the same as the phpDocumentor binary version.
To update the default templates version, the overriding custom templates must be updated as well to obtain a better or equal result without bug.
See `PHPDOC_VERSION` and `PHPDOC_TEMPLATE_VERSION`.

## Advanced usage

`tools/php_api_ref/phpdoc.sh` has a set of internal variables that might be edited for particular usages.

`PHPDOC_CONF` can be changed to use a different config file.
For example, when working on the design, the set of parsed files can be reduced for a quicker PHP API Reference compilation.

`PHP_BINARY` can be edited, for example, to use a different PHP version than the default, to change verbosity, or to add `-d memory_limit=-1`.

`FORCE_DXP_INSTALL` can be changed to `0` (zero) to have a persistent `TMP_DXP_DIR`.
After a first run to create it, the Ibexa DXP won't be rebuilt by Composer by next runs.
Time is saved. The DXP's code could even be modified for test purpose.

If you change some of those values, please do not commit those changes, and don't commit their output.
To prevent that, you can make a local copy, and use this copy to generate in a temporary output directory:
```shell
cp tools/php_api_ref/phpdoc.sh tools/php_api_ref/phpdoc.dev.sh
nano phpdoc.dev.sh # Edit and make your changes. For example, change PHPDOC_CONF to use phpdoc.dev.xml.
nano phpdoc.dev.xml # Edit and make your changes. For example, target only your package.
tools/php_api_ref/phpdoc.sh ~/.composer/auth.json ./docs/api/php_api/php_api_reference-TMP
```

### Test a branch

To load a package on a development branch instead of a released version,
uncommented in `phpdoc.sh` the piece of code about `MY_PACKAGE` and `MY_BRANCH`,
and set the value of those two variables.

`MY_PACKAGE` is the name of the Ibexa package without the vendor.

`MY_BRANCH` is the Composer constraint targeting the branch.
It's the name of the branch prefixed with `dev-` (e.g. `dev-improved_contentservice_phpdoc`),
or a branch alias suffixed with `-dev` (e.g. `4.6.x-dev`).
See https://getcomposer.org/doc/articles/aliases.md for more.

The following example load `ibexa/core` package at the `HEAD` of `4.6` branch using its alias.

```bash
if [ 0 -eq $DXP_ALREADY_EXISTS ]; then
  MY_PACKAGE='core';
  MY_BRANCH='4.6.x-dev';
  composer require --no-interaction --ignore-platform-reqs --no-scripts ibexa/$MY_PACKAGE "$MY_BRANCH as $DXP_VERSION";
fi;
```
