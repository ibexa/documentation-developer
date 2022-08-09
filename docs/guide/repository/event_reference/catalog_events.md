---
description: Events that are triggered when working with products, prices and currencies.
---

# Catalog events

## Products

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateAttributeDefinitionEvent`|`AttributeDefinitionService::createAttributeDefinition`|`AttributeDefinitionCreateStruct $createStruct`|
|`BeforeCreateAttributeGroupEvent`|`AttributeGroupService::createAttributeGroup`|`AttributeGroupCreateStruct $createStruct`|
|`BeforeCreateProductEvent`|`ProductService::createProduct`|`ProductCreateStruct $createStruct`|
|`BeforeDeleteAttributeDefinitionEvent`|`AttributeDefinitionService::deleteAttributeDefinition`|`AttributeDefinitionInterface $attributeDefinition`|
|`BeforeDeleteAttributeGroupEvent`|`AttributeGroupService::deleteAttributeGroup`|`AttributeGroupInterface $attributeGroup`|
|`BeforeDeleteProductEvent`|`ProductService::deleteProduct`|`ProductInterface $product`|
|`BeforeUpdateAttributeDefinitionEvent`|`AttributeDefinitionService::updateAttributeDefinition`|`AttributeDefinitionInterface $attributeDefinition`</br>`AttributeDefinitionUpdateStruct $updateStruct`|
|`BeforeUpdateAttributeGroupEvent`|`AttributeGroupService::updateAttributeGroup`|`AttributeGroupInterface $attributeGroup`</br>`AttributeGroupUpdateStruct $updateStruct`|
|`BeforeUpdateProductEvent`|`ProductService::updateProduct`|`ProductUpdateStruct $updateStruct`|
|`CreateAttributeDefinitionEvent`|`AttributeDefinitionService::createAttributeDefinition`|`AttributeDefinitionCreateStruct $createStruct`</br>`AttributeDefinitionInterface $attributeDefinition`|
|`CreateAttributeGroupEvent`|`AttributeGroupService::createAttributeGroup`|`AttributeGroupCreateStruct $createStruct`</br>`AttributeGroupInterface $attributeGroup`|
|`CreateProductEvent`|`ProductService::createProduct`|`ProductCreateStruct $createStruct`</br>`ProductInterface $product`|
|`DeleteAttributeDefinitionEvent`|`AttributeDefinitionService::deleteAttributeDefinition`|`AttributeDefinitionInterface $attributeDefinition`|
|`DeleteAttributeGroupEvent`|`AttributeGroupService::deleteAttributeGroup`|`AttributeGroupInterface $attributeGroup`|
|`DeleteProductEvent`|`ProductService::deleteProduct`|`ProductInterface $product`|
|`UpdateAttributeDefinitionEvent`|`AttributeDefinitionService::updateAttributeDefinition`|`AttributeDefinitionInterface $attributeDefinition`</br>`AttributeDefinitionUpdateStruct $updateStruct`|
|`UpdateAttributeGroupEvent`|`AttributeGroupService::updateAttributeGroup`|`AttributeGroupInterface $attributeGroup`</br>`AttributeGroupUpdateStruct $updateStruct`|
|`UpdateProductEvent`|`ProductService::updateProduct`|`ProductInterface $product`</br>`ProductUpdateStruct $updateStruct`|

## Product variants

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateProductVariantsEvent`|`ProductService::createProductVariants`|`ProductInterface $product`</br>`iterable $createStructs`|
|`BeforeUpdateProductVariantEvent`|`ProductService::updateProductVariant`|`ProductVariantInterface $productVariant`</br>`ProductVariantUpdateStruct $updateStruct`|
|`CreateProductVariantsEvent`|`ProductService::createProductVariants`|`ProductInterface $product`</br>`iterable $createStructs`|
|`UpdateProductVariantEvent`|`ProductService::updateProductVariant`|`ProductVariantInterface $productVariant`</br>`ProductVariantUpdateStruct $updateStruct`|

