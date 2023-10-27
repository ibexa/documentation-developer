---
description: Back Office components allow you to inject any custom widgets into selected places of the user interface.
---

# Custom components

The Back Office has designated places where you can use your own components.

Components enable you to inject widgets (for example, **My dashboard** blocks) and HTML code (for example, a tag for loading JS or CSS files).
A component is any class that implements the `Renderable` interface.
It must be tagged as a service in `config/services.yaml`:

``` yaml
App\Component\MyNewComponent:
    tags:
        - { name: ezplatform.admin_ui.component, group: content-edit-form-before }
```

`group` indicates where the widget is displayed. The available groups are:

- [`stylesheet-head`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/ui/layout.html.twig#L98)
- [`script-head`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/ui/layout.html.twig#L99)
- [`stylesheet-body`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/ui/layout.html.twig#L163)
- [`script-body`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/ui/layout.html.twig#L164)
- [`content-edit-form-before`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/user/edit.html.twig#L57)
- [`content-edit-form-after`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/user/edit.html.twig#L67)
- [`content-create-form-before`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/user/create.html.twig#L54)
- [`content-create-form-after`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/user/create.html.twig#L62)
- [`dashboard-blocks`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/ui/dashboard/dashboard.html.twig#L30)
- [`dashboard-all-tab-groups`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/ui/dashboard/block/all.html.twig#L6)
- [`dashboard-my-tab-groups`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/ui/dashboard/block/me.html.twig#L6)
- [`content-type-tab-groups`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/content_type/index.html.twig#L10)
- [`calendar-widget-before`](https://github.com/ezsystems/ezplatform-calendar/blob/master/src/bundle/Resources/views/themes/admin/calendar/view.html.twig#L24)
- [`login-form-before`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/account/login/index.html.twig#L8)
- [`login-form-after`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/themes/admin/account/login/index.html.twig#L69)

## Base component classes

If you only need to inject a short element (for example, a Twig template or a CSS link) without writing a class,
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
