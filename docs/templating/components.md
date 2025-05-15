---
description: Twig components allow you to inject any custom widgets into selected places of the user interface.
---

# Twig Components

Twig Components are widgets (for example, **My dashboard** blocks) and HTML code (for example, a tag for loading JS or CSS files) that you can inject into the existing templates to customize and extend the user interface.
They are combined into groups that are rendered in designated templates.

Twig Component groups are available for:

- [back office](custom_components.md)
- [storefront](customize_storefront_layout.md)

To learn which groups are available in a given view, use the [integration Symfony Profiler](#symfony-profiler-integration).

## Create Twig Component

You can create Twig Components in one of two ways:

### PHP code

Create a class implementing the `\Ibexa\Contracts\TwigComponents\ComponentInterface` interface and register it as a service by using the `ibexa.twig.component` service tag, for example:

``` yaml
App\Component\MyNewComponent:
    tags:
        - { name: ibexa.twig.component, group: content-edit-form-before, priority: 0 }
```

The available attributes are:

- `group` - indicates the group to which the component belongs
- `priority` - indicates the priority of rendering this component when rendering the whole component group. The higher the value the earlier the component is rendered

This way requires writing custom code, but it allows you to fully control the rendering of the component.

### YAML Configuration

You can create a Twig Component and add it to a group using YAML configuration, as in the example below:

``` yaml
ibexa_twig_components:
    # Component group
    storefront-before-head:
        # Component name
        google_tag_manager:
            type: script
            arguments:
                src: 'https://...'
```

The Component priority cannot be specified when using the YAML configuration, but it allows you to use the built-in components to quickly achieve common goals.

You can use an unique group name when creating a Twig Component to create your own group.

## Built-in components

| Name | Description | YAML type |
|---|---|---|
| [Script](https://github.com/ibexa/twig-components/blob/main/src/lib/Component/ScriptComponent.php) | Renders a [`<script>` tag](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/script) | `script` |
| [Stylesheet](https://github.com/ibexa/twig-components/blob/main/src/lib/Component/LinkComponent.php) | Renders a [`<link>` tag](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/link) | `stylesheet`
| [Template](https://github.com/ibexa/twig-components/blob/main/src/lib/Component/TemplateComponent.php) | Renders a Twig template|`template` |
| [Controller](https://github.com/ibexa/twig-components/blob/main/src/lib/Component/ControllerComponent.php) | Renders a Symfony controller |`controller` |
| [HTML](https://github.com/ibexa/twig-components/blob/main/src/lib/Component/HtmlComponent.php) | Renders static HTML |`html` |

## Example

In the example below

- A "Hello world!" is added to the user menu.
- The current user thumbnail is a random cat.
- …
``` yaml
ibexa_twig_components:
    admin-ui-user-menu:
        custom-html-component:
            type: html
            arguments:
                content: '<b>Hello world!</b>'
        custom-template-component:
            type: template
            arguments:
                template: '@ibexadesign/ui/component/user_thumbnail/user_thumbnail.html.twig'
                parameters:
                    user_content:
                        name: "Thumbnail"
                        thumbnail:
                            resource: https://placecats.com/100/100
        custom-controller-component:
            type: controller
            arguments:
                controller: '\App\Controller\MyController::requestAction'
                parameters:
                    parameter1: 'custom'
                    parameter2: true
    admin-ui-stylesheet-head:
        custom-link-component:
            type: stylesheet
            arguments:
                href: 'https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i%7CRoboto+Mono:400,400i,700,700i&amp;display=fallback'
                rel: stylesheet
                crossorigin: anonymous
                integrity: sha384-LN/mLhO/GN6Ge8ZPvI7uRsZpiXmtSkep+aFlJcHa8by4TvA34o1am9sa88eUzKTD
                type: text/css
    admin-ui-script-head:
        custom-script-component:
            type: script
            arguments:
                src: 'https://doc.ibexa.co/en/latest/js/custom.js'
                crossorigin: anonymous
                defer: false
                async: true
                integrity: sha384-Ewi2bBDtPbbu4/+fs8sIbBJ3zVl0LDOSznfhFR/JBK+SzggdRdX8XQKauWmI9HH2
                type: text/javascript
```

## Render Twig Components

Render both single Twig Components and whole groups using the [dedicated Twig functions](component_twig_functions.md).
You can modify the Component rendering process by:

- listening to one of the [related events](twig_component_events.md)
- decorating the `\Ibexa\Contracts\TwigComponents\Renderer\RendererInterface` service

## Symfony Profiler integration

Use the built-in integration with [Symfony Profiler]([[= symfony_doc =]]/profiler.html) to see which Twig Components have been rendered in a given view. In the **[[= product_name =]]** tab you can find:

- the list of all rendered Twig Component groups by the given view, including empty groups
- the list of rendered Twig Components with information about the group they belong to

![Symfony Profiler showing the list of rendered Twig Components in a back office view](img/twig_components_symfony_profiler.png "Symfony Profiler showing the list of rendered Twig Components in a back office view")
