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
For example, when working on the design, the set of analysed files can be reduced for a quicker PHP API Reference compilation.

`PHP_BINARY` can be edited, for example, to use a different PHP version than the default, or to change verbosity.

`FORCE_DXP_INSTALL` can be changed to `0` (zero) to have a persistent `TMP_DXP_DIR`.
After a first run to create it, the Ibexa DXP won't be rebuilt by Composer by next runs.
Time is saved. The DXP's code could even be modified for test purpose.
