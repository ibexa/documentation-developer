<?php

declare(strict_types=1);

namespace App\Query\Criterion\Elasticsearch;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Elasticsearch\Query\CriterionVisitor;
use Ibexa\Contracts\Elasticsearch\Query\LanguageFilter;

final class CameraManufacturerVisitor implements CriterionVisitor
{
    public function supports(Criterion $criterion, LanguageFilter $languageFilter): bool
    {
        return $criterion instanceof CameraManufacturerCriterion;
    }

    public function visit(CriterionVisitor $dispatcher, Criterion $criterion, LanguageFilter $languageFilter): array
    {
        return [
            'terms' => [
                'exif_camera_manufacturer_id' => (array)$criterion->value,
            ],
        ];
    }
}
