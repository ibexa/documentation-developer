---
description: Back Office holds the administrator and editor interface and allows creating, publishing and managing content, users, settings and so on.
---

# Back Office

The Back Office interface is produced by the [`ibexa/admin-ui` bundle](https://github.com/ibexa/admin-ui).
Additionally, it uses React-based modules that make each part of the UI extensible, and Bootstrap for styling.
The interface is accessible in your browser at `http://<yourdomain>/admin`.

To extend the Back Office with PHP code, you can use [events]([[= symfony_doc =]]/event_dispatcher.html),
either built-in Symfony events or events dispatched by the application.

Some extensibility, such as [adding custom tags](extend_online_editor.md#configure-custom-tags),
is possible without writing your own code, with configuration and templating only.

!!! note "String translations"

    Refer to [Custom string translations](back_office_translations.md#custom-string-translations)
    to learn how to provide string translations when extending the Back Office.

[[= cards([
    "administration/back_office/back_office_configuration",
    "administration/back_office/back_office_menus/back_office_menus",
    "administration/back_office/back_office_tabs/back_office_tabs",
    "administration/back_office/back_office_elements/reusable_components",
    "administration/back_office/notifications",
    "administration/back_office/browser/browser",
    "administration/back_office/add_user_setting",
    "administration/back_office/customize_calendar",
], columns=4) =]]
