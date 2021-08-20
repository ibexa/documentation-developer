# raml2html

Tool for generating static HTML from RAML definitions.   

## Installation

Install required dependencies before use. Go to raml2html root directory and run:

```
composer install
``` 

To generate static HTML from RAML definitions, use the following code:


```sh
php tools/raml2html/raml2html.php build --non-standard-http-methods=COPY,MOVE,PUBLISH,SWAP -t default -o docs/api/rest_api_reference/output/ docs/api/rest_api_reference/input/ez.raml
```
