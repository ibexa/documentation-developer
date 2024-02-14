---
description: Add a "sort by" method to the Back Office search result page.
---

# Customize search sorting

To add an entry to the "Sort by" to the Back Office search result page, create a service implementing the `Ibexa\Contracts\Search\SortingDefinition\SortingDefintionProviderInterface` and tagged `ibexa.search.sorting_definition.provider`.

The following example class implements `SortingDefinitionProviderInterface::getSortingDefinitions`, and add two definitions to sort by section name.
A sorting definition is an identifier, a menu label, a list of [Content Search's Sort Clauses](sort_clause_reference.md#sort-clauses), even [custom ones](create_custom_sort_clause.md), and a priority to position it in the menu.
For the menu label, its also implements `TranslationContainerInterface::getTranslationMessages` to provide two default English translations in the `ibexa_search` namespace.
This example is coded in `src/Search/SortingDefinition/Provider/SectionNameSortingDefinitionProvider.php`:
``` php hl_lines="22"
[[= include_file('code_samples/back_office/search/src/Search/SortingDefinition/Provider/SectionNameSortingDefinitionProvider.php') =]]
```

Its service definition is appended to `config/services.yaml`:
``` yaml hl_lines="5"
[[= include_file('code_samples/back_office/search/config/append_to_services.yaml') =]]
```

Translation file can be extracted with a `translation:extract` command, such as `php bin/console translation:extract en --dir=src --output-dir=translations` to obtain an `translations/ibexa_search.en.xlf` file.
Or translation file can be manually produced, like the following `translations/messages.en.yaml`:
``` yaml
[[= include_file('code_samples/back_office/search/translations/messages.en.yaml') =]]
```
