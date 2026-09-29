# Language events

Events that are triggered when working with languages.

| Event                           | Dispatched by                         | Properties                                                          |
| ------------------------------- | ------------------------------------- | ------------------------------------------------------------------- |
| `BeforeCreateLanguageEvent`     | `LanguageService::createLanguage`     | `LanguageCreateStruct $languageCreateStruct` `?Language $language`  |
| `CreateLanguageEvent`           | `LanguageService::createLanguage`     | `Language $language` `LanguageCreateStruct $languageCreateStruct`   |
| `BeforeUpdateLanguageNameEvent` | `LanguageService::updateLanguageName` | `Language $language` `string $newName` `?Language $updatedLanguage` |
| `UpdateLanguageNameEvent`       | `LanguageService::updateLanguageName` | `Language $updatedLanguage` `Language $language` `string $newName`  |
| `BeforeDeleteLanguageEvent`     | `LanguageService::deleteLanguage`     | `Language $language`                                                |
| `DeleteLanguageEvent`           | `LanguageService::deleteLanguage`     | `Language $language`                                                |

## Enabling languages

| Event                        | Dispatched by                      | Properties                                         |
| ---------------------------- | ---------------------------------- | -------------------------------------------------- |
| `BeforeEnableLanguageEvent`  | `LanguageService::enableLanguage`  | `Language $language` `?Language $enabledLanguage`  |
| `EnableLanguageEvent`        | `LanguageService::enableLanguage`  | `Language $enabledLanguage` `Language $language`   |
| `BeforeDisableLanguageEvent` | `LanguageService::disableLanguage` | `Language $language` `?Language $disabledLanguage` |
| `DisableLanguageEvent`       | `LanguageService::disableLanguage` | `Language $disabledLanguage` `Language $language`  |
