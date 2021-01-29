# Step 3a - Filtering query results

In this step you will enable the content list to be filtered by Content Types.  The following tutorial requires the completed [Step 2 - Creating a top menu item](2_creating_a_content_list.md).

## Update routing

First, modify the route to the content list page.
In `config/routes.yaml` add the `contentTypeIdentifier` parameter and set its default value:

``` yml hl_lines="2 5"
[[= include_file('code_samples/back_office/menu/filtered_content_list/config/routes.yaml', 4, 10) =]]
```

## Modify the controller

Introduce changes to `src/Controller/AllContentListController.php`, so that it takes the selected Content Type into account.

First, provide the new `contentTypeIdentifier` parameter in the `listAction` function

``` php
[[= include_file('code_samples/back_office/menu/filtered_content_list/src/Controller/AllContentListController.php', 24, 25) =]]
```

Add the following block inside the `listAction` function, after defining `$criterions`:

``` php
[[= include_file('code_samples/back_office/menu/filtered_content_list/src/Controller/AllContentListController.php', 32, 36) =]]
```

After the lines setting the `$paginator` parameters, add the following code block:

``` php
[[= include_file('code_samples/back_office/menu/filtered_content_list/src/Controller/AllContentListController.php', 44, 50) =]]
```

Finally, provide the new parameter to `$this->render`, after `articles`:

``` php
[[= include_file('code_samples/back_office/menu/filtered_content_list/src/Controller/AllContentListController.php', 53, 54) =]]
```

<details class="tip">
<summary>Complete controller code</summary>
``` php hl_lines="25 33 34 35 45 46 47 48 49 54"
[[= include_file('code_samples/back_office/menu/filtered_content_list/src/Controller/AllContentListController.php') =]]
```
</details>

## Change the template

The last thing to do is to update the template by adding a drop-down menu for choosing Content Types.

Add the following block to `templates/list/all_content_list.html.twig`
inside `<section class="container my-4">`:

``` html+twig
[[= include_file('code_samples/back_office/menu/filtered_content_list/templates/list/all_content_list.html.twig', 19, 34) =]]
```

<details class="tip">
<summary>Complete template code</summary>
``` html+twig hl_lines="20 21 22 23 24 25 26 27 28 29 30 31 32 33 34"
[[= include_file('code_samples/back_office/menu/filtered_content_list/templates/list/all_content_list.html.twig') =]]
```
</details>

## Check results

!!! tip

    If you cannot see the results or encounter an error, clear the cache and reload the application.

At this point you should see a drop-down menu at the top of the content list.
Select a Content Type and the list will filter to show only Content items of this type.

![Filtered content list](img/content_list_dropdown.png "Filtered content list")
