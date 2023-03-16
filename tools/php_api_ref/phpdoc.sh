#!/usr/bin/env bash

AUTH_JSON=$1;
OUTPUT_DIR=$2;

FLAVOR='commerce';
VERSION='4.4.*';
TMP_DXP_DIR=/tmp/ibexa-dxp-phpdoc;
PHPDOC_CONF="$(pwd)/tools/php_api_ref/phpdoc.dist.xml";
PHPDOC_DIR="$(pwd)/tools/php_api_ref/.phpdoc";
if [ -z "$OUPUT_DIR" ]; then
  OUTPUT_DIR="$(pwd)/docs/api/php_api/php_api_reference";
fi;

rm -rf $TMP_DXP_DIR;
mkdir $TMP_DXP_DIR;
cd $TMP_DXP_DIR;

composer create-project ibexa/$FLAVOR-skeleton:$VERSION . --no-interaction --no-install --ignore-platform-reqs --no-scripts;
if [ -n "$AUTH_JSON" ]; then
  cp $AUTH_JSON ./;
fi;
composer install --no-interaction --ignore-platform-reqs --no-scripts;

cp $PHPDOC_CONF ./;
cp -R $PHPDOC_DIR ./;
curl -LO "https://github.com/phpDocumentor/phpDocumentor/releases/download/v3.3.1/phpDocumentor.phar";
php phpDocumentor.phar -t $OUTPUT_DIR;
rm -rf $OUTPUT_DIR/files $OUTPUT_DIR/indices

rm -rf $TMP_DXP_DIR;
