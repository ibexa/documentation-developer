---
description: Events that are triggered when working with languages.
---

# Language events

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateLanguageEvent`|`LanguageService::createLanguage`|`LanguageCreateStruct $languageCreateStruct`</br>`Language|null $language`|
|`CreateLanguageEvent`|`LanguageService::createLanguage`|`Language $language`</br>`LanguageCreateStruct $languageCreateStruct`|
|`BeforeUpdateLanguageNameEvent`|`LanguageService::updateLanguageName`|`Language $language`</br>`string $newName`</br>`Language|null $updatedLanguage`|
|`UpdateLanguageNameEvent`|`LanguageService::updateLanguageName`|`Language $updatedLanguage`</br>`Language $language`</br>`string $newName`|
|`BeforeDeleteLanguageEvent`|`LanguageService::deleteLanguage`|`Language $language`|
|`DeleteLanguageEvent`|`LanguageService::deleteLanguage`|`Language $language`|

## Enabling languages

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeEnableLanguageEvent`|`LanguageService::enableLanguage`|`Language $language`</br>`Language|null $enabledLanguage`|
|`EnableLanguageEvent`|`LanguageService::enableLanguage`|`Language $enabledLanguage`</br>`Language $language`|
|`BeforeDisableLanguageEvent`|`LanguageService::disableLanguage`|`Language $language`</br>`Language|null $disabledLanguage`|
|`DisableLanguageEvent`|`LanguageService::disableLanguage`|`Language $disabledLanguage`</br>`Language $language`|
