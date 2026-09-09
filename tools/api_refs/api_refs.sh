#!/usr/bin/env bash

set +x;

AUTH_JSON=$(realpath ${1:-~/.composer/auth.json}); # Path to an auth.json file allowing to install the targeted edition and version
REST_API_OUTPUT_FILE=${2:-./docs/api/rest_api/rest_api_reference/rest_api_reference.html}; # Path to the REST API Reference file
REST_API_OPENAPI_FILE_YAML=${3:-./docs/api/rest_api/rest_api_reference/openapi.yaml}; # Path to the REST API OpenAPI spec file
REST_API_OPENAPI_FILE_JSON=${4:-./docs/api/rest_api/rest_api_reference/openapi.json}; # Path to the REST API OpenAPI spec file

DXP_EDITION='commerce'; # Edition from and for which the Reference is built
DXP_VERSION="${DXP_VERSION:-6.0.*}"; # Version from and for which the Reference is built; can be overridden by the DXP_VERSION env var (e.g. v5.0.x-dev for a dev build)
DXP_ADD_ONS=(integrated-help fieldtype-richtext-rte connector-anthropic connector-gemini shopping-list cdp connector-raptor connector-quable mcp); # Packages not included in $DXP_EDITION but added to the Reference, listed without their vendor "ibexa"
REDOCLY_CONFIG_TEMPLATE="$(pwd)/tools/api_refs/redocly.yaml.template"; # Absolute path to Redocly configuration template file
REDOCLY_CONFIG="$(pwd)/tools/api_refs/redocly.yaml"; # Absolute path to Redocly configuration file (generated from template)
REDOCLY_TEMPLATE="$(pwd)/tools/api_refs/redocly.hbs"; # Absolute path to Redocly wrapping template
OPENAPI_FIX="$(pwd)/tools/api_refs/openapi.php"; # A script editing and fixing few things on the dumped schema (should be temporary and fixes reported to source)

PHP_BINARY="php -d error_reporting=`php -r 'echo E_ALL & ~E_DEPRECATED;'`"; # Avoid deprecation messages from the Symfony console when using PHP 8.2 or higher
COMPOSER_BINARY='composer';
TMP_DXP_DIR=/tmp/ibexa-dxp-openapi; # Absolute path of the temporary directory in which Ibexa DXP will be installed and the REST API Reference built
FORCE_DXP_INSTALL=1; # If 1, empty the temporary directory, install DXP from scratch, build, remove temporary directory; if 0, potentially reuse the DXP already installed in temporary directory, keep temporary directory for future uses.
VIRTUAL_DXP_VERSION="${VIRTUAL_DXP_VERSION:-}"; # Version for which the reference is supposedly built when using dev branch as version; can be overridden by the VIRTUAL_DXP_VERSION env var

REST_API_OUTPUT_FILE=$(realpath $REST_API_OUTPUT_FILE); # Transform into absolute path before changing the working directory
REST_API_OPENAPI_FILE_YAML=$(realpath $REST_API_OPENAPI_FILE_YAML); # Transform into absolute path before changing the working directory
REST_API_OPENAPI_FILE_JSON=$(realpath $REST_API_OPENAPI_FILE_JSON); # Transform into absolute path before changing the working directory

if [ 1 -eq $FORCE_DXP_INSTALL ]; then
  echo 'Remove temporary directory…';
  rm -rf $TMP_DXP_DIR;
fi;
if [ -e $TMP_DXP_DIR ]; then
  echo 'Temporary directory already exists.';
  DXP_ALREADY_EXISTS=1;
else
  echo 'Create temporary directory…';
  DXP_ALREADY_EXISTS=0;
  mkdir -p $TMP_DXP_DIR;
  if [ $? -ne 0 ]; then
    exit 2;
  fi;
fi;
cd $TMP_DXP_DIR; # /!\ Change working directory (reason why all paths must be absolute)

