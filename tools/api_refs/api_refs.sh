#!/usr/bin/env bash

set +x;
set -e;

AUTH_JSON=$(realpath ${1:-~/.composer/auth.json}); # Path to an auth.json file allowing to install the targeted edition and version
PHP_API_OUTPUT_DIR=${2:-./docs/api/php_api/php_api_reference}; # Path to the directory where the built PHP API Reference is hosted
REST_API_OUTPUT_FILE=${3:-./docs/api/rest_api/rest_api_reference/rest_api_reference.html}; # Path to the REST API Reference file
REST_API_OPENAPI_FILE_YAML=${4:-./docs/api/rest_api/rest_api_reference/openapi.yaml}; # Path to the REST API OpenAPI spec file
REST_API_OPENAPI_FILE_JSON=${5:-./docs/api/rest_api/rest_api_reference/openapi.json}; # Path to the REST API OpenAPI spec file

DXP_EDITION='commerce'; # Edition from and for which the Reference is built
DXP_VERSION="${DXP_VERSION:-6.0.*}"; # Version from and for which the Reference is built; can be overridden by the DXP_VERSION env var (e.g. v5.0.x-dev for a dev build)
DXP_ADD_ONS=(rector integrated-help fieldtype-richtext-rte connector-anthropic connector-gemini shopping-list cdp connector-raptor connector-quable mcp); # Packages not included in $DXP_EDITION but added to the Reference, listed without their vendor "ibexa"
DXP_EDITIONS=(oss headless experience commerce); # Available editions ordered by ascending capabilities
SF_VERSION='7.4'; # Symfony version used by Ibexa DXP
PHPDOC_VERSION='3.10.0'; # Version of phpDocumentor used to build the Reference
PHPDOC_CONF="$(pwd)/tools/api_refs/phpdoc.dist.xml"; # Absolute path to phpDocumentor configuration file
#PHPDOC_CONF="$(pwd)/tools/api_refs/phpdoc.dev.xml"; # Absolute path to phpDocumentor configuration file
PHPDOC_TEMPLATE_VERSION='3.10.0'; # Version of the phpDocumentor base template set
PHPDOC_DIR="$(pwd)/tools/api_refs/.phpdoc"; # Absolute path to phpDocumentor resource directory (containing the override template set)
REDOCLY_CONFIG_TEMPLATE="$(pwd)/tools/api_refs/redocly.yaml.template"; # Absolute path to Redocly configuration template file
REDOCLY_CONFIG="$(pwd)/tools/api_refs/redocly.yaml"; # Absolute path to Redocly configuration file (generated from template)
REDOCLY_TEMPLATE="$(pwd)/tools/api_refs/redocly.hbs"; # Absolute path to Redocly wrapping template
REDOCLY_LINT_CONFIG="$(pwd)/tools/api_refs/redocly-lint.yaml"; # Absolute path to the Redocly configuration used to report unresolved $refs in the dumped schema
OPENAPI_FIX="$(pwd)/tools/api_refs/openapi.php"; # A script editing and fixing few things on the dumped schema (should be temporary and fixes reported to source)

PHP_BINARY="php -d error_reporting=`php -r 'echo E_ALL & ~E_DEPRECATED;'`"; # Avoid depreciation messages from phpDocumentor/Reflection/issues/529 when using PHP 8.2 or higher
COMPOSER_BINARY='composer';
TMP_DXP_DIR=/tmp/ibexa-dxp-phpdoc; # Absolute path of the temporary directory in which Ibexa DXP will be installed and the PHP API Reference built
FORCE_DXP_INSTALL=1; # If 1, empty the temporary directory, install DXP from scratch, build, remove temporary directory; if 0, potentially reuse the DXP already installed in temporary directory, keep temporary directory for future uses.
BASE_DXP_BRANCH="${BASE_DXP_BRANCH:-}"; # Branch from and for which the Reference is built when using a dev branch as version; can be overridden by the BASE_DXP_BRANCH env var
VIRTUAL_DXP_VERSION="${VIRTUAL_DXP_VERSION:-}"; # Version for which the reference is supposedly built when using dev branch as version; can be overridden by the VIRTUAL_DXP_VERSION env var

if [ ! -d $PHP_API_OUTPUT_DIR ]; then
  echo -n "Creating ${PHP_API_OUTPUT_DIR}… ";
  mkdir -p $PHP_API_OUTPUT_DIR;
  if [ $? -eq 0 ]; then
    echo 'OK';
  else
    exit 1;
  fi;
