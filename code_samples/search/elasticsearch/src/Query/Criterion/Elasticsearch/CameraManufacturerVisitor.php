<?php

declare(strict_types=1);

namespace App\Query\Criterion\Elasticsearch;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\CriterionVisitor;
use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\LanguageFilter;

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
