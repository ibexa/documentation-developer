<?php declare(strict_types=1);

namespace App\Search\SortingDefinition\Provider;

use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Search\SortingDefinition\SortingDefinition;
use Ibexa\Contracts\Search\SortingDefinition\SortingDefinitionProviderInterface;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class VersionNoSortingDefinitionProvider implements SortingDefinitionProviderInterface, TranslationContainerInterface
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
                'version_number_asc',
                $this->translator->trans('sort_definition.version_number_asc.label'),
                [
                    new SortClause\CustomField('content_version_no_i', Query::SORT_ASC),
                ],
                333
            ),
            new SortingDefinition(
                'version_number_desc',
                $this->translator->trans('sort_definition.version_number_desc.label'),
                [
                    new SortClause\CustomField('content_version_no_i', Query::SORT_DESC),
                ],
                369
            ),
        ];
    }

    public static function getTranslationMessages(): array
    {
        return [
            (new Message('sort_definition.version_number_asc.label', 'ibexa_search'))->setDesc('Sort by version number (Less)'),
            (new Message('sort_definition.version_number_desc.label', 'ibexa_search'))->setDesc('Sort by version number (More)'),
        ];
    }
}
