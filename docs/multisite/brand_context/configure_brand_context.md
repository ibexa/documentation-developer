---
description: Configure brand context, create attribute definitions for AI guidelines, and customize how attribute values are displayed in the back office.
month_change: true
---

# Configure brand context

You can configure [brand context](brand_context_guide.md) under the `ibexa_site_context` key, for example, in the `config/packages/ibexa_site_context.yaml` file that comes with a new [[= product_name =]] project.

The following example shows the available settings with their default values:

``` yaml
ibexa_site_context:
    enabled: true
    ui:
        show_brand_indicator: true
    api:
        expose_ai_context: false
    templates:
        attributes:
            - '@ibexadesign/brand_context/attribute_blocks.html.twig'
```

| Setting | Description |
|---|---|
| `enabled` | When set to `false`, AI actions don't use brand context guidelines, the content tree doesn't show brand context badges, the content editing form doesn't show the message about the selected brand context, and [location previews]() of the selected website don't use a headless front end, even if it's configured. |
| `ui.show_brand_indicator` | When set to `false`, the **Context** drop-down list in the back office top bar doesn't group websites by brand context. |
| `api.expose_ai_context` | When set to `true`, the [MCP tools](mcp_config.md#built-in-tools) return the values of AI Context attributes. AI guidelines may contain sensitive information, so enable this setting only for MCP servers that you trust. |
| `templates.attributes` | Templates that render attribute values on the brand context screen in the back office. For more information, see [Customize attribute rendering](#customize-attribute-rendering). |

## Exclude locations from website selection

When an editor selects a website in the back office top bar, the content tree shows only the content of the selected website.
Some parts of the content tree, for example, users or media, don't belong to any website, but editors still need to access them.

Such locations are listed under the [SiteAccess-aware](siteaccess_aware_configuration.md) `site_context.excluded_paths` setting, and they stay available regardless of the selected website.
The `config/packages/ibexa_site_context.yaml` file excludes the following locations by default:

``` yaml
ibexa:
    system:
        admin_group:
            site_context:
                excluded_paths:
                    - /1/5/     # Users
                    - /1/43/    # Media
                    - /1/55/    # Forms
                    - /1/56/    # Site skeletons
                    - /1/67/    # Dashboards
                    - /1/61/    # Product categories
                    - /1/65/    # Corporate Account
                    - /1/57/    # Tags
```

To exclude other locations, add their path strings to this list.

If you set `excluded_paths` for a single back office SiteAccess, for example, `admin`, that list replaces the `admin_group` list, so repeat the default entries there.

To check whether a location is excluded in templates, use the [`ibexa_site_context_aware`](site_context_twig_functions.md#ibexa_site_context_aware) Twig test.

## Permissions

To work with brand contexts in the back office, users need the [`brand_context` policies](policies.md#brand-context).
To manage attribute groups and attribute definitions, users need the `brand_context_attributes_config/manage` policy.

[[= product_name =]] doesn't assign these policies to any role by default.
Grant them to the roles of users who manage brands, and use the [Brand Context limitation](limitation_reference.md#brand-context-limitation) to limit access to selected brand contexts.

## Create attribute definitions for AI guidelines

You can create attribute definitions for the AI Context group in the back office or with [data migrations](importing_data.md#brand-context-attributes).

## Customize attribute rendering

The `ibexa_format_brand_context_attribute` Twig filter renders attribute values on the brand context screen in the back office.
For each attribute value, the filter looks for a block named `<type identifier>_attribute`, for example, `color_attribute` or `url_attribute`, in the templates listed under `templates.attributes`.
If the block doesn't exist in any of the templates, the filter uses the `generic_attribute` block.

The block receives the following variables:

- `attribute` - the attribute value object, which implements [`BrandContextAttributeValueInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Values-BrandContextAttributeValueInterface.html)
- `value` - the attribute value
- `parameters` - additional parameters passed to the filter

To change how values of a specific type are displayed, create a template with the block, for example, `templates/themes/admin/brand_context/custom_attribute_blocks.html.twig`:

``` html+twig
{% block url_attribute %}
    <a href="{{ value }}" target="_blank" rel="noopener">{{ value }}</a>
{% endblock %}
```

Then, add the template to the configuration:

``` yaml
ibexa_site_context:
    templates:
        attributes:
            - '@ibexadesign/brand_context/custom_attribute_blocks.html.twig'
```

Built-in templates are always checked last, so blocks from your templates take precedence.

### Customize rendering of single attribute

A block from the `templates.attributes` list changes how all values of a type are displayed.
To change the display of a single attribute only, listen to the [`BrandContextAttributeRenderEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-SiteContext-Event-BrandContextAttributeRenderEvent.html) event, which is dispatched for every rendered attribute value.
With the event, you can change the list of templates and the parameters passed to the template block.

For example, the following event listener adds a template only when the `color_accent` attribute is rendered:

``` php hl_lines="11 17"
[[= include_file('code_samples/brand_context/src/EventSubscriber/AccentColorAttributeRenderSubscriber.php') =]]
```

The template, `templates/themes/admin/brand_context/accent_color_blocks.html.twig`, overrides the `color_attribute` block:

``` html+twig
[[= include_file('code_samples/brand_context/templates/themes/admin/brand_context/accent_color_blocks.html.twig') =]]
```

Other attributes of the `color` type keep the default rendering.
