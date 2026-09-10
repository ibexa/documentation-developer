# Customize checkout

Customize the existing checkout functionality to support additional functions.

Editions: Commerce

When you work with your Commerce implementation, you can review and modify the checkout configuration.

Checkout is an essential component of the Commerce offering. It collects data that is necessary to create an order, including:

- payment method
- shipping method
- billing / delivery address

It could also collect any other information that you find necessary.

Depending on your needs, the checkout process can be either complex or straightforward. For example, if the website is selling airline tickets, you may need several [additional steps](#add-checkout-step) with passengers defining their special needs. On the other side of the spectrum would be a store that sells books with personal pickup, where [one page checkout](#create-a-one-page-checkout) would be enough.

Several factors make checkout particularly flexible and customizable:

- it's based on Symfony workflow
- it exposes a variety of APIs
- it exposes Twig functions that help you render the steps

The most important contract exposed by the package is the `CheckoutServiceInterface` interface. It exposes a number of methods that you can call, for example, to load checkouts based on checkout identifier or for a specific cart. Other methods help you create, update, or delete checkouts.

For more information, see [Checkout API](../checkout_api/index.md).

## Add checkout step

By default, Ibexa DXP comes with a multi-step checkout process, which you can expand by adding steps. For example, if you were creating a project for selling theater tickets, you could add a step that allows users to select their seats.

### Define workflow

You can create workflow definitions under the `framework.workflows` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files). Each workflow definition consists of a series of steps and a series of transitions between the steps.

To create a new workflow, for example, `seat_selection_checkout`, use the default workflow that comes with the storefront module as a basis, and add a `seat_selected` step.

```yaml
framework:
    workflows:
         seat_selection_checkout:
            type: state_machine
            audit_trail:
                enabled: false
            marking_store:
                type: method
                property: status
            supports:
                - Ibexa\Contracts\Checkout\Value\CheckoutInterface
            initial_marking: initialized
            places:
                - initialized
                - seat_selected
                - address_selected
                - shipping_selected
                - summarized
```

Then, add a list of transitions. When defining a new transition, within its metadata, map the transition to its controller, and set other necessary details, such as the next step and label.

```yaml
            transitions:
                select_seat:
                    from:
                        - initialized
                        - seat_selected
                        - address_selected
                        - shipping_selected
                        - summarized
                    to: seat_selected
                    metadata:
                        next_step: select_address
                        controller: App\Controller\Checkout\Step\SelectSeatStepController
                        label: 'Select your seats'
```

### Create controller

At this point you must add a controller that supports the newly added step. In this case, you want users to select seats in the audience.

In the `src/Controller/Checkout/Step` folder, create a file that resembles the following example.

The controller contains a Symfony form that collects user selections. It can reuse fields and functions that come from the checkout component, for example, after you check whether the form is valid, use the `AbstractStepController::advance` method to go to the next step of the process.

```php
<?php

declare(strict_types=1);

namespace App\Controller\Checkout\Step;

use App\Form\Type\SelectSeatType;
use Ibexa\Bundle\Checkout\Controller\AbstractStepController;
use Ibexa\Contracts\Checkout\Value\CheckoutInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SelectSeatStepController extends AbstractStepController
{
    public function __invoke(
        Request $request,
        CheckoutInterface $checkout,
        string $step
    ): Response {
        $form = $this->createStepForm($step, SelectSeatType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->advance($checkout, $step, $form->getData());
        }

        return $this->render(
            '@ibexadesign/checkout/step/select_seat.html.twig',
            [
                'layout' => $this->getSeatsLayout(),
                'current_step' => $step,
                'checkout' => $checkout,
                'form' => $form,
            ]
        );
    }

    private function getSeatsLayout(): array
    {
        return [
            'A' => 'X,X,0,0,1,1,1,1,X,X,X,X',
            'B' => '0,0,X,0,0,1,1,1,1,X,X,X',
            'C' => '1,1,1,1,0,0,0,0,0,0,0,0',
            'D' => '1,1,1,1,0,1,0,0,0,0,0,0',
            'E' => '1,1,1,1,0,1,0,1,0,0,0,0',
            'F' => '1,1,1,1,0,1,1,0,0,1,1,0',
            'G' => '1,1,1,1,1,1,1,1,1,1,1,1',
            'H' => '1,1,1,1,1,1,1,1,1,1,1,1',
            'I' => '1,1,1,1,1,1,1,1,1,1,1,1',
        ];
    }
}
```

#### Create a form

In the `src/Form/Type` folder, create a corresponding form:

```php
<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class SelectSeatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'selection',
            TextType::class,
            [
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Selected seats: ',
            ]
        );
    }
}
```

### Create Twig template

You also need a Twig template to render the Symfony form. In `templates/themes/storefront/checkout/step`, create a layout that uses JavaScript to translate clicking into a grid to a change in value:

