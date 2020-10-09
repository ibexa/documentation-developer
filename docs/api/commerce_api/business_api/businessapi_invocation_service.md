# Business API invocation service

This service is the access point to the Business API and defined by a service with the ID `ses_eshop.business_api.invocation`.
Because this service acts only as a proxy, the business logic itself is handled by different operation services.

## Calling Business API operation service

To call Business API operation service, use the `call()` method of the Business API invocation service.

|method|parameters|returns|
|--- |--- |--- |
|call()|`string $operationIdentifier`</br>`ValueObject $operationInput`|`ValueObject $operationOutput`|

### Creating $operationIdentifier

The identifier of the Business API operation service consists of two parts separated by a dot.

1. The first part is the alias of the operation service that can be found in the configuration: `services.business_layer.xml`.
1. The second part is the operation method that should be invoked.
The method name must be lowercase, separated by underscore instead of the method's camelCase notation (`get_basket` => `getBasket()`).

For examples:

``` 
basket.get_basket
basket.add_products
catalog.load_products
```

## Example

The following example shows how to use the Business API basket operation service.

``` php
use Silversolutions\Bundle\EshopBundle\Entities\BusinessLayer\InputValueObjects\GetBasket as InputGetBasket;
use Silversolutions\Bundle\EshopBundle\Entities\BusinessLayer\OutputValueObjects\GetBasket as OutputGetBasket;

/** @var InputGetBasket $input */
$input = new InputGetBasket(array('request' => $request));

/** @var OutputGetBasket $output */
$output = $this->get('ses_eshop.business_api.invocation')->call('basket.get_basket', $input);
```

### Implementing a Business API operation

To extend the Business API, you need to create a new service class.
The operations of that class contain the business logic respectively and are stored in `EshopBundle/Services/BusinessLayer/Operations/*`.

Each operation, e.g. basket, is a service which must be tagged in the following way:

``` xml
<service id="ses_eshop.basket.business_api" class="%ses_eshop.basket.business_api.class%" parent="ses_eshop.business_api.base">
   <argument type="service" id="silver_basket.basket_service" />
   <tag name="business_api_operation" alias="basket" />
</service>
```

!!! note

    The tag `name` must always be `business_api_operation`.

    The attribute `alias` defines the first part in the operation identifier.

    Derive your new service from the [common parent class `BaseOperation`](baseoperation/baseoperation.md)
    to get access to commonly needed dependencies (e.g. logging and translations).

### Overriding an existing Business API class

If you want to override a particular API service you need to create a new service class, which extends the original.
Within that class you can override individual methods or add new methods.
Then you need to redefine the service in the Symfony configuration with the new class and the same tag values (name and alias).

For example:

``` php
namespace Example\Bundle\ExtensionBundle\Services\BusinessLayer\Operations;

class NewBasketApi extends Silversolutions\Bundle\EshopBundle\Services\BusinessLayer\Operations\Basket
{
    public function newBasketOperation(InputBasketOperation $operationInput) {
        // process something
        // ..
        return new OutputBasketOperation(array('resultAttribute' => $result));
    }
    
    public function addProducts(InputAddItemToBasket $operationInput)
    {
        // override method logic
        // ..
        return new OutputAddItemToBasket(array('basket' => $basketObject));
    }
}
```

There are two ways to redefine the service configuration:

If the original service is defined with a configuration parameter (`%` notation) in its class attribute,
you need to redefine that parameter with a fully-qualified class name.

``` yaml
parameters:
    ses_eshop.basket.business_api.class: 'Example\Bundle\ExtensionBundle\Services\BusinessLayer\Operations\NewBasketApi'
```

The other option is to completely redefine the original service with a new fully-qualified class name.

``` xml
<service id="ses_eshop.basket.business_api" class="Example\Bundle\ExtensionBundle\Services\BusinessLayer\Operations\NewBasketApi" parent="ses_eshop.business_api.base">
   <argument type="service" id="silver_basket.basket_service" />
   <tag name="business_api_operation" alias="basket" />
</service>
```
