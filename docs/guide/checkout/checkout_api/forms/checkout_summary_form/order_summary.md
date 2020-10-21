# Order summary

Summary is the last step in the checkout process. In order to finish the process, the customer needs to accept terms and conditions.

## Forms

See [Checkout Summary Form](checkout_summary_form.md) for more information.

## Templates

|                              |           |
| ---------------------------- | --------- |
| Main template                | `vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/views/Checkout/checkout_summary.html.twig` |
| Sidebar template for summary | `vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/views/Checkout/sidebar_summary.html.twig`  |

## Terms and conditions

In [checkout summary form](checkout_summary_form.md) there is a field `termsAndConditions` which is rendered as a checkbox.

The texts for terms and conditions are stored as translatable text modules in the content model
(see `/Hidden-folder/Terms-Conditions-terms_conditions` in the Back Office).
This text module is a label in the form type and is fetched via `TransService`.

The customer must accept the terms and conditions to complete the order.

Terms and conditions content is loaded via Ajax. You can implement this functionality in the whole shop.

![](../../../../img/checkout_6.png)
