<?php

declare(strict_types=1);

namespace App\QueryType;

use DateInterval;
use DateTimeImmutable;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Field\DateTimeRangeAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Field\FloatStatsAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Field;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\LogicalAnd;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause\DatePublished;
use Ibexa\Contracts\Taxonomy\Search\Query\Aggregation\TaxonomyEntryIdAggregation;
use Ibexa\Contracts\Taxonomy\Search\Query\Criterion\TaxonomyEntryId;
use Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry;
use Ibexa\Core\QueryType\OptionsResolverBasedQueryType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BlogPostsQueryType extends OptionsResolverBasedQueryType
{
    protected function configureOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->define('category')->default(null)->allowedTypes(TaxonomyEntry::class, 'null');
        $optionsResolver->define('start')->default(null)->allowedTypes('int', 'null');
        $optionsResolver->define('end')->default(null)->allowedTypes('int', 'null');
        $optionsResolver->define('min_rate')->default(null)->allowedTypes('float', 'null');
    }

    protected function doGetQuery(array $parameters): LocationQuery
    {
        $query = new LocationQuery();
        $query->filter = $this->createFilters($parameters);
        $query->aggregations[] = $this->createTagsAggregation();
        $query->aggregations[] = $this->createPublicationDateAggregation();
        $query->aggregations[] = $this->createRateAggregation();
        $query->sortClauses[] = new DatePublished(Query::SORT_DESC);

        return $query;
    }

    public static function getName(): string
    {
        return 'BlogPosts';
    }

    private function createFilters(array $parameters): Criterion
    {
        $filters = [];
        $filters[] = new ContentTypeIdentifier('blog_post');

        if ($parameters['category'] !== null) {
            $filters[] = new TaxonomyEntryId($parameters['category']->id);
        }

        if ($parameters['start'] !== null) {
            $filters[] = new Field(
                'publication_date',
                Operator::GTE,
                $parameters['start']
            );
        }

        if ($parameters['end'] !== null) {
            $filters[] = new Field(
                'publication_date',
                Operator::LTE,
                $parameters['end']
            );
        }

        if ($parameters['min_rate'] !== null) {
            $filters[] = new Field(
                'rate',
                Operator::GTE,
                $parameters['min_rate']
            );
        }

        return count($filters) > 1 ? new LogicalAnd($filters) : $filters[0];
    }

    private function createTagsAggregation(): TaxonomyEntryIdAggregation
    {
        $aggregation = new TaxonomyEntryIdAggregation('content_by_tag', 'tags');
        $aggregation->setLimit(100);

        return $aggregation;
    }

    private function createPublicationDateAggregation(): DateTimeRangeAggregation
    {
        $ranges = [];

        $current = new DateTimeImmutable("last day of this month");
        for ($i = 0; $i < 12; $i++) {
            $previous = $current->sub(new DateInterval("P1M"));
            $ranges[] = Range::ofDateTime($previous, $current);
            $current = $previous;
        }
        $ranges[] = Range::ofDateTime(null, $current);

        return new DateTimeRangeAggregation(
            'content_by_publication_date',
            'blog_post',
            'publication_date',
            $ranges
        );
    }

    private function createRateAggregation(): FloatStatsAggregation
    {
        return new FloatStatsAggregation('rate', 'blog_post', 'rate');
    }
}
