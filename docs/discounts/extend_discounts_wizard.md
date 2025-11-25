---
description: Integrate custom rules and conditions into the back office forms.
editions: 
    - lts-update
    - commerce
month_change: true
---

# Extend Discounts wizard

To allow using your [custom conditions and rules](extend_discounts.md#create-custom-conditions) by the store managers, you need to integrate them into the back office discounts creation form.

The [`DiscountFormMapperInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html) is the service responsible for translating the form data into structures used by the PHP API.

The form uses a data driven approach, where the mapper provides all the data to the form and the form creates the fields.

It also provides a two-way mapping between the form structures (used to render the form) and the PHP API values used to create the discounts.

The `DiscountFormMapperInterface::createFormData()` and `DiscountFormMapperInterface::publicmapDiscountToFormData()` methods return objects implementing the [`DiscountDataInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Data-DiscountDataInterface.html), allowing you to access the form data.

The `DiscountFormMapperInterface::mapCreateDataToStruct()`, `DiscountFormMapperInterface::mapEditTranslateDataToStruct()`, and `mapUpdateDataToStruct()`

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



### Condition

### Rules
