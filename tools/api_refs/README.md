# PHP API Ref

## Install/Dependencies

Requires [`jq`](https://stedolan.github.io/jq/download/)

## Basic usage

`tools/api_refs/api_refs.sh` is a script generating PHP & REST API References, by default, under `docs/api/php_api/php_api_reference/` and `docs/api/rest_api/rest_api_reference/`.

- For Composer, if you do not use a global authentication to retrieve _Commerce_ edition, a path to an auth.json file can be given as first optional argument. For example:
  ```
  tools/api_refs/api_refs.sh ~/www/ibexa-dxp-commerce/auth.json
  ```
- The second optional argument can be a path to an output directory to use instead of the default one. For example, using the Composer global authentication file as first argument and the path to directory (which is created if it doesn't exist yet):
  ```
  tools/api_refs/api_refs.sh ~/.composer/auth.json ./docs/api/php_api/php_api_reference-TMP
  ```
- The next three optional arguments are the REST API files
    - 3rd argument is the reference HTML file path
    - 4th argument is the file path for the OpenAPI specification in YAML format
    - 5th argument is the file path for the OpenAPI specification in JSON format

## Rebuild example

```bash
tools/api_refs/api_refs.sh
git add docs/api/php_api/php_api_reference/
git commit -m "Rebuild PHP API Ref's HTML"
git push
```

## Maintenance

In `tools/api_refs/api_refs.sh`:

`PHPDOC_VERSION` should always target the last version of phpDocumentor.

`DXP_VERSION` should target the version of Ibexa DXP Commerce corresponding to the main doc's branch.

### Templates

Custom templates are located in `tools/api_refs/.phpdoc/template/` directory.
They are overriding the default templates from a phpDocumentor version.
The default templates version is not always the same as the phpDocumentor binary version.
To update the default templates version, the overriding custom templates must be updated as well to obtain a better or equal result without bug.
See `PHPDOC_VERSION` and `PHPDOC_TEMPLATE_VERSION`.

## Advanced usage

`tools/api_refs/api_refs.sh` has a set of internal variables that might be edited for particular usages.

`PHPDOC_CONF` can be changed to use a different config file.
For example, when working on the design, the set of parsed files can be reduced for a quicker PHP API Reference compilation.

`PHP_BINARY` can be edited, for example, to use a different PHP version than the default, to change verbosity, or to add `-d memory_limit=-1`.

`FORCE_DXP_INSTALL` can be changed to `0` (zero) to have a persistent `TMP_DXP_DIR`.
After a first run to create it, the Ibexa DXP won't be rebuilt by Composer by next runs.
Time is saved. The DXP's code could even be modified for test purpose.

If you change some of those values, please do not commit those changes, and don't commit their output.
To prevent that, you can make a local copy, and use this copy to generate in a temporary output directory:
```bash
cp tools/api_refs/api_refs.sh tools/api_refs/api_refs.dev.sh
nano tools/api_refs/api_refs.dev.sh # Edit and make your changes. For example, change PHPDOC_CONF to use phpdoc.dev.xml.
nano tools/api_refs/phpdoc.dev.xml # Edit and make your changes. For example, target only your package.
tools/api_refs/api_refs.dev.sh ~/.composer/auth.json ./docs/api/php_api/php_api_reference-TMP
```

### Creating a build of dev version

To build the reference for an unreleased version, set the following variables:

- `DXP_VERSION`
- `BASE_DXP_BRANCH`
- `VIRTUAL_DXP_VERSION`

For example, to build the API Reference based on the development version of the DXP before the 5.0.10 release, run:

``` bash
DXP_VERSION=v5.0.x-dev BASE_DXP_BRANCH=5.0 VIRTUAL_DXP_VERSION=5.0.10 tools/api_refs/api_refs.sh ~/my/path/to/auth.json
```

### Test a branch

To load a package on a development branch instead of a released version,
uncommented in `api_refs.sh` the piece of code about `MY_PACKAGE` and `MY_BRANCH`,
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

### Run as GitHub Action

#### Using `gh`

With [GitHub CLI `gh`](https://cli.github.com/), you can trigger a GitHub Action workflow to build the API References.

```bash
gh workflow run api_refs.yaml -f version=<tag> -f use_dev_version=<false|true> --ref <branch> -f base_branch=<branch> -f work_branch=<branch> -f force=<false|true>
```

`-f version=<tag>` to pass the Ibexa DXP version tag for which the API References are built.
`-f use_dev_version=<false|true>` to use the released version designed by the tag, or to use the development version (`v5.0.x-dev`) for an incoming tag.
`--ref <branch>` to use the `api_refs.yaml` workflow from a given branch instead of the default branch (`5.0`).
`-f base_branch=<branch>` to use the `api_refs.sh` from a given branch and make a PR to that branch.
`-f work_branch=<branch>` to use a given target branch to commit the build and make a PR from that branch.
`-f force=<false|true>` to force the commit on the target branch even if it already exists.

Examples:

Build from the dev branch `5.0.x-dev` API references for `v5.0.999`:

```bash
gh workflow run api_refs.yaml -f version=v5.0.999 -f use_dev_version=true
```

Rebuild references for the released version `v5.0.10` from `my-tools`'s `api_refs.yaml` with `my-tools`'s tools and commit the result into `my-api-refs` even if it already exists:

```bash
gh workflow run api_refs.yaml -f version=v5.0.10 --ref my-builder -f base_branch=my-builder -f work_branch=my-api-refs -f force=true
```
