# Elasticsearch extensibility

!!! enterprise

    ## Indexing custom data

    [Elasticsearch](elastic.md) indexes content and Location data out of the box.
    Besides what is indexed automatically, you can add additional data to the Elasticsearch index.

    To do so, subscribe to one of the following events:

    - `Ibexa\Platform\Contracts\ElasticSearchEngine\Mapping\Event\ContentIndexCreateEvent`
    - `Ibexa\Platform\Contracts\ElasticSearchEngine\Mapping\Event\LocationIndexCreateEvent`

    These events are called when the index is created for the content and Location documents, respectively.

    You can pass the event to a subscriber which gives you access to the document that you can modify.

    In the following example, when an index in created for a content or a Location document,
    the event subscriber adds a `custom_field` of the type `StringField` to the index:

    ``` php hl_lines="19 20 21"
    <?php

    declare(strict_types=1);

    namespace App\EventSubscriber;

    use eZ\Publish\SPI\Search\Field;
    use eZ\Publish\SPI\Search\FieldType\StringField;
    use Ibexa\Platform\Contracts\ElasticSearchEngine\Mapping\Event\ContentIndexCreateEvent;
    use Ibexa\Platform\Contracts\ElasticSearchEngine\Mapping\Event\LocationIndexCreateEvent;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;

    final class CustomIndexDataSubscriber implements EventSubscriberInterface
    {
        public function onContentDocumentCreate(ContentIndexCreateEvent $event): void
        {
            $document = $event->getDocument();
            $document->fields[] = new Field(
                'custom_field',
                'Custom field value',
                new StringField()
            );
        }

        public function onLocationDocumentCreate(LocationIndexCreateEvent $event): void
        {
            $document = $event->getDocument();
            $document->fields[] = new Field(
                'custom_field',
                'Custom field value',
                new StringField()
            );
        }

        public static function getSubscribedEvents(): array
        {
            return [
                ContentIndexCreateEvent::class => 'onContentDocumentCreate',
                LocationIndexCreateEvent::class => 'onLocationDocumentCreate'
            ];
        }
    }
    ```

    Remember to register the subscriber as a service:

    ``` yaml
    services:
        App\EventSubscriber\CustomIndexDataSubscriber:
            tags:
                - { name: kernel.event_subscriber }
    ```

    ## Manipulating the query

    You can customize the search query before it is executed.
    To do it, subscribe to `Ibexa\Platform\Contracts\ElasticSearchEngine\Query\Event\QueryFilterEvent`.

    The following example shows how to add an additional Search Criterion to all queries.

    Depending on your configuration, this might impact all search queries,
    including those used for search and content tree in the Back Office.

    ``` php hl_lines="35"
    <?php

    declare(strict_types=1);

    namespace App\EventSubscriber;

    use eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalAnd;
    use eZ\Publish\API\Repository\Values\Content\Query\Criterion\ObjectStateIdentifier;
    use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\Event\QueryFilterEvent;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;

    final class CustomQueryFilterSubscriber implements EventSubscriberInterface
    {
        public function onQueryFilter(QueryFilterEvent $event): void
        {
            $query = $event->getQuery();

            $additionalCriteria = new ObjectStateIdentifier('locked');

            if ($query->filter !== null) {
                $query->filter = $additionalCriteria;
            } else {
                // Append Criterion to existing filter
                $query->filter = new LogicalAnd([
                    $query->filter,
                    $additionalCriteria
                ]);
            }
        }

        public static function getSubscribedEvents(): array
        {
            return [
                QueryFilterEvent::class => 'onQueryFilter'
            ];
        }
    }
    ```

    Remember to register the subscriber as a service:

    ``` yaml
    services:
        App\EventSubscriber\CustomQueryFilterSubscriber:
            tags:
                - { name: kernel.event_subscriber }
    ```

    ## Custom Search Criterion

    To provide support for a custom Search Criterion, you need to implement `Ibexa\Platform\Contracts\ElasticSearchEngine\Query\CriterionVisitor`:

    ``` php
    <?php

    declare(strict_types=1);

    namespace App\Query\Criterion;

    use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
    use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\CriterionVisitor;
    use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\LanguageFilter;

    final class CameraManufacturerVisitor implements CriterionVisitor
    {
        public function supports(Criterion $criterion, LanguageFilter $languageFilter): bool
        {
            return $criterion instanceof CameraManufacturer;
        }

        public function visit(CriterionVisitor $dispatcher, Criterion $criterion, LanguageFilter $languageFilter): array
        {
            return [
                'terms' => [
                    'exif_camera_manufacturer_id' => (array)$criterion->value
                ]
            ];
        }
    }
    ```

    Next, add the Search Criterion class itself in src/Query/Criterion/CameraManufacturerCriterion.php

    ``` php
    <?php

    declare(strict_types=1);

    namespace App\Query\Criterion;

    use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
    use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator;
    use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Operator\Specifications;

    final class CameraManufacturer extends Criterion
    {
        /**
         * @param string|string[] $value One or more manufacturer names that must be matched.
         */
        public function __construct($value)
        {
            parent::__construct(null, null, $value);
        }

        public function getSpecifications(): array
        {
            return [
                new Specifications(
                    Operator::IN,
                    Specifications::FORMAT_ARRAY,
                    Specifications::TYPE_STRING
                ),
                new Specifications(
                    Operator::EQ,
                    Specifications::FORMAT_SINGLE,
                    Specifications::TYPE_STRING
                ),
            ];
        }
    }
    ```

    Search Criteria can be valid for both content and Location search.
    To choose the search type, use either `content` or `location` in the tag when registering the visitor as a service:

    ``` yaml
    services:
        App\Query\Criterion\CameraManufacturerVisitor:
            tags:
                - { name: ezplatform.search.elasticsearch.query.content.criterion_visitor }
                - { name: ezplatform.search.elasticsearch.query.location.criterion_visitor }
    ```

    ## Custom Sort Clause

    To create a custom Sort Clause for use with Elasticsearch,
    implement `Ibexa\Platform\Contracts\ElasticSearchEngine\Query\SortClauseVisitor`
    in `src/Query/SortClause/ScoreVisitor.php`:

    ``` php
    <?php

    declare(strict_types=1);

    namespace App\Query\SortClause;

    use eZ\Publish\API\Repository\Values\Content\Query;
    use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
    use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\LanguageFilter;
    use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\SortClauseVisitor;

    final class ScoreVisitor implements SortClauseVisitor
    {
        public function supports(SortClause $sortClause, LanguageFilter $languageFilter): bool
        {
            return $sortClause instanceof Score;
        }

        public function visit(SortClauseVisitor $visitor, SortClause $sortClause, LanguageFilter $languageFilter): array
        {
            $order = $sortClause->direction === Query::SORT_ASC ? 'asc' : 'desc';

            return [
                '_score' => [
                    'order' => $order,
                ],
            ];
        }
    }
    ```

    The `supports()` method checks if the implementation can handle the given Sort Clause.
    The `visit()` method contains the logic that translates Sort Clause information into data understandable by Elasticsearch.
    The `visit()` method takes the Sort Clause visitor, the Sort Clause itself and the language filter as arguments.

    Next, add the Sort Clause class itself in `src/Query/SortClause/ScoreSortClause.php`:

    ``` php
    <?php

    declare(strict_types=1);

    namespace App\Query\SortClause;

    use eZ\Publish\API\Repository\Values\Content\Query;
    use eZ\Publish\API\Repository\Values\Content\Query\SortClause;

    final class Score extends SortClause
    {
        public function __construct(string $sortDirection = Query::SORT_ASC)
        {
            parent::__construct('_score', $sortDirection);
        }
    }
    ```

    Sort Clauses can be valid for both content and Location search.
    To choose the search type, use either `content` or `location` in the tag when registering the visitor as a service:

    ``` yaml
    services:
        App\Query\SortClause\ScoreVisitor:
            tags:
                - { name: ezplatform.search.elasticsearch.query.content.sort_clause_visitor }
                - { name: ezplatform.search.elasticsearch.query.location.sort_clause_visitor }
    ```

    ## Custom Facet

    To create a custom search Facet for use with Elasticsearch, create a Facet class and a Facet builder.
    You also need to add a visitor and a result extractor.

    The following example shows how to create a Facet that filters results according to their Content Type group.

    `src/Query/ContentTypeGroupFacet`:

    ``` php
    <?php

    declare(strict_types=1);

    namespace App\Query\Facet;

    use eZ\Publish\API\Repository\Values\Content\Search\Facet;

    /**
     * This class holds counts of content with content type.
     */
    final class ContentTypeGroupFacet extends Facet
    {
        /**
         * An array with ContentTypeGroup::$id as key and count of matching content objects as value.
         *
         * @var int[]
         */
        public $entries = [];
    }
    ```

    `src/Query/ContentTypeGroupFacetBuilder`:

    ``` php
    <?php

    declare(strict_types=1);

    namespace App\Query\FacetBuilder;

    use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;

    final class ContentTypeGroupFacetBuilder extends FacetBuilder
    {
    }
    ```

    `src/Query/ContentTypeGroupFacetBuilderVisitor`:

    ``` php
    <?php

    declare(strict_types=1);

    namespace App\Query\FacetBuilder;

    use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;
    use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\FacetBuilderVisitor;
    use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\LanguageFilter;

    /**
     * Example (simplified) visitor implementation for ContentTypeGroupFacetBuilder
     */
    final class ContentTypeGroupFacetBuilderVisitor implements FacetBuilderVisitor
    {
        public function supports(FacetBuilder $builder, LanguageFilter $languageFilter): bool
        {
            return $builder instanceof ContentTypeGroupFacetBuilder;
        }

        public function visit(FacetBuilderVisitor $dispatcher, FacetBuilder $builder, LanguageFilter $languageFilter): array
        {
            return [
                'terms' => [
                    'field' => 'content_type_group_id_mid',
                ],
            ];
        }
    }
    ```

    `src/Query/ContentTypeGroupFacetResultExtractor`:

    ``` php
    <?php

    declare(strict_types=1);

    namespace App\Query\FacetBuilder;

    use App\Query\Facet\ContentTypeGroupFacet;
    use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;
    use eZ\Publish\API\Repository\Values\Content\Search\Facet;
    use Ibexa\Platform\Contracts\ElasticSearchEngine\Query\FacetResultExtractor;

    final class ContentTypeGroupFacetResultExtractor implements FacetResultExtractor
    {
        public function supports(FacetBuilder $builder): bool
        {
            return $builder instanceof ContentTypeGroupFacetBuilder;
        }

        public function extract(FacetBuilder $builder, array $data): Facet
        {
            $facet = new ContentTypeGroupFacet();
            $facet->name = $builder->name;
            foreach ($data['buckets'] as $bucket) {
                $facet->entries[$bucket['key']] = $bucket['doc_count'];
            }

            return $facet;
        }
    }
    ```

    Remember to register the facet classes as services:

    ``` yaml
    services:
        App\Query\FacetBuilder\ContentTypeGroupFacetBuilderVisitor:
            tags:
                - { name: ezplatform.search.elasticsearch.query.content.facet_builder_visitor }
                - { name: ezplatform.search.elasticsearch.query.location.facet_builder_visitor }

        App\Query\FacetBuilder\ContentTypeGroupFacetResultExtractor:
            tags:
                - { name: ezplatform.search.elasticsearch.query.facet_result_extractor }
    ```
