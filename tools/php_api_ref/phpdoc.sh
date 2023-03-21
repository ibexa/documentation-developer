#!/usr/bin/env bash

AUTH_JSON=$1;
OUTPUT_DIR=$2;

FLAVOR='commerce';
VERSION='4.4.*';
TMP_DXP_DIR=/tmp/ibexa-dxp-phpdoc;
PHPDOC_CONF="$(pwd)/tools/php_api_ref/phpdoc.dist.xml";
PHPDOC_DIR="$(pwd)/tools/php_api_ref/.phpdoc";
if [ -z "$OUTPUT_DIR" ]; then
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

if [[ "$VERSION" == *".*" ]]; then
  VERSION=$(composer -n show ibexa/core | grep -E "^version" | cut -d 'v' -f 3);
  echo "Obtained version: $VERSION";
fi;

map=$PHPDOC_DIR/template/edition-package-map.twig;
if [[ -f $map ]]; then
  rm $map;
fi;
echo "{% set package_edition_map = {" >> $map;
for edition in oss content experience commerce; do
  while IFS= read -r line; do
    package=$(echo $line | cut -d '"' -f 2);
    echo "'$package': '$edition'," >> $map;
  done <<< "$(curl "https://raw.githubusercontent.com/ibexa/$edition/v$VERSION/composer.json" | jq .require | grep ibexa)";
  if [ "$edition" == "$flavor" ]; then
    break;
  fi;
done;
echo "} %}{% block content %}{% endblock %}" >> $map;

cp $PHPDOC_CONF ./;
cp -R $PHPDOC_DIR ./;
curl -LO "https://github.com/phpDocumentor/phpDocumentor/releases/download/v3.3.1/phpDocumentor.phar";
php phpDocumentor.phar -t php_api_reference;
rm -rf ./php_api_reference/files ./php_api_reference/indices;
cp -rf ./php_api_reference/* $OUTPUT_DIR;
while IFS= read -r line; do
  file="$(echo $line | sed -r 's/Only in (.*): (.*)/\1\/\2/')";
  if [[ $file = $OUTPUT_DIR/* ]]; then
    rm -rf $file;
  fi;
done <<< "$(diff -qr ./php_api_reference $OUTPUT_DIR | grep 'Only in ')";

rm -rf $TMP_DXP_DIR;
