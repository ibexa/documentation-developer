<?php

declare(strict_types=1);

namespace App\Query\Criterion\Solr;

use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use EzSystems\EzPlatformSolrSearchEngine\Query\CriterionVisitor;

final class CameraManufacturerVisitor extends CriterionVisitor
{
    public function canVisit(Criterion $criterion)
    {
        return $criterion instanceof CameraManufacturer;
    }

    public function visit(Criterion $criterion, CriterionVisitor $subVisitor = null)
    {
        $expressions = array_map(
            static function ($value): string {
                return 'exif_camera_manufacturer_id:"' . $this->escapeQuote($value) . '"';
            },
            $criterion->value
        );

        return '(' . implode(' OR ', $expressions) . ')';
    }
}
