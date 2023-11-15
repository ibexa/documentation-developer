---
description: Create a bundle extension for Ibexa DXP.
---

# Create bundle

A bundle is a reusable [[= product_name =]] extension that can be integrated.
To ensure full compatibility, follow the structure specifications described in the 
[package structure](package_structure.md/#package-and-bundle-structure-and-namespaces) section.

The bundle extension described here is called `AcmeCurrencyExchangeRate` and enables a new page block which displays a currency exchange rate on your site.

You can create a bundle skeleton in two simplified ways:

- [using Ibexa bundle generator](#create-bundle-with-bundle-generator)
- [with GitHub template](#use-github-template)

## Create bundle with bundle-generator

[[= product_name_base =]] bundle generator is a Symfony Bundle generator for projects based on [[= product_name =]].
It can work as a standalone application mode.
This section thoroughly explains how to create a bundle using generator as a stand-alone application.
You can use this skeleton as a basis for your extension project.
It's the easiest and recommended way.

1\. Go to [Ibexa bundle generator](https://github.com/ibexa/bundle-generator){:target="\_blank"} and clone the repository.

```bash
git clone git@github.com:ibexa/bundle-generator.git
```
2\. Change to bundle generator directory.

```bash
cd bundle-generator
```

3\. Install dependencies:

```bash
composer install
```

4\. Run bundle generator:

```bash
php bin/ibexa-bundle-generator currency-exchange-rate --skeleton-name=extension
```

5\. Adjust the bundle to your needs providing the following parameters.
    The command runs with an interactive mode. 

- Package vendor name - acme
- Bundle vendor namespace - Acme
- Bundle name - CurrencyExchangeRate
- Skeleton name - acme-ee

![Bundle generator](bundle_generator.png)

This creates a bundle files structure in the  `./target` directory.

You can rename the target directory according to your needs.

Or you can use a command with all available options:


```bash
php bin/ibexa-bundle-generator currency-exchange-rate currency-exchange-rate-dir  --vendor-name=acme --vendor-namespace=ACME --bundle-name=CurrencyExchangeRate  --skeleton-name=extension
```

## Create bundle with GitHub template

1\. Go to the [[= product_name_base =]] [GitHub repository](https://github.com/ibexa/bundle-template).

2\. In the upper-right corner, click the **Use this template** button, and select **Create a new repository**.

3\. Provide repository name. Optionally, you can add description for the bundle.
Next, click **Create repository**.

![GitHub template](bundle_github_template.png)


Once the repository is created, a workflow starts which generates a bundle structure.

Vendor namespace is generated from the orgnization name.
Package and bundle name inherits from repository name.


### Bundle directory structure

Generated bundle consists of the following structure:

```
.
├── LICENSE
├── README.md
├── composer.json
├── deptrac.yaml
├── package.json
├── phpstan.neon
├── phpunit.xml.dist
├── src
│   ├── bundle
│   │   ├── AcmeCurrencyExchangeRateBundle.php
│   │   ├── DependencyInjection
│   │   │   └── AcmeCurrencyExchangeRateExtension.php
│   │   └── Resources
│   │       ├── config
│   │       │   ├── prepend.yaml
│   │       │   ├── services
│   │       │   └── services.yaml
│   │       └── views
│   │           └── themes
│   │               ├── admin
│   │               └── standard
│   ├── contracts
│   └── lib
└── tests
    ├── bundle
    ├── integration
    └── lib
```
Where:

- `LICENSE` - a license file, GPL v2 by default.
- `README.md` - a readme file with bundle description, its version and install instructions.
- `composer.json` - a package definition.
- `deptrac.yaml` - a tool for static code analysis for PHP, checks the coherence of package architecture, for more information see [deptrac](https://qossmic.github.io/deptrac/) documentation.
- `package.json` - frontend dependencies, for more information, see [about packages and modules](https://docs.npmjs.com/about-packages-and-modules).
- `phpstan.neon` - phpstan configuration, a tool for static code analysis for PHP, scans, and evaluates codebase to find errors, and bugs, for more information, see the [documentation](https://phpstan.org/user-guide/getting-started).
- `phpunit.xml.dist` - config for phpunit, unit and integration tests - see [documentation](https://phpunit.de/getting-started/phpunit-10.html).
- `src` and `tests` follow the base catalog structure, according to [package structure](https://phpunit.de/getting-started/phpunit-10.html) docs.

To fully use the possibilities of the bundle, get familiar with the structure:

- `resources/`
    - `config/` - contains configuration for the environment/ governs budle configuration
        - `services/` - recommended place for services definition files
        all services definitions must be split into separate files
        - `prepend.yaml` - houses additional configuration for other extensions
    - `views/` - handles the [design engine](../../../templating/design_engine/design_engine.md)
- `tests` - contains all tests for the bundle. For more information, see [continuous integration](#continuous-integration).

## Build page block

This section presents an example of how to create an extension that add a new page block in Page Builder.

1\. In `composer.json` add the Page Builder depency to be able to create a page block:

```json
 "require": {
    "php": "^7.4 || ^8.0",
    "ibexa/core": "^4.5",
    "ibexa/page-builder": "^4.5",
    "symfony/config": "^5.4",
    "symfony/dependency-injection": "^5.4",
    "symfony/event-dispatcher": "^5.4",
    "symfony/event-dispatcher-contracts": "^2.2",
    "symfony/http-foundation": "^5.4",
    "symfony/http-kernel": "^5.4",
    "symfony/yaml": "^5.4",
    "http-interop/http-factory-guzzle": "^1.2"
  },
```

2\. Page Builder isn't an open-source package, so to be able to use this dependency, add `repositories`:

```json
"repositories": {
    "ibexa": {
      "type": "composer",
      "url": "https://updates.ibexa.co"
    }
  }
```

3\. Next, run the following command to fetch the Page Builder dependency:

```bash
    composer update
```

For more information, see [bundles](../../../administration/project_organization/bundles.md) documentation.


### Create bundle example

!!! note

    Make sure you follow naming convention to ensure clarity.


### Define block

Define specific settings for the page block bundle. Files should follow the Symfony configuration convention. Define various aspects of the bundle, include services, 
parameters, routess, and security.

To define a page block, in the `prepend.yaml` file, add the following page block configuration:

```yaml
ibexa_fieldtype_page:
  blocks:
    currency_exchange:
      name: Currency exchange
      thumbnail: /assets/images/blocks/random_block.svg#random
      views:
        default:
          template: '@ibexadesign/blocks/currency_exchange/default.html.twig'
          name: Currency exchange block
      attributes:
        amount:
          type: integer
          name: Amount
        base_currency:
          type: select
          name: Base currency
          options:
            choices:
              'US Dollar': USD
              'EURO': EUR
              'Polish Zloty': PLN
```
This file contains all configuration provided for 3rd party extension packages.

### Implement view

Create a view template that you indicated in the configuration.
In the `src`, add the `default.html.twig` file with the script provided by [Currency rate](https://currencyrate.today/exchangerates-widget):

```html+twig
<script>var fm = "{{ base_currency }}";
var to = "BTC,AUD,GBP,EUR,CNY,JPY,RUB";
var tz = "timezone";
var sz = "1x349";
var lg = "en";var st = "primary";
var cd = 0;
var am = {{ amount }}</script><script src="//currencyrate.today/exchangerates"></script>
<div style="text-align:right"><a href="https://currencyrate.today">CurrencyRate</a></div>
```

Next, commit all changes to the GitHub.

### Continuous integration

To ensure quality requirements of your code in the newly created bundle, run:

- `composer php cs fixer`
- `composer tests`

Before releasing the newly created bundle: to ensure your source follows quality reqwuiremet run:
run  composer php cs fixer
run composer test unit tests

[GitHub actions](https://docs.github.com/en/actions)

To ensure delivery of working code, use CI/CD pipeline right from the GitHub repository.

Best practices for testing your bundle encompas:

- supported Symfony versions
- supported PHP versions
- unit tests

## License and readme

Before you publish the bundle, choose the license type and modify the readme file respectively.
