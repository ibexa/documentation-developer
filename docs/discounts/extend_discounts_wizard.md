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

The form uses a data driver approach, where the mapper provides all the data to the form and the form adjusts and created the fields as neccessary.

### Condition

### Rules
