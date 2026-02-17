---
description: Events that are triggered when working with integrated help features like product tours.
edition: lts-update
page_type: reference
month_change: true
---

# Integrated help events

## Product tour events

The following event is dispatched when rendering a [product tour scenario](product_tour.md).

| Event | Dispatched by |
|---|---|
|`RenderProductTourScenarioEvent`|`Ibexa\IntegratedHelp\Renderer\ProductTourRenderer::render()`|

### RenderProductTourScenarioEvent

TODO: Move to "Customize product tour?" Maybe it's a better place

This event is dispatched before rendering a product tour scenario and you can use it to:

- Modify tour steps based on user permissions or roles
- Add or remove steps dynamically
- Change block content based on runtime conditions
- Integrate custom data into tour scenarios

With the following example, the scenario is modified to trigger only when certain conditions are matched. When the current user has a pending [notification]([[= user_doc =]]/getting_started/notifications/), a custom onboarding scenario is triggered.

First, define a custom product tour scenario.
It contains a placeholder step with a single block.

``` yaml
ibexa:
    system:
        default:
            product_tour:
                notifications:
                    type: 'targetable'
                    steps:
                        placeholder_step:
                            step_title_translation_key: 'This is a placeholder step'
                            target: '.ibexa-header-user-menu__notifications-toggler'
                            blocks:
                                - type: text
                                  params:
                                      text_translation_key: 'This is a placeholder block, modified during event subscriber execution'
```

Then, create a subscriber modifying the scenario.

```php hl_lines="35-37 39-41 43-45 47-58"
[[= include_file('code_samples/back_office/product_tour/src/EventSubscriber/NotificationScenarioSubscriber.php') =]]
```

The subscriber executes the following actions:

- makes sure the correct scenario is being processed
- removes all the existing scenario steps
- verifies that the current user has a pending notification
- adds a custom clickable step to highlight the unread notification

TODO: Screenshot here
