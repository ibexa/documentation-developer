<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\Core\Repository\Iterator\BatchIterator;
use Ibexa\Contracts\ProductCatalog\Iterator\BatchIteratorAdapter\ProductVariantFetchAdapter;
use Ibexa\Contracts\ProductCatalog\Local\LocalProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductVariantQuery;
use Ibexa\Core\MVC\Symfony\View\ContentView;
use Ibexa\Core\MVC\Symfony\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ProductViewController extends AbstractController
{
    public function __construct(private readonly LocalProductServiceInterface $productService)
    {
    }

    public function viewAction(Request $request, ContentView $view): View
    {
        $product = $this->productService->getProductFromContent($view->getContent());
        if ($product->isBaseProduct()) {
            $view->addParameters([
                'variants' => new BatchIterator(new ProductVariantFetchAdapter(
                    $this->productService,
                    $product,
                    new ProductVariantQuery(),
                )),
            ]);
        }

        return $view;
    }
}
