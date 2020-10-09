# BaseOperation

The `BaseOperation` class is used as a base class for all operation services.
It is abstract and holds dependencies to services which are commonly needed by business services.

The following services are injected into this base class.

| Service                                                              | Base class attribute |
| -------------------------------------------------------------------- | -------------------- |
| `Silversolutions\Bundle\EshopBundle\Services\LogService`         | `$logger`              |
| `Silversolutions\Bundle\TranslationBundle\Services\TransService` | `$transService`        |

Service ID: `ses_eshop.business_api.base`

## Operation basket

This class implements business logic for basket.

### Methods

| Method | Parameters  | Returns    | Purpose  | Operation identifier |
| ------ | ----------- | ---------- | -------- | -------------------- |
| [`addProducts`](addproducts.md) | `InputAddItemToBasket $operationInput` | `OutputAddItemToBasket $operationOutput` | adds products to the basket | `basket.add_products` |
| [`getBasket`](getbasket.md)     | `InputGetBasket $input`                | `OutputGetBasket $output`                | returns current basket     | `basket.get_basket`   |

### Service definition

``` xml
<parameters>
    <parameter key="ses_eshop.basket.business_api.class">Silversolutions\Bundle\EshopBundle\Services\BusinessLayer\Operations\Basket</parameter>
</parameters>         

<!-- basket business component -->
<service id="ses_eshop.basket.business_api" class="%ses_eshop.basket.business_api.class%"
             parent="ses_eshop.business_api.base">
        <argument type="service" id="silver_basket.basket_service" />            
        <tag name="business_api_operation" alias="basket" />
</service> 
```

## Operation catalog

This class implements business logic for catalog.

### Methods

|Method|Parameters|Returns|Purpose|Operation identifier|
|--- |--- |--- |--- |--- |
|`loadProducts`|`InputLoadList $input`|`OutputLoadList $input`|loads products from catalog|`catalog.load_products`|

### Service definition

services.business_layer.xml:

``` xml
<parameters>
    <parameter key="ses_eshop.catalog.business_api.class">Silversolutions\Bundle\EshopBundle\Services\BusinessLayer\Operations\Catalog</parameter>
</parameters>

<!-- catalog business component -->
<service id="ses_eshop.catalog.business_api" class="%ses_eshop.catalog.business_api.class%"
             parent="ses_eshop.business_api.base">
        <argument type="service" id="silver_catalog.catalog_service" />
        <tag name="business_api_operation" alias="catalog" />
</service>
```
