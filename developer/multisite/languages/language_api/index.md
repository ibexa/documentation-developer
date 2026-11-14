# Language API

You can add languages to the system and get information about existing languages via the PHP API.

You can manage languages configured in the system with PHP API by using [`Ibexa\Contracts\Core\Repository\LanguageService`](../../../../../../ibexa/core/src/contracts/Repository/LanguageService.php).

## Getting language information

To get a list of all languages in the system use [`LanguageService::loadLanguages`:](../../../../../../ibexa/core/src/contracts/Repository/LanguageService.php)

```php
$languageList = $this->languageService->loadLanguages();

foreach ($languageList as $language) {
    $output->writeln($language->languageCode . ': ' . $language->name);
}
```

## Creating a language

To create a new language, you need to create a [`Ibexa\Contracts\Core\Repository\Values\Content\LanguageCreateStruct`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/LanguageCreateStruct.php) and provide it with the language code and language name. Then, use [`LanguageService::createLanguage`](../../../../../../ibexa/core/src/contracts/Repository/LanguageService.php) and pass the `LanguageCreateStruct` to it:

```php
$languageCreateStruct = $this->languageService->newLanguageCreateStruct();
$languageCreateStruct->languageCode = 'pol-PL';
$languageCreateStruct->name = 'Polish';
$this->languageService->createLanguage($languageCreateStruct);
$output->writeln('Added language Polish with language code pol-PL.');
```
