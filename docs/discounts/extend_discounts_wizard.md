---
description: Integrate custom rules and conditions into the back office forms.
editions: 
    - lts-update
    - commerce
month_change: true
---

## Extend Discounts wizard

To allow using your [custom conditions and rules](extend_discounts.md#create-custom-conditions) by the store managers, you need to integrate them into the back office discounts creation form.

The [`DiscountFormMapperInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html) is the service responsible for translating the form data into structures used by the PHP API.

The form uses a data driver approach, where the mapper provides all the data to the form and the form adjusts and creates the fields as neccessary.

It also provides a two-way mapping between the form structures (used to render the form) and the PHP API values used to create the discounts.

TODO: DiscountFormMapper zwraca obiekty typu DiscountDataInterface - i on jest kluczowy!

### Custom form steps

To add a custom step, create a new event listener listening to the [`CreateFormDataEvent` event](discounts_events.md#form).

``` php

```

And add the required data class:

``` php

```

Then, 


The following priorities are used in the system by default:

| Step name | Priority |
|---| ---|
| General properties | 50| 
| Target group | -20 |
| Products | -30 |
| Conditions | -40 |
| Discount value | -50 |
| Summary | -1000 |

### Condition

### Rules
