<?php declare(strict_types=1);

namespace App\Search\SortingDefinition\Provider;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Search\SortingDefinition\SortingDefinition;
use Ibexa\Contracts\Search\SortingDefinition\SortingDefinitionProviderInterface;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class RandomSortingDefinitionProvider implements SortingDefinitionProviderInterface, TranslationContainerInterface
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
                'random',
                $this->translator->trans('sort_definition.random.label'),
                [
                    new SortClause\Random(),
                ],
                400
            ),
        ];
    }

    public static function getTranslationMessages(): array
    {
        return [
            (new Message('sort_definition.random.label', 'ibexa_search'))->setDesc('Shuffle'),
        ];
    }
}
