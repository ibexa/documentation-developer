# Step 1 - Creating a My dashboard tab

**My dashboard** is the front page that you visit after logging in to the Back Office.
You can also get to it from any other page by selecting the site logo in the top left corner.
By default, the **My dashboard** page contains following blocks: "My content" and "Common content", which list Content items and Media.

![Unmodified dashboard](img/dashboard.png)

In this step you will add a new tab to the "Common content" block in the dashboard.
This tab, called "Articles", will list ten most recently modified Content items of the Content Type `article`.

!!! tip

    To be able to view the results of this step, create a few Content items of the type "Article".

## Register a service

First, add the following block to `config/services.yaml`. Place the block indented, under the `services` key:

``` yaml
[[= include_file('code_samples/back_office/dashboard/article_tab/config/services.yaml', 33, 39) =]]
```

The tags indicate that this is a tab on the **My dashboard** page that will be placed in the "Common content" block.

This configuration points to the `EveryoneArticleTab.php` file, which you now need to create.

## Create a tab

Create an `EveryoneArticleTab.php` file in `src/Tab/Dashboard/Everyone`:

``` php hl_lines="17 47"
[[= include_file('code_samples/back_office/dashboard/article_tab/src/Tab/Dashboard/Everyone/EveryoneArticleTab.php') =]]
```

!!! tip

    The tab extends `AbstractTab`.
    There are also [other tab types that you can extend](../../extending/extending_tabs.md).

The tab also implements `OrderedTabInterface` (see line 17), which enables you to define the order in which the tab is displayed on the **My dashboard** page.
This is done using the `getOrder` method (see line 47).

The rendering is done using the built-in `all_content.html.twig` template,
which ensures the tab looks the same as the existing tabs.

## Check results

!!! tip

    If you cannot see the results or encounter an error, clear the cache and reload the application.

At this point you can go to the **My dashboard** page in the Back Office: select the site logo in the top left corner.
In the "Common content" block you can see the new "Articles" tab with the first ten articles in the Repository.

![Articles tab in My dashboard](img/dashboard_articles_tab.png "Articles tab in My dashboard")
