# Extending Back Office

The Back Office interface is produced by the [`ezplatform-admin-ui` bundle](https://github.com/ezsystems/ezplatform-admin-ui).
Additionally, it uses React-based modules that make each part of the UI extensible, and Bootstrap for styling.
React modules can be found in [`ezplatform-admin-ui-modules`](https://github.com/ezsystems/ezplatform-admin-ui-modules)
  that handle specific parts of the application.
The interface is accessible in your browser at `http://<yourdomain>/admin`.

To extend the Back Office with PHP code, you can use [events](https://symfony.com/doc/5.0/event_dispatcher.html),
either built-in Symfony events or events dispatched by the application.

Some extensibility, such as [adding custom tags](extending_online_editor.md#custom-tags),
is possible without writing your own code, with configuration and templating only.

To learn more, take a look at the [Extending Admin UI tutorial](../../tutorials/extending_admin_ui/extending_admin_ui.md)
or at the more specific cases in Extending Back Office section.

!!! note "String translations"

    Refer to [Custom string translations](../back_office_translations.md#custom-string-translations)
    to learn how to provide string translations when extending the Back Office.
