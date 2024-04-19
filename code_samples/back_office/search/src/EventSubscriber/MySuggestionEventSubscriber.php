<?php declare(strict_types=1);

namespace App\EventSubscriber;

use App\Search\Model\Suggestion\ProductSuggestion;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;
use Ibexa\Contracts\Search\Event\BuildSuggestionCollectionEvent;
use Ibexa\Contracts\Search\Mapper\SearchHitToContentSuggestionMapperInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MySuggestionEventSubscriber implements EventSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private ProductServiceInterface $productService;

    private SearchHitToContentSuggestionMapperInterface $contentSuggestionMapper;

    public function __construct(
        ProductServiceInterface $productService,
        SearchHitToContentSuggestionMapperInterface $contentSuggestionMapper
    ) {
        $this->productService = $productService;
        $this->contentSuggestionMapper = $contentSuggestionMapper;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BuildSuggestionCollectionEvent::class => ['onBuildSuggestionCollectionEvent', -1],
        ];
    }

    public function onBuildSuggestionCollectionEvent(BuildSuggestionCollectionEvent $event): BuildSuggestionCollectionEvent
    {
        $suggestionQuery = $event->getQuery();
        $suggestionCollection = $event->getSuggestionCollection();

        $text = $suggestionQuery->getQuery();
        $words = explode(' ', preg_replace('/\s+/', ' ', $text));
        $limit = $suggestionQuery->getLimit();

        try {
            $productQuery = new ProductQuery(null, new Criterion\LogicalOr([
                new Criterion\ProductName(implode(' ', array_map(static function (string $word) {
                    return "$word*";
                }, $words))),
                new Criterion\ProductCode($words),
                new Criterion\ProductType($words),
            ]), [], 0, $limit);
            $searchResult = $this->productService->findProducts($productQuery);

            if ($searchResult->getTotalCount()) {
                $maxScore = 0.0;
                $suggestionsByContentIds = [];
                /** @var \Ibexa\Contracts\Search\Model\Suggestion\ContentSuggestion $suggestion */
                foreach ($suggestionCollection as $suggestion) {
                    $maxScore = max($suggestion->getScore(), $maxScore);
                    $suggestionsByContentIds[$suggestion->getContent()->id] = $suggestion;
                }

                /** @var \Ibexa\ProductCatalog\Local\Repository\Values\Product $product */
                foreach ($searchResult as $product) {
                    $contentId = $product->getContent()->id;
                    if (array_key_exists($contentId, $suggestionsByContentIds)) {
                        $suggestionCollection->remove($suggestionsByContentIds[$contentId]);
                    }

                    $productSuggestion = new ProductSuggestion($maxScore + 1, $product);
                    $suggestionCollection->append($productSuggestion);
                }
            }
        } catch (\Throwable $throwable) {
            $this->logger->error($throwable);
        }

        return $event;
    }
}
