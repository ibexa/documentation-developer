# Extending Back Office

## Custom Content Type icons

To add custom icons for existing Content Types or custom Content Types in eZ Platform follow the instructions below.

### Configuration

A configuration of the default icon for Content Type is possible via `default-config` key.
For example:

```yaml
ezpublish:
    system:
       default:
           content_type:
              default-config:
                 thumbnail: /assets/images/mydefaulticon.svg
```

To configure a custom icon you just need to replace the `default-config` key with a Content Type identifier.
For example:

```yaml
ezpublish:
    system:
       default:
           content_type:
              article:
                 thumbnail: /assets/images/customicon.svg
```

!!! note "Icons format"

    All icons should be in SVG format so they can display properly in Back Office.

### Custom icons in Twig templates

Content Type icons are accessible in Twig templates via `ez_content_type_icon` function.
It requires Content Type identifier as an argument. The function returns the path to a Content Type icon.

```twig
<svg class="ez-icon ez-icon-{{ contentType.identifier }}">
    <use xlink:href="{{ ez_content_type_icon(contentType.identifier) }}"></use>
</svg>
```

If the icon for given Content Type is **not specified** in the configuration the default icon will be returned.

### Custom icons in JavaScript

Content Types icons configuration is stored in a global object: `eZ.adminUiConfig.contentTypes`.

You can easily retrieve icon URL with a helper function `getContentTypeIcon`, set on a global object `eZ.helpers.contentType`.
It takes Content Type identifier as an argument and returns:

 - URL of given Content Type's icon or
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
AppBundle\Component\MyNewComponent:
    tags:
        - { name: ezplatform.admin_ui.component, group: content-edit-form-before }
```

`group` indicates where the widget will be displayed. The available groups are:

- [`stylesheet-head`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/views/layout.html.twig#L93)
- [`script-head`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/views/layout.html.twig#L94)
- [`stylesheet-body`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/views/layout.html.twig#L160)
- [`script-body`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/views/layout.html.twig#L161)
- [`custom-admin-ui-modules`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/views/layout.html.twig#L152)
- [`custom-admin-ui-config`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/views/layout.html.twig#L153)
- [`content-edit-form-before`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/views/content/content_edit/content_edit.html.twig#L74)
- [`content-edit-form-after`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/views/content/content_edit/content_edit.html.twig#L84)
- [`content-create-form-before`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/views/content/content_edit/content_create.html.twig#L60)
- [`content-create-form-after`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/views/content/content_edit/content_create.html.twig#L68)
- [`dashboard-blocks`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/views/dashboard/dashboard.html.twig#L28)

### Base component classes

If you only need to inject a short element (e.g. a Twig template or a CSS link) without writing a class,
you can make use of the following base classes:

- `TwigComponent` renders a Twig template.
- `LinkComponent` renders the HTML `<link>` tag.
- `ScriptComponent` renders the HTML `<script>` tag.

In this case all you have to do is add a service definition (with proper parameters), for example:

``` yaml
appbundle.components.my_twig_component:
    parent: EzSystems\EzPlatformAdminUi\Component\TwigComponent
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
appbundle.components.my_link_component:
    parent: EzSystems\EzPlatformAdminUi\Component\LinkComponent
    arguments:
        $href: 'http://address.of/file.css'
    tags:
        - { name: ezplatform.admin_ui.component, group: stylesheet-head }
```

``` yaml
appbundle.components.my_script_component:
    parent: EzSystems\EzPlatformAdminUi\Component\ScriptComponent
    arguments:
        $src: 'http://address.of/file.js'
    tags:
        - { name: ezplatform.admin_ui.component, group: script-body }
```

## Format date and time

Apart from changing the [date and time formats](config_back_office#date-and-time-formats), you can use Twig filters:

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

To use them, create an `src\AppBundle\Service\MyService.php` file containing:

``` php
<?php

namespace AppBundle\Service;

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

Then, add the following to `app/config/services.yml`:

``` yaml
services:    
    AppBundle\Service\MyService:
        arguments:
            $shortDateTimeFormatter: '@ezplatform.user.settings.short_datetime_format.formatter'
```
