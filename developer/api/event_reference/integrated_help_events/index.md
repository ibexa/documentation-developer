# Integrated help events

Events that are triggered when working with integrated help features like product tours.

Editions: LTS Update

## Product tour events

The following event is dispatched when rendering a [product tour scenario](../../../administration/back_office/product_tour/index.md).

| Event                                                                                                                                                                          | Dispatched by                                                 |
| ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ------------------------------------------------------------- |
| [`Ibexa\Contracts\IntegratedHelp\Event\RenderProductTourScenarioEvent`](../../../../../../ibexa/integrated-help/src/contracts/Event/RenderProductTourScenarioEvent.php) | `Ibexa\IntegratedHelp\Renderer\ProductTourRenderer::render()` |

To learn how you can use this event to customize your product tour scenarios, see [Customize product tour](../../../administration/back_office/customize_product_tour/index.md).
