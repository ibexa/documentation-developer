<?php

namespace App\Controller;

use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Core\MVC\Symfony\View\View;

final class ProductListController
{
    private ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function showProductsAction(View $view): View
    {
        $query = new ProductQuery();

        $result = $this->productService->findProducts($query);

        $view->addParameters([
            'products' => $result,
        ]);

        return $view;
    }
}
