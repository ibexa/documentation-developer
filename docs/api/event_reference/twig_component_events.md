---
description: Events that are triggered when rendering Twig Components.
page_type: reference
month_change: false
---

# Twig Components events

Use the events to hook into the rendering process of [Twig Components](components.md).

## Twig Component rendering

| Event | Dispatched by | Description |
|---|---|---|
|`RenderGroupEvent`| `\Ibexa\TwigComponents\Component\Renderer\DefaultRenderer::renderGroup()` | Dispatched before a Component group is rendered
|`RenderSingleEvent`| `\Ibexa\TwigComponents\Component\Renderer\DefaultRenderer::renderSingle()` |Dispatched before a single Component is rendered
