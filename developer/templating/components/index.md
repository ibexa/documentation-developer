# Twig Components

Twig components allow you to inject any custom widgets into selected places of the user interface.

Twig Components are widgets (for example, **My dashboard** blocks from Headless edition) and HTML code (for example, a tag for loading JS or CSS files) that you can inject into the existing templates to customize and extend the user interface. They are combined into groups that are rendered in designated templates.

Twig Component groups are available for:

- [back office](../../administration/back_office/back_office_elements/custom_components/index.md)
- [storefront](../layout/customize_storefront_layout/index.md)

To learn which groups are available in a given view, use the [integration Symfony Profiler](#symfony-profiler-integration).

## Create Twig Component

You can create Twig Components in one of two ways:

### PHP code

Create a class that implements the `\Ibexa\Contracts\TwigComponents\ComponentInterface` interface. Register it as a service by using the `AsTwigComponent` attribute or the `ibexa.twig.component` service tag:

**PHP Attribute**

```php
<?php declare(strict_types=1);

namespace App\Twig\Component;

use Ibexa\Contracts\TwigComponents\Attribute\AsTwigComponent;
use Ibexa\Contracts\TwigComponents\ComponentInterface;

#[AsTwigComponent(
    group: 'admin-ui-dashboard-all-tab-groups',
    priority: 100
)]
final class MyComponent implements ComponentInterface
{
    public function render(array $parameters = []): string
    {
        return 'Hello world!';
    }
}
```

**YAML configuration**

```yaml
App\Twig\Component\MyComponent:
    tags:
        - { name: ibexa.twig.component, group: admin-ui-dashboard-all-tab-groups, priority: 100 }
```

The available attributes are:

- `group` - indicates the group to which the component belongs
- `priority` - indicates the priority of rendering this component when rendering the whole component group. The higher the value the earlier the component is rendered

This way requires writing custom code, but it allows you to fully control the rendering of the component.

### YAML configuration

You can create a Twig Component and add it to a group using YAML configuration, as in the example below:

```yaml
ibexa_twig_components:
    # Component group
    storefront-before-head:
        # Component name
        google_tag_manager:
            type: script
            priority: 50
            arguments:
                src: 'https://...'
```

YAML configuration allows you to use the built-in components to quickly achieve common goals.

You can use an unique group name when creating a Twig Component to create your own group.

## Built-in components

| Name                                                                                                      | Description                                                                                             | YAML type    |
| --------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------- | ------------ |
| [Controller](https://github.com/ibexa/twig-components/blob/5.0/src/lib/Component/ControllerComponent.php) | Renders a Symfony controller                                                                            | `controller` |
| [HTML](https://github.com/ibexa/twig-components/blob/5.0/src/lib/Component/HtmlComponent.php)             | Renders static HTML                                                                                     | `html`       |
| [Menu](https://github.com/ibexa/twig-components/blob/5.0/src/lib/Component/MenuComponent.php)             | Renders a [menu](https://symfony.com/bundles/KnpMenuBundle/current/index.html)                          | `menu`       |
| [Script](https://github.com/ibexa/twig-components/blob/5.0/src/lib/Component/ScriptComponent.php)         | Renders a [`<script>` tag](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/script) | `script`     |
| [Stylesheet](https://github.com/ibexa/twig-components/blob/5.0/src/lib/Component/LinkComponent.php)       | Renders a [`<link>` tag](https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/Elements/link)     | `stylesheet` |
| [Template](https://github.com/ibexa/twig-components/blob/5.0/src/lib/Component/TemplateComponent.php)     | Renders a Twig template                                                                                 | `template`   |

For the menu component, the following properties are available:

| parameter | type     | required | description                    |
| --------- | -------- | -------- | ------------------------------ |
| name      | string   | yes      | Menu name                      |
| options   | array    | no       | Options passed to menu builder |
| path      | string[] | no       | Path to starting node          |
| template  | string   | no       | Template used to render menu   |
| depth     | int      | no       | Menu depth limit               |

The menu component, same as [back office menus](../../administration/back_office/back_office_menus/back_office_menus/index.md), relies on the [KnpMenuBundle](https://symfony.com/bundles/KnpMenuBundle/current/index.html). For more information about the available properties, refer to the [official documentation of the bundle](https://symfony.com/bundles/KnpMenuBundle/current/index.html#create-your-first-menu).

## Example

The following example shows how you can use each of the built-in components to customize the back office:

```yaml
ibexa_twig_components:
    admin-ui-user-menu:
        custom-controller-component:
            type: controller
            arguments:
                controller: '\App\Controller\MyController::requestAction'
                parameters:
                    parameter1: 'custom'
                    parameter2: true
        custom-html-component:
            type: html
            priority: 0
            arguments:
                content: '<b>Hello world!</b>'
        duplicated_user_menu:
            type: menu
            arguments:
                name: ezplatform_admin_ui.menu.user
                template: '@ibexadesign/ui/menu/user.html.twig'
                depth: 1
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
    admin-ui-stylesheet-head:
        custom-link-component:
            type: stylesheet
            arguments:
                href: 'https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i%7CRoboto+Mono:400,400i,700,700i&amp;display=fallback'
                rel: stylesheet
                crossorigin: anonymous
                integrity: sha384-LN/mLhO/GN6Ge8ZPvI7uRsZpiXmtSkep+aFlJcHa8by4TvA34o1am9sa88eUzKTD
                type: text/css
    admin-ui-global-search:
        custom-template-component:
            type: template
            priority: 50
            arguments:
                template: '@ibexadesign/ui/component/user_thumbnail/user_thumbnail.html.twig'
                parameters:
                    user_content:
                        name: "Thumbnail"
                        thumbnail:
                            resource: https://placecats.com/100/100
```

## Render Twig Components

Render both single Twig Components and whole groups using the [dedicated Twig functions](../twig_function_reference/component_twig_functions/index.md). You can modify the Component rendering process by:

- listening to one of the [related events](../../api/event_reference/twig_component_events/index.md)
- decorating the `\Ibexa\Contracts\TwigComponents\Renderer\RendererInterface` service

## Symfony Profiler integration

Use the built-in integration with [Symfony Profiler](https://symfony.com/doc/7.4/profiler.html) to see which Twig Components have been rendered in a given view. In the **Ibexa DXP** tab you can find:

- the list of all rendered Twig Component groups by the given view, including empty groups
- the list of rendered Twig Components with information about the group they belong to

![Symfony Profiler showing the list of rendered Twig Components in a back office view](https://doc.ibexa.co/en/5.0/templating/img/twig_components_symfony_profiler.png "Symfony Profiler showing the list of rendered Twig Components in a back office view")