if [ 0 -eq $DXP_ALREADY_EXISTS ]; then
  if [ ! -f $AUTH_JSON ]; then
    echo "Credentials file ${AUTH_JSON} doesn't exist.";
    exit 3;
  fi;

  echo "Creating ibexa/$DXP_EDITION-skeleton:$DXP_VERSION project in ${TMP_DXP_DIR}…";
  if [[ "$DXP_VERSION" == *".x-dev" ]]; then
    COMPOSER_AUTH="$(tr -d '\n' < $AUTH_JSON)" $COMPOSER_BINARY create-project ibexa/website-skeleton:$DXP_VERSION . --no-interaction --ignore-platform-reqs --no-scripts --stability=dev;
    if [ -n "$AUTH_JSON" ]; then
      cp $AUTH_JSON ./;
    fi;
    $COMPOSER_BINARY config repositories.ibexa composer https://updates.ibexa.co;
    $COMPOSER_BINARY config extra.symfony.endpoint "https://api.github.com/repos/ibexa/recipes-dev/contents/index.json?ref=flex/main";
    $COMPOSER_BINARY require ibexa/$DXP_EDITION:$DXP_VERSION --no-interaction --update-with-all-dependencies --no-install --ignore-platform-reqs --no-scripts;
  elif [[ "$DXP_VERSION" == *"-rc"* ]]; then
    COMPOSER_AUTH="$(tr -d '\n' < $AUTH_JSON)" $COMPOSER_BINARY create-project ibexa/website-skeleton:$DXP_VERSION . --no-interaction --ignore-platform-reqs --no-scripts --stability=rc;
    if [ -n "$AUTH_JSON" ]; then
      cp $AUTH_JSON ./;
    fi;
    $COMPOSER_BINARY config repositories.ibexa composer https://updates.ibexa.co;
    $COMPOSER_BINARY require ibexa/$DXP_EDITION:$DXP_VERSION --no-interaction --update-with-all-dependencies --no-install --ignore-platform-reqs --no-scripts;
  else
    COMPOSER_AUTH="$(tr -d '\n' < $AUTH_JSON)" $COMPOSER_BINARY create-project ibexa/$DXP_EDITION-skeleton:$DXP_VERSION . --no-interaction --no-install --ignore-platform-reqs --no-scripts;
    if [ -n "$AUTH_JSON" ]; then
      cp $AUTH_JSON ./;
    fi;
  fi;
  $COMPOSER_BINARY install --no-interaction --ignore-platform-reqs --no-scripts;
fi;

if [[ "$DXP_VERSION" == *".*"* ]]; then
  export COMPOSER_ROOT_VERSION=0.0.0;
  DXP_VERSION=$($COMPOSER_BINARY -n show ibexa/$DXP_EDITION | grep -E "^version" | cut -d 'v' -f 3);
  echo "Obtained version: $DXP_VERSION";
fi;

export COMPOSER_ROOT_VERSION=$DXP_VERSION;

if [ 0 -eq $DXP_ALREADY_EXISTS ]; then
  for additional_package in "${DXP_ADD_ONS[@]}"; do
    $COMPOSER_BINARY require --no-interaction --ignore-platform-reqs --no-scripts --with-all-dependencies ibexa/$additional_package:$DXP_VERSION;
  done;
fi;

if [[ "$DXP_VERSION" == *".x-dev" ]]; then
  DXP_VERSION=$VIRTUAL_DXP_VERSION;
fi;

if [ 0 -eq $DXP_ALREADY_EXISTS ]; then
  echo 'Set up DXP recipes…';
  git init -b main && git add . && git commit -m "Installed Ibexa Commerce" > /dev/null;
  $COMPOSER_BINARY recipes:install ibexa/$DXP_EDITION --force --reset --no-interaction;
fi;

echo 'Dump REST OpenAPI schema… ';
$PHP_BINARY bin/console ibexa:openapi --yaml \
  | sed "s@info:@info:\n  x-logo:\n    url: 'https://doc.ibexa.co/en/saas/images/cohesivo-logo.png'@" \
> openapi.yaml;
$PHP_BINARY bin/console ibexa:openapi \
  | sed 's@"info": {@"info": {\n    "x-logo": {\n      "url": "https://doc.ibexa.co/en/saas/images/cohesivo-logo.png"\n    },@' \
> openapi.json;
echo 'Fix REST OpenAPI schema… ';
$PHP_BINARY $OPENAPI_FIX;
echo 'Build REST Reference… ';
echo 'Generate Redocly config from template… ';
# Replace version with the base branch
BRANCH_VERSION=$(echo $DXP_VERSION | sed 's/^v*\([^v.]*\.[^.]*\).*/\1/');
sed "s/\$VERSION/$BRANCH_VERSION/g" $REDOCLY_CONFIG_TEMPLATE > $REDOCLY_CONFIG;
redocly build-docs openapi.yaml --output $REST_API_OUTPUT_FILE --config $REDOCLY_CONFIG --template $REDOCLY_TEMPLATE;
echo 'Copy OpenAPI spec to documentation… ';
cp openapi.yaml $REST_API_OPENAPI_FILE_YAML;
cp openapi.json $REST_API_OPENAPI_FILE_JSON;

if [ 1 -eq $FORCE_DXP_INSTALL ]; then
  echo 'Remove temporary directory…';
  rm -rf $TMP_DXP_DIR;
fi;

echo 'Done.';
exit 0;
