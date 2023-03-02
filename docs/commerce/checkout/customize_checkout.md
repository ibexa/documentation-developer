---
description: Customize the existing checkout functionality to support additional functions.
edition: commerce
---

# Customize checkout

When you work with your Commerce implementation, you can review and modify 
the checkout configuration.

Checkout is an essential component of the Commerce offering.
It collects data that is necessary to create an order, including:

- payment method
- shipping method
- billing / delivery address

It could also collect any other information that you find necessary.

Depending on your needs, the checkout process can be either complicated or very simple. 
For example, if the website is selling airline tickets, you may need several additional steps 
with passengers defining their special needs.
On the other side of the spectrum would be a store that sells books with personal pickup, 
where one-page checkout would be enough.

There are several factors that make checkout particularly flexible and customizable:

- it is based on Symfony workflow
- exposes a variety of APIs
- exposes Twig functions that help you render the steps

The most important contract exposed by the package is the `CheckoutServiceInterface` interface. 
It exposes a number of methods that you can call, for example, to load checkouts based 
on checkout identifier or for a specific cart. 
Other methods help you create, update, or delete checkouts. 

For more information, see [Checkout API](checkout_api.md).

## Add checkout stage

By default [[= product_name =]] comes with a multi-step checkout process, which you can expand by adding steps.
For example, if you were creating a project for selling theater tickets, you could add a step 
that allows users to select their seats.

### Define workflow

You can create workflow definitions in the `config/packages/ibexa.yaml` file. 
Each workflow definition consists of a series of stages as well as a series of transitions between the stages. 

To create a new workflow, for example, `seat_selection_checkout`, modify the default workflow that comes with the storefront module, by adding a  `select_seat` stage.

``` yaml hl_lines="3 15"
[[= include_file('code_samples/front/shop/checkout/config/packages/ibexa.yaml', 25, 27) =]] [[= include_file('code_samples/front/shop/checkout/config/packages/ibexa.yaml', 103, 120) =]] [[= include_file('code_samples/front/shop/checkout/config/packages/ibexa.yaml', 23, 24) =]]
```

Then, modify a list of transitions. 
When defining a new transition, within its metadata, map the transition to its controller, and set other necessary details, such as the next step and label.

``` yaml hl_lines="2 12"
[[= include_file('code_samples/front/shop/checkout/config/packages/ibexa.yaml', 120, 133) =]] [[= include_file('code_samples/front/shop/checkout/config/packages/ibexa.yaml', 23, 24) =]]
```

### Create controller

At this point you must add a controller that supports the newly added step.
In this case, you want users to select seats in the audience.

In the `src/Controller/Checkout/Step` folder, create a file that resembles the following example.

The controller contains a Symfony form that collects user selections. 
It can reuse fields and functions that come from the checkout component, for example, 
after you check whether the form is valid, use the `advance` method to go to the next stage 
of the process.

``` php hl_lines="23 24"
[[= include_file('code_samples/front/shop/checkout/src/Controller/SelectSeatStepController.php') =]]
```

### Create Twig template

You also need a Twig template to render the Symfony form.
In `templates/themes/custom/storefront/checkout/step`, create a layout that uses JavaScript to translate clicking into a grid to a change in value:

```html+twig
[[= include_file('code_samples/front/shop/checkout/templates/themes/storefront/checkout/step/select_seat.html.twig') =]]
```

### Configure repository

At this point, you must inform the application about a repository that the workflow supports.

You do it repository configuration, by replacing the `ibexa_checkout` configuration with one for `seat_selection_checkout`:

``` yaml
ibexa:
    repositories:
        default: 
            checkout:
                workflow: seat_selection_checkout
```

### Restart application

You are now ready to see the results of your work.
Shut down the application, clear browser cache, and restart the application.
You should be able to see a different checkout applied after you have added products to a cart.

## Create a single-form checkout

Another way of customizing the process would be to implement a single-form checkout.
Such solution could work for certain industries, where simplicity is key.
The single form's basic advantage is simplified navigation with less clicks to complete the transaction.

### Define workflow

To create a single-form checkout, define a workflow that has two stages, `initialized` and `completed`, and one transition, from `initialized` or `completed` to `completed`.

``` yaml hl_lines="3 18 19"
[[= include_file('code_samples/front/shop/checkout/config/packages/ibexa.yaml', 25, 27) =]] [[= include_file('code_samples/front/shop/checkout/config/packages/ibexa.yaml', 84, 103) =]] [[= include_file('code_samples/front/shop/checkout/config/packages/ibexa.yaml', 23, 24) =]]
```

### Create controller

Add a controller in project code that is a regular Symfony controller, which reuses classes provided by the application.
Within the controller, create a form that contains all the necessary fields, such as the shipping and billing addresses, as well as shipping and billing methods.

In the `src/Controller/Checkout` folder, create a file that resembles the following example:

``` php
[[= include_file('code_samples/front/shop/checkout/src/Controller/SinglePageCheckout.php') =]]
```

Again, after you handle the form and validate it, you advance the workflow by using the `advance` method provided in the base component.

### Create Twig template

Create a Twig template to render the Symfony form.
In `templates/themes/custom/storefront/checkout`, create a layout that iterates through all the fields and renders them.

```html+twig
[[= include_file('code_samples/front/shop/checkout/templates/themes/storefront/checkout/checkout.html.twig') =]]
```
### Configure repository

Then you have to map the single-step workflow to the repository, 
by replacing the default `ibexa_checkout` reference with one of `single_page_checkout`:

``` yaml
ibexa:
    repositories:
        default: 
            checkout:
                workflow: single_page_checkout
```

### Restart application

To see the results of your work, shut down the application, clear browser cache, and restart the application.
You should be able to see a single-page checkout applied after you add products to a cart.