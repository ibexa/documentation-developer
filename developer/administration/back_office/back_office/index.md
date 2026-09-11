# Back office

Back office holds the administrator and editor interface and allows creating, publishing and managing content, users, settings, and more.

The back office interface is produced by the [`ibexa/admin-ui` bundle](https://github.com/ibexa/admin-ui). Additionally, it uses React-based modules that make each part of the UI extensible, and Bootstrap for styling. The interface is accessible in your browser at `http://<yourdomain>/admin`.

To extend the back office with PHP code, you can use [events](https://symfony.com/doc/7.4/event_dispatcher.html), either built-in Symfony events or events dispatched by the application.

Some extensibility, such as [adding custom tags](../../../content_management/rich_text/extend_online_editor/index.md#configure-custom-tags), is possible without writing your own code, with configuration and templating only.

> **Note: String translations**
>
> Refer to [Custom string translations](../../../multisite/languages/back_office_translations/index.md#custom-string-translations) to learn how to provide string translations when extending the back office.

- [Back office configuration](../back_office_configuration/index.md): Configure default upload locations, pagination limits, and more settings for the back office.
- [Back office menus](../back_office_menus/back_office_menus/index.md): All menus in the back office are based on KnpMenuBundle and you can easily extend them with new items.
- [Back office tabs](../back_office_tabs/back_office_tabs/index.md): Tabs are used for content view, in dashboard, system information and other parts of the back office and are extensible.
- [Reusable components](../back_office_elements/reusable_components/index.md): Speed up creating back office templates with the help of ready-made reusable components.
- [Notifications](../notifications/index.md): You can send notifications to users who work with the back office by using notification bars or notifications in the user menu.
- [Browser](../browser/browser/index.md): Customize the configuration of the content browser.
- [Add user setting](../add_user_setting/index.md): Add the option to select a custom preference in user menu.
- [Customize calendar](../customize_calendar/index.md): Add custom events to the calendar and customize its looks.
