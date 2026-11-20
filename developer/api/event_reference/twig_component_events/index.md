# Twig Components events

Events that are triggered when rendering Twig Components.

Use the events to hook into the rendering process of [Twig Components](../../../templating/components/index.md).

## Twig Component rendering

| Event               | Dispatched by                                                              | Description                                      |
| ------------------- | -------------------------------------------------------------------------- | ------------------------------------------------ |
| `RenderGroupEvent`  | `\Ibexa\TwigComponents\Component\Renderer\DefaultRenderer::renderGroup()`  | Dispatched before a Component group is rendered  |
| `RenderSingleEvent` | `\Ibexa\TwigComponents\Component\Renderer\DefaultRenderer::renderSingle()` | Dispatched before a single Component is rendered |
