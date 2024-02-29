---
description: Add a "sort by" method to the Back Office search result page.
---

# Customize search sorting

To add an entry to the "Sort by" to the Back Office search result page, create a service to implement the `Ibexa\Contracts\Search\SortingDefinition\SortingDefintionProviderInterface` and tag `ibexa.search.sorting_definition.provider`.

The following example class implements `SortingDefinitionProviderInterface::getSortingDefinitions`, and adds two definitions to sort by section name.
A sorting definition contains an identifier, a menu label, a list of [Content Search's Sort Clauses](sort_clause_reference.md#sort-clauses), including [custom ones](create_custom_sort_clause.md), and a priority to position it in the menu.
It also implements `TranslationContainerInterface::getTranslationMessages` to provide two default English translations in the `ibexa_search` namespace.
The example below is coded in `src/Search/SortingDefinition/Provider/SectionNameSortingDefinitionProvider.php`:
``` php hl_lines="22"
[[= include_file('code_samples/back_office/search/src/Search/SortingDefinition/Provider/SectionNameSortingDefinitionProvider.php') =]]
```

The service definition is added to `config/services.yaml`:
``` yaml hl_lines="5"
[[= include_file('code_samples/back_office/search/config/append_to_services.yaml') =]]
```

Translation file can be extracted with a `translation:extract` command, such as `php bin/console translation:extract en --dir=src --output-dir=translations` to obtain an `translations/ibexa_search.en.xlf` file.
It can be also created manually, as `translations/messages.en.yaml` file below :
``` yaml
[[= include_file('code_samples/back_office/search/translations/messages.en.yaml') =]]
```
