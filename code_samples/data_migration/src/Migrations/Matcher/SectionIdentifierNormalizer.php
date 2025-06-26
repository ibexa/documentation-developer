<?php declare(strict_types=1);

namespace App\Migrations\Matcher;

use Ibexa\Bundle\Migration\Serializer\Normalizer\Criterion\AbstractCriterionNormalizer;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Filter\FilteringCriterion;
use Webmozart\Assert\Assert;

class SectionIdentifierNormalizer extends AbstractCriterionNormalizer
{
    public function __construct()
    {
        parent::__construct('section_identifier');
    }

    /**
     * @param array<mixed> $data
     * @param array<mixed> $context
     */
    protected function createCriterion(array $data, string $type, ?string $format, array $context): FilteringCriterion
    {
        Assert::keyExists($data, 'value');

        return new Criterion\SectionIdentifier($data['value']);
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Criterion\SectionIdentifier;
    }
}
