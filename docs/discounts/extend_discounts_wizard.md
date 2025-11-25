---
description: Integrate custom rules and conditions into the back office forms.
editions: 
    - lts-update
    - commerce
month_change: true
---

# Extend Discounts wizard

To allow the store managers to use your [custom conditions and rules](extend_discounts.md#create-custom-conditions), you need to integrate them into the back office discounts creation form.

The form is built using [Symfony Forms]([[= symfony_doc=]]/forms.html) and the [`DiscountFormMapperInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html) is the core of the implementation.

It also provides a two-way mapping between the form structures (used to render the form) and the PHP API values used to create the discounts. 
It offers methods related to:

- form rendering 
- data structure mapping

Form rendering methods return objects implementing the [`DiscountDataInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Data-DiscountDataInterface.html), allowing you to access and modify the form data.
They include:

- [`createFormData()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html#method_createFormData) renders the form before the discount exists
- [`mapDiscountToFormData()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html#method_mapDiscountToFormData) renders the form when the discount already exists. It fills the discount edit form with the saved discount details.

The data mapping methods are responsible for transforming the form data into structures compatible to use with the [Discount's PHP API](discounts_api.md). They include:

- [`mapCreateDataToStruct()`]
- [`mapEditTranslateDataToStruct()`]
- [`mapUpdateDataToStruct()`]


The `mapCreateDataToStruct()`, `DiscountFormMapperInterface::mapEditTranslateDataToStruct()`, and `mapUpdateDataToStruct()`

Form mappers attached both to the whole wizard and to each step in it emit [events](discounts_events.md#forms), allowing you to customize their behavior.

### Custom form steps

To add a custom step, create a new event listener listening to the [`CreateFormDataEvent` event](discounts_events.md#form).
The example below adds a new step to the cart discount wizard.

``` php

```

Each of the existing form steps has a constant priority, allowing you to add your custom step between them.

| Step name | Priority |
|---| ---|
| General properties | 50| 
| Target group | -20 |
| Products | -30 |
| Conditions | -40 |
| Discount value | -50 |
| Summary | -1000 |

The priority of `-45` causes the custom step to be rendered between the "Conditions" and "Discount value"  steps.

Add the required data class:

``` php

```

Then, add a form mapper 

And a form type dedicated for the created data class:


The following priorities are used in the system by default:

### Custom condition

### Custom rules
