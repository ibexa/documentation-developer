---
description: Integrated help provides quick access to documentation, training, and support resources.
edition: lts-update
month_change: false
---

# Integrated help

Integrated help is an [LTS Update](editions.md#lts-updates) that brings documentation, training resources and product roadmap-related information into the back office.
With this feature installed, users can click the ![Help icon](about-info.png){.inline-image} icon to access relevant content straight from the UI.

![Integrated help menu](5_0_integrated_help_menu.png)

Integrated help is contextual, therefore, apart from user documentation, release notes, and partner guidelines, which are available to editors and store managers, developers can access API references, the GraphQL console, or the support portal.

## Install package

Integrated help is optional. 
To enable it, run the following command:

```bash
composer require ibexa/integrated-help
```

After installation, you must [enable the help center in user settings]([[= user_doc =]]/getting_started/discover_ui#enable-help-center) to use the feature.

## Customize help menu

You can extend or alter the integrated help menu by quickly changing the link to user documentation, or adding or removing menu items or even entire menu sections.

For more information, see [Customize integrated help](customize_integrated_help.md).