```html+twig
{% extends '@ibexadesign/checkout/layout.html.twig' %}

{% block content %}
    {{ form_start(form) }}
        {% include '@ibexadesign/checkout/component/quick_summary.html.twig' with { entries_count : 1} %}

        <h1>Please select your seats</h1>
        <p>If you prefer not to book one, we will assign a random seat for you 48 hours before the event.</p>

        <div class="seats-selection-container">
            <div class="seats-map">
                {% set class_map = {
                    'X': 'null',
                    '1': 'available',
                    '0': 'not-available'
                } %}

                {% for row_idx, row in layout %}
                    <div class="seats-row">
                        {% for col_idx, seat in row|split(',') %}
                            {% set seat_id = '%s%d'|format(row_idx, col_idx + 1) %}

                            <a class="seat seat-{{ class_map[seat] }}" data-seat-id="{{ seat_id }}" title="{{ seat_id }}"></a>
                        {% endfor %}
                    </div>
                {% endfor %}
            </div>
            <div class="seats-input">
                {{ form_row(form.select_seat.selection) }}
            </div>
        </div>

        {% include '@ibexadesign/checkout/component/actions.html.twig' with {
            label: 'Go to Billing & shipping address',
            href: ibexa_checkout_step_path(checkout, 'select_address'),
        } %}
    {{ form_end(form) }}
{% endblock %}

{% block stylesheets %}
    {{ parent() }}
    {{ encore_entry_link_tags('checkout') }}
{% endblock %}

{% block javascripts %}
    {{ parent() }}
    {{ encore_entry_script_tags('checkout') }}

    <script>
        (function () {
            const SELECTION_CLASS = 'seat-selected';
            const SEAT_SELECTOR = '.seat-available';
            const SELECTED_SEATS_SELECTOR = '.seat-selected';
            const VALUE_INPUT_SELECTOR = '#form_select_seat_selection';

            const input = document.querySelector(VALUE_INPUT_SELECTOR)

            document.querySelectorAll(SEAT_SELECTOR).forEach((seat) => {
                seat.addEventListener('click', (e) => {
                    e.preventDefault();

                    seat.classList.toggle(SELECTION_CLASS);

                    const selection = [
                        ...document.querySelectorAll(SELECTED_SEATS_SELECTOR)
                    ].map((seat) => seat.dataset.seatId);

                    input.value = selection.join(',');
                });
            });
        })();
    </script>
{% endblock %}
```

In `assets/styles/checkout.css`, add styles required to properly display your template.

```css
.seats-selection-container {
    padding: 20px 0;
    display: grid;
    grid-auto-columns: auto;
}

.seat {
    display: inline-block;
    padding: 15px;
    border: 1px solid #ccc;
}

.seat-null {
    background: #EEEEEE;
}

.seat-available {
    background: #98de98;
    cursor: pointer;
}

.seat-not-available {
    background: #d38e8e;
}

.seat-selected {
    background: #0a410a;
}

.seats-map {
    grid-column: 1 / 3;
    grid-row: 1;
}

.seats-input {
    grid-column: 2 / 3;
    grid-row: 1;
}
```

