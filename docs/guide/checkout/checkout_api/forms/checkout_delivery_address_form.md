# Delivery address form [[% include 'snippets/commerce_badge.md' %]]

## Model class

`CheckoutDeliveryAddress` (`Ibexa\Platform\Commerce\Checkout\Form\CheckoutDeliveryAddress`)
extends `AbstractFormEntity` and implements `CheckoutAddressInterface`.
It manages the form for choosing delivery address in checkout process.

## Fields

|Name|Description|Assertions|
|--- |--- |--- |
|`addressStatus`|Status of the delivery address||
|`company`|User or company name|not blank</br>min = 2</br>max = 30|
|`companySecond`|Second name|min = 2</br>max = 30|
|`street`|Street name|not blank</br>min = 2</br>max = 30|
|`addressSecond`|Optional second address|min = 2</br>max = 30|
|`zip`|ZIP number|not blank (excluding Ireland)</br>min = 3</br>max = 20</br>mumeric|
|`city`|City name|not blank</br>min = 2</br>max = 30|
|`country`|Country name|not blank|
|`county`|County name|min = 2</br>max = 30|
|`phone`|Phone number|`SesAssert\Phone`|
|`email`|Email address|`SesAssert\Email`|
|`saveAddress`|`true` if the user wants to store this address in their address list|boolean|
|`partyId`|Party ID in ERP system|string|
|`forceStep`|`true` if the user wants to force moving to the next step with event errors|boolean|

## Form Type

`Ibexa\Platform\Commerce\Checkout\Form\TypeCheckoutDeliveryAddressType`
(service ID: `siso_checkout.form_entity.checkout_delivery_address_type`)
implements the setup for this form.

This class is defined as a service to take advantage of other services, such as `TransService`,
and to be able to read configuration settings.

!!! note

    The scope of this service is set to `prototype`.
    A new instance of `CheckoutDeliveryAddressType` is created every time this service is called.

## Configuration

You set the parameters in the [configuration for checkout forms](configuration_for_checkout_forms.md).

## Templates

|                              |        |
| ---------------------------- | ------ |
| Main template                | `EshopBundle/Resources/views/Checkout/checkout_delivery_address.html.twig` |
| Sidebar template for invoice | `EshopBundle/Resources/views/Checkout/sidebar_delivery_address.html.twig`  |

## Exceptions in validation process for delivery

In some cases you need to suppress the form validation, for example:

- If the user has a customer number and uses invoice as delivery.
- If the user has a customer number and uses an address from a list.

In these cases the data comes from the ERP and the user cannot change it.
