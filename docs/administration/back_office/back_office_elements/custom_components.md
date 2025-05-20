---
description: Back office components allow you to inject any custom widgets into selected places of the user interface.
---

# Custom components

The back office has designated places where you can use your own components.

Components enable you to inject widgets (for example, **My dashboard** blocks) and HTML code (for example, a tag for loading JS or CSS files).
A component is any class that implements the `Renderable` interface.
It must be tagged as a service in `config/services.yaml`:

``` yaml
App\Component\MyNewComponent:
    tags:
        - { name: ibexa.admin_ui.component, group: content-edit-form-before }
```

`group` indicates where the widget is displayed. The available groups are:

- [`stylesheet-head`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/ui/layout.html.twig#L101)
- [`script-head`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/ui/layout.html.twig#L102)
- [`stylesheet-body`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/ui/layout.html.twig#L210)
- [`script-body`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/ui/layout.html.twig#L211)
- [`content-edit-form-before`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/user/edit.html.twig#L37)
- [`content-edit-form-after`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/user/edit.html.twig#L47)
- [`content-create-form-before`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/user/create.html.twig#L37)
- [`content-create-form-after`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/user/create.html.twig#L45)
- [`dashboard-blocks`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/ui/dashboard/dashboard.html.twig#L30)
- [`dashboard-all-tab-groups`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/ui/dashboard/block/all.html.twig#L6)
- [`dashboard-my-tab-groups`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/ui/dashboard/block/me.html.twig#L6)
- [`content-type-tab-groups`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/content_type/index.html.twig#L37)
- `calendar-widget-before`
- [`login-form-before`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/account/login/index.html.twig#L7)
- [`login-form-after`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/account/login/index.html.twig#L70)
- [`global-search`](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/Resources/views/themes/admin/ui/layout.html.twig#L129)

## Base component classes

If you only need to inject a short element (for example, a Twig template or a CSS link) without writing a class, you can make use of the following base classes:

- `TwigComponent` renders a Twig template.
- `LinkComponent` renders the HTML `<link>` tag.
- `ScriptComponent` renders the HTML `<script>` tag.

In this case, all you have to do is add a service definition (with proper parameters), for example:

``` yaml
appbundle.components.my_twig_component:
    parent: Ibexa\AdminUi\Component\TwigComponent
    autowire: true
    autoconfigure: false
    arguments:
        $template: path/to/file.html.twig
        $parameters:
            first_param: first_value
            second_param: second_value
    tags:
        - { name: ibexa.admin_ui.component, group: dashboard-blocks }
```

This renders the `path/to/file.html.twig` template with `first_param` and `second_param` as parameters.

With `LinkComponent` and `ScriptComponent` you provide `$href` and `$src` as arguments:

``` yaml
app.components.my_link_component:
    parent: Ibexa\AdminUi\Component\LinkComponent
    autowire: true
    autoconfigure: false
    arguments:
        $href: 'http://address.of/file.css'
    tags:
        - { name: ibexa.admin_ui.component, group: stylesheet-head }
```

``` yaml
app.components.my_script_component:
    parent: Ibexa\AdminUi\Component\ScriptComponent
    autowire: true
    autoconfigure: false
    arguments:
        $src: 'http://address.of/file.js'
    tags:
        - { name: ibexa.admin_ui.component, group: script-body }
```