> **Note: Note**
>
> Remember to [add the new asset file to your Webpack configuration](../../../templating/assets/index.md#configure-assets).

### Select supported workflow

Next, you must inform the application that the configured workflow is used in your repository.

You do it in repository configuration, under the `ibexa.repositories.<repository_name>.checkout.workflow` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    repositories:
        default:
            checkout:
                workflow: seat_selection_checkout
```

### Restart application

you're now ready to see the results of your work. Shut down the application, clear browser cache, and restart the application. You should be able to see a different checkout applied after you have added products to a cart.

![Additional checkout step](https://doc.ibexa.co/en/5.0/commerce/checkout/img/additional_checkout_step.png "Additional checkout step")

## Hide checkout step

By default, Ibexa DXP comes with a multi-step checkout process, which you can scale down by hiding steps. To do it, modify workflow under the `framework.workflows` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files).

This example shows how to hide a 'Billing & shipping address' step. It can be used for logged-in users with billing data stored in their accounts.

```yaml
framework:
    workflows:
        ibexa_checkout:
            transitions:
                select_address:
                    metadata:
                        next_step: select_shipping
                        controller: Ibexa\Bundle\Checkout\Controller\CheckoutStep\AddressStepController::renderStepView
                        label: 'Billing & shipping address'
                        translation_domain: checkout
                        physical_products_step: true
                        hidden: true
```

## Create a one page checkout

Another way of customizing the process would be to implement a one page checkout. Such solution could work for certain industries, where simplicity is key. It's basic advantage is simplified navigation with less clicks to complete the transaction.

### Define workflow

To create a one page checkout, define a workflow that has two steps, `initialized` and `completed`, and one transition, from `initialized` or `completed` to `completed`.

```yaml
framework:
    workflows:
        one_page_checkout:
            type: state_machine
            audit_trail:
                enabled: false
            marking_store:
                type: method
                property: status
            supports:
                - Ibexa\Contracts\Checkout\Value\CheckoutInterface
            initial_marking: initialized
            places:
                - initialized
                - completed
            transitions:
                checkout_data:
                    from: [ initialized, completed ]
                    to: completed
                    metadata:
                        controller: App\Controller\Checkout\OnePageCheckoutController
```

### Create controller

Add a regular Symfony controller in project code, which reuses classes provided by the application. Within the controller, create a form that contains all the necessary fields, such as the shipping and billing addresses, together with shipping and billing methods.

In the `src/Controller/Checkout` folder, create a file that resembles the following example:

```php
<?php

declare(strict_types=1);

namespace App\Controller\Checkout;

use App\Form\Type\OnePageCheckoutType;
use Ibexa\Bundle\Checkout\Controller\AbstractStepController;
use Ibexa\Contracts\Checkout\Value\CheckoutInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class OnePageCheckout extends AbstractStepController
{
    public function __invoke(
        Request $request,
        CheckoutInterface $checkout,
        string $step
    ): Response {
        $form = $this->createForm(
            OnePageCheckoutType::class,
            $checkout->getContext()->toArray(),
            [
                'cart' => $this->getCart($checkout->getCartIdentifier()),
            ]
        );

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $stepData = [
                'shipping_method' => [
                    'identifier' => $formData['shipping_method']->getIdentifier(),
                    'name' => $formData['shipping_method']->getName(),
                ],
                'payment_method' => [
                    'identifier' => $formData['payment_method']->getIdentifier(),
                    'name' => $formData['payment_method']->getName(),
                ],
            ];

            return $this->advance($checkout, $step, $stepData);
        }

        return $this->render(
            '@storefront/checkout/checkout.html.twig',
            [
                'form' => $form,
                'checkout' => $checkout,
            ]
        );
    }
}
```

The controller can reuse fields and functions that come from the checkout component, for example, after you check whether the form is valid, use the `AbstractStepController::advance` method to go to the next step of the process.

#### Create a form

In the `src/Form/Type` folder, create a corresponding form:

```php
<?php

declare(strict_types=1);

namespace App\Form\Type;

use Ibexa\Bundle\Checkout\Form\Type\AddressType;
use Ibexa\Bundle\Payment\Form\Type\PaymentMethodChoiceType;
use Ibexa\Bundle\Shipping\Form\Type\ShippingMethodChoiceType;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

final class OnePageCheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'payment_method',
            PaymentMethodChoiceType::class,
            [
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Payment Method',
            ],
        );

        $builder->add(
            'billing_address',
            AddressType::class,
            [
                'type' => 'billing',
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Billing Address',
            ]
        );

        $builder->add(
            'shipping_method',
            ShippingMethodChoiceType::class,
            [
                'cart' => $options['cart'],
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Shipping Method',
            ]
        );

        $builder->add(
            'shipping_address',
            AddressType::class,
            [
                'type' => 'shipping',
                'constraints' => [
                    new NotBlank(),
                ],
                'label' => 'Shipping Address',
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'cart' => null,
        ]);

        $resolver->setAllowedTypes('cart', ['null', CartInterface::class]);
    }
}
```

### Create Twig template

Create a Twig template to render the Symfony form. In `templates/themes/storefront/checkout`, create a layout that iterates through all the fields and renders them.

```html+twig
{% extends '@ibexadesign/storefront/layout.html.twig' %}

{% form_theme form '@ibexadesign/storefront/form_fields.html.twig' %}

{% block content %}
    {{ form_start(form) }}
        {{ form_widget(form._token) }}

        <header class="checkout-header">
            <h1>Single-page checkout</h1>
            <p>A single-page checkout uses one page to display all the elements of a standard checkout process, 
                including payment details, billing and shipping addresses, and shipping options.</p>
        </header>

    <div class="ibexa-store-checkout__content">
        {% for child in form %}
            {% if not child.rendered %}
                <div class="ibexa-store-checkout-block__header">
                    <div class="ibexa-store-checkout-block__header-step">{{ loop.index }}</div>
                    <h2 class="ibexa-store-checkout-block__header-label">{{ child.vars.label }}</h2>
                </div>

                <div class="ibexa-store-checkout-block__content--dark ibexa-store-checkout-block__content">
                    <div class="checkout-field-group-form">
                        {{ form_widget(child) }}
                    </div>
                </div>
            {% endif %}
        {% endfor %}
    </div>

        <button class="ibexa-store-btn ibexa-store-btn--primary">
            Complete purchase
        </button>
    {{ form_end(form) }}
{% endblock %}
```

In `assets/styles/checkout.css`, add styles required to properly display your template.

> **Note: Note**
>
> Remember to [add the new asset file to your Webpack configuration](../../../templating/assets/index.md#configure-assets).

### Select supported workflow

Then you have to map the single-step workflow to the repository, by replacing the default `ibexa_checkout` reference with one of `one_page_checkout`:

```yaml
ibexa:
    repositories:
        default:
            checkout:
                workflow: one_page_checkout
