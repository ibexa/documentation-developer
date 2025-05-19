<?php declare(strict_types=1);

namespace App\QueryType;

use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\LogicalAnd;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause\DatePublished;
use Ibexa\Contracts\Taxonomy\Search\Query\Criterion\TaxonomyEntryId;
use Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry;
use Ibexa\Core\QueryType\OptionsResolverBasedQueryType;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BlogPostsQueryType extends OptionsResolverBasedQueryType
{
    protected function configureOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->define('category')->default(null)->allowedTypes(TaxonomyEntry::class, 'null');
    }

    protected function doGetQuery(array $parameters): LocationQuery
    {
        $query = new LocationQuery();
        $query->filter = $this->createFilters($parameters);
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

        return count($filters) > 1 ? new LogicalAnd($filters) : $filters[0];
    }
}
