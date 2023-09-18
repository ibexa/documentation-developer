---
description: All code contributions to Ibexa DXP must follow package and bundle structure and namespace standards.
---

# Create bundle

The following section explains the whole process from creating a bundle from scratch to uploading it on the [packagist.org](https://packagist.org/) website.

A bundle is modular structure that contain related functionality and can be integrated into an application.
[Follow specific strucutre](package_structure.md/#package-and-bundle-structure-and-namespaces).

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

## Use GitHub template

https://github.com/ibexa/bundle-template

Directory structure for AcmeCurrencyExchangeRate
podac url
button use template
<!-- ekran gdzie podac parametry dla repozytorium -->
<!-- [dodac strukture katalogu, screen albo diagram] -->


Once the repository is created, a workflow starts which generates a bundle structure.
- Vendor namespace is generated from the orgnization name: github/github user name.
Package and bundle name inherits from repository name.

<!-- screenshot z rezultatem -->

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


- LICENSE - a license file, GPL v2 by default
- README.md - a readme file with bundle description, its version and install instructions
- `composer.json` - a package definition
- `deptrac.yaml` - a tool for static code analysis for PHP, checks the coherence of package architecture, for more information see [deptrac](https://qossmic.github.io/deptrac/) documentation.
- `package.json` - frontend dependencies, for more information, see [about packages and modules](https://docs.npmjs.com/about-packages-and-modules).
- `phpstan.neon` - phpstan configuration, a tool for static code analysis for PHP, scans, and evaluates codebase to find errors, and bugs, for more information, see the [documentation](https://phpstan.org/user-guide/getting-started).
- `phpunit.xml.dist` - config for phpunit, unit and integration tests - see [documentation](https://phpunit.de/getting-started/phpunit-10.html).
- src and tests follow the base catalog structure, according to [package structure](https://phpunit.de/getting-started/phpunit-10.html) docs.
<!-- - `src/` - delivers a default configuration, how to extract translation from code, generate xlif files,
          contains classes related to the bundle logic -->

To fully use the possibilities of the bundle, get familiar with the structure:

- `resources/`
    - `config/` - contains configuration for the environment/ governs budle configuration
        - `services/` - recommended place for services definition files
        all services definitions must be split into separate files
        - `prepend.yaml` - houses additional configuration for other extensions
    - `views/` - handles the [design engine](../../../templating/design_engine/design_engine.md)
- `tests` - contains all tests for the bundle. For more information, see [continuous integration](#continuous-integration).

### Add the dependencies to the composer.json

1. In composer.json add the Page Builder depency to be able to create a page block.

```json hl_lines="156"
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
2. Run the following command:

```bash
    composer update
```

```json
  "scripts-descriptions": {
    "fix-cs": "Automatically fixes code style in all files",
    "check-cs": "Run code style checker for all files",
    "test": "Run automatic tests",
    "phpstan": "Run static code analysis",
    "deptrac": "Run Deptrac architecture testing"
  },
```

- `composer.json` - defines your project requirements, contains the following sections:

    - `php-cs-fixer` - defines method of verifying/checking code style, by default as internal package `for Ibexa style`
    - `eslintrc` - a tool for static code analysis for JavaScript
 

For more information, see [bundles](../../../administration/project_organization/bundles.md) documentation.


### Create class

!!! note

  Make sure you follow naming convention to ensure clarity.

In the `/src` create a ACMECurrencyExchangeRateBundle class:


```php
<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Acme\Bundle\CurrencyExchangeRate;

use Symfony\Component\HttpKernel\Bundle\Bundle;

final class AcmeCurrencyExchangeRateBundle extends Bundle
{
}
```



### Service configuration

In `services.yaml`, create in `src` directory an extension class in the `DependencyInjection` namespace.
This class is responsible for loading the configuration settings of the bundle and making them available in the app container.
Make sure, the DependecyInjection class name is the same as the bundle name.


### Routing

!!! note

    When creating a bundle for a Symfony it's the best practice to perfect the route's name with a bundle alias.


Bundle alias as a prefix for parameters that are defined in the bundles configuration files.

The following `yaml` configuration specifies a routing collection named `acme_currency_exchange_rate.routes` that uses annotation type routine.

Next, to define routes within your bundle, provide the routing configuration. To do this, implement the `Interface.php`:

```yaml
imports:
    - { resource: services/**.yaml }
services:
    ACME\Bundle\CurrencyExchangeRate\Controller\AcmeCurrencyExchangeRateController:
        tags:
            - {name: controller.service_arguments}
```

### Configuration files

Define specific settings for this bundle. Files should follow the Symfony configuration convention. Define various aspects of the bundle, include services, 
parameters, roads, and security.

In the prepend.yaml, provide the following page block configuration:

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

### Continuous integration

Before releasing the newly created bundle:
run php cs fixer
run unit tests

[GitHub actions](https://docs.github.com/en/actions)

To ensure delivery of working code, use CI/CD pipeline right from the GitHub repository.

Best practices for testing your bundle encompas::

- supported Symfony versions
- supported PHP versions


### Continuous development


## License and readme

Choose license type, modify readme doc.