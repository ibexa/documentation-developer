<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion;
use Ibexa\Contracts\Search\Event\BuildSuggestionCollectionEvent;
use Ibexa\Contracts\Search\Model\Suggestion\ContentSuggestion;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MySuggestionEventSubscriber implements EventSubscriberInterface
{
    private ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BuildSuggestionCollectionEvent::class => 'onBuildSuggestionCollectionEvent',
        ];
    }

    public function onBuildSuggestionCollectionEvent(BuildSuggestionCollectionEvent $event): BuildSuggestionCollectionEvent
    {
        $suggestionQuery = $event->getQuery();
        $suggestionCollection = $event->getSuggestionCollection();

        $text = $suggestionQuery->getQuery();
        $words = explode(' ', preg_replace('/\s+/', ' ', $text));
        $limit = $suggestionQuery->getLimit();
        //$language = $suggestionQuery->getLanguageCode();

        try {
            $productQuery = new ProductQuery(null, new Criterion\LogicalOr([
                new Criterion\ProductName("$text*"),
                new Criterion\ProductCode($words),
                new Criterion\ProductType($words),
            ]), [], 0, $limit);
            $searchResult = $this->productService->findProducts($productQuery);

            /** @var \Ibexa\ProductCatalog\Local\Repository\Values\Product $result */
            foreach ($searchResult as $result) {
                $content = $result->getContent();

                $contentSuggestion = new ContentSuggestion(
                    100,
                    $content,
                    $content->getContentType(),
                    '',
                    []
                );
                $suggestionCollection->append($contentSuggestion);
            }
        } catch (\Throwable $throwable) {
            //TODO
            dump($throwable);
        }

        return $event;
    }
}
