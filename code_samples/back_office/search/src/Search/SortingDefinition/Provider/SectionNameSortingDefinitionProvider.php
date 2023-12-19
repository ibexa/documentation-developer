<?php declare(strict_types=1);

namespace App\Search\SortingDefinition\Provider;

use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Search\SortingDefinition\SortingDefinition;
use Ibexa\Contracts\Search\SortingDefinition\SortingDefinitionProviderInterface;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class SectionNameSortingDefinitionProvider implements SortingDefinitionProviderInterface, TranslationContainerInterface
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
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
