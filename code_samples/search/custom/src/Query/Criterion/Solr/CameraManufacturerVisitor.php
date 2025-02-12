<?php

declare(strict_types=1);

namespace App\Query\Criterion\Solr;

use App\Query\Criterion\CameraManufacturerCriterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Solr\Query\CriterionVisitor;

final class CameraManufacturerVisitor extends CriterionVisitor
{
    public function canVisit(Criterion $criterion)
    {
        return $criterion instanceof CameraManufacturerCriterion;
    }

    /**
     * @param \App\Query\Criterion\CameraManufacturerCriterion $criterion
     */
    public function visit(Criterion $criterion, CriterionVisitor $subVisitor = null)
    {
        $expressions = array_map(
            function ($value): string {
                return 'exif_camera_manufacturer_id:"' . $this->escapeQuote((string) $value) . '"';
            },
            $criterion->value
        );

        return '(' . implode(' OR ', $expressions) . ')';
    }
}
