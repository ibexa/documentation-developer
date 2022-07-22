<?php

declare(strict_types=1);

namespace App\Query\Aggregation\Elasticsearch;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\AbstractRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\LocationAggregation;

final class PriorityRangeAggregation extends AbstractRangeAggregation implements LocationAggregation
{
}