## Product availability

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateProductAvailabilityEvent`|`ProductAvailabilityService::createProductAvailability`|`ProductAvailabilityCreateStruct $createStruct`|
|`BeforeDecreaseProductAvailabilityEvent`|`ProductAvailabilityService::decreaseProductAvailability`|`ProductInterface $product`</br>`int $amount`|
|`BeforeDeleteProductAvailabilityEvent`|`ProductAvailabilityService::deleteProductAvailability`|`ProductInterface $product`|
|`BeforeIncreaseProductAvailabilityEvent`|`ProductAvailabilityService::increaseProductAvailability`|`ProductInterface $product`</br>`int $amount`|
|`BeforeUpdateProductAvailabilityEvent`|`ProductAvailabilityService::updateProductAvailability`|`ProductAvailabilityUpdateStruct $updateStruct`|
|`CreateProductAvailabilityEvent`|`ProductAvailabilityService::createProductAvailability`|`ProductAvailabilityCreateStruct $createStruct`</br>`AvailabilityInterface $productAvailability`|
|`DecreaseProductAvailabilityEvent`|`ProductAvailabilityService::decreaseProductAvailability`|`AvailabilityInterface $productAvailability`</br>`ProductInterface $product`</br>`int $amount`|
|`DeleteProductAvailabilityEvent`|`ProductAvailabilityService::deleteProductAvailability`|`ProductInterface $product`|
|`IncreaseProductAvailabilityEvent`|`ProductAvailabilityService::increaseProductAvailability`|`AvailabilityInterface $productAvailability ProductInterface $product`</br>`int $amount`|
|`UpdateProductAvailabilityEvent`|`ProductAvailabilityService::updateProductAvailability`|`AvailabilityInterface $productAvailability`</br>`ProductAvailabilityUpdateStruct $updateStruct`|

## Price

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreatePriceEvent`|`ProductPriceService::createProductPrice`|`ProductPriceCreateStructInterface $createStruct`|
|`BeforeDeletePriceEvent`|`ProductPriceService::deletePrice`|`ProductPriceDeleteStructInterface $deleteStruct`|
|`BeforeUpdatePriceEvent`|`ProductPriceService::updateProductPrice`|`ProductPriceUpdateStructInterface $updateStruct`|
|`CreatePriceEvent`|`ProductPriceService::createProductPrice`|`ProductPriceCreateStructInterface $createStruct`</br>`PriceInterface $price`|
|`DeletePriceEvent`|`ProductPriceService::deletePrice`|`ProductPriceDeleteStructInterface $deleteStruct`|
|`UpdatePriceEvent`|`ProductPriceService::updateProductPrice`|`PriceInterface $price`</br>`ProductPriceUpdateStructInterface $updateStruct`|

## Currency

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateCurrencyEvent`|`CurrencyService::createCurrency`|`CurrencyCreateStruct $createStruct`|
|`BeforeDeleteCurrencyEvent`|`CurrencyService::deleteCurrency`|`CurrencyInterface $currency`|
|`BeforeUpdateCurrencyEvent`|`CurrencyService::updateCurrency`|`CurrencyInterface $currency`</br>`CurrencyUpdateStruct $updateStruct`|
|`CreateCurrencyEvent`|`CurrencyService::createCurrency`|`CurrencyCreateStruct $createStruct`</br>`CurrencyInterface $currency`|
|`DeleteCurrencyEvent`|`CurrencyService::deleteCurrency`|`CurrencyInterface $currency`|
|`UpdateCurrencyEvent`|`CurrencyService::updateCurrency`|`CurrencyInterface $currency`</br>`CurrencyUpdateStruct $updateStruct`|

## Catalogs

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateCatalogEvent`|`CatalogService::createCatalog`|`CatalogCreateStruct $createStruct`|
|`BeforeDeleteCatalogEvent`|`CatalogService::deleteCatalog`|`CatalogInterface $catalog`|
|`BeforeUpdateCatalogEvent`|`CatalogService::updateCatalog`|`CatalogUpdateStruct $updateStruct`|
|`CreateCatalogEvent`|`CatalogService::createCatalog`|`CatalogCreateStruct $createStruct`</br>`CatalogInterface $catalog`|
|`DeleteCatalogEvent`|`CatalogService::deleteCatalog`|`CatalogInterface $catalog`|
|`UpdateCatalogEvent`|`CatalogService::updateCatalog`|`CatalogUpdateStruct $updateStruct`|
