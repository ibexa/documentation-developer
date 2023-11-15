<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;
use Ibexa\Contracts\Search\Event\BuildSuggestionCollectionEvent;
use Ibexa\Contracts\Search\Model\Suggestion\ContentSuggestion;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MySuggestionEventSubscriber implements EventSubscriberInterface
{
    use LoggerAwareTrait;

    private ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
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
                new Criterion\ProductName("$text*"),
                new Criterion\ProductCode($words),
                new Criterion\ProductType($words),
            ]), [], 0, $limit);
            $searchResult = $this->productService->findProducts($productQuery);

            if ($searchResult->getTotalCount()) {

                $maxScore = 0.0;
                /** @var ContentSuggestion $suggestion */
                foreach ($suggestionCollection as $suggestion) {
                    $maxScore = max($suggestion->getScore(), $maxScore);
                }

                /** @var \Ibexa\ProductCatalog\Local\Repository\Values\Product $result */
                foreach ($searchResult as $result) {
                    $content = $result->getContent();

                    $contentSuggestion = new ContentSuggestion(
                        $maxScore+1,
                        $content,
                        $content->getContentType(),
                        $content->contentInfo->getMainLocation()->pathString,
                        []
                    );
                    $suggestionCollection->append($contentSuggestion);
                }
            }
        } catch (\Throwable $throwable) {
            $this->logger->error($throwable);
        }

        return $event;
    }
}
