---
description: Back Office holds the administrator and editor interface and allows creating, publishing and managing content, users, settings and so on.
---

# Back Office

The Back Office interface is produced by the [`ezplatform-admin-ui` bundle](https://github.com/ezsystems/ezplatform-admin-ui).
Additionally, it uses React-based modules that make each part of the UI extensible, and Bootstrap for styling.
React modules that handle specific parts of the application
can be found in [`ezplatform-admin-ui-modules`](https://github.com/ezsystems/ezplatform-admin-ui-modules)
The interface is accessible in your browser at `http://<yourdomain>/admin`.

To extend the Back Office with PHP code, you can use [events]([[= symfony_doc =]]/event_dispatcher.html),
either built-in Symfony events or events dispatched by the application.

Some extensibility, such as [adding custom tags](extending_online_editor.md#configure-custom-tags),
is possible without writing your own code, with configuration and templating only.

!!! note "String translations"

    Refer to [Custom string translations](../guide/back_office_translations.md#custom-string-translations)
    to learn how to provide string translations when extending the Back Office.
