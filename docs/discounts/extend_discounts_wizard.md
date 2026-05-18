---
description: Integrate custom rules and conditions into the back office forms.
month_change: false
edition: commerce
---

# Extend Discounts wizard

## Introduction

For the store managers to use your [custom conditions and rules](extend_discounts.md#implement-custom-condition), you need to integrate them into the back office discounts creation form.

This form is built using [Symfony Forms]([[= symfony_doc=]]/forms.html) and the [`DiscountFormMapperInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html) interface is at the core of the implementation.

It provides a two-way mapping between the form structures (used to render the form) and the PHP API values used to create the discounts by offering methods related to:

- form rendering
- data structure mapping

Form rendering methods return objects implementing the [`DiscountDataInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Data-DiscountDataInterface.html), allowing you to access and modify the form data.
They include:

- [`createFormData()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html#method_createFormData) renders the form before the discount is created
- [`mapDiscountToFormData()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html#method_mapDiscountToFormData) renders the form when the discount already exists. It fills the discount edit form with the saved discount details

The data mapping methods are responsible for transforming the form data into structures compatible with the [Discount's PHP API](discounts_api.md) services like [`DiscountServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountServiceInterface.html) and [`DiscountCodeServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-DiscountsCodes-DiscountCodeServiceInterface.html).
They include:

- [`mapCreateDataToStruct()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html#method_mapCreateDataToStruct) creates the [`DiscountCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountCreateStruct.html) object to create the discount
- [`mapUpdateDataToStruct()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html#method_mapUpdateDataToStruct) creates the [`DiscountUpdateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountUpdateStruct.html) object to update the discount
- [`mapEditTranslateDataToStruct()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html#method_mapEditTranslateDataToStruct) creates the [`TranslationStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Value-Struct-DiscountTranslationStruct.html) objects for [translating the discounts](discounts_api.md#discount-translations)

In the UI, the discounts wizard consists of several steps:

- General properties
- Target group
- Products
- Conditions (only for Cart discounts)
- Discount value
- Summary

Each of these steps is represented by its own form mappers, data classes, and form types in the code.

In addition, the main form mapper and the form mappers responsible for each step in the wizard dispatch events that you can use to add your custom logic.
See [discount's form events](discounts_events.md#form-events) for a list of the available events.

## Integrate custom conditions

This example continues the [anniversary discount condition example](extend_discounts.md#implement-custom-condition), integrating the condition with the wizard by adding a dedicated step with condition options.
The example limits the new step to cart discounts only.

To add a custom step, create a value object representing the step.
It contains the step identifier, properties for storing form data, and extends the [`AbstractDiscountStep`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-Data-AbstractDiscountStep.html):

``` php
[[= include_file('code_samples/discounts/src/Discounts/Step/AnniversaryConditionStep.php') =]]
```

Then, create a new event listener listening to the [`CreateFormDataEvent` and `MapDiscountToFormDataEvent` events](discounts_events.md#form):

``` php hl_lines="18-19 26-50"
[[= include_file('code_samples/discounts/src/Discounts/Step/Step1/AnniversaryConditionStepEventSubscriber.php') =]]
```

Attaching the `addAnniversaryConditionStep()` method to both these events adds the custom step both in discount creation and edit forms.

The method first verifies if the form renders the cart discount wizard, according to assumptions of this example.

Then, it creates the `AnniversaryConditionStep` object.
If the discount existed already and is being edited, the saved values are used to populate the form.

Finally, the new step is added to the wizard using the `withStep()` method, using `45` as step priority.
Each of the existing form steps has its own priority, allowing you to add your custom steps between them.

| Step name | Priority |
|---| ---|
| General properties | 50|
| Target group | -20 |
| Products | -30 |
| Conditions | -40 |
| Discount value | -50 |
| Summary | -1000 |

The custom step is added between the "Conditions" and "Discount value"  steps.

To add form fields to it, create an event listener adding your fields and a custom form type:

``` php
[[= include_file('code_samples/discounts/src/Discounts/Step/AnniversaryConditionStepFormListener.php') =]]
```

``` php
[[= include_file('code_samples/discounts/src/Form/Type/AnniversaryConditionStepType.php') =]]
```

The new form step, including its form fields, are now part of the discounts wizard.

The last task is making sure that the form data is correctly saved by attaching it to the discounts API structs.

Expand the previously created `AnniversaryConditionStepEventSubscriber` to listen to two additional events:

- [`CreateDiscountCreateStructEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateDiscountCreateStructEvent.html)
- [`CreateDiscountUpdateStructEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Event-CreateDiscountUpdateStructEvent.html)

and add the `addStepDataToStruct()` method:

``` php hl_lines="23-24 57-70"
[[= include_file('code_samples/discounts/src/Discounts/Step/Step2/AnniversaryConditionStepEventSubscriber.php') =]]
```

When the form is submitted, this method extracts information whether the store manager enabled the anniversary discount in the form and adds the condition to make sure this data is properly saved.

The custom condition is now integrated with the discounts wizard and can be used by store managers to attract new customers.

## Integrate custom rules

This example continues the [purchasing power parity rule example](extend_discounts.md#implement-custom-rules), integrating the rule with the wizard.

First, create a new service implementing the `DiscountValueMapperInterface` interface, responsible for handling the new rule type:

``` php hl_lines="59-60"
[[= include_file('code_samples/discounts/src/Form/FormMapper/PurchasingPowerParityValueMapper.php') =]]
```

It uses an `PurchasingPowerParityValue` object to store the form data:

``` php
[[= include_file('code_samples/discounts/src/Form/Data/PurchasingPowerParityValue.php') =]]
```

This value mapper is used by a new form mapper, dedicated to the new rule type:

``` php
[[= include_file('code_samples/discounts/src/Form/FormMapper/PurchasingPowerParityFormMapper.php') =]]
```

Link them together when defining the services:

``` yaml
    App\Form\FormMapper\PurchasingPowerParityValueMapper: ~

    App\Form\FormMapper\PurchasingPowerParityFormMapper:
      arguments:
        $discountValueMapper: '@App\Form\FormMapper\PurchasingPowerParityValueMapper'
```

The [`DiscountFormMapperInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-DiscountFormMapperInterface.html) acts as a registry, finding a form mapper dedicated for given rule type and delegating to the responsibility of building the form.

As each rule type might have a different rule calculation logic, each rule must have a different "Discount value" step in the form.

To create it, create a dedicated class implementing the [`DiscountValueFormTypeMapperInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Discounts-Admin-Form-DiscountValueFormTypeMapperInterface.html)

``` php
[[= include_file('code_samples/discounts/src/Form/FormMapper/PurchasingPowerParityDiscountValueFormTypeMapper.php') =]]
```

and add a dedicated value type class:

``` php hl_lines="26-38 45-59 71"
[[= include_file('code_samples/discounts/src/Form/Type/DiscountValue/PurchasingPowerParityValueType.php') =]]
```

In the example above, the discount value step is used to display a read-only field with regions the discount is limited to.
The `$availableRegionHandler` callback function extracts the selected regions and modifies the form as needed, using the `FormEvents::PRE_SET_DATA` and `FormEvents::POST_SUBMIT` events.

The last step consists of providing all the required translations.
Specify them in `translations/ibexa_discount.en.yaml`:

``` yaml
ibexa.discount.type.purchasing_power_parity: Purchasing Power Parity
discount.rule_type.purchasing_power_parity: Purchasing Power Parity
```

The custom rule is now integrated with the discounts wizard and can be used by store managers to offer new discounts.
