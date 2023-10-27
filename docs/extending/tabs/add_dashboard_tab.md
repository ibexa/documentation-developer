---
description: Add a new tab to the Back Office dashboard that welcomes every user after logging in.
---

# Create dashboard tab

To create a new tab in the dashboard, create an `EveryoneArticleTab.php` file in `src/Tab/Dashboard/Everyone`.
This adds a tab to the **Common content** dashboard block that displays all articles in the repository.

``` php hl_lines="17 45 57-60 70-72"
[[= include_file('code_samples/back_office/dashboard/article_tab/src/Tab/Dashboard/Everyone/EveryoneArticleTab.php') =]]
```

This tab searches for content with Content Type "Article" (lines 57-60)
and renders the results using the built-in `all_content.html.twig` template,
which ensures the tab looks the same as the existing tabs (lines 70-72).

The tab also implements OrderedTabInterface (line 17),
which enables you to define the order in which the tab is displayed on the dashboard page.
This is done using the `getOrder()` method (line 45).

Register this tab as a service:

``` yaml
[[= include_file('code_samples/back_office/dashboard/article_tab/config/custom_services.yaml') =]]
```
