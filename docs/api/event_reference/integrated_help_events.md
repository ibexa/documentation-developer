---
description: Events that are triggered when working with integrated help features like product tours.
edition: lts-update
page_type: reference
month_change: false
---

# Integrated help events

## Product tour events

The following event is dispatched when rendering a [product tour scenario](product_tour.md).

| Event | Dispatched by |
|---|---|
|[`RenderProductTourScenarioEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-IntegratedHelp-Event-RenderProductTourScenarioEvent.html)|`Ibexa\IntegratedHelp\Renderer\ProductTourRenderer::render()`|

To learn how you can use this event to customize your product tour scenarios, see [Customize product tour](customize_product_tour.md).
