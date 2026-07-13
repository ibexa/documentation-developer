---
description: Use [[=product_name_base=]]  Rector, an optional package based on Rector, to remove PHP and JavaScript code deprecations.
month_change: true
---

# [[= product_name_base =]] Rector

[[= product_name_base =]] Rector is an optional package based on [Rector](https://getrector.com/) that comes with additional rule sets for working with [[= product_name =]] code.
Use it to get rid of PHP and JavaScript code deprecations and prepare your project for the next major release.

## Installation

Add the Composer dependency:

``` bash
composer require --dev ibexa/rector
```

## Refactor PHP code

### Configuration

Adjust the generated `rector.php` file by:

- making it match your project's directory structure
- selecting the [[= product_name_base =]] rule set that matches your current version, for example [`IbexaSetList::IBEXA_50`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Rector-Sets-IbexaSetList.html#enumcase_IBEXA_50)
- adding project-specific rules:
    - [PHP rules by using `withPhpSets`](https://getrector.com/documentation/set-lists#content-php-sets)
    - [Symfony, Twig, or Doctrine rules by using `withComposerBased`](https://getrector.com/documentation/composer-based-sets)

It's recommended to activate one rule set at a time and preview the output before applying it.

An example configuration looks as follows:

``` php
use Ibexa\Contracts\Rector\Sets\IbexaSetList;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths(
       [
           __DIR__ . '/src',
       ]
    )
    ->withSets(
       [
           IbexaSetList::IBEXA_50->value,
       ]
    )
    ->withPhpSets(php83: true)
    ->withComposerBased(symfony: true)
;
```

For more information, see [Rector documentation](https://getrector.com/documentation).

### Usage

Run Rector in dry-run mode to preview the changes it would make:

``` bash
vendor/bin/rector --dry-run
```

Once you're satisfied with the proposed changes, apply them by running:

``` bash
vendor/bin/rector
```

## Refactor JavaScript code

[[= product_name_base =]] Rector also comes with transform module to help you maintain your JavaScript code.

### Configuration

To adjust the default configuration, plugins, or rules, modify the `rector.config.js` file present in your project or bundle directory:

``` js
module.exports = {
    config: {
        paths: [{
            input: 'src/bundle/Resources/public',
            output: 'src/bundle/Resources/public',
        }],
        prettierConfigPath: './prettier.js',
    }
    plugins: (plugins) => {
        // modify enabled plugins

        return plugins;
    },
    pluginsConfig: (config) => {
        // modify plugins config

        return config;
    }
};
```

### Configuration options

#### `paths`

Array of objects with input and output directories for transformed files, relative to your project or bundle root.
Directory structure is not modified during the transformation.

#### `prettierConfigPath`

[Prettier](https://prettier.io/) is run at the end of the transformation.
You can provide the path to your own configuration file, otherwise [the default file](https://github.com/ibexa/eslint-config-ibexa/blob/main/prettier.mjs) is used.

#### `plugins`

Use it to modify enabled plugins.
To learn more about plugins, see [the list of plugins](#list-of-plugins).

#### `pluginsConfig`

Use this setting to modify the plugins configuration, as in the example below:

``` json
{
    "ibexa-rename-string-values": {
        "ez-form-error": "ibexa-form-error",
        "ez-selection-settings": {
            "to": "ibexa-selection-settings",
            "exactMatch": true
        },
        "(^|\\s)\\.ez-": {
            "to": ".ibexa-",
            "regexp": true
        },
        "ibexa-field-edit--ez([A-Za-z0-9]+)": {
            "to": "ibexa-field-edit--ibexa$1",
            "regexp": true
        }
    }
}
```

The plugin configuration is an object with plugin names as keys, for example `ibexa-rename-string-values`.
Inside a single plugin configuration, the property names are values that should be replaced.
They can be specified explicitly (`ezform-error`) or by using regexp (`(^|\\s)\\.ez-`).

#### Shorthand expression

You can use a shorthand form to specify the configuration:

- `"ez-form-error": "ibexa-form-error"` - changes all `ez-form-error` occurrences to `ibexa-form-error`

#### Complete plugin configuration

When not using the shorthand configuration, the following options are available:

- `"to": "ibexa-selection-settings"` - specifies the new value
- `"regexp": true/false` - use regexp to find the matching values. Use capture groups to reuse parts of the original value in the new value
- `"exactMatch": true` - replace matching values only when the whole value is matched. Using the example configuration, `ez-selection-settings__field` would not be replaced as it doesn't match `ez-selection-settings` exactly

#### Shared configuration

You can create a shared configuration for all plugins by using the `shared` keyword, as in the example below:

``` json
{
    "shared": {
        "ez": {
            "to": "ibexa",
            "exactMatch": true,
        }
    }
}
```

Values specifies in the `shared` configuration can be overwritten by using configuration for specific plugins.

### List of plugins

#### Rename eZ global variables

Identifier: `ibexa-rename-ez-global`

This plugin changes all `eZ` variables to `ibexa`.

Configuration: none

#### Rename variables

This plugin allows to rename any variable.

Identifier: `ibexa-rename-variables`

##### Configuration example

``` json
{
    "^Ez(.*?)Validator$": {
        "to": "Ibexa$1Validator",
        "regexp": true
    },
    "^EZ_": {
        "to": "IBEXA_",
        "regexp": true
    }
}
```

##### Example output

| Before | After |
|---|---|
| `class EzBooleanValidator extends eZ.BaseFieldValidator` | `class IbexaBooleanValidator extends ibexa.BaseFieldValidator` |
| `const EZ_INPUT_SELECTOR = 'ezselection-settings__input';` | `const IBEXA_INPUT_SELECTOR = 'ezselection-settings__input';` |

#### Rename string values

This plugin changes any string value except translations. You can use it to transform selectors and other values.

Identifier: `ibexa-rename-string-values`

##### Configuration example

``` json
{
    "(^|\\s)\\.ez-": {
        "to": ".ibexa-",
        "regexp": true
    },
    "ibexa-field-edit--ez([A-Za-z0-9]+)": {
        "to": "ibexa-field-edit--ibexa$1",
        "regexp": true
    },
    "ezselection-settings": "ibexaselection-settings"
}
```

##### Example output

| Before | After |
|---|---|
| `const SELECTOR_FIELD = '.ez-field-edit--ezboolean';` | `const SELECTOR_FIELD = '.ibexa-field-edit--ezboolean'` |
| `const SELECTOR_FIELD = '.ibexa-field-edit--ezboolean';` | `const SELECTOR_FIELD = '.ibexa-field-edit--ibexaboolean';` |

#### Rename translation IDs

This plugin allows to change translation ids.
Extract translations after running this transformation.

Identifier: `ibexa-rename-trans-id`

##### Configuration example

``` json
{
    "^ez": {
        "to": "ibexa",
        "regexp": true
    }
}
```

##### Example output

| Before | After |
|---|---|
|`'ez_boolean.limitation.pick.ez_error'` | `'ibexa_boolean.limitation.pick.ez_error'` |

#### Rename translation strings

This plugin changes values in translations.
Extract translations after running this transformation.

Identifier: `ibexa-rename-in-translations`

##### Configuration example

``` json
{
    "to": "ibexa-not-$1--show-modal",
    "regexp": true,
    "selectors-only": true
}
```

If the `selectors-only` property is set to `true`, this plugin changes only strings inside HTML tags.
Set to `false` or remove property to change text values as well.

##### Example output

| `selectors-only` value | Before | After |
|---|---|---|
| true | `/*@Desc("<p class='ez-not-error--show-modal'>Show message</p> for ez-not-error--show-modal")*/`  | `/*@Desc("<p class='ibexa-not-error--show-modal'>Show message</p> for ez-not-error--show-modal")*/` |
| false | `/*@Desc("<p class='ez-not-error--show-modal'>Show message</p> for ez-not-error--show-modal")*/` |  `/*@Desc("<p class='ibexa-not-error--show-modal'>Show message</p> for ibexa-not-error--show-modal")*/` |

#### Rename icons names used in getIconPath method

This plugin allows you to rename any icon name that is passed as an argument to the `getIconPath` method.

Identifier: `ibexa-rename-icons`

##### Configuration example

In this plugin, the `exactMatch` default value is set `true` when using the shorthand expression.

``` json
{
    "browse": "folder-browse",
    "content-": {
        "to": "file-",
        "exactMatch": false
    }
}
```

##### Example output

| Before | After |
|---|---|
| `getIconPath('browse')` | `getIconPath('folder-browse')` |

### Usage

To install the dependencies, execute the following command:

``` bash
yarn --cwd ./vendor/ibexa/rector/js install
```

Then, run the transform:

``` bash
yarn --cwd ./vendor/ibexa/rector/js transform
```

The `--cwd` argument must point to the directory where the transform module is installed, by default `./vendor/ibexa/rector/js`.
