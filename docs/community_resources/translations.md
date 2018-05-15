# Contribute translations

If you'd like to see eZ Platform in your language, you can contribute to the translations.

[`ezplatform-i18n`](https://github.com/ezsystems/ezplatform-i18n) contains the XLIFF files providing translations.
You can use an XLIFF editor of your choice to contribute strings in your language.

## Install new translation package

To make use of the UI translations, you need to install the new translation package in your project.

### Translation packages per language

To allow users to install only what they need, we have split every language into a dedicated package.

All translation packages are published on [ezplatform-i18n organisation on github](https://github.com/ezplatform-i18n)

### Install a new language in your project

If you want to install a new language in your project, you just have to install the corresponding package.

For example, if you want to translate your application into French, you just have to run:

`composer require ezplatform-i18n/ezplatform-i18n-fr_fr`

and then clear the cache.

Now you can reload your eZ Platform administration page which will be translated in French (if your browser is configured to fr\_FR.)

## Full translation workflow

You can read a full description of how new translations are prepared and distributed in [the documentation of GitHub](https://github.com/ezsystems/ezplatform/blob/1.8/doc/i18n/translation_workflow.md).
