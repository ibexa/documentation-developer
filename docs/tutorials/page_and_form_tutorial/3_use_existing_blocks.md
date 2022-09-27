---
description: Learn how to use and customize built-in Page blocks.
edition: experience
---

# Step 3 — Use existing blocks

In this step you'll add a Content List block and a Content Scheduler block and customize them.

### Add a Content List block

First, create an override template for the Content List block: `templates/blocks/contentlist/default.html.twig`:

``` html+twig hl_lines="10"
[[= include_file('code_samples/tutorials/page_tutorial/templates/blocks/contentlist/default.html.twig') =]]
```

Then add a configuration that will tell the app to use this template instead of the default one.
In `config/packages/ibexa_fieldtype_page.yaml` add the following code at the end of the file, under the `ibexa_fieldtype_page` key on the same level as `layouts`:

``` yaml
[[= include_file('code_samples/tutorials/page_tutorial/config/packages/ibexa_fieldtype_page.yaml', 13, 19) =]]
```

The template makes use of an [image variation](images.md) (line 10).
It is the thumbnail of the Dog Breed image that will be displayed in the block.
To configure this variation, open the `config/packages/image_variations.yaml` file and add the following code under the `image_variations` key:

``` yaml
[[= include_file('code_samples/tutorials/page_tutorial/config/packages/image_variations.yaml', 13, 18) =]]
```

Finally, add some styling to the block. Add the following CSS to the end of the `assets/css/style.css` file:

``` css
[[= include_file('code_samples/tutorials/page_tutorial/assets/css/style.css', 153, 176) =]]
```

Run `yarn encore <dev|prod>` to regenerate assets.

At this point you can start adding blocks to the Page.
You do it in the Page's Edit mode by dragging a block from the menu on the right to the correct zone on the page.

Drag a Content List block from the menu to the left zone on the page.
Click the block and fill in the form. Here you name the block and decide what it will display.
Choose the "Dog Breed Catalog" folder as the Parent, select Dog Breed as the Content Type to be displayed, and choose a limit (3).
You'll display the first three Dog Breeds from the database.

![Window with Content List options](enterprise_tut_content_list_window.png)

Click Submit and you should see a preview of what the block will look like with the dog breed information displayed.

![Content List Styled](enterprise_tut_content_list_styled.png "Content List Styled")

The block is displayed using the new template.
Built-in blocks have default templates included in a clean installation, but you can override them.
Publish the page now and move on to creating another type of block.

### Create a Content Scheduler block for featured articles

The next block is the Content Scheduler block that will air articles at predetermined times.

First, add a configuration that points to the layout. Go to `config/packages/ibexa_fieldtype_page.yaml` again and add the following code under `blocks` on the same level as the `contentlist` key:

``` yaml
[[= include_file('code_samples/tutorials/page_tutorial/config/packages/ibexa_fieldtype_page.yaml', 19, 24) =]]
```

The configuration defines one view for the Schedule block called `featured` and points to a `featured.html.twig` template.
Create the new file `templates/blocks/schedule/featured.html.twig`:

``` html+twig hl_lines="11"
[[= include_file('code_samples/tutorials/page_tutorial/templates/blocks/schedule/featured.html.twig') =]]
```

When you look at the template, you can see three blocks, each of which will render the Content items using the `featured` view (line 11).
So far you only have templates for `full` view for Articles. This means you need to create a `featured` view template,
otherwise you will get an error when trying to add Content to the block.

You need to modify the `config/packages/views.yaml` file to indicate when to use the template.
Add the following code to this file, on the same level as the `full` key:

``` yaml
[[= include_file('code_samples/tutorials/page_tutorial/config/packages/views.yaml', 39, 44) =]]
```

Now create a `templates/featured/article.html.twig` file:

``` html+twig
[[= include_file('code_samples/tutorials/page_tutorial/templates/featured/article.html.twig') =]]
```

Like in the case of the Content List block, the template specifies an image variation.
Add it in `config/packages/image_variations.yaml` under the `image_variations` key:

``` yaml
[[= include_file('code_samples/tutorials/page_tutorial/config/packages/image_variations.yaml', 18, 22) =]]
```

The Block is already operational, but first update the stylesheet. Add the following CSS at the end of the `assets/css/style.css` file:

``` css
[[= include_file('code_samples/tutorials/page_tutorial/assets/css/style.css', 177, 207) =]]
```

Run `yarn encore <dev|prod>` to regenerate assets.

At this point you can add a new Content Scheduler block to your Page and fill it with content to see how it works.

!!! tip

    If you do not see the featured block template, you may need to clear the cache (using `php bin/console cache:clear`) and/or reload the app.

Go back to editing the Home Page and drag a Content Scheduler block from the pane on the right to the main zone in the layout, above the Content List block.
Select the block and click the Block Settings icon.

Set the Limit to three and click Select Content.
Navigate to the "All Articles" folder and select the articles you had created and confirm.

![Selecting Articles for the Schedule Block](enterprise_tut_select_articles.png)

Accept the suggested airtime and click Submit.

Now click the Airtime button next to one of the Articles and choose a time in the future.
This article will be listed in the queue.

![Content Scheduler with scheduled content](enterprise_tut_choosing_airtime.png)

Publish the Page.

Now open the Timeline at the top of the screen.
You can move the slider to different times and preview what the Content Scheduler block will look like at different hours.
Content will be shown when you move the slider to the point when it airs.

!!! tip

    At this point you have configured the Content Scheduler block to work with Articles only.
    If you try to add Content of any other type, you will see an error.
    This is because there is no `featured` view for content other than Articles defined at the moment.

![Front Page after adding Featured Block](enterprise_tut_page_with_featured_articles.png "Front Page after adding Featured Block")
