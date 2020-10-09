# Checkout summary form

`CheckoutSummary` (`\Siso\Bundle\CheckoutBundle\Form\CheckoutSummary`)
extends `AbstractFormEntity`
and manages the HTML form for order summary in checkout process.

## Fields

|Name|Description|Assertions|
|--- |--- |--- |
|`termsAndConditions`|"Terms and conditions" Checkbox field|boolean</br>not blank|
|`comment`|Optional user comment/remark|string</br>length, max = 255|
|`forceStep`|`true` if the user wants to force moving to next step with event errors|boolean|

## Configuration

See [Configuration for Checkout Forms](../configuration_for_checkout_forms.md).

## Form Type

`\Siso\Bundle\CheckoutBundle\Form\Type\CheckoutSummaryType`
(service ID: `siso_checkout.form_entity.checkout_summary_type`)
implements the setup for this form.

This class is defined as a service to take advantage of other services, such as `TransService`,
and to be able to read configuration settings.

!!! note

    The scope of this service is set to `prototype`.
    A new instance of  `Siso\Bundle\CheckoutBundle\Form\Type\CheckoutSummaryType` is created every time this service is called.

### Select values configuration

More configuration values are set in the config file `checkout.yml`.
