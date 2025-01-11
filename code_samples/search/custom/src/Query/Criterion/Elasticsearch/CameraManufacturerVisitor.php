<?php

declare(strict_types=1);

namespace App\Query\Criterion\Elasticsearch;

use App\Query\Criterion\CameraManufacturerCriterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\CriterionInterface;
use Ibexa\Contracts\Elasticsearch\Query\CriterionVisitor;
use Ibexa\Contracts\Elasticsearch\Query\LanguageFilter;

final class CameraManufacturerVisitor implements CriterionVisitor
{
    public function supports(CriterionInterface $criterion, LanguageFilter $languageFilter): bool
    {
        return $criterion instanceof CameraManufacturerCriterion;
    }

    /**
     * @param \App\Query\Criterion\CameraManufacturerCriterion $criterion
     */
    public function visit(CriterionVisitor $dispatcher, CriterionInterface $criterion, LanguageFilter $languageFilter): array
    {
        return [
            'terms' => [
                'exif_camera_manufacturer_id' => (array)$criterion->value,
            ],
        ];
    }
}
