<?php declare(strict_types=1);

namespace App\ProductCatalog\Availability;

use Ibexa\Contracts\ProductCatalog\ProductAvailabilityStrategyInterface;
use Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityContextInterface;
use Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityInterface;
use Ibexa\Contracts\ProductCatalog\Values\ProductInterface;
use Ibexa\ProductCatalog\Local\Persistence\Legacy\ProductAvailability\HandlerInterface;
use Ibexa\ProductCatalog\Local\Repository\Values\Availability;

final readonly class ProductAvailabilityPurchasableWithoutStockStrategy implements ProductAvailabilityStrategyInterface
{
    public function __construct(private HandlerInterface $handler)
    {
    }

    public function accept(AvailabilityContextInterface $context): bool
    {
        return $context instanceof PurchasableWithoutStockAvailabilityContext;
    }

    public function getProductAvailability(
        ProductInterface $product,
        AvailabilityContextInterface $context
    ): AvailabilityInterface {
        $productAvailability = $this->handler->find($product->getCode());

        $rawAvailableFlag = $productAvailability->isAvailable();
        $stock = $productAvailability->getStock();
        $isInfinite = $productAvailability->isInfinite();

        $computedAvailable = $this->calculateAvailability(
            $rawAvailableFlag,
            $stock,
            $isInfinite,
        );

        return new Availability(
            $product,
            $rawAvailableFlag,
            $computedAvailable,
            $isInfinite,
            $stock,
        );
    }

    private function calculateAvailability(
        bool $rawAvailable,
        ?int $stock,
        bool $isInfinite
    ): bool {
        if ($rawAvailable === false) {
            return false;
        }

        if ($isInfinite) {
            return true;
        }

        if ($stock === null) {
            return true;
        }

        return $stock >= 0;
    }
}
