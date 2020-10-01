# Interfaces for checkout services

## CheckoutFormServiceInterface

`CheckoutFormServiceInterface` (`Silversolutions\Bundle\EshopBundle\Service\CheckoutFormServiceInterface`)
is an interface for checkout forms which defines a common way to prefill the form and store the data in basket.

|Method|Parameters|Usage|
|--- |--- |--- |
|`storeFormDataInBasket`|`FormEntityInterface $form`</br>`Basket $basket`|Used to persist the form data in basket|
|`prefillForm`|`FormEntityInterface $form`</br>`Basket $basket`|Used to prefill the form with data|

## CheckoutSummaryFormServiceInterface

`CheckoutSummaryFormServiceInterface` (`Silversolutions\Bundle\EshopBundle\Service\CheckoutSummaryFormServiceInterface`)
is an interface for checkout summary forms that handles getting the user confirmation email.

|Method|Parameters|Usage|
|--- |--- |--- |
|`getCustomerEmailForOrderConfirmation`|`Basket $basket`|Gets the user confirmation email|
|`getSalesEmailForOrderConfirmation`|`Basket $basket`|Gets the confirmation email address for the sales contact|


## CheckoutAddressFormServiceInterface

`CheckoutAddressFormServiceInterface` (`Silversolutions\Bundle\EshopBundle\Service\CheckoutAddressFormServiceInterface`)
is an interface for checkout forms that handles addresses and defines a way to convert form data into a party and back.

|Method|Parameters|Usage|
|--- |--- |--- |
|`convertFormDataToParty`|`CheckoutAddressInterface $form`|Converts the form data into a party|
|`convertPartyToFormData`|`Party $party`</br>`CheckoutAddressInterface $form = null`|Converts party data into the form|
