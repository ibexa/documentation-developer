---
description: Add a "sort by" method to the back office search result page.
---

# Customize search sorting

You can customize the **Sort by** menu in the back office search result page, for example, by adding new sort criteria.

To do it, you must create a service that implements the `Ibexa\Contracts\Search\SortingDefinition\SortingDefinitionProviderInterface` and tag it with `ibexa.search.sorting_definition.provider`.

The following example class implements `SortingDefinitionProviderInterface::getSortingDefinitions`, and adds two definitions to sort by section name.
A sorting definition contains an identifier, a menu label, a list of content search Sort Clauses, which could be either [default](sort_clause_reference.md#sort-clauses) or [custom](create_custom_sort_clause.md), and a priority value to position them in the menu.
It also implements `TranslationContainerInterface::getTranslationMessages` to provide two default English translations in the `ibexa_search` namespace.

Create the `src/Search/SortingDefinition/Provider/SectionNameSortingDefinitionProvider.php` file:

``` php hl_lines="22"
[[= include_file('code_samples/back_office/search/src/Search/SortingDefinition/Provider/SectionNameSortingDefinitionProvider.php') =]]
```

Then add a service definition to `config/services.yaml`:

``` yaml hl_lines="5"
services:
    #…
[[= include_file('code_samples/back_office/search/config/append_to_services.yaml', 29, 32) =]]
```

You can extract a translation file with the `translation:extract` command, for example, `php bin/console translation:extract en --dir=src --output-dir=translations` to obtain the `translations/ibexa_search.en.xlf` file.
You could also create it manually, as `translations/messages.en.yaml` file with the following contents:

``` yaml
[[= include_file('code_samples/back_office/search/translations/messages.en.yaml') =]]
```
