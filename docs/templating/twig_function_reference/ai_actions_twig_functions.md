---
description: AI Actions functions allows you to embed AI Actions in your templates
page_type: reference
month_change: true
---

# AI Actions Twig functions

AI Actions functions allows you to pass information about AI Actions to the Twig templates.

### `ibexa_ai_config()`

The `ibexa_ai_config` function loads the configuration of an Action Type with given identifier.

``` html+twig
    {% set ai_config = ibexa_ai_config('refine_text') %}
    {% set ai_config2 = ibexa_ai_config('refine_text', { 'some': 'optional data' }) %}

    <div class="hidden" data-ai-config-name="refine_text" data-ai-config="{{ ai_config|json_encode }}"></div>
```

You can use the [ResolveActionConfigurationWidgetConfigEvent](ai_action_events.md#others) event to modify the configuration after it's been loaded. The optional data provided in the function call is available in the event object.
