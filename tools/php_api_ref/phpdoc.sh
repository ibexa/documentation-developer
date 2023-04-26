#!/usr/bin/env bash

AUTH_JSON=$1;
OUTPUT_DIR=$2;

FLAVOR='commerce';
VERSION='4.5.*';
TMP_DXP_DIR=/tmp/ibexa-dxp-phpdoc;
PHPDOC_CONF="$(pwd)/tools/php_api_ref/phpdoc.dist.xml";
PHPDOC_DIR="$(pwd)/tools/php_api_ref/.phpdoc";
if [ -z "$OUTPUT_DIR" ]; then
  OUTPUT_DIR="$(pwd)/docs/api/php_api/php_api_reference";
else
  if [ ! -d $OUTPUT_DIR ]; then
    echo -n "Creating ${OUTPUT_DIR}… ";
    mkdir -p $OUTPUT_DIR;
    if [ $? -eq 0 ]; then
      echo 'OK';
    else
      exit 1;
    fi;
  fi;
  OUTPUT_DIR=$(readlink -f $OUTPUT_DIR);
fi;

rm -rf $TMP_DXP_DIR;
mkdir -p $TMP_DXP_DIR;
if [ $? -ne 0 ]; then
  exit 2;
fi;
cd $TMP_DXP_DIR;

echo "Creating ibexa/$FLAVOR-skeleton:$VERSION project in ${TMP_DXP_DIR}…";
composer create-project ibexa/$FLAVOR-skeleton:$VERSION . --no-interaction --no-install --ignore-platform-reqs --no-scripts;
if [ -n "$AUTH_JSON" ]; then
  cp $AUTH_JSON ./;
fi;
composer install --no-interaction --ignore-platform-reqs --no-scripts;

if [[ "$VERSION" == *".*"* ]]; then
  VERSION=$(composer -n show ibexa/$FLAVOR | grep -E "^version" | cut -d 'v' -f 3);
  echo "Obtained version: $VERSION";
fi;

echo -n 'Building package→edition map… ';
map=$PHPDOC_DIR/template/package-edition-map.twig;
editions=(oss content experience commerce);
if [[ -f $map ]]; then
  rm $map;
fi;
echo "{% set package_edition_map = {" >> $map;
for edition in ${editions[@]}; do
  echo -n "${edition}… ";
  while IFS= read -r line; do
    package=$(echo $line | cut -d '"' -f 2);
    if [[ ! "${editions[*]}" =~ "${package/ibexa\//}" ]]; then
      echo "'$package': '$edition'," >> $map;
    fi;
  done <<< "$(curl --no-progress-meter "https://raw.githubusercontent.com/ibexa/$edition/v$VERSION/composer.json" | jq .require | grep -E "(ibexa|ezsystems|silversolutions)")";
  if [ "$edition" == "$FLAVOR" ]; then
    break;
  fi;
done;
echo "} %}{% block content %}{% endblock %}" >> $map;
echo 'OK';

echo "Set and run phpDocumentor…";
sed "s/version number=\".*\"/version number=\"$VERSION\"/" $PHPDOC_CONF > ./phpdoc.dist.xml;
cp -R $PHPDOC_DIR ./;
curl -LO "https://github.com/phpDocumentor/phpDocumentor/releases/download/v3.3.1/phpDocumentor.phar";
php phpDocumentor.phar -t php_api_reference;
if [ $? -eq 0 ]; then
  echo -n "Remove unneeded from phpDocumentor output… ";
  rm -rf ./php_api_reference/files ./php_api_reference/indices;
  echo -n "Copy phpDocumentor output to ${OUTPUT_DIR}… ";
  cp -rf ./php_api_reference/* $OUTPUT_DIR;
  echo -n "Remove surplus… ";
  while IFS= read -r line; do
    file="$(echo $line | sed -r 's/Only in (.*): (.*)/\1\/\2/')";
    if [[ $file = $OUTPUT_DIR/* ]]; then
      rm -rf $file;
    fi;
  done <<< "$(diff -qr ./php_api_reference $OUTPUT_DIR | grep 'Only in ' | grep -v ': images')";
  echo 'OK.';
else
  echo 'A phpDocumentor error prevents reference update.';
fi;

rm -rf $TMP_DXP_DIR;
