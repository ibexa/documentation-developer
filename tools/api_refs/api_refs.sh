#!/usr/bin/env bash

set +x;

AUTH_JSON=${1:-~/.composer/auth.json}; # Path to an auth.json file allowing to install the targeted edition and version
PHP_API_OUTPUT_DIR=${2:-./docs/api/php_api/php_api_reference}; # Path to the directory where the built PHP API Reference is hosted
REST_API_OUTPUT_FILE=${3:-./docs/api/rest_api/rest_api_reference/rest_api_reference.html}; # Path to the REST API Reference file

DXP_EDITION='commerce'; # Edition from and for which the Reference is built
DXP_VERSION='5.0.x-dev'; # Version from and for which the Reference is built
DXP_ADD_ONS=(connector-ai connector-openai automated-translation product-catalog-date-time-attribute); # Packages not included in $DXP_EDITION but added to the Reference, listed without their vendor "ibexa"
DXP_EDITIONS=(oss headless experience commerce); # Available editions ordered by ascending capabilities
SF_VERSION='6.4'; # Symfony version used by Ibexa DXP
PHPDOC_VERSION='3.7.1'; # Version of phpDocumentor used to build the Reference
PHPDOC_CONF="$(pwd)/tools/api_refs/phpdoc.dist.xml"; # Absolute path to phpDocumentor configuration file
#PHPDOC_CONF="$(pwd)/tools/api_refs/phpdoc.dev.xml"; # Absolute path to phpDocumentor configuration file
PHPDOC_TEMPLATE_VERSION='3.7.1'; # Version of the phpDocumentor base template set
PHPDOC_DIR="$(pwd)/tools/api_refs/.phpdoc"; # Absolute path to phpDocumentor resource directory (containing the override template set)

PHP_BINARY="php -d error_reporting=`php -r 'echo E_ALL & ~E_DEPRECATED;'`"; # Avoid depreciation messages from phpDocumentor/Reflection/issues/529 when using PHP 8.2 or higher
TMP_DXP_DIR=/tmp/ibexa-dxp-phpdoc; # Absolute path of the temporary directory in which Ibexa DXP will be installed and the PHP API Reference built
FORCE_DXP_INSTALL=1; # If 1, empty the temporary directory, install DXP from scratch, build, remove temporary directory; if 0, potentially reuse the DXP already installed in temporary directory, keep temporary directory for future uses.
BASE_DXP_BRANCH='master'; # Branch from and for which the Reference is built when using a dev branch as version
VIRTUAL_DXP_VERSION='5.0.0'; # Version for which the reference is supposedly built when using dev branch as version

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
  echo "Creating ibexa/$DXP_EDITION-skeleton:$DXP_VERSION project in ${TMP_DXP_DIR}…";
  if [[ "$DXP_VERSION" == *".x-dev" ]]; then
    composer create-project ibexa/website-skeleton:$DXP_VERSION . --no-interaction --no-install --ignore-platform-reqs --no-scripts --stability=dev;
    if [ -n "$AUTH_JSON" ]; then
      cp $AUTH_JSON ./;
    fi;
    composer config repositories.ibexa composer https://updates.ibexa.co;
    composer require ibexa/$DXP_EDITION:$DXP_VERSION --no-interaction --update-with-all-dependencies --no-install --ignore-platform-reqs --no-scripts;
  else
    composer create-project ibexa/$DXP_EDITION-skeleton:$DXP_VERSION . --no-interaction --no-install --ignore-platform-reqs --no-scripts;
    if [ -n "$AUTH_JSON" ]; then
      cp $AUTH_JSON ./;
    fi;
  fi;
  composer install --no-interaction --ignore-platform-reqs --no-scripts;
fi;

if [[ "$DXP_VERSION" == *".*"* ]]; then
  export COMPOSER_ROOT_VERSION=0.0.0;
  DXP_VERSION=$(composer -n show ibexa/$DXP_EDITION | grep -E "^version" | cut -d 'v' -f 3);
  echo "Obtained version: $DXP_VERSION";
fi;

export COMPOSER_ROOT_VERSION=$DXP_VERSION;

if [ 0 -eq $DXP_ALREADY_EXISTS ]; then
  for additional_package in "${DXP_ADD_ONS[@]}"; do
    composer require --no-interaction --ignore-platform-reqs --no-scripts ibexa/$additional_package:$DXP_VERSION
  done;
fi;

if [[ "$DXP_VERSION" == *".x-dev" ]]; then
  GIT_REF=$BASE_DXP_BRANCH;
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
        NAMESPACES=$(composer show "$package" --available --format=json | \
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
    NAMESPACES=$(composer show "ibexa/$package" --available --format=json | \
      jq -r --arg PACKAGE "ibexa/$package" '"'\''\(.autoload | ."psr-4" | try to_entries[] catch empty | .key[:-1] | sub("\\\\";"\\\\\\";"g"))'\'': '\''\($PACKAGE)'\'',"')
    NAMESPACE_MAP="$NAMESPACE_MAP\n$NAMESPACES"
    PACKAGE_MAP="$PACKAGE_MAP\n'ibexa/$package': 'optional',"
  done;
  echo 'OK';

  echo -n "Store package→edition and namespace→edition maps into $map… ";
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
  rm -f ./php_api_reference/classes/Symfony-*.html ./php_api_reference/namespaces/symfony*.html
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

echo -n 'Dumping REST OpenAPI schema… ';
$PHP_BINARY bin/console ibexa:openapi --yaml > openapi.yaml;
echo -n 'Building REST Reference… ';
redocly build-docs openapi.yaml --output $REST_API_OUTPUT_FILE
echo 'OK';

if [ 1 -eq $FORCE_DXP_INSTALL ]; then
  echo 'Remove temporary directory…';
  rm -rf $TMP_DXP_DIR;
fi;

echo 'Done.';
exit 0;
