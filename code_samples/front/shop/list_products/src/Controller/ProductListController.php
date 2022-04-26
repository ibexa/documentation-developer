<?php

namespace App\Controller;

use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\ProductCatalog\Local\Repository\ProductService;
use Ibexa\Core\MVC\Symfony\View\View;

class ProductListController
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function showProductsAction(View $view)
    {
        $query = new ProductQuery();

        $result = $this->productService->findProducts($query);

        $view->addParameters([
            'products' => $result,
        ]);

        return $view;
    }
}
