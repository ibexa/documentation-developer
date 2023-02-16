# Ibexa DXP Developer Documentation

This repository is the source for the [developer documentation for Ibexa](https://doc.ibexa.co/en/latest),
a digital experience platform that is based on the Symfony Full Stack Framework in PHP.

# Resources

1. Ibexa DXP Developer Hub: https://developers.ibexa.co
1. Ibexa DXP Repository: https://github.com/ibexa/oss
1. Open JIRA board: https://issues.ibexa.co
1. Ibexa Website: https://ibexa.co
1. User documentation: https://doc.ibexa.co/projects/userguide

## How to contribute

To contribute to the documentation, you can open a PR in this repository.

If you'd like to see Ibexa DXP in your language, you can [contribute to the translations](https://doc.ibexa.co/en/latest/resources/contributing/contribute_translations/).

### Contribute to API reference

The REST API Reference is located in the `docs/api/rest_api/rest_api_reference/rest_api_reference.html` 
file, which is generated automatically by the RAML2HTML tool.
It is based on `*.raml` files located in the `docs/api/rest_api/rest_api_reference/input` directory that you can edit in your editor/IDE.

After you modify relevant files in the input folder, you can generate an HTML file from repository root (this step can also be performed by one of the Tech Writers during PR review): 

`php tools/raml2html/raml2html.php build --non-standard-http-methods=COPY,MOVE,PUBLISH,SWAP -t default -o docs/api/rest_api/rest_api_reference/output/ docs/api/rest_api/rest_api_reference/input/ez.raml`

In case of errors, look for mistakes in the RAML file, for example, double apostrophes.
Move `rest_api_reference.html`  from the output folder to `docs/api/rest_api/rest_api_reference/` root.

See `tools/raml2html/README.md` for more information.

## Build and preview documentation

To build and preview your changes locally, you need to install Python along with its package manager (`pip`).
Other required tools will be installed by using the following command:

```bash
pip install -r requirements.txt
```

Then you can run:

```bash
mkdocs serve
```

After a short while your documentation should be reachable at http://localhost:8000. If it isn't, check the output
of the command.

## Where to View

https://doc.ibexa.co
