# Product catalog events

Events that are triggered when working with products, prices, currencies, and attribute rendering.

## Products

| Event                                  | Dispatched by                                           | Properties                                                                                          |
| -------------------------------------- | ------------------------------------------------------- | --------------------------------------------------------------------------------------------------- |
| `BeforeCreateAttributeDefinitionEvent` | `AttributeDefinitionService::createAttributeDefinition` | `AttributeDefinitionCreateStruct $createStruct`                                                     |
| `BeforeCreateAttributeGroupEvent`      | `AttributeGroupService::createAttributeGroup`           | `AttributeGroupCreateStruct $createStruct`                                                          |
| `BeforeCreateProductEvent`             | `ProductService::createProduct`                         | `ProductCreateStruct $createStruct`                                                                 |
| `BeforeDeleteAttributeDefinitionEvent` | `AttributeDefinitionService::deleteAttributeDefinition` | `AttributeDefinitionInterface $attributeDefinition`                                                 |
| `BeforeDeleteAttributeGroupEvent`      | `AttributeGroupService::deleteAttributeGroup`           | `AttributeGroupInterface $attributeGroup`                                                           |
| `BeforeDeleteProductEvent`             | `ProductService::deleteProduct`                         | `ProductInterface $product`                                                                         |
| `BeforeUpdateAttributeDefinitionEvent` | `AttributeDefinitionService::updateAttributeDefinition` | `AttributeDefinitionInterface $attributeDefinition` `AttributeDefinitionUpdateStruct $updateStruct` |
| `BeforeUpdateAttributeGroupEvent`      | `AttributeGroupService::updateAttributeGroup`           | `AttributeGroupInterface $attributeGroup` `AttributeGroupUpdateStruct $updateStruct`                |
| `BeforeUpdateProductEvent`             | `ProductService::updateProduct`                         | `ProductUpdateStruct $updateStruct`                                                                 |
| `CreateAttributeDefinitionEvent`       | `AttributeDefinitionService::createAttributeDefinition` | `AttributeDefinitionCreateStruct $createStruct` `AttributeDefinitionInterface $attributeDefinition` |
| `CreateAttributeGroupEvent`            | `AttributeGroupService::createAttributeGroup`           | `AttributeGroupCreateStruct $createStruct` `AttributeGroupInterface $attributeGroup`                |
| `CreateProductEvent`                   | `ProductService::createProduct`                         | `ProductCreateStruct $createStruct` `ProductInterface $product`                                     |
| `DeleteAttributeDefinitionEvent`       | `AttributeDefinitionService::deleteAttributeDefinition` | `AttributeDefinitionInterface $attributeDefinition`                                                 |
| `DeleteAttributeGroupEvent`            | `AttributeGroupService::deleteAttributeGroup`           | `AttributeGroupInterface $attributeGroup`                                                           |
| `DeleteProductEvent`                   | `ProductService::deleteProduct`                         | `ProductInterface $product`                                                                         |
| `UpdateAttributeDefinitionEvent`       | `AttributeDefinitionService::updateAttributeDefinition` | `AttributeDefinitionInterface $attributeDefinition` `AttributeDefinitionUpdateStruct $updateStruct` |
| `UpdateAttributeGroupEvent`            | `AttributeGroupService::updateAttributeGroup`           | `AttributeGroupInterface $attributeGroup` `AttributeGroupUpdateStruct $updateStruct`                |
| `UpdateProductEvent`                   | `ProductService::updateProduct`                         | `ProductInterface $product` `ProductUpdateStruct $updateStruct`                                     |

## Product variants

| Event                              | Dispatched by                           | Properties                                                                           |
| ---------------------------------- | --------------------------------------- | ------------------------------------------------------------------------------------ |
| `BeforeCreateProductVariantsEvent` | `ProductService::createProductVariants` | `ProductInterface $product` `iterable $createStructs`                                |
| `BeforeUpdateProductVariantEvent`  | `ProductService::updateProductVariant`  | `ProductVariantInterface $productVariant` `ProductVariantUpdateStruct $updateStruct` |
| `CreateProductVariantsEvent`       | `ProductService::createProductVariants` | `ProductInterface $product` `iterable $createStructs`                                |
| `UpdateProductVariantEvent`        | `ProductService::updateProductVariant`  | `ProductVariantInterface $productVariant` `ProductVariantUpdateStruct $updateStruct` |

## Product availability

