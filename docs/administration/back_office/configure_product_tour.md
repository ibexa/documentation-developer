---
description: Configure custom product tour scenarios with steps, blocks, and interaction modes.
edition: lts-update
month_change: false
---

# Configure product tour scenarios

You can configure the product tour scenarios to adapt it to your project needs, covering different onboarding scenarios.

Product tour scenarios are configured with YAML configuration files.
Configuration is SiteAccess-aware, allowing you to create separate onboarding experiences for different back offices in [multisite setups](multisite.md).

For more advanced customization cases that require PHP code, see [Customize product tour](customize_product_tour.md).

Use the default provided configuration, available in `config/packages/ibexa_integrated_help_tours.yaml`, as a starting point that you can adjust to your needs.

## Configuration structure

Product tour scenarios are configured under the `ibexa.system.<siteaccess>.product_tour` key.
Each scenario has a unique identifier and contains steps, which in turn contain blocks.

Basic configuration structure of a scenario:

```yaml
ibexa:
    system:
        <scope>>: # For example, admin or admin_group
            product_tour:
                <scenario_identifier>:
                    type: <general|targetable>
                    user_groups_excluded: [<user_group_remote_content_id>, ...]  # Optional
                    steps:
                        <step_identifier>: # Scenario step, unique within a scenario
                            step_title_translation_key: <translation_key>
                            background_image: <image_path>  # Only for general type, optional
                            target: <css_selector>  # Only for targetable type, required
                            interaction_mode: <null|clickable|draggable>  # Only for targetable type, optional
                            blocks:
                                - type: <block_type>
                                  params:
                                      # Block-specific parameters
                                      # ...
```

The product tour scenarios are meant to be translatable.
It's recommended to use translation keys instead of literal values in the YAML configuration, and provide the translations separately.
Use the `ibexa_integrated_help` translation domain.

For all the examples below, you can provide the translations by creating a `translations/ibexa_integrated_help.en.yaml` file with the following content:

``` yaml
title: "Welcome!"
subtitle: "This is the subtitle"
tour.step.description: "This is the description of the step, you can use it to explain what to do in this step."
tour.link.documentation: "Documentation link"
tour.list.title: "This is the list title"
tour.list.item1: "First item"
tour.list.item2: "Second item"
tour.list.item3: "Third item"
```

To insert a line break into a translation, HTML encode the `<br>` entities to `&lt;br/&gt;`.

## Scenario configuration

Each scenario must specify its type and can optionally restrict access by user groups.

### Scenario display order

The order of scenarios in the configuration file determines the order in which they are evaluated and, if the right conditions are met, displayed.

For **general scenario**, the scenario appears at the earliest opportunity (on any page after logging in), with an exception of the user settings area.

For **targeted scenarios**, the scenario begins if the target element is found in the DOM.
This means the scenario only appears on pages where the target element exists.
To control where a targeted tour appears, ensure the first step targets an element unique to that specific page or section.

Once a scenario ends, the next scenario from the configuration is evaluated and, if applicable, displayed.

### Scenario type

