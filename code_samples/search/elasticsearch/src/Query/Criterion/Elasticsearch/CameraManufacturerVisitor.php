<?php

declare(strict_types=1);

namespace App\Query\Criterion\Elasticsearch;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\CriterionInterface;
use Ibexa\Contracts\Elasticsearch\Query\CriterionVisitor;
use Ibexa\Contracts\Elasticsearch\Query\LanguageFilter;

final class CameraManufacturerVisitor implements CriterionVisitor
{
    public function supports(CriterionInterface $criterion, LanguageFilter $languageFilter): bool
    {
        return $criterion instanceof CameraManufacturerCriterion;
    }

    public function visit(CriterionVisitor $dispatcher, CriterionInterface $criterion, LanguageFilter $languageFilter): array
    {
        /** @var \Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion $criterion */
        return [
            'terms' => [
                'exif_camera_manufacturer_id' => property_exists($criterion, 'value') ? (array)$criterion->value : [],
            ],
        ];
    }
}
