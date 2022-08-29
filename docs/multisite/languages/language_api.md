---
description: You can add languages to the system and get information about existing languages via the PHP API.
---

# Language API

You can manage languages configured in the system with PHP API by using [`LanguageService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LanguageService.php).

## Getting language information

To get a list of all languages in the system use [`LanguageService::loadLanguages`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LanguageService.php#L79)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/AddLanguageCommand.php', 37, 42) =]]
```

## Creating a language

To create a new language, you need to create a [`LanguageCreateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/LanguageCreateStruct.php)
and provide it with the language code and language name.
Then, use [`LanguageService::createLanguage`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LanguageService.php#L27) and pass the `LanguageCreateStruct` to it:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/AddLanguageCommand.php', 43, 47) =]]
```