Set the scenario type to either `general` or `targetable` to [control how the scenario is displayed](product_tour.md#scenario-types).

```yaml
product_tour:
    welcome_tour:
        type: general
```

### User group restrictions

Restrict scenario visibility by excluding specific user groups by using their content remote IDs:

```yaml
product_tour:
    my_scenario:
        user_groups_excluded: ['user_group_content_remote_id_1', 'user_group_content_remote_id_2']  # Exclude specific user groups
```

When creating new [back office user groups](user_registration.md#user-types), you should decide whether the existing product tour scenarios should be available for the new user group.
If not, add the new group to the exclusion list.

!!! warning

    If a scenario contains information meant only for specific group of users, always use the `user_groups_excluded` setting to exclude other groups.
    Don't rely only on UI access restrictions to control the access to scenarios, as a malicious internal user could trigger and preview them outside of the intended place.

## Step configuration

Steps define individual instructions within a scenario.
The configuration differs based on scenario type:

### General scenario steps

General scenario steps display centered modals and support the `background_image` settings, allowing you to set a shared background image for each step.

```yaml hl_lines="6 10"
[[= include_file('code_samples/back_office/product_tour/config/general_scenario.yaml', 0, 14) =]]
```

### Targeted tour steps

Targeted tour steps highlight specific UI elements using CSS selectors.
You can select a specific element by using the `target` setting.

```yaml hl_lines="6 10"
[[= include_file('code_samples/back_office/product_tour/config/targetable_scenario.yaml', 0, 15) =]]
```

If a step's target element doesn't exist on the page, the step isn't be displayed and the scenario is be stopped.
Ensure your configuration matches the actual DOM structure to avoid broken scenarios.
Use unique selectors to avoid triggering your scenarios on other pages.

#### Interaction modes

Select how the scenario step interacts with the target element by using the `interaction_mode` setting.
Targeted steps support [three interaction modes](product_tour.md#targeted-scenarios):

TODO: 2 pane screenshot here, showing the UI for each of types.

!!! note

    Clickable and draggable modes are designed for single actions only (buttons, links).
    You can't select an entire form.
    If the interaction with the highlighted element results in redirection to a new page or opening a modal window where the previous target element can't be found, the "Previous" navigation step will be disabled.

**Standard mode**:

The default value. A tooltip attached to specific element on the page is displayed.
Users continue the scenario with Previous/Next buttons:

```yaml
[[= include_file('code_samples/back_office/product_tour/config/targetable_scenario.yaml', 7, 15) =]]
```

**Clickable mode**:

A tooltip attached to specific element on the page is displayed.
Users continue the scenario by clicking the highlighted element.

```yaml
[[= include_file('code_samples/back_office/product_tour/config/targetable_scenario.yaml', 15, 23) =]]
```

**Draggable mode**:

A tooltip attached to specific element on the page is displayed.
Users continue the scenario by [dragging](https://developer.mozilla.org/en-US/docs/Web/API/HTML_Drag_and_Drop_API#draggable_items) the highlighted element.

```yaml
[[= include_file('code_samples/back_office/product_tour/config/targetable_scenario.yaml', 31, 39) =]]
```

## Block types

Blocks are content elements that make up each step, available both for `general` and `targetable` scenarios.
Seven block types are available for building step content, and a scenario step must contain at least one.
If multiple blocks are defined for a step, they are displayed one after the other.

TODO: Step screenshot with all 7 blocks available?

### Title block

Display bold, prominent titles:

```yaml
[[= include_file('code_samples/back_office/product_tour/config/general_scenario.yaml', 11, 14) =]]
```

### Text block

Display regular text content:

```yaml
[[= include_file('code_samples/back_office/product_tour/config/general_scenario.yaml', 14, 17) =]]
```

### Link block

Add external or internal links:

```yaml
[[= include_file('code_samples/back_office/product_tour/config/general_scenario.yaml', 17, 21) =]]
```

### List block

Create bulleted lists with title:

```yaml
[[= include_file('code_samples/back_office/product_tour/config/general_scenario.yaml', 29, 36) =]]
```

The `title_translation_key` property is optional.

### Media blocks

To provide data to the media block, place your image or video files in the `public` directory and provide the relative path to it.

!!! tip

    To resolve the path relative to the site root, [prefix it with `/`](https://developer.mozilla.org/en-US/docs/Web/API/URL_API/Resolving_relative_references#root_relative).

#### Image block

Embed images with alternative text:

```yaml
[[= include_file('code_samples/back_office/product_tour/config/general_scenario.yaml', 21, 25) =]]
```

#### Video block

Embed video content by using the [`video` HTML element](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/video):

```yaml
[[= include_file('code_samples/back_office/product_tour/config/general_scenario.yaml', 25, 29) =]]
```

### Custom Twig template block

For advanced content, use custom Twig templates that allows you to fully control the styling of the block:

```yaml
[[= include_file('code_samples/back_office/product_tour/config/general_scenario.yaml', 36, 39) =]]
```

Create the dedicated template, for example in `templates/custom_template.html.twig`.

``` html+twig
{% trans_default_domain 'app' %}

{{ 'custom_step_description'|trans }}
```

and provide the required translations in `translations/app.en.yaml`:

``` yaml
custom_step_description: "This is a description coming from custom template"
```

## Configuration examples

### Example 1: General welcome tour

The following example showcases all the built-in block types for a `general` scenario consisting of a single step.

```yaml
[[= include_file('code_samples/back_office/product_tour/config/general_scenario.yaml') =]]
```

### Example 2: Targeted feature tour with interactive steps

The following example showcases the three interaction modes of a `targetable` scenario building an onboarding scenario for the [customizable dashboard](customize_dashboard.md):

```yaml
[[= include_file('code_samples/back_office/product_tour/config/targetable_scenario.yaml') =]]
```

To learn how to customize your scenarios even further with PHP code, see [Customize product tour](customize_product_tour.md).
