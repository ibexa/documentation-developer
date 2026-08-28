# Quable API

Learn how to use PHP and REST APIs to retrieve product data from Quable

As Quable products are represented as Ibexa DXP products, you can use the existing [Product APIs](../../product_api/index.md) to retrieve the product information.

Quable is the source of truth about products and categories and you should only use the Ibexa DXP APIs to read the information coming from Quable, but you can't use them to modify it. To modify the information, use the [Quable interface](https://www.quable.com) or the dedicated [Quable APIs](https://developers.quable.com/quable-api/).

## REST API Usage

To learn how to work with Ibexa DXP REST API, see [REST API reference](../../../api/rest_api/rest_api_usage/rest_api_usage/index.md).

You can use the following endpoints to retrieve product and category information:

- [Product REST API](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product)
- [Taxonomy REST API](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Taxonomy)

## PHP API Usage

### Retrieve products

To retrieve product information coming from Quable, use the same APIs as described in [Product API](../../product_api/index.md).

The following example shows how you can retrieve a single product:

```php
$product = $this->productService->getProduct($productCode);
```

### Search for products

Use [`ProductQuery`](../../product_api/index.md#getting-product-information) to search for multiple products:

```php
$criteria = new Criterion\ProductType([$productType]);
$sortClauses = [new SortClause\ProductName(ProductQuery::SORT_ASC)];

$productQuery = new ProductQuery(null, $criteria, $sortClauses);

$products = $this->productService->findProducts($productQuery);

foreach ($products as $product) {
    $output->writeln($product->getName() . ' of type ' . $product->getProductType()->getName());
}
```

When working with Quable products, the following search criteria are supported:

| Search Criterion                                                                                                          | Search based on                                          |
| ------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------- |
| [CreatedAt](../../../search/criteria_reference/createdat_criterion/index.md)                           | Date and time when product was created                   |
| [LogicalAnd](../../../search/criteria_reference/logicaland_criterion/index.md)                         | Composite criterion combining multiple criteria with AND |
| [MatchAll](../../../search/criteria_reference/matchall_criterion/index.md)                             | All products                                             |
| [ProductCategory](../../../search/criteria_reference/productcategory_criterion/index.md)               | Product category assigned to product                     |
| [ProductCategorySubtree](../../../search/criteria_reference/productcategorysubtree_criterion/index.md) | Product category subtree                                 |
| [ProductCode](../../../search/criteria_reference/productcode_criterion/index.md)                       | Product's code                                           |
| [ProductName](../../../search/criteria_reference/productname_criterion/index.md)                       | Product's name                                           |
| [ProductType](../../../search/criteria_reference/producttype_criterion/index.md)                       | Product type                                             |
| [UpdatedAt](../../../search/criteria_reference/updated_at_criterion/index.md)                          | Date and time when product was last updated              |

The following sort clauses are supported:

| Sort Clause                                                                                              | Sorting based on                           |
| -------------------------------------------------------------------------------------------------------- | ------------------------------------------ |
| [CreatedAt](../../../search/sort_clause_reference/createdat_sort_clause/index.md)     | Date and time of the creation of a product |
| [ProductCode](../../../search/sort_clause_reference/productcode_sort_clause/index.md) | Product's code                             |
| [ProductName](../../../search/sort_clause_reference/productname_sort_clause/index.md) | Product's name                             |

### Manage stock and pricing

For information stored outside of Quable, such as [product availability](../../product_api/index.md#product-availability) or [pricing](../../price_api/index.md), you can use the existing services to manage them:

```php
// Manage availability
$product = $this->productService->getProduct('NEWMODIFIEDPRODUCT');

$productAvailabilityCreateStruct = new ProductAvailabilityCreateStruct($product, false, true);

$this->productAvailabilityService->createProductAvailability($productAvailabilityCreateStruct);

// Manage prices
$newCurrency = $this->currencyService->getCurrencyByCode($newCurrencyCode);

$money = new Money\Money(50000, new Money\Currency($newCurrencyCode));
$priceCreateStruct = new ProductPriceCreateStruct($product, $newCurrency, $money, null, null);

$this->productPriceService->createProductPrice($priceCreateStruct);
```

For advanced pricing strategies, use the [Discounts API](../../../discounts/discounts_api/index.md) to specify prices for Quable's products.
