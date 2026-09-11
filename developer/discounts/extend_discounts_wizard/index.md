# Extend Discounts wizard

Integrate custom rules and conditions into the back office forms.

Editions: Commerce

## Introduction

For the store managers to use your [custom conditions and rules](../extend_discounts/index.md#implement-custom-condition), you need to integrate them into the back office discounts creation form.

This form is built using [Symfony Forms](https://symfony.com/doc/7.4/forms.html) and the [`Ibexa\Contracts\Discounts\DiscountFormMapperInterface`](../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php) interface is at the core of the implementation.

It provides a two-way mapping between the form structures (used to render the form) and the PHP API values used to create the discounts by offering methods related to:

- form rendering
- data structure mapping

Form rendering methods return objects implementing the [`Ibexa\Contracts\Discounts\Admin\Form\Data\DiscountDataInterface`](../../../../../ibexa/discounts/src/contracts/Admin/Form/Data/DiscountDataInterface.php), allowing you to access and modify the form data. They include:

- [`createFormData()`](../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php) renders the form before the discount is created
- [`mapDiscountToFormData()`](../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php) renders the form when the discount already exists. It fills the discount edit form with the saved discount details

The data mapping methods are responsible for transforming the form data into structures compatible with the [Discount's PHP API](../discounts_api/index.md) services like [`Ibexa\Contracts\Discounts\DiscountServiceInterface`](../../../../../ibexa/discounts/src/contracts/DiscountServiceInterface.php) and [`Ibexa\Contracts\DiscountsCodes\DiscountCodeServiceInterface`](../../../../../ibexa/discounts-codes/src/contracts/DiscountCodeServiceInterface.php). They include:

- [`mapCreateDataToStruct()`](../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php) creates the [`Ibexa\Contracts\Discounts\Value\Struct\DiscountCreateStruct`](../../../../../ibexa/discounts/src/contracts/Value/Struct/DiscountCreateStruct.php) object to create the discount
- [`mapUpdateDataToStruct()`](../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php) creates the [`Ibexa\Contracts\Discounts\Value\Struct\DiscountUpdateStruct`](../../../../../ibexa/discounts/src/contracts/Value/Struct/DiscountUpdateStruct.php) object to update the discount
- [`mapEditTranslateDataToStruct()`](../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php) creates the [`TranslationStruct`](../../../../../ibexa/discounts/src/contracts/Value/Struct/DiscountTranslationStruct.php) objects for [translating the discounts](../discounts_api/index.md#discount-translations)

In the UI, the discounts wizard consists of several steps:

- General properties
- Target group
- Products
- Conditions (only for Cart discounts)
- Discount value
- Summary

Each of these steps is represented by its own form mappers, data classes, and form types in the code.

In addition, the main form mapper and the form mappers responsible for each step in the wizard dispatch events that you can use to add your custom logic. See [discount's form events](../../api/event_reference/discounts_events/index.md#form-events) for a list of the available events.

## Integrate custom conditions

This example continues the [anniversary discount condition example](../extend_discounts/index.md#implement-custom-condition), integrating the condition with the wizard by adding a dedicated step with condition options. The example limits the new step to cart discounts only.

To add a custom step, create a value object representing the step. It contains the step identifier, properties for storing form data, and extends the [`Ibexa\Contracts\Discounts\Admin\Form\Data\AbstractDiscountStep`](../../../../../ibexa/discounts/src/contracts/Admin/Form/Data/AbstractDiscountStep.php):

```php
<?php declare(strict_types=1);

namespace App\Discounts\Step;

use Ibexa\Contracts\Discounts\Admin\Form\Data\AbstractDiscountStep;

final class AnniversaryConditionStep extends AbstractDiscountStep
{
    public const string IDENTIFIER = 'anniversary_condition_step';

    public function __construct(public bool $enabled = false, public int $tolerance = 0)
    {
    }
}
```

Then, create a new event listener listening to the [`CreateFormDataEvent` and `MapDiscountToFormDataEvent` events](../../api/event_reference/discounts_events/index.md#form):

```php
<?php
declare(strict_types=1);

namespace App\Discounts\Step;

use App\Discounts\Condition\IsAccountAnniversary;
use Ibexa\Contracts\Discounts\Event\CreateFormDataEvent;
use Ibexa\Contracts\Discounts\Event\MapDiscountToFormDataEvent;
use Ibexa\Contracts\Discounts\Value\DiscountType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class AnniversaryConditionStepEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            CreateFormDataEvent::class => 'addAnniversaryConditionStep',
            MapDiscountToFormDataEvent::class => 'addAnniversaryConditionStep',
        ];
    }

    /**
     * @param \Ibexa\Contracts\Discounts\Event\CreateFormDataEvent|\Ibexa\Contracts\Discounts\Event\MapDiscountToFormDataEvent $event
     */
    public function addAnniversaryConditionStep(Event $event): void
    {
        $data = $event->getData();
        if ($data->getType() !== DiscountType::CART) {
            return;
        }

        /** @var \App\Discounts\Condition\IsAccountAnniversary $discount */
        $discount = $event instanceof MapDiscountToFormDataEvent ?
                    $event->getDiscount()->getConditionByIdentifier(IsAccountAnniversary::IDENTIFIER) :
                    null;

        $conditionStep = $discount !== null ?
                        new AnniversaryConditionStep(true, $discount->getTolerance()) :
                        new AnniversaryConditionStep();

        $event->setData(
            $event->getData()->withStep(
                $conditionStep,
                AnniversaryConditionStep::IDENTIFIER,
                'Anniversary Condition',
                -45 // Priority
            )
        );
    }
}
```

Attaching the `addAnniversaryConditionStep()` method to both these events adds the custom step both in discount creation and edit forms.

The method first verifies if the form renders the cart discount wizard, according to assumptions of this example.

Then, it creates the `AnniversaryConditionStep` object. If the discount existed already and is being edited, the saved values are used to populate the form.

Finally, the new step is added to the wizard using the `withStep()` method, using `45` as step priority. Each of the existing form steps has its own priority, allowing you to add your custom steps between them.

| Step name          | Priority |
| ------------------ | -------- |
| General properties | 50       |
| Target group       | -20      |
| Products           | -30      |
| Conditions         | -40      |
| Discount value     | -50      |
| Summary            | -1000    |

The custom step is added between the "Conditions" and "Discount value" steps.

To add form fields to it, create an event listener adding your fields and a custom form type:

```php
<?php declare(strict_types=1);

namespace App\Discounts\Step;

use App\Form\Type\AnniversaryConditionStepType;
use Ibexa\Contracts\Discounts\Admin\Form\Data\DiscountStepData;
use Ibexa\Contracts\Discounts\Admin\Form\Listener\AbstractStepFormListener;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\FormInterface;

final class AnniversaryConditionStepFormListener extends AbstractStepFormListener implements TranslationContainerInterface
{
    public function isDataSupported(DiscountStepData $data): bool
    {
        return $data->getStepData() instanceof AnniversaryConditionStep;
    }

    public function addFields(FormInterface $form, DiscountStepData $data, PreSetDataEvent $event): void
    {
        $form->add(
            'stepData',
            AnniversaryConditionStepType::class,
            [
                'label' => false,
            ]
        );
    }

    public static function getTranslationMessages(): array
    {
        return [
            (new Message('discount.step.custom.label', 'discount'))->setDesc('Custom'),
        ];
    }
}
```

```php
<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Discounts\Step\AnniversaryConditionStep;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends \Symfony\Component\Form\AbstractType<AnniversaryConditionStep>
 */
final class AnniversaryConditionStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'enabled',
            CheckboxType::class,
            [
                'label' => 'Enable anniversary discount',
                'required' => false,
            ]
        )->add(
            'tolerance',
            NumberType::class,
            [
                'label' => 'Tolerance in days',
                'required' => false,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnniversaryConditionStep::class,
        ]);
    }
}
```

The new form step, including its form fields, are now part of the discounts wizard.

The last task is making sure that the form data is correctly saved by attaching it to the discounts API structs.

Expand the previously created `AnniversaryConditionStepEventSubscriber` to listen to two additional events:

- [`Ibexa\Contracts\Discounts\Event\CreateDiscountCreateStructEvent`](../../../../../ibexa/discounts/src/contracts/Event/CreateDiscountCreateStructEvent.php)
- [`Ibexa\Contracts\Discounts\Event\CreateDiscountUpdateStructEvent`](../../../../../ibexa/discounts/src/contracts/Event/CreateDiscountUpdateStructEvent.php)

and add the `addStepDataToStruct()` method:

```php
<?php
declare(strict_types=1);

namespace App\Discounts\Step;

use App\Discounts\Condition\IsAccountAnniversary;
use Ibexa\Contracts\Discounts\Event\CreateDiscountCreateStructEvent;
use Ibexa\Contracts\Discounts\Event\CreateDiscountUpdateStructEvent;
use Ibexa\Contracts\Discounts\Event\CreateFormDataEvent;
use Ibexa\Contracts\Discounts\Event\DiscountStructEventInterface;
use Ibexa\Contracts\Discounts\Event\MapDiscountToFormDataEvent;
use Ibexa\Contracts\Discounts\Value\DiscountType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class AnniversaryConditionStepEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            CreateFormDataEvent::class => 'addAnniversaryConditionStep',
            MapDiscountToFormDataEvent::class => 'addAnniversaryConditionStep',
            CreateDiscountCreateStructEvent::class => 'addStepDataToStruct',
            CreateDiscountUpdateStructEvent::class => 'addStepDataToStruct',
        ];
    }

    /**
     * @param \Ibexa\Contracts\Discounts\Event\CreateFormDataEvent|\Ibexa\Contracts\Discounts\Event\MapDiscountToFormDataEvent $event
     */
    public function addAnniversaryConditionStep(Event $event): void
    {
        $data = $event->getData();
        if ($data->getType() !== DiscountType::CART) {
            return;
        }

        /** @var \App\Discounts\Condition\IsAccountAnniversary $discount */
        $discount = $event instanceof MapDiscountToFormDataEvent ?
                    $event->getDiscount()->getConditionByIdentifier(IsAccountAnniversary::IDENTIFIER) :
                    null;

        $conditionStep = $discount !== null ?
                        new AnniversaryConditionStep(true, $discount->getTolerance()) :
                        new AnniversaryConditionStep();

        $event->setData(
            $event->getData()->withStep(
                $conditionStep,
                AnniversaryConditionStep::IDENTIFIER,
                'Anniversary Condition',
                -45 // Priority
            )
        );
    }

    public function addStepDataToStruct(DiscountStructEventInterface $event): void
    {
        /** @var AnniversaryConditionStep $stepData */
        $stepData = $event
                        ->getData()
                        ->getStepByIdentifier(AnniversaryConditionStep::IDENTIFIER)?->getStepData();

        if ($stepData === null || !$stepData->enabled) {
            return;
        }

        $discountStruct = $event->getStruct();
        $discountStruct->addCondition(new IsAccountAnniversary($stepData->tolerance));
    }
}
```

When the form is submitted, this method extracts information whether the store manager enabled the anniversary discount in the form and adds the condition to make sure this data is properly saved.

The custom condition is now integrated with the discounts wizard and can be used by store managers to attract new customers.

## Integrate custom rules

This example continues the [purchasing power parity rule example](../extend_discounts/index.md#implement-custom-rules), integrating the rule with the wizard.

First, create a new service implementing the `DiscountValueMapperInterface` interface, responsible for handling the new rule type:

```php
<?php declare(strict_types=1);

namespace App\Form\FormMapper;

use App\Discounts\Rule\PurchasingPowerParityRule;
use App\Form\Data\PurchasingPowerParityValue;
use Ibexa\Contracts\Discounts\Admin\Form\Data\DiscountValueInterface;
use Ibexa\Contracts\Discounts\Admin\FormMapper\DiscountValueMapperInterface;
use Ibexa\Contracts\Discounts\Value\DiscountInterface;
use Ibexa\Contracts\Discounts\Value\Struct\DiscountCreateStruct;
use Ibexa\Contracts\Discounts\Value\Struct\DiscountUpdateStruct;
use LogicException;

final class PurchasingPowerParityValueMapper implements DiscountValueMapperInterface
{
    public function createFormData(string $type, string $ruleType): DiscountValueInterface
    {
        if ($ruleType !== PurchasingPowerParityRule::TYPE) {
            throw new LogicException('Not implemented');
        }

        return new PurchasingPowerParityValue();
    }

    public function mapDiscountToFormData(DiscountInterface $discount): DiscountValueInterface
    {
        $discountRule = $discount->getRule();
        if (!$discountRule instanceof PurchasingPowerParityRule) {
            throw new LogicException('Not implemented');
        }

        return new PurchasingPowerParityValue();
    }

    public function mapCreateDataToStruct(
        DiscountValueInterface $data,
        DiscountCreateStruct $struct
    ): void {
        $this->addRuleToStruct($data, $struct);
    }

    public function mapUpdateDataToStruct(
        DiscountInterface $discount,
        DiscountValueInterface $data,
        DiscountUpdateStruct $struct
    ): void {
        $this->addRuleToStruct($data, $struct);
    }

    /**
     * @param \Ibexa\Contracts\Discounts\Value\Struct\DiscountCreateStruct|\Ibexa\Contracts\Discounts\Value\Struct\DiscountUpdateStruct $struct
     */
    private function addRuleToStruct(DiscountValueInterface $data, $struct): void
    {
        if (!$data instanceof PurchasingPowerParityValue) {
            throw new LogicException('Not implemented');
        }

        $rule = new PurchasingPowerParityRule();
        $struct->setRule($rule);
    }
}
```

It uses an `PurchasingPowerParityValue` object to store the form data:

```php
<?php declare(strict_types=1);

namespace App\Form\Data;

use Ibexa\Contracts\Discounts\Admin\Form\Data\AbstractDiscountValue;

final class PurchasingPowerParityValue extends AbstractDiscountValue
{
    public string $value;
}
```

This value mapper is used by a new form mapper, dedicated to the new rule type:

```php
<?php declare(strict_types=1);

namespace App\Form\FormMapper;

use App\Discounts\Rule\PurchasingPowerParityRule;
use Ibexa\Bundle\Discounts\Form\FormMapper\AbstractFormMapper;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

final class PurchasingPowerParityFormMapper extends AbstractFormMapper implements TranslationContainerInterface
{
    public function getDiscountRuleTypes(?string $type): array
    {
        return [PurchasingPowerParityRule::TYPE];
    }

    public function supports(string $type, string $ruleType): bool
    {
        return $ruleType === PurchasingPowerParityRule::TYPE;
    }

    public static function getTranslationMessages(): array
    {
        return [
            Message::create(
                sprintf('%s.%s', self::TRANSLATION_PREFIX, PurchasingPowerParityRule::TYPE),
                'ibexa_discounts',
            )->setDesc('Regional'),
        ];
    }
}
```

Link them together when defining the services:

```yaml
    App\Form\FormMapper\PurchasingPowerParityValueMapper: ~

    App\Form\FormMapper\PurchasingPowerParityFormMapper:
      arguments:
        $discountValueMapper: '@App\Form\FormMapper\PurchasingPowerParityValueMapper'
```

The [`Ibexa\Contracts\Discounts\DiscountFormMapperInterface`](../../../../../ibexa/discounts/src/contracts/DiscountFormMapperInterface.php) acts as a registry, finding a form mapper dedicated for given rule type and delegating to the responsibility of building the form.

As each rule type might have a different rule calculation logic, each rule must have a different "Discount value" step in the form.

To create it, create a dedicated class implementing the [`Ibexa\Contracts\Discounts\Admin\Form\DiscountValueFormTypeMapperInterface`](../../../../../ibexa/discounts/src/contracts/Admin/Form/DiscountValueFormTypeMapperInterface.php)

```php
<?php declare(strict_types=1);

namespace App\Form\FormMapper;

use App\Form\Data\PurchasingPowerParityValue;
use App\Form\Type\DiscountValue\PurchasingPowerParityValueType;
use Ibexa\Contracts\Discounts\Admin\Form\Data\DiscountValueInterface;
use Ibexa\Contracts\Discounts\Admin\Form\DiscountValueFormTypeMapperInterface;

final class PurchasingPowerParityDiscountValueFormTypeMapper implements DiscountValueFormTypeMapperInterface
{
    public function hasFormTypeForData(DiscountValueInterface $data): bool
    {
        return $data instanceof PurchasingPowerParityValue;
    }

    public function getFormTypeForData(DiscountValueInterface $data): ?string
    {
        return $data instanceof PurchasingPowerParityValue ? PurchasingPowerParityValueType::class : null;
    }

    public function getFormTypeOptionsForData(DiscountValueInterface $data): array
    {
        return [];
    }
}
```

and add a dedicated value type class:

```php
<?php
declare(strict_types=1);

namespace App\Form\Type\DiscountValue;

use App\Form\Data\PurchasingPowerParityValue;
use Ibexa\Bundle\Discounts\Form\Type\DiscountValueType;
use Ibexa\Contracts\ProductCatalog\Values\RegionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends \Symfony\Component\Form\AbstractType<\App\Form\Data\PurchasingPowerParityValue>
 */
final class PurchasingPowerParityValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $availableRegionHandler = static function (FormInterface $form, PurchasingPowerParityValue $data): void {
            $regions = $data->getDiscountData()->getGeneralProperties()->getRegions();
            $regionNames = implode(', ', array_map(static fn (RegionInterface $region): string => $region->getIdentifier(), $regions));

            $options = [
                'required' => false,
                'disabled' => true,
                'label' => 'This discount applies to the following regions',
                'data' => $regionNames,
            ];

            $form->add('value', TextType::class, $options);
        };

        $builder->add('type', FormType::class, [
            'mapped' => false,
            'label' => false,
        ]);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            static function (PreSetDataEvent $event) use ($availableRegionHandler): void {
                $form = $event->getForm();
                $availableRegionHandler($form, $event->getData());
            },
        );
        $builder->get('type')->addEventListener(
            FormEvents::POST_SUBMIT,
            static function (PostSubmitEvent $event) use ($availableRegionHandler): void {
                $form = $event->getForm()->getParent();
                assert($form !== null);
                $availableRegionHandler($form, $form->getData());
            },
        );
    }

    #[\Override]
    public function getParent(): string
    {
        return DiscountValueType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PurchasingPowerParityValue::class,
        ]);
    }
}
```

In the example above, the discount value step is used to display a read-only field with regions the discount is limited to. The `$availableRegionHandler` callback function extracts the selected regions and modifies the form as needed, using the `FormEvents::PRE_SET_DATA` and `FormEvents::POST_SUBMIT` events.

The last step consists of providing all the required translations. Specify them in `translations/ibexa_discount.en.yaml`:

```yaml
ibexa.discount.type.purchasing_power_parity: Purchasing Power Parity
discount.rule_type.purchasing_power_parity: Purchasing Power Parity
```

The custom rule is now integrated with the discounts wizard and can be used by store managers to offer new discounts.