fi;
PHP_API_OUTPUT_DIR=$(realpath $PHP_API_OUTPUT_DIR); # Transform into absolute path before changing the working directory
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
  GIT_REF=$BASE_DXP_BRANCH;
elif [[ "$DXP_VERSION" == "v"* ]]; then
  GIT_REF="$DXP_VERSION";
else
  GIT_REF="v$DXP_VERSION";
fi

if [ 0 -eq $DXP_ALREADY_EXISTS ]; then
  echo -n 'Building package→edition map… ';
  PACKAGE_MAP=''
  NAMESPACE_MAP=''
  for edition in ${DXP_EDITIONS[@]}; do
    echo -n "${edition}… ";
    while IFS= read -r line; do
      package=$(echo $line | cut -d '"' -f 2);
      if [[ ! "${DXP_EDITIONS[*]}" =~ "${package/ibexa\//}" ]]; then
        PACKAGE_MAP="$PACKAGE_MAP\n'$package': '$edition',"
        NAMESPACES=$($COMPOSER_BINARY show "$package" --available --format=json | \
          jq -r --arg PACKAGE "$package" '"'\''\(.autoload | ."psr-4" | try to_entries[] catch empty | .key[:-1] | sub("\\\\";"\\\\\\";"g"))'\'': '\''\($PACKAGE)'\'',"')
        NAMESPACE_MAP="$NAMESPACE_MAP\n$NAMESPACES"
      fi;
    done <<< "$(curl --no-progress-meter "https://raw.githubusercontent.com/ibexa/$edition/$GIT_REF/composer.json" | jq .require | grep -E "(ibexa|ezsystems|silversolutions)")";
    if [ "$edition" == "$DXP_EDITION" ]; then
      break;
    fi;
  done;
  echo 'OK';

  echo -n 'Building namespace→edition map… ';
  for package in "${DXP_ADD_ONS[@]}"; do
    NAMESPACES=$($COMPOSER_BINARY show "ibexa/$package" --available --format=json | \
      jq -r --arg PACKAGE "ibexa/$package" '"'\''\(.autoload | ."psr-4" | try to_entries[] catch empty | .key[:-1] | sub("\\\\";"\\\\\\";"g"))'\'': '\''\($PACKAGE)'\'',"')
    NAMESPACE_MAP="$NAMESPACE_MAP\n$NAMESPACES"
    PACKAGE_MAP="$PACKAGE_MAP\n'ibexa/$package': 'optional',"
  done;
  echo 'OK';

  echo -n "Store package→edition and namespace→edition maps into ${map}… ";
  map=$PHPDOC_DIR/template/package-edition-map.twig;
  if [[ -f $map ]]; then
    rm $map;
  fi;
  PACKAGE_MAP="{% set package_edition_map = {\n$PACKAGE_MAP\n} %}"
  NAMESPACE_MAP="{% set namespace_package_map = {\n$NAMESPACE_MAP\n} %}"
  {
      echo -e "$PACKAGE_MAP";
      echo -e "$NAMESPACE_MAP";
      echo '{% block content %}{% endblock %}'
  } >> "$map";
  echo 'OK';
fi;

if [[ "$DXP_VERSION" == *".x-dev" ]]; then
  DXP_VERSION=$VIRTUAL_DXP_VERSION;
fi;

echo 'Set up phpDocumentor…';
sed "s/version number=\".*\"/version number=\"$DXP_VERSION\"/" $PHPDOC_CONF > ./phpdoc.dist.xml;
mkdir .phpdoc;

if [ "$PHPDOC_VERSION" != "$PHPDOC_TEMPLATE_VERSION" ]; then
  echo 'Set phpDocumentor base templates…';
  git clone -n -b "v$PHPDOC_TEMPLATE_VERSION" --depth=1 --filter=tree:0 https://github.com/phpDocumentor/phpDocumentor
  cd phpDocumentor;
  git sparse-checkout set --no-cone data/templates/default/;
  git checkout;
  mv data/templates/default ../.phpdoc/template;
  cd -;
  rm -rf phpDocumentor;
fi;

echo 'Set phpDocumentor override templates…';
cp -R $PHPDOC_DIR ./;
mkdir -p php_api_reference/js;
mv ./.phpdoc/template/fonts ./php_api_reference/;
mv ./.phpdoc/template/images ./php_api_reference/;
mv ./.phpdoc/template/js/*.js ./php_api_reference/js/;

echo 'Set Symfony version…';
sed "s/symfony_version = '.*'/symfony_version = '$SF_VERSION'/" $PHPDOC_DIR/template/base.html.twig > ./.phpdoc/template/base.html.twig;

echo 'Run phpDocumentor…';
curl -LO "https://github.com/phpDocumentor/phpDocumentor/releases/download/v$PHPDOC_VERSION/phpDocumentor.phar";
PHPDOC_BIN='phpDocumentor.phar';
if [[ "$PHPDOC_VERSION" == "3.4."* ]]; then
  PHPDOC_BIN='phpDocumentor.phar run';
fi;
$PHP_BINARY $PHPDOC_BIN -t php_api_reference;
if [ $? -eq 0 ]; then
  echo -n 'Remove unneeded from phpDocumentor output… ';
  rm -rf ./php_api_reference/files ./php_api_reference/graphs ./php_api_reference/indices ./php_api_reference/packages;
  rm -f ./php_api_reference/images/apple-touch-icon.png ./php_api_reference/images/favicon-16x16.png ./php_api_reference/images/favicon-32x32.png ./php_api_reference/images/favicon.ico;
  rm -f ./php_api_reference/classes/Symfony-*.html ./php_api_reference/namespaces/symfony*.html;
  echo -n 'Remove Symfony namespace from index… ';
  awk 'NR==FNR{if (/.*"fqsen": "\\\\Symfony.*/) for (i=-1;i<=3;i++) del[NR+i]; next} !(FNR in del)' \
    ./php_api_reference/js/searchIndex.js \
    ./php_api_reference/js/searchIndex.js \
    > ./php_api_reference/js/searchIndex.new.js;
  mv -f ./php_api_reference/js/searchIndex.new.js ./php_api_reference/js/searchIndex.js;
  echo -n "Copy phpDocumentor output to ${PHP_API_OUTPUT_DIR}… ";
  cp -rf ./php_api_reference/* $PHP_API_OUTPUT_DIR;
  echo -n 'Remove surplus… ';
  while IFS= read -r line; do
    file="$(echo $line | sed -r 's/Only in (.*): (.*)/\1\/\2/')";
    if [[ $file = $PHP_API_OUTPUT_DIR/* ]]; then
      rm -rf $file;
    fi;
  done <<< "$(diff -qr ./php_api_reference $PHP_API_OUTPUT_DIR | grep 'Only in ')";
  echo 'OK.';
else
  echo 'A phpDocumentor error prevents PHP Reference update.';
  exit 3;
fi;

if [ 0 -eq $DXP_ALREADY_EXISTS ]; then
  echo 'Set up DXP recipes…';
  git init -b main && git add . && git commit -m "Installed Ibexa Commerce" > /dev/null;
  $COMPOSER_BINARY recipes:install ibexa/$DXP_EDITION --force --reset --no-interaction;
fi;

echo 'Dump REST OpenAPI schema… ';
$PHP_BINARY bin/console ibexa:openapi --yaml \
  | sed "s@info:@info:\n  x-logo:\n    url: 'https://doc.ibexa.co/en/latest/images/cohesivo-logo-alt.svg'@" \
> openapi.yaml;
$PHP_BINARY bin/console ibexa:openapi \
  | sed 's@"info": {@"info": {\n    "x-logo": {\n      "url": "https://doc.ibexa.co/en/latest/images/cohesivo-logo-alt.svg"\n    },@' \
> openapi.json;
echo 'Fix REST OpenAPI schema… ';
$PHP_BINARY $OPENAPI_FIX;
echo 'Check the dumped REST OpenAPI schema for unresolved references… ';
# `redocly build-docs` reports an unresolved $ref as nothing but
# "Invalid reference token: <name>", with no file, path or line, which makes such
# a failure very hard to trace back to the endpoint that caused it. Linting first
# names the exact location. Kept non-fatal on purpose: `build-docs` below stays
# the gate, so this can only ever add information, never break a working build.
if ! redocly lint openapi.yaml --config $REDOCLY_LINT_CONFIG; then
  echo '::error title=Unresolved references in the REST OpenAPI schema::The dumped schema references components it does not define; see the paths reported above. This makes the "redocly build-docs" step below fail with "Invalid reference token".';
fi;
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
