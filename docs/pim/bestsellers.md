---
description: The bestseller functionality calculates the best-selling products in the catalog.
---

# Bestsellers

Bestsellers are determined based on all confirmed orders. The information how often a product was purchased is stored in the search engine.
The shop owner can specify from which point a product counts as a bestseller.

Bestsellers can be displayed on Landing Pages and a bestseller page. 

## Configuration

To enable bestsellers, set the following parameter to true:

``` yaml
ibexa.commerce.site_access.config.core.default.enable_bestsellers: true
```

## Template list

- `Eshop/Resources/views/Bestsellers/bestsellers.html.twig` renders a bestseller page, available by default under the `/bestsellers` route.

![Bestseller page](bestseller_page.png)

- `Eshop/Resources/views/Bestsellers/bestsellers_box.html.twig` renders a slider for the Bestseller Page block.

![Bestseller Page block](bestseller_block_slider.png)

- `Eshop/Resources/views/Bestsellers/bestsellers_catalog.html.twig` renders a slider for the catalog page.

![Bestsellers in product category](bestseller_category.png)

- `Eshop/Resources/views/Bestsellers/bestsellers_box_esi.html.twig` creates an Edge Side Includes tag and calls the controller for Landing Page bestsellers.

!!! note "Category pages/Caching"

    Catalog bestsellers are cached independently of the rest of the page using ESI.

## API

### `BestsellerService`

`Ibexa\Bundle\Commerce\Search\Api\Engine\BestsellerService.php` fetches bestsellers from the search engine.

### `EcontentBestsellerIndexerPlugin`

`Ibexa\Bundle\Commerce\Search\Service\EcontentBestsellerIndexerPlugin.php` adds an additional search index field with a sum of cart lines.
