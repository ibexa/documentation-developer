<?php declare(strict_types=1);

namespace App\Search\Model\Suggestion;

use Ibexa\Contracts\Search\Model\Suggestion\Suggestion;
use Ibexa\ProductCatalog\Local\Repository\Values\Product;

class ProductSuggestion extends Suggestion {
    private Product $product;

    public function __construct(
        float $score,
        Product $product
    ) {
        parent::__construct($score, $product->getName());
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }
}
