# Extending Back Office

## Custom Content Type icons

To add custom icons for existing Content Types or custom Content Types in eZ Platform, follow the instructions below.

### Configuration

A configuration of the default icon for Content Type is possible via the `default-config` key, e.g.:

```yaml
ezplatform:
    system:
       default:
           content_type:
              default-config:
                 thumbnail: /assets/images/mydefaulticon.svg
```

To configure a custom icon, you need to replace the `default-config` key with a Content Type identifier.
For example:

```yaml
ezplatform:
    system:
       default:
           content_type:
              article:
                 thumbnail: /assets/images/customicon.svg
```

!!! note "Icons format"

    All icons should be in SVG format so they can display properly in Back Office.

### Custom icons in Twig templates

Content Type icons are accessible in Twig templates via the `ez_content_type_icon` function.
It requires Content Type identifier as an argument. The function returns the path to a Content Type icon.

```twig
<svg class="ez-icon ez-icon-{{ contentType.identifier }}">
    <use xlink:href="{{ ez_content_type_icon(contentType.identifier) }}"></use>
</svg>
```

If the icon for a given Content Type is **not specified** in the configuration, the default icon is returned.

### Custom icons in JavaScript

Content Types icons configuration is stored in a global object: `eZ.adminUiConfig.contentTypes`.

You can easily retrieve the icon URL with the `getContentTypeIcon`  helper function that is set on the global `eZ.helpers.contentType` object.
It takes Content Type identifier as an argument and returns one of the following items:

 - URL of a given Content Type's icon
 - `null` if there is no Content Type with given identifier

Example with `getContentTypeIcon`:

```jsx
const contentTypeIconUrl = eZ.helpers.contentType.getContentTypeIconUrl(contentTypeIdentifier);
return (
   <svg className="ez-icon">
       <use xlinkHref={contentTypeIconUrl} />
   </svg>
)
```

## Injecting custom components

The Back Office has designated places where you can use your own components.

Components enable you to inject widgets (e.g. Dashboard blocks) and HTML code (e.g. a tag for loading JS or CSS files).
A component is any class that implements the `Renderable` interface.
It must be tagged as a service:

``` yaml
App\Component\MyNewComponent:
    tags:
        - { name: ezplatform.admin_ui.component, group: content-edit-form-before }
```

`group` indicates where the widget will be displayed. The available groups are:

- [`stylesheet-head`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/ui/layout.html.twig#L96)
- [`script-head`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/ui/layout.html.twig#L97)
- [`stylesheet-body`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/layout.html.twig#L175)
- [`script-body`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/layout.html.twig#L176)
- [`custom-admin-ui-modules`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/layout.html.twig#L147)
- [`custom-admin-ui-config`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/layout.html.twig#L148)
- [`content-edit-form-before`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/content/content_edit/content_edit.html.twig#L74)
- [`content-edit-form-after`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/content/content_edit/content_edit.html.twig#L84)
- [`content-create-form-before`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/content/content_edit/content_create.html.twig#L60)
- [`content-create-form-after`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/content/content_edit/content_create.html.twig#L68)
- [`dashboard-blocks`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/dashboard/dashboard.html.twig#L30)
- [`calendar-widget-before`](https://github.com/ezsystems/ezplatform-calendar/blob/master/src/bundle/Resources/views/themes/admin/calendar/view.html.twig#L21)

### Base component classes

If you only need to inject a short element (e.g. a Twig template or a CSS link) without writing a class,
you can make use of the following base classes:

- `TwigComponent` renders a Twig template.
- `LinkComponent` renders the HTML `<link>` tag.
- `ScriptComponent` renders the HTML `<script>` tag.

In this case, all you have to do is add a service definition (with proper parameters), for example:

``` yaml
appbundle.components.my_twig_component:
    parent: EzSystems\EzPlatformAdminUi\Component\TwigComponent
    autowire: true
    autoconfigure: false
    arguments:
        $template: path/to/file.html.twig
        $parameters:
            first_param: first_value
            second_param: second_value
    tags:
        - { name: ezplatform.admin_ui.component, group: dashboard-blocks }
```

This renders the `path/to/file.html.twig` template with `first_param` and `second_param` as parameters.

With `LinkComponent` and `ScriptComponent` you provide `$href` and `$src` as arguments, respectively:

``` yaml
app.components.my_link_component:
    parent: EzSystems\EzPlatformAdminUi\Component\LinkComponent
    autowire: true
    autoconfigure: false
    arguments:
        $href: 'http://address.of/file.css'
    tags:
        - { name: ezplatform.admin_ui.component, group: stylesheet-head }
```

``` yaml
app.components.my_script_component:
    parent: EzSystems\EzPlatformAdminUi\Component\ScriptComponent
    autowire: true
    autoconfigure: false
    arguments:
        $src: 'http://address.of/file.js'
    tags:
        - { name: ezplatform.admin_ui.component, group: script-body }
```

## Format date and time

Apart from changing the [date and time formats](../config_back_office#date-and-time-formats), you can use Twig filters:

- `ez_short_datetime`
- `ez_short_date`
- `ez_short_time`
- `ez_full_datetime`
- `ez_full_date`
- `ez_full_time`

The following are examples of using the filters:

``` php hl_lines="3 6"
<div>
    // Date formatted in the preferred time zone and short datetime format:
    {{ content.versionInfo.creationDate|ez_short_datetime }}

    // Date formatted in UTC and preferred short datetime format:
    {{ content.versionInfo.creationDate|ez_short_datetime('UTC') }}
</div>
```

The filters accept an optional `timezone` parameter for displaying date and time in a chosen time zone.
The default time zone is set in the User settings menu.

For details, see reference materials on the [full format filters](../twig_functions_reference.md#ez_full_datetime-ez_full_date-ez_full_time) and [short format filters](../twig_functions_reference.md#ez_short_datetime-ez_short_date-ez_short_time).

You can also format date and time by using the following services:

- `@ezplatform.user.settings.short_datetime_format.formatter`
- `@ezplatform.user.settings.short_datet_format.formatter`
- `@ezplatform.user.settings.short_time_format.formatter`
- `@ezplatform.user.settings.full_datetime_format.formatter`
- `@ezplatform.user.settings.full_date_format.formatter`
- `@ezplatform.user.settings.full_time_format.formatter`

To use them, create an `src\Service\MyService.php` file containing:

``` php
<?php

namespace App\Service;

use EzSystems\EzPlatformUser\UserSetting\DateTimeFormat\FormatterInterface;

class MyService
{
    /** @var \EzSystems\EzPlatformUser\UserSetting\DateTimeFormat\FormatterInterface */
    private $shortDateTimeFormatter;

    public function __construct(FormatterInterface $shortDateTimeFormatter)
    {
        // your code

        $this->shortDateTimeFormatter = $shortDateTimeFormatter;

        // your code
    }

    public function foo()
    {
        // your code

        $now = new \DateTimeImmutable();
        $date = $this->shortDateTimeFormatter->format($now);
        $utc = $this->shortDateTimeFormatter->format($now, 'UTC');

        // your code
    }
}
```

Then, add the following to `config/services.yaml`:

``` yaml
services:    
    App\Service\MyService:
        arguments:
            $shortDateTimeFormatter: '@ezplatform.user.settings.short_datetime_format.formatter'
```

### Add tooltips

Tooltips help provide more information for the users when they hover over, focus on, or tap an element.
eZ Platform tooltips use [Bootstrap tooltips.](https://getbootstrap.com/docs/4.1/components/tooltips/)

To create a tooltip you have to add a `title` attribute with a custom tooltip text for HTMLnode.

```html
<button title="custom tooltip text">click me</button>
```

Additionally, you can add following attributes:

- `data-extra-classes` - an additional class for tooltip container `.tooltip`
- `data-tooltip-container-selector` - a css selector for a tooltip container (Bootstrap tooltip `data-container` attribute)

Example of a tooltip with additional attributes:

```html
<button title="custom tooltip text" data-extra-classes="additinal_class" data-tooltip-container-selector="selector">
	click me
</button>
```

You can also add tooltip helpers to the JavaScript `eZ.helpers` object:

- `eZ.helpers.tooltips.parse(optional HTMLnode)` - creates a tooltip. Equivalent of `$(selector).tooltip()`. HTMLnode will execute `querySelectorAll` on this object, a `window.document` is default value.
- `eZ.helpers.tooltips.hideAll(optional HTMLnode)` - closes all tooltips. Equivalent of `$(selector).tooltip('hide')`. HTMLnode will execute `querySelectorAll` on this object, a `window.document` is default value.