```

### Restart application

To see the results of your work, shut down the application, clear browser cache, and restart the application. You should be able to see a one page checkout applied after you add products to a cart.

![One page checkout](https://doc.ibexa.co/en/5.0/commerce/checkout/img/single_page_checkout.png "One page checkout")

## Create custom strategy

Create a PHP definition of the new strategy that allows for workflow manipulation. In this example, custom checkout workflow applies when specific currency code ('EUR') is used in the cart.

```php
<?php

declare(strict_types=1);

namespace App\Checkout\Workflow\Strategy;

use Ibexa\Checkout\Value\Workflow\Workflow;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Checkout\Value\Workflow\WorkflowInterface;
use Ibexa\Contracts\Checkout\Workflow\WorkflowStrategyInterface;

final class NewWorkflow implements WorkflowStrategyInterface
{
    private const string IDENTIFIER = 'new_workflow';

    public function getWorkflow(CartInterface $cart): WorkflowInterface
    {
        return new Workflow(self::IDENTIFIER);
    }

    public function supports(CartInterface $cart): bool
    {
        return $cart->getCurrency()->getCode() === 'EUR';
    }
}
```

### Add conditional step

Defining strategy allows to add conditional step for workflow if needed. If you add conditional step, the checkout process uses provided workflow and goes to defined step if the condition described in the strategy is met. By default conditional step is set as null.

To use conditional step you need to pass second argument to constructor in the strategy definition:

```php
<?php

declare(strict_types=1);

namespace App\Checkout\Workflow\Strategy;

use Ibexa\Checkout\Value\Workflow\Workflow;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Checkout\Value\Workflow\WorkflowInterface;
use Ibexa\Contracts\Checkout\Workflow\WorkflowStrategyInterface;

final class NewWorkflowConditionalStep implements WorkflowStrategyInterface
{
    private const string IDENTIFIER = 'new_workflow';

    public function getWorkflow(CartInterface $cart): WorkflowInterface
    {
        return new Workflow(self::IDENTIFIER, 'conditional_step_name');
    }

    public function supports(CartInterface $cart): bool
    {
        return $cart->getCurrency()->getCode() === 'EUR';
    }
}
```

### Register strategy

Now, register the strategy as a service:

```yaml
services:
    App\Checkout\Workflow\Strategy\NewWorkflow:
        tags:
            - name: ibexa.checkout.workflow.strategy
              priority: 100
```

### Override default workflow

Next, you must inform the application that the configured workflow is used in your repository.

> **Note: Note**
>
> The configuration allows to override the default workflow, but it's not mandatory. Checkout supports multiple workflows.

You do it in repository configuration, under the `ibexa.repositories.<repository_name>.checkout.workflow` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    repositories:
        <repository_name>:
            checkout:
                workflow: new_workflow
```

## Manage multiple workflows

When you have multiple checkout workflows, you can specify which one to use by passing an argument with the name of the selected checkout workflow to a button or link that triggers the checkout process.

```twig
{% set checkout_path = path('ibexa.checkout.init', {
    cartIdentifier: cart_identifier,
    checkoutName: 'selected_checkout_name'  # Reference your workflow name here
}) %}
```

With this setup, you can specify which workflow to use by clicking the button or link that starts the checkout. The argument passed determines which workflow is used, providing flexibility in workflow selection.

## Define custom Address field type formats

To create custom Address field type formats to be used in checkout, make the following changes in the project configuration files.

First, define custom format configuration keys for `billing_address_format` and `shipping_address_format`:

```yaml
ibexa:
    repositories:
        <repository_name>:
            checkout:
                #"billing" by default
                billing_address_format: <custom_billing_fieldtype_address_format>
                #"shipping" by default
                shipping_address_format: <custom_shipping_fieldtype_address_format>
                #used in registration, uses given shipping/billing addresses to pre-populate address forms in select_address checkout step, "customer" by default
                customer_content_type: <your_ct_identifier_for_customer>
```

Then, define custom address formats, which, for example, don't include the `locality` field:

```yaml
ibexa_field_type_address:
    formats:
        <custom_shipping_fieldtype_address_format>:
            country:
                default:
                    - region
                    - street
                    - postal_code
                    - email
                    - phone_number

        <custom_billing_fieldtype_address_format>:
            country:
                default:
                    - region
                    - street
                    - postal_code
                    - email
                    - phone_number
```
