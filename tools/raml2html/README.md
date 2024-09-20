# raml2html

Tool for generating static HTML from RAML definitions.   

## Installation

PHP 8 and [Composer](https://getcomposer.org/) are required.

To install required dependencies, go to raml2html directory and run:

```sh
composer install;
``` 

## Usage

### Generate

To generate static HTML from RAML definitions, use the following code from project root:

```sh
php tools/raml2html/raml2html.php build --non-standard-http-methods=COPY,MOVE,PUBLISH,SWAP -t default -o docs/api/rest_api/rest_api_reference/ docs/api/rest_api/rest_api_reference/input/ibexa.raml
```

### Compare documented routes with DXP configured routes

To test static HTML against an Ibexa DXP to find routes missing from the doc, and routes removed from the DXP:

```sh
php tools/raml2html/raml2html.php test:compare ~/ibexa-dxp
```

Note: The Ibexa DXP doesn't need to run.

```shell
mkdir ~/ibexa-dxp;
cd ~/ibexa-dxp;
composer create-project ibexa/commerce-skeleton . --no-install --ignore-platform-reqs --no-scripts;
composer install --ignore-platform-reqs --no-scripts;
cd -;
php tools/raml2html/raml2html.php test:compare ~/ibexa-dxp;
```
