---
description: You can add languages to the system and get information about existing languages via the PHP API.
---

# Language API

You can manage languages configured in the system with PHP API by using [`LanguageService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LanguageService.html).

## Getting language information

To get a list of all languages in the system use [`LanguageService::loadLanguages`:](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LanguageService.html#method_loadLanguage)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/AddLanguageCommand.php', 42, 47) =]]
```

## Creating a language

To create a new language, you need to create a [`LanguageCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-LanguageCreateStruct.html) and provide it with the language code and language name.
Then, use [`LanguageService::createLanguage`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LanguageService.html#method_createLanguage) and pass the `LanguageCreateStruct` to it:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/AddLanguageCommand.php', 48, 52) =]]
```
