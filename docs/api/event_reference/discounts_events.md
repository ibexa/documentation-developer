---
description: Events that are triggered when working with discounts.
page_type: reference
editions:
    - lts-update
    - commerce
month_change: true
---

# Discounts events

## Discount management

The events below are dispatched when managing [discounts](discounts_guide.md):

| Event | Dispatched by |
|---|---|
|[BeforeCreateDiscountEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-BeforeCreateDiscountEvent.html)| [DiscountServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html)
|[CreateDiscountEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateDiscountEvent.html)| [DiscountServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html)
|[BeforeDeleteDiscountEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-BeforeDeleteDiscountEvent.html)| [DiscountServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html)
|[DeleteDiscountEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-DeleteDiscountEvent.html)| [DiscountServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html)
|[BeforeUpdateDiscountEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-BeforeUpdateDiscountEvent.html)| [DiscountServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html)|
|[UpdateDiscountEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-UpdateDiscountEvent.html)| [DiscountServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html)|

## Form events

### Form

The events below allow you to customize the discounts creation wizard:

| Event | Dispatched by |
|---|---|
|[CreateDiscountCreateStructEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateDiscountCreateStructEvent.html) | [DiscountFormMapperInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html)|
|[CreateDiscountUpdateStructEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateDiscountUpdateStructEvent.html) | [DiscountFormMapperInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html)|
|[CreateFormDataEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateFormDataEvent.html) | [DiscountFormMapperInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html)|
|[MapDiscountToFormDataEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-MapDiscountToFormDataEvent.html) | [DiscountFormMapperInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html) |

### Form steps

The following events are dispatched when rendering each step of the discount wizard, allowing you to add new fields to it:

| Event | Event name |
|---|---|
|[CreateFormDataEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-Step-CreateFormDataEvent.html)| `ibexa.discounts.form_mapper.<step_identifier>.create_form_data`|
|[MapCreateDataToStructEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-Step-MapCreateDataToStructEvent.html)|`ibexa.discounts.form_mapper.<step_identifier>.map_create_data_to_struct`|
|[MapDiscountToFormDataEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-Step-MapDiscountToFormDataEvent.html)| `ibexa.discounts.form_mapper.<step_identifier>.map_discount_to_form_data`|
|[MapUpdateDataToStructEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-Step-MapUpdateDataToStructEvent.html)|`ibexa.discounts.form_mapper.<step_identifier>.map_update_data_to_struct `|

The event classes are shared between steps, but they are dispatched with different names.
Each step form mapper dispatches its own set of events.

| Form mapper | Step identifier |
|---|---|
| [ConditionsMapperInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-ConditionsMapperInterface.html)| [`conditions`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Data-ConditionsInterface.html#constant_IDENTIFIER) |
| [GeneralPropertiesMapperInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-GeneralPropertiesMapperInterface.html)| [`general_properties`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Data-GeneralPropertiesInterface.html#constant_IDENTIFIER) |
| [ProductConditionsMapperInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-ProductConditionsMapperInterface.html)| [`products`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Data-ProductConditionInterface.html#constant_IDENTIFIER) |
| [UserConditionsMapperInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-FormMapper-UserConditionsMapperInterface.html)| [`target_group`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Data-UserConditionInterface.html#constant_IDENTIFIER) |

### Back office

These events are dispatched by the back office controllers after user chooses the "Save" action when creating or updating a discount.

| Event | Dispatched by | Description |
|---|---|---|
[PreDiscountCreateEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Event-PreDiscountCreateEvent.html) | `Ibexa\Bundle\Discounts\Controller\DiscountCreateController` | Dispatched when the discount creation is finished in the back office form |
[PreDiscountUpdateEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Event-PreDiscountUpdateEvent.html) | `Ibexa\Bundle\Discounts\Controller\DiscountEditController` | Dispatched when the discount modifications is finished in the back office form |

## Discount codes

The event below allows you to inject your custom logic before the discount code is applied to a product in cart:

| Event | Dispatched by | Description |
|---|---|---|
|[BeforeDiscountCodeApplyEvent](/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-Event-BeforeDiscountCodeApplyEvent.html)|`Ibexa\Bundle\DiscountsCodes\Controller\REST\DiscountCodeController`| Dispatched before a discount code is applied in the cart |
