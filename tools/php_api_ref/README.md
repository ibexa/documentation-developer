PHP API Ref
===========

## Install/Dependencies

Requires [`jq`](https://stedolan.github.io/jq/download/)

## Usage

`tools/php_api_ref/phpdoc.sh` is a script generating PHP API Reference, by default, under `docs/api/php_api/php_api_reference/`.

- For Composer, if you do not use a global authentication to retrieve _Commerce_ edition, a path to an auth.json file can be given as first argument.
- The second argument can be a path to an output directory to use instead of the default one.

```
tools/php_api_ref/phpdoc.sh ~/www/ibexa-dxp-commerce/auth.json
```
