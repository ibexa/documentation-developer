---
description: You can add languages to the system and get information about existing languages via the PHP API.
---

# Language API

You can manage languages configured in the system with PHP API by using `LanguageService`.

## Getting language information

To get a list of all languages in the system use `LanguageService::loadLanguages`:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/AddLanguageCommand.php', 32, 37, remove_indent=True) =]]
```

## Creating a language

To create a new language, you need to create a `LanguageCreateStruct` and provide it with the language code and language name.
Then, use `LanguageService::createLanguage` and pass the `LanguageCreateStruct` to it:

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/AddLanguageCommand.php', 38, 42, remove_indent=True) =]]
```
