---
description: Checkout Twig functions return information about the checkout process, and total values related to cart and cart items.
edition: commerce
---

# Checkout Twig functions

You can use Checkout Twig functions to get information about the checkout process, 
as well as total values related to cart and cart items.

### `ibexa_checkout_step_label()`

The `ibexa_checkout_step_label()` function returns a name of the step (configured in `framework.workflows.workflow.ibexa_checkout.transitions.<transition>.metadata.label`).

``` html+twig
{% block title %}
    <h1>{{ ibexa_checkout_step_label(checkout, step) }}</h1>
{% endblock %}
```

### `ibexa_checkout_steps()`

The `ibexa_checkout_steps()` function returns a list of steps configured in `framework.workflows.workflow.ibexa_checkout.transitions`).

``` html+twig
{% for step in ibexa_checkout_steps(checkout) %}
    // ...
{% endfor %}
```

### `ibexa_checkout_step_path()`

The `ibexa_checkout_step_path()` function returns a path to the step.

``` html+twig 
<a href="{{ ibexa_checkout_step_path(checkout, step) }}">{{ <link_label> }}</a>
```

### `ibexa_checkout_step_url()`

The `ibexa_checkout_step_url()` function returns a URL address of the step. 
By setting the optional argument to `true` you can decide whether the function 
returns a relative or absolute URL of the checkout step.
The default value of the optional argument is `false`, which stands for the absolute URL.

``` html+twig 
<a href="{{ ibexa_checkout_step_url(checkout, step, true) }}">{{ <target_page_label> }}</a>
```

### `ibexa_checkout_step_number()`

The `ibexa_checkout_step_number` function returns a sequential number of the step (based on configuration under `framework.workflows.workflow.ibexa_checkout.transitions`).

``` html+twig
{% block page_number %}
    <h1>{{ ibexa_checkout_step_number(checkout, step) }}</h1>
{% endblock %}
```

### `ibexa_checkout_summary_entries()`

The `ibexa_checkout_summary_entries` function takes in a single argument, a cart summary object, and returns the checkout summary.

``` html+twig 
{% block items %}
    {% for entry in ibexa_checkout_summary_entries(summary) %}
        // ...
    {% endfor %}
{% endblock %}  
```

### `ibexa_checkout_summary_vat_summaries()`

The `ibexa_checkout_summary_vat_summaries()` function takes in a single argument, a cart summary object, 
and returns an array of VAT summary objects for the cart. 
Each VAT summary relates to a certain VAT rate, and contains information about the VAT rate, and the VAT value.

``` html+twig 
{% set vat_summaries = ibexa_checkout_summary_vat_summaries(summary) %}
```