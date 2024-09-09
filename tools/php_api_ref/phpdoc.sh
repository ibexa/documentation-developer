#!/usr/bin/env bash

set +x;

AUTH_JSON=${1:-~/.composer/auth.json}; # Path to an auth.json file allowing to install the targeted edition and version
OUTPUT_DIR=${2:-./docs/api/php_api/php_api_reference}; # Path to the directory where the built PHP API Reference is hosted

DXP_EDITION='commerce'; # Edition from and for which the Reference is built
DXP_VERSION='4.6.*'; # Version from and for which the Reference is built
DXP_ADD_ONS=(automated-translation); # Packages not included in $DXP_EDITION but added to the Reference, listed without their vendor "ibexa"
DXP_EDITIONS=(oss headless experience commerce); # Available editions ordered by ascending capabilities
PHPDOC_VERSION='3.5.0'; # Version of phpDocumentor used to build the Reference
PHPDOC_CONF="$(pwd)/tools/php_api_ref/phpdoc.dist.xml"; # Absolute path to phpDocumentor configuration file
#PHPDOC_CONF="$(pwd)/tools/php_api_ref/phpdoc.dev.xml"; # Absolute path to phpDocumentor configuration file
PHPDOC_TEMPLATE_VERSION='3.5.0'; # Version of the phpDocumentor base template set
PHPDOC_DIR="$(pwd)/tools/php_api_ref/.phpdoc"; # Absolute path to phpDocumentor resource directory (containing the override template set)

PHP_BINARY="php -d error_reporting=`php -r 'echo E_ALL & ~E_DEPRECATED;'`"; # Avoid depreciation messages from phpDocumentor/Reflection/issues/529 when using PHP 8.2 or higher
TMP_DXP_DIR=/tmp/ibexa-dxp-phpdoc; # Absolute path of the temporary directory in which Ibexa DXP will be installed and the PHP API Reference built
FORCE_DXP_INSTALL=1; # If 1, empty the temporary directory, install DXP from scratch, build, remove temporary directory; if 0, potentially reuse the DXP already installed in temporary directory, keep temporary directory for future uses.

if [ ! -d $OUTPUT_DIR ]; then
  echo -n "Creating ${OUTPUT_DIR}… ";
  mkdir -p $OUTPUT_DIR;
  if [ $? -eq 0 ]; then
    echo 'OK';
  else
    exit 1;
  fi;
fi;
OUTPUT_DIR=$(realpath $OUTPUT_DIR); # Transform to absolute path before changing the working directory

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
  composer create-project ibexa/$DXP_EDITION-skeleton:$DXP_VERSION . --no-interaction --no-install --ignore-platform-reqs --no-scripts;
  if [ -n "$AUTH_JSON" ]; then
    cp $AUTH_JSON ./;
  fi;
  composer install --no-interaction --ignore-platform-reqs --no-scripts;
fi;

if [[ "$DXP_VERSION" == *".*"* ]]; then
  DXP_VERSION=$(composer -n show ibexa/$DXP_EDITION | grep -E "^version" | cut -d 'v' -f 3);
  echo "Obtained version: $DXP_VERSION";
fi;

if [ 0 -eq $DXP_ALREADY_EXISTS ]; then
  for additional_package in ${DXP_ADD_ONS[@]}; do
    composer require --no-interaction --ignore-platform-reqs --no-scripts ibexa/$additional_package:$DXP_VERSION
  done;
fi;

#if [ 0 -eq $DXP_ALREADY_EXISTS ]; then
#  MY_PACKAGE='';
#  MY_BRANCH='';
#  composer require --no-interaction --ignore-platform-reqs --no-scripts ibexa/$MY_PACKAGE "$MY_BRANCH as $DXP_VERSION";
#fi;

if [ 0 -eq $DXP_ALREADY_EXISTS ]; then
  echo -n 'Building package→edition map… ';
  map=$PHPDOC_DIR/template/package-edition-map.twig;
  if [[ -f $map ]]; then
    rm $map;
  fi;
  echo '{% set package_edition_map = {' >> $map;
  for edition in ${DXP_EDITIONS[@]}; do
    echo -n "${edition}… ";
    while IFS= read -r line; do
      package=$(echo $line | cut -d '"' -f 2);
      if [[ ! "${DXP_EDITIONS[*]}" =~ "${package/ibexa\//}" ]]; then
        echo "'$package': '$edition'," >> $map;
      fi;
    done <<< "$(curl --no-progress-meter "https://raw.githubusercontent.com/ibexa/$edition/v$DXP_VERSION/composer.json" | jq .require | grep -E "(ibexa|ezsystems|silversolutions)")";
    if [ "$edition" == "$DXP_EDITION" ]; then
      break;
    fi;
  done;
  echo '} %}{% block content %}{% endblock %}' >> $map;
  echo 'OK';
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
  echo -n "Copy phpDocumentor output to ${OUTPUT_DIR}… ";
  cp -rf ./php_api_reference/* $OUTPUT_DIR;
  echo -n 'Remove surplus… ';
  while IFS= read -r line; do
    file="$(echo $line | sed -r 's/Only in (.*): (.*)/\1\/\2/')";
    if [[ $file = $OUTPUT_DIR/* ]]; then
      rm -rf $file;
    fi;
  done <<< "$(diff -qr ./php_api_reference $OUTPUT_DIR | grep 'Only in ')";
  echo 'OK.';
else
  echo 'A phpDocumentor error prevents reference update.';
  exit 3;
fi;

if [ 1 -eq $FORCE_DXP_INSTALL ]; then
  echo 'Remove temporary directory…';
  rm -rf $TMP_DXP_DIR;
fi;

echo 'Done.';
exit 0;
