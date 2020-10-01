# Restricting payment options

To restrict payment options, first you need to override the checkout service in your project and define it in `service.xml`.

``` xml
<parameter key="siso_checkout.form_entity.checkout_shipping_payment_type.class">MyCustomer\ProjectBundle\Form\Type\CheckoutShippingPaymentType</parameter>
 
<!-- checkout shipping payment type -->
<service id="siso_checkout.form_entity.checkout_shipping_payment_type" class="%siso_checkout.form_entity.checkout_shipping_payment_type.class%" scope="prototype">
    <call method="setFormsValues">
        <argument>%ses_forms.checkout_values%</argument>
    </call>
    <call method="setServices">
        <argument type="service" id="silver_trans.translator" />
        <argument type="service" id="ses.customer_profile_data.ez_erp" />
    </call>
</service>
```

In the service, restrict building the form. In this example you do not offer invoice payment to blocked customers.

In `CheckoutShippingPaymentType`:

``` php
public function buildForm(FormBuilderInterface $builder, array $options)
{
    $shippingMethods =  isset($this->formsValues['shippingMethods'])
        ? $this->formsValues['shippingMethods'] : array();

    $paymentMethods =  isset($this->formsValues['paymentMethods'])
        ? $this->formsValues['paymentMethods'] : array();

    // restrict payment for blocked customers
    $buyerParty =  $this->customerProfileDataService->getDefaultBuyerParty();
    if(isset($buyerParty->SesExtension->value['Blocked']) &&
        $buyerParty->SesExtension->value['Blocked'] != self::CUSTOMER_ACTIVE) {
        unset($paymentMethods[self::PAYMENT_INVOICE]);
    }
```