| Event                                    | Dispatched by                                             | Properties                                                                                   |
| ---------------------------------------- | --------------------------------------------------------- | -------------------------------------------------------------------------------------------- |
| `BeforeCreateProductAvailabilityEvent`   | `ProductAvailabilityService::createProductAvailability`   | `ProductAvailabilityCreateStruct $createStruct`                                              |
| `BeforeDecreaseProductAvailabilityEvent` | `ProductAvailabilityService::decreaseProductAvailability` | `ProductInterface $product` `int $amount`                                                    |
| `BeforeDeleteProductAvailabilityEvent`   | `ProductAvailabilityService::deleteProductAvailability`   | `ProductInterface $product`                                                                  |
| `BeforeIncreaseProductAvailabilityEvent` | `ProductAvailabilityService::increaseProductAvailability` | `ProductInterface $product` `int $amount`                                                    |
| `BeforeUpdateProductAvailabilityEvent`   | `ProductAvailabilityService::updateProductAvailability`   | `ProductAvailabilityUpdateStruct $updateStruct`                                              |
| `CreateProductAvailabilityEvent`         | `ProductAvailabilityService::createProductAvailability`   | `ProductAvailabilityCreateStruct $createStruct` `AvailabilityInterface $productAvailability` |
| `DecreaseProductAvailabilityEvent`       | `ProductAvailabilityService::decreaseProductAvailability` | `AvailabilityInterface $productAvailability` `ProductInterface $product` `int $amount`       |
| `DeleteProductAvailabilityEvent`         | `ProductAvailabilityService::deleteProductAvailability`   | `ProductInterface $product`                                                                  |
| `IncreaseProductAvailabilityEvent`       | `ProductAvailabilityService::increaseProductAvailability` | `AvailabilityInterface $productAvailability ProductInterface $product` `int $amount`         |
| `UpdateProductAvailabilityEvent`         | `ProductAvailabilityService::updateProductAvailability`   | `AvailabilityInterface $productAvailability` `ProductAvailabilityUpdateStruct $updateStruct` |

## Price

| Event                    | Dispatched by                             | Properties                                                                |
| ------------------------ | ----------------------------------------- | ------------------------------------------------------------------------- |
| `BeforeCreatePriceEvent` | `ProductPriceService::createProductPrice` | `ProductPriceCreateStructInterface $createStruct`                         |
| `BeforeDeletePriceEvent` | `ProductPriceService::deletePrice`        | `ProductPriceDeleteStructInterface $deleteStruct`                         |
| `BeforeUpdatePriceEvent` | `ProductPriceService::updateProductPrice` | `ProductPriceUpdateStructInterface $updateStruct`                         |
| `CreatePriceEvent`       | `ProductPriceService::createProductPrice` | `ProductPriceCreateStructInterface $createStruct` `PriceInterface $price` |
| `DeletePriceEvent`       | `ProductPriceService::deletePrice`        | `ProductPriceDeleteStructInterface $deleteStruct`                         |
| `UpdatePriceEvent`       | `ProductPriceService::updateProductPrice` | `PriceInterface $price` `ProductPriceUpdateStructInterface $updateStruct` |

## Currency

| Event                       | Dispatched by                     | Properties                                                         |
| --------------------------- | --------------------------------- | ------------------------------------------------------------------ |
| `BeforeCreateCurrencyEvent` | `CurrencyService::createCurrency` | `CurrencyCreateStruct $createStruct`                               |
| `BeforeDeleteCurrencyEvent` | `CurrencyService::deleteCurrency` | `CurrencyInterface $currency`                                      |
| `BeforeUpdateCurrencyEvent` | `CurrencyService::updateCurrency` | `CurrencyInterface $currency` `CurrencyUpdateStruct $updateStruct` |
| `CreateCurrencyEvent`       | `CurrencyService::createCurrency` | `CurrencyCreateStruct $createStruct` `CurrencyInterface $currency` |
| `DeleteCurrencyEvent`       | `CurrencyService::deleteCurrency` | `CurrencyInterface $currency`                                      |
| `UpdateCurrencyEvent`       | `CurrencyService::updateCurrency` | `CurrencyInterface $currency` `CurrencyUpdateStruct $updateStruct` |

## Catalogs

| Event                      | Dispatched by                   | Properties                                                      |
| -------------------------- | ------------------------------- | --------------------------------------------------------------- |
| `BeforeCreateCatalogEvent` | `CatalogService::createCatalog` | `CatalogCreateStruct $createStruct`                             |
| `BeforeDeleteCatalogEvent` | `CatalogService::deleteCatalog` | `CatalogInterface $catalog`                                     |
| `BeforeUpdateCatalogEvent` | `CatalogService::updateCatalog` | `CatalogUpdateStruct $updateStruct`                             |
| `CreateCatalogEvent`       | `CatalogService::createCatalog` | `CatalogCreateStruct $createStruct` `CatalogInterface $catalog` |
| `DeleteCatalogEvent`       | `CatalogService::deleteCatalog` | `CatalogInterface $catalog`                                     |
| `UpdateCatalogEvent`       | `CatalogService::updateCatalog` | `CatalogUpdateStruct $updateStruct`                             |

## Attribute rendering

The following event is dispatched when the [`ibexa_format_product_attribute`](../../../templating/twig_function_reference/product_twig_functions/index.md#ibexa_format_product_attribute) Twig filter renders an attribute value.

| Event                         | Dispatched by                                | Properties                                                                                                                                                                                            |
| ----------------------------- | -------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `ProductAttributeRenderEvent` | `ibexa_format_product_attribute` Twig filter | `list<string> $templates` [`Ibexa\Contracts\ProductCatalog\Values\AttributeInterface`](../../../../../../ibexa/product-catalog/src/contracts/Values/AttributeInterface.php) `array $parameters` |

For a usage example, see [Customize product attribute templates](../../../product_catalog/customize_product_attribute_templates/index.md).
