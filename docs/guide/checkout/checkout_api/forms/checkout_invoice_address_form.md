# Invoice address form

## Model class

`CheckoutInvoiceAddress` (`Siso\Bundle\CheckoutBundle\Form\CheckoutInvoiceAddress`)
extends `AbstractFormEntity` and implements `CheckoutAddressInterface`.

## Fields

|Name|Description|Assertions|
|--- |--- |--- |
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
|`invoiceSameAsDelivery`|`true` if the user wants to use this address as delivery address|boolean|
|`forceStep`|`true` if the user wants to force move to the next step with event errors|boolean|

## Configuration

The parameters are set in the [Configuration for Checkout Forms](configuration_for_checkout_forms.md).

## Form Type

`Siso\Bundle\CheckoutBundle\Form\Type\CheckoutInvoiceAddressType`
(service ID: `siso_checkout.form_entity.checkout_invoice_address_type`)
implements the setup for this form.

This class is defined as a service to take advantage of other services, such as `TransService`,
and to be able to read configuration settings.

!!! note 

    The scope of this service is set to `prototype`.
    A new instance of `CheckoutInvoiceAddressType` is created every time this service is called.

## Templates

|                              |        |
| ---------------------------- | -------|
| Main template                | `vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/views/Checkout/checkout_invoice_address.html.twig` |
| Sidebar template for invoice | `vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/views/Checkout/sidebar_invoice_address.html.twig`  |

### Exceptions in validation process for invoice

In some cases you need to suppress the form validation, for example
if the user has a customer number.
