# Customize search sorting

Add a "sort by" method to the back office search result page.

You can customize the **Sort by** menu in the back office search result page, for example, by adding new sort criteria.

To do it, you must create a service that implements the `Ibexa\Contracts\Search\SortingDefinition\SortingDefinitionProviderInterface` and tag it with `ibexa.search.sorting_definition.provider`.

The following example class implements `SortingDefinitionProviderInterface::getSortingDefinitions`, and adds two definitions to sort by section name. A sorting definition contains an identifier, a menu label, a list of content search Sort Clauses, which could be either [default](../../../search/sort_clause_reference/sort_clause_reference/index.md#sort-clauses) or [custom](../../../search/extensibility/create_custom_sort_clause/index.md), and a priority value to position them in the menu. It also implements `TranslationContainerInterface::getTranslationMessages` to provide two default English translations in the `ibexa_search` namespace.

Create the `src/Search/SortingDefinition/Provider/SectionNameSortingDefinitionProvider.php` file:

```php
<?php declare(strict_types=1);

namespace App\Search\SortingDefinition\Provider;

use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Search\SortingDefinition\SortingDefinition;
use Ibexa\Contracts\Search\SortingDefinition\SortingDefinitionProviderInterface;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class SectionNameSortingDefinitionProvider implements SortingDefinitionProviderInterface, TranslationContainerInterface
{
    public function __construct(private TranslatorInterface $translator)
    {
    }

    public function getSortingDefinitions(): array
    {
        return [
            new SortingDefinition(
                'section_asc',
                $this->translator->trans('sort_definition.section_name_asc.label'),
                [
                    new SortClause\SectionName(Query::SORT_ASC),
                ],
                333
            ),
            new SortingDefinition(
                'section_desc',
                $this->translator->trans('sort_definition.section_name_desc.label'),
                [
                    new SortClause\SectionName(Query::SORT_DESC),
                ],
                369
            ),
        ];
    }

    public static function getTranslationMessages(): array
    {
        return [
            (new Message('sort_definition.section_name_asc.label'))->setDesc('Sort by section A-Z'),
            (new Message('sort_definition.section_name_desc.label'))->setDesc('Sort by section Z-A'),
        ];
    }
}
```

Then add a service definition to `config/services.yaml`:

```yaml
services:
    #…
    App\Search\SortingDefinition\Provider\SectionNameSortingDefinitionProvider:
        tags:
            - name: ibexa.search.sorting_definition.provider
```

You can extract a translation file with the `jms:translation:extract` command, for example, `php bin/console jms:translation:extract en --dir=src --output-dir=translations` to obtain the `translations/ibexa_search.en.xlf` file. You could also create it manually, as `translations/messages.en.yaml` file with the following contents:

```yaml
sort_definition.section_name_asc.label: 'Sort by section A-Z'
sort_definition.section_name_desc.label: 'Sort by section Z-A'
```
