# Discounts events

Events that are triggered when working with discounts.

Editions: Commerce

## Discount management

The events below are dispatched when managing [discounts](../../../discounts/discounts/index.md):

| Event                                                                                                                                                             | Dispatched by                                                                                                                                                                                     |
| ----------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [`Ibexa\Contracts\Discounts\Event\BeforeCreateDiscountEvent`](../../../../../../ibexa/discounts/src/contracts/Event/BeforeCreateDiscountEvent.php)   | [`DiscountServiceInterface::createDiscount()`](../../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php)   |
| [`Ibexa\Contracts\Discounts\Event\CreateDiscountEvent`](../../../../../../ibexa/discounts/src/contracts/Event/CreateDiscountEvent.php)               | [`DiscountServiceInterface::createDiscount()`](../../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php)   |
| [`Ibexa\Contracts\Discounts\Event\BeforeEnableDiscountEvent`](../../../../../../ibexa/discounts/src/contracts/Event/BeforeEnableDiscountEvent.php)   | [`DiscountServiceInterface::enableDiscount()`](../../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php)   |
| [`Ibexa\Contracts\Discounts\Event\EnableDiscountEvent`](../../../../../../ibexa/discounts/src/contracts/Event/EnableDiscountEvent.php)               | [`DiscountServiceInterface::enableDiscount()`](../../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php)   |
| [`Ibexa\Contracts\Discounts\Event\BeforeDisableDiscountEvent`](../../../../../../ibexa/discounts/src/contracts/Event/BeforeDisableDiscountEvent.php) | [`DiscountServiceInterface::disableDiscount()`](../../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php) |
| [`Ibexa\Contracts\Discounts\Event\DisableDiscountEvent`](../../../../../../ibexa/discounts/src/contracts/Event/DisableDiscountEvent.php)             | [`DiscountServiceInterface::disableDiscount()`](../../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php) |
| [`Ibexa\Contracts\Discounts\Event\BeforeDeleteDiscountEvent`](../../../../../../ibexa/discounts/src/contracts/Event/BeforeDeleteDiscountEvent.php)   | [`DiscountServiceInterface::deleteDiscount()`](../../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php)   |
| [`Ibexa\Contracts\Discounts\Event\DeleteDiscountEvent`](../../../../../../ibexa/discounts/src/contracts/Event/DeleteDiscountEvent.php)               | [`DiscountServiceInterface::deleteDiscount()`](../../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php)   |
| [`Ibexa\Contracts\Discounts\Event\BeforeUpdateDiscountEvent`](../../../../../../ibexa/discounts/src/contracts/Event/BeforeUpdateDiscountEvent.php)   | [`DiscountServiceInterface::updateDiscount()`](../../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php)   |
| [`Ibexa\Contracts\Discounts\Event\UpdateDiscountEvent`](../../../../../../ibexa/discounts/src/contracts/Event/UpdateDiscountEvent.php)               | [`DiscountServiceInterface::updateDiscount()`](../../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php)   |

## Form events

### Form

The events below allow you to [customize the discounts creation wizard](../../../discounts/extend_discounts_wizard/index.md).

| Event                                                                                                                                                                       | Dispatched by                                                                                                                                                                                                       |
| --------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [`Ibexa\Contracts\Discounts\Event\CreateDiscountCreateStructEvent`](../../../../../../ibexa/discounts/src/contracts/Event/CreateDiscountCreateStructEvent.php) | [`DiscountFormMapperInterface::mapCreateDataToStruct()`](../../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php) |
| [`Ibexa\Contracts\Discounts\Event\CreateDiscountUpdateStructEvent`](../../../../../../ibexa/discounts/src/contracts/Event/CreateDiscountUpdateStructEvent.php) | [`DiscountFormMapperInterface::mapUpdateDataToStruct()`](../../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php) |
| [`Ibexa\Contracts\Discounts\Event\CreateFormDataEvent`](../../../../../../ibexa/discounts/src/contracts/Event/CreateFormDataEvent.php)                         | [`DiscountFormMapperInterface::createFormData()`](../../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php)               |
| [`Ibexa\Contracts\Discounts\Event\MapDiscountToFormDataEvent`](../../../../../../ibexa/discounts/src/contracts/Event/MapDiscountToFormDataEvent.php)           | [`DiscountFormMapperInterface::mapDiscountToFormData()`](../../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php) |

### Form steps

The following events are dispatched when rendering each step of the discount wizard, allowing you to add new fields to it:

