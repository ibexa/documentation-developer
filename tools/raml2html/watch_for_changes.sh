#!/bin/sh

REST_API_REFERENCE_DIR=$1

echo "Watching for changes in $REST_API_REFERENCE_DIR/input"
inotifywait -m -e close_write "$REST_API_REFERENCE_DIR/input" |
  while read -r filename event; do
    php raml2html.php build --non-standard-http-methods=COPY,MOVE,PUBLISH,SWAP -t default -o "$REST_API_REFERENCE_DIR" "$REST_API_REFERENCE_DIR/input/ez.raml"
  done
