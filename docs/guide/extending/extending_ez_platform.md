# Extending eZ Platform

You can extend eZ Platform in many ways, including [customizing the Back Office](#extending-the-back-office)
and the content model, by [adding new Field Types](#adding-new-field-types).

## Extending the Back Office

The Back Office interface is produced by the [`ezplatform-admin-ui` bundle](https://github.com/ezsystems/ezplatform-admin-ui).
Additionally, [`ezplatform-admin-ui-modules`](https://github.com/ezsystems/ezplatform-admin-ui-modules)
contains React modules that handle specific parts of the application.
This interface is accessible in your browser at `http://<yourdomain>/admin`.

The Back Office uses React-based modules that make each part of the UI extensible,
and Bootstrap for styling.

To extend the Back Office with PHP code, you can use [events](https://symfony.com/doc/3.4/event_dispatcher.html),
either built-in Symfony events or events dispatched by the application.
See [Extending menus](extending_menus.md) for an example on how to use an event subscriber
to extend one of the menus in the Back Office.

Some extensibility, such as [adding custom tags](extending_online_editor.md#custom-tags),
is possible without writing your own code, with configuration and templating only.

!!! tip "Tutorial"

    Take a look at the [Extending Admin UI tutorial](../../tutorials/extending_admin_ui/extending_admin_ui.md)
    to learn how to go through some basic steps in extending the Back Office.

You can extend the Back Office by adding and extending:

- [Menus](extending_menus.md), such as the top bar or edit menu,
- [Dashboard](extending_dashboard.md), for example by modifying block order,
- [Tabs](extending_tabs.md), for example by adding new tabs in content preview,
- [Workflow](extending_workflow.md), by adding custom events to the workflow timeline,
- [User settings](extending_settings.md), by adding a new setting to the menu,
- [Online Editor](extending_online_editor.md), for example by adding custom tags or styles,
- [Page](extending_page.md#creating-page-blocks), by adding new blocks,
- [Forms](extending_form_builder.md#extending-form-fields), by adding new types of Form fields.

React modules enable you to extend:

- [Universal Discovery Widget](extending_modules.md#universal-discovery-module) used for content browsing,
- [Sub-items list](extending_modules.md#sub-items-list) presented in content preview,
- [Multi-file upload](extending_modules.md#multi-file-upload) for quick uploading of media files.

Additionally you can:

- [Add custom Content Type icons](extending_back_office.md#custom-content-type-icons),
- [Inject custom components](extending_back_office.md#injecting-custom-components) into the Back Office,
- [Format date and time](extending_back_office.md#format-date-and-time).

!!! note "String translations"

    Refer to [Custom string translations](../back_office_translations.md#custom-string-translations)
    to learn how to provide string translations when extending the Back Office.

!!! tip

    You can also see:

    - [a presentation about eZ Platform extensibility](https://www.slideshare.net/sunpietro/extending-ez-platform-2x-with-symfony-and-react)
    - [a case study of creating a new Field Type and extending eZ Platform UI](https://mikadamczyk.github.io/presentations/extending-ez-platform-ui/).

## Adding new Field Types

You can extend eZ Platform by adding new [Field Types](../../api/field_type_api.md).

To learn how to add a new Field Type, refer to the [Creating a Tweet Field Type tutorial](../../tutorials/field_type/creating_a_tweet_field_type.md).
