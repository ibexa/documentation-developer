---
description: Integrated help provides quick access to documentation, training, and support resources.
edition: lts-update
month_change: true
---

# Integrated help

Integrated help is an [LTS Update](editions.md#lts-updates) that brings documentation, training resources, and product roadmap-related information into the back office, together with user onboarding capabilities.
With this feature installed, users can click the ![Help icon](about-info.png){.inline-image} icon to access relevant content straight from the UI.

![Integrated help menu](5_0_integrated_help_menu.png)

Integrated help is contextual, therefore, apart from user documentation, release notes, and partner guidelines, which are available to editors and store managers, developers can access API references, the GraphQL console, or the support portal.

## Product tours

Product tours are interactive guided walkthroughs that help back office users discover [[= product_name =]] features, available starting with [[= product_name =]] v4.6.29.
They provide step-by-step guidance directly within the application interface, accelerating user adoption and reducing training time.

Developers can create custom onboarding journeys tailored to specific client implementations, user roles, or business processes.

For more information, see [Product tour](product_tour.md).

## Install package

The Integrated help LTS Update is optional.
To enable it, run the following command:

```bash
composer require ibexa/integrated-help
```

After installation, the help center is enabled by default for all back office users.
If needed, they can [disable it in user settings]([[= user_doc =]]/getting_started/discover_ui#disable-help-center).
