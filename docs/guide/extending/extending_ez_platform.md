# Extending eZ Platform UI

## Back Office interface

The Back Office interface is produced by [the ezplatform-admin-ui Bundle](https://github.com/ezsystems/ezplatform-admin-ui)
together with [ezplatform-admin-ui-modules](https://github.com/ezsystems/ezplatform-admin-ui-modules),
which contains React modules that handle specific parts of the application.
This interface is accessible in your browser at `http://[uri_of_platform]/admin`.

The Back Office uses React-based modules that make each part of the UI easily extensible.
The interface uses Bootstrap, which facilitates adapting and styling the interface to your needs.

!!! tip

    You can also see:

    - [a presentation about eZ Platform extensibility](https://www.slideshare.net/sunpietro/extending-ez-platform-2x-with-symfony-and-react)
    - [a case study of creating a new Field Type and extending eZ Platform UI](https://mikadamczyk.github.io/presentations/extending-ez-platform-ui/).

## General extensibility

You can extend the Back Office in the following areas:

- [Menus](extending_menus.md)
- [Dashboard](extending_dashboard.md)
- [Tabs](extending_tabs.md)
- [Custom Content Type icons](extending_back_office.md#custom-content-type-icons)
- [Workflow event timeline](extending_workflow.md)
- [Injecting custom components](extending_back_office.md#injecting-custom-components)
- [Format date and time](extending_back_office.md#format-date-and-time)
- [Settings](extending_settings.md)
- [Universal Discovery module](extending_modules.md#universal-discovery-module)
- [Sub-items list](extending_modules.md#sub-items-list)
- [Multi-file upload](extending_modules.md#multi-file-upload)
- [Online Editor](extending_online_editor.md)
- [Page blocks](extending_page.md#creating-page-blocks)
- [Form fields](extending_form_builder.md#extending-form-fields)

!!! note "String translations"

    Refer to [Custom string translations](back_office_translations.md#custom-string-translations)
    to learn how to provide string translations when extending the Back Office.
