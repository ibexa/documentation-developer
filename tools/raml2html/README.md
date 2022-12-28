# raml2html

Tool for generating static HTML from RAML definitions.   

## Installation

PHP 7.2 and [Composer](https://getcomposer.org/) are required.

To install required dependencies, go to raml2html directory and run:

```sh
composer install;
``` 

## Usage

To generate static HTML from RAML definitions, use the following code from project root:

```sh
php tools/raml2html/raml2html.php build --non-standard-http-methods=COPY,MOVE,PUBLISH,SWAP -t default -o docs/api/rest_api/rest_api_reference/output/ docs/api/rest_api/rest_api_reference/input/ez.raml
```

Note: If PHP 7.2 is not the default PHP, please, adapt.
