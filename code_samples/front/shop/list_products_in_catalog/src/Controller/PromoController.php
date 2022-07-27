<?php

declare(strict_types=1);

namespace App\Controller;

use Ibexa\Bundle\Core\Controller;
use Ibexa\Contracts\ProductCatalog\CatalogServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;

final class PromoController extends Controller
{
    private ProductServiceInterface $productService;

    private CatalogServiceInterface $catalogService;

    public function __construct(ProductServiceInterface $productService, CatalogServiceInterface $catalogService)
    {
        $this->productService = $productService;
        $this->catalogService = $catalogService;
    }

    public function listPromoProductsAction()
    {
        $catalog = $this->catalogService->getCatalogByIdentifier('desk_promo');
        $query = new ProductQuery($catalog->getQuery());

        $result = $this->productService->findProducts($query);

        return $this->render('@ibexadesign/full/promo.html.twig', [
            'products' => $result,
        ]);
    }
}
