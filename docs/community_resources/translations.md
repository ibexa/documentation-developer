# Contribute translations

If you'd like to see [[= product_name =]] in your language, you can contribute to the translations.

[`ibexa-i18n`](https://github.com/ibexa/i18n) contains the XLIFF files providing translations under a `/translations` directory.
You can use an XLIFF editor of your choice to contribute strings in your language.

## How to translate the interface using Crowdin

If you wish to contribute to an existing translation of Back Office or start a new one you can
use the Crowdin website.

Visit [[[= product_name =]]'s Crowdin page](https://crowdin.com/project/ibexa-dxp), choose a language, and you will see a list of files containing strings. Here you can suggest your translations.

If the language you want to translate to is not available, you can ask for it to be added in the [Crowdin discussion forum for [[= product_name =]]](https://crowdin.com/project/ibexa-dxp/discussions).

## Translation process

There is a Github integration configured. When you provide a new translation message in the Crowdin UI then it will be automatically transferred to the `l10n_main` branch of `ibexa/i18` package. 

Synchronization will be done every 6 hours. As the last step of synchronization new PR will be automatically created with new translations or, if PR is already open, it will be updated with a new commit. 

Next PR will be merged to the main branch.

## Full translation workflow

You can read a full description of how new translations are prepared and distributed in [the documentation of GitHub](https://github.com/ibexa/i18n/blob/main/README.md).