| Event                                                                                                                                                                  | Event name                                                                |
| ---------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------- |
| [`Ibexa\Contracts\Discounts\Event\Step\CreateFormDataEvent`](../../../../../../ibexa/discounts/src/contracts/Event/Step/CreateFormDataEvent.php)               | `ibexa.discounts.form_mapper.<step_identifier>.create_form_data`          |
| [`Ibexa\Contracts\Discounts\Event\Step\MapCreateDataToStructEvent`](../../../../../../ibexa/discounts/src/contracts/Event/Step/MapCreateDataToStructEvent.php) | `ibexa.discounts.form_mapper.<step_identifier>.map_create_data_to_struct` |
| [`Ibexa\Contracts\Discounts\Event\Step\MapDiscountToFormDataEvent`](../../../../../../ibexa/discounts/src/contracts/Event/Step/MapDiscountToFormDataEvent.php) | `ibexa.discounts.form_mapper.<step_identifier>.map_discount_to_form_data` |
| [`Ibexa\Contracts\Discounts\Event\Step\MapUpdateDataToStructEvent`](../../../../../../ibexa/discounts/src/contracts/Event/Step/MapUpdateDataToStructEvent.php) | `ibexa.discounts.form_mapper.<step_identifier>.map_update_data_to_struct` |

The event classes are shared between steps, but they are dispatched with different names. Each step form mapper dispatches its own set of events.

You can use the names specified above or generate them using the `createEventName` method, for example `CreateFormDataEvent::createEventName(GeneralPropertiesInterface::IDENTIFIER)` returns `ibexa.discounts.form_mapper.general_properties.create_form_data`.

| Form mapper                                                                                                                                                                              | Step identifier                                                                                                                                                                         |
| ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [`Ibexa\Contracts\Discounts\Admin\FormMapper\ConditionsMapperInterface`](../../../../../../ibexa/discounts/src/contracts/Admin/FormMapper/ConditionsMapperInterface.php)               | [`conditions`](../../../../../../ibexa/discounts/src/contracts/Admin/Form/Data/ConditionsInterface.php)                |
| [`Ibexa\Contracts\Discounts\Admin\FormMapper\GeneralPropertiesMapperInterface`](../../../../../../ibexa/discounts/src/contracts/Admin/FormMapper/GeneralPropertiesMapperInterface.php) | [`general_properties`](../../../../../../ibexa/discounts/src/contracts/Admin/Form/Data/GeneralPropertiesInterface.php) |
| [`Ibexa\Contracts\Discounts\Admin\FormMapper\ProductConditionsMapperInterface`](../../../../../../ibexa/discounts/src/contracts/Admin/FormMapper/ProductConditionsMapperInterface.php) | [`products`](../../../../../../ibexa/discounts/src/contracts/Admin/Form/Data/ProductConditionInterface.php)            |
| [`Ibexa\Contracts\Discounts\Admin\FormMapper\UserConditionsMapperInterface`](../../../../../../ibexa/discounts/src/contracts/Admin/FormMapper/UserConditionsMapperInterface.php)       | [`target_group`](../../../../../../ibexa/discounts/src/contracts/Admin/Form/Data/UserConditionInterface.php)           |

### Back office

These events are dispatched by the back office controllers after user chooses the "Save" action when creating or updating a discount.

| Event                                                                                                                                                                | Dispatched by                                                | Description                                                                    |
| -------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------ | ------------------------------------------------------------------------------ |
| [`Ibexa\Contracts\Discounts\Admin\Form\Event\PreDiscountCreateEvent`](../../../../../../ibexa/discounts/src/contracts/Admin/Form/Event/PreDiscountCreateEvent.php) | `Ibexa\Bundle\Discounts\Controller\DiscountCreateController` | Dispatched when the discount creation is finished in the back office form      |
| [`Ibexa\Contracts\Discounts\Admin\Form\Event\PreDiscountUpdateEvent`](../../../../../../ibexa/discounts/src/contracts/Admin/Form/Event/PreDiscountUpdateEvent.php) | `Ibexa\Bundle\Discounts\Controller\DiscountEditController`   | Dispatched when the discount modifications is finished in the back office form |

## Discount codes

The event below allows you to inject your custom logic before the discount code is applied to a product in cart:

| Event                                                                                                                                                                      | Dispatched by                                                        | Description                                              |
| -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------- | -------------------------------------------------------- |
| [`Ibexa\Contracts\DiscountsCodes\Event\BeforeDiscountCodeApplyEvent`](../../../../../../ibexa/discounts-codes/src/contracts/Event/BeforeDiscountCodeApplyEvent.php) | `Ibexa\Bundle\DiscountsCodes\Controller\REST\DiscountCodeController` | Dispatched before a discount code is applied in the cart |
