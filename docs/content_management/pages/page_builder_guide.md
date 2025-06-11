---
description: Read about the Page Builder - a powerful tool for creating and modifying pages in Ibexa DXP.
edition: experience
month_change: false
---

# Page Builder product guide

## What is page

[Page](pages.md) is a block-based type of content.
You can create and modify it with a visual drag-and-drop editor - Page Builder.
Page is divided into zones into which you can drop various dynamic blocks.
By editing pages you can customize the layout and content of your website.

### Create page

To create a new page:

1\. In the main menu, go to **Content**.

2\. Select **Content structure**.

3\. On the right-side toolbar, click **Create content**.

4\. From the list of content items select **Landing Page**.

5\. Select the layout and click **Create**.

![Create page](create_page.png)

### Edit page

You can edit any existing page with the Page Builder.
To do it, in the back office go to **Content** and select **Content structure**.
Then, from the content tree choose the page and click **Edit**.

<!--ARCADE EMBED START--><div style="position: relative; padding-bottom: calc(51.27314814814815% + 41px); height: 0; width: 100%;"><iframe src="https://demo.arcade.software/d4T5EgOwz6bri2Zgy53M?embed&embed_mobile=tab&embed_desktop=inline&show_copy_link=true" title="Edit existing page" frameborder="0" loading="lazy" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="clipboard-write" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; color-scheme: light;" ></iframe></div><!--ARCADE EMBED END-->

## What is Page Builder

Page Builder is a visual tool that allows you to create and edit any page in [[= product_name =]].
It's more than managing: it's about building pages, creating customized content and fully-targeted landing pages.
Creating pages in Page Builder involves composing content from ready-to-use elements - blocks, properly configured and customized.
It's also important to choose a layout - it determines the arrangement of drop zones that contain content elements.

![Page Builder - diagram](page_builder_diagram.png)

### Availability

Page Builder is available in [[=product_name_exp=]] and [[=product_name_com=]].

### How does Page Builder work

#### Page Builder interface

Page Builder has plain and intuitive interface. You can create a Page without having advanced technical skills.

![Page Builder interface](page_builder_interface.png)

Page Builder user interface consists of:

A. Drop zone

B. Page blocks / Structure view toolbar

C. Settings toolbar (including Fields, Visibility and Schedule settings)

D. Mode toolbar (including PC, tablet and mobile mode)

E. Buttons:

|Button|Description|
|------|-----------|
|![Edit and preview switch](page_builder_toolbar_editpreview.png)|Access main properties of the page, like title and description.|
|![Preview segments](page_builder_toolbar_preview_segment.png)|Access preview of the page for a given segment.|
|![Timeline button](page_builder_toolbartimelinetoggler.png)|Access the timeline to preview how the page changes with time. You can also view the list of all upcoming scheduled events.|
|![View toggler](page_builder_toolbar_devicestoggler.png)|Toggle through to see how the page is rendered on different devices.|
|![Page blocks menu](page_builder_toolbarelements.png)|Move Page blocks / Structure view to the other side of the screen.|
|![Undo](page_builder_undo.png)|Undo latest change.|
|![Redo](page_builder_redo.png)|Redo latest change.|

F. Saving options

|Option|Description|
|------|-----------|
|Close|Close the page without saving it.|
|Send to review|Save the page and send it to review.|
|Publish / Publish later|Publish the page or schedule publishing for later.|
|Save draft|Save the page draft*.|
|Delete draft|Delete the page draft.|

*To help you preserve your work, system saves drafts of content items automatically.

For more information, see [Autosave]([[= user_doc =]]/content_management/content_versions/#autosave).

Page Builder has two main views that you can use while creating a page:

- Page blocks toolbar - consists of all available elements that you can use by dragging them and dropping on a drop zone.

![Page blocks](page_blocks_toolbar.png)

- Structure view - shows a structure of the page, including its division into zones and the blocks that it contains.
It follows the behavior of the content tree.
Structure view has ability to reorder blocks using drag and drop.

![Structure view](structure_view.png)

<!--ARCADE EMBED START--><div style="position: relative; padding-bottom: calc(51.27314814814815% + 41px); height: 0; width: 100%;"><iframe src="https://demo.arcade.software/kbdnGkdrkXL2VAJW6c3O?embed&embed_mobile=tab&embed_desktop=inline&show_copy_link=true" title="Page Builder interface" frameborder="0" loading="lazy" webkitallowfullscreen mozallowfullscreen allowfullscreen allow="clipboard-write" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; color-scheme: light;" ></iframe></div><!--ARCADE EMBED END-->

##### Choose layout

For newly created Page you can choose a [layout]([[= user_doc =]]/content_management/configure_ct_field_settings/#available-page-layouts) which defines the available zones.

Applying a layout divides the Page into the defined zones. The zones are placeholders for content items.

On the Page creation modal, select the layout and click **Create draft**.
Now you're ready to add blocks of content to the Page.

The page layouts that an editor has access to are up to you to choose.
In the `Select layouts` section, you can select layouts that you want to be available for the Page.

![Switch layout](switch_layout_window.png)

The default, built-in Page layout has only one zone, but developers can create other layouts in configuration.

For more information, see [Configure layout](render_page.md#configure-layout).

#### Add blocks

To customize your page in Page Builder you need to add blocks.
To do it, access Page blocks toolbar, drag page block that you want to use, and drop it on the empty place on a drop zone.

When you add a new block to the drop zone, drop it in the blue highlighted area. Before you drop it, a bold line appears  - it helps you see the position of the newly added block in relation to other, already added blocks.

![Drop zone line](drop_zone_line.png)

Ready-to-use blocks available in [[= product_name =]] have their own, unique functions, but you can also [add your own, custom blocks](create_custom_page_block.md). All available tools and settings, that Page Builder comes with, enable you to customize the content appearing on the page.

You can check all ready-to-use blocks available in Page Builder in User Documentation, [Block reference page]([[= user_doc =]]/content_management/block_reference/).

#### Work with blocks

Working with blocks is intuitive. You don't have to worry about placing blocks in the proper place from the start - you can reorder them at any time.
You can reorder blocks in a few ways:

- drag and drop block in the desired location on a drop zone
- select block and use up and down arrow on the keyboard
- access Structure view and use 'Move up' and 'Move down' function in the settings of the block or drag and drop to change the position in the structure

![Structure view - drag and drop](structure_view_drag_drop.png)

You can manage each block by accessing its settings. To do it, click settings icon next to the block's name.

![Block settings](block_settings.png)

Available settings are:

- Move up - allows you to change position of the block on the page by moving it up
- Move down - allows you to change position of the block on the page by moving it down
- Configuration - allows you to access configuration window
- Duplicate - duplicates a block with its settings, by creating a copy of it that appears below the original block
- Refresh - refreshes preview of the block
- Delete - deletes existing block

#### Distraction free mode

While configuring blocks that include Rich Text section, for example, Text block, you can switch to distraction free mode that expands the workspace to full screen.

![Distraction free mode](distraction_free_mode.png)

For more information, see [Distraction free mode]([[= user_doc =]]/content_management/create_edit_content_items/#distraction-free-mode).

#### Schedule content

Page Builder comes with a Scheduler, it allows you to schedule content appearance.

You can schedule content to be revealed, or hidden in Page Builder in two ways with:

- **Scheduler tab** - it's available in the configuration of all Page blocks. In this tab you can set the date and time when the block becomes visible and when it disappears from a Page.

![Scheduler tab](scheduler_tab.png)

- **Content Scheduler** - it's one of the blocks available in Page Builder Page blocks menu. To proceed with the schedule, go to **Basic** tab of the block, then click **Select content** and confirm your choice. Then set date and time in the **Content airtime settings** window.

![Content Scheduler](content_scheduler.png)

For more information, see [Schedule publication]([[= user_doc =]]/content_management/schedule_publishing/).

## Benefits

### Manage your pages without technical skills

Thanks to intuitive and plain Page Builder interface, you can create and manage your website without the need of having advanced technical skills.
Page blocks toolbar, visible page zones and Structure view - these are the elements that make working with Page Builder really intuitive and quick.

### Self schedule content, special offers and campaigns

One of the most important tools that Page Builder offers, is a Scheduler. It allows you to set and schedule a specific date and time for the content to be published or hidden. As a result, you can manage timeline of publications, without the need of manual publishing, or hiding each of them.

### Create high-converting and fully-targeted landing pages

Page Builder allows you to create highly customizable websites. You can build modifiable and targeted landing pages that meet your needs.
Each dynamic blocks has its own settings, properties and design that you can set up in your way to customize the content appearing on the page.
Additionaly, if you feel comfortable with your technical skills, you can configure your own elements, for example, a new customized layout, or block.

### Increase sales with highly personalized campaigns

Personalized campaigns are one of the factors that can increase your sales. 
With Page Builder you can achieve it, by using customization and time Scheduler.
Anytime you can edit your page and change a position of a block to enhance visibility.
Additionaly, Page Builder offers you a selection of ready-to-use page blocks that can help you to create content tailored to each individual customer:

A. **Default** blocks:

- Dynamic targeting - embeds recommended items based on the segment the user belongs to.
- Personalized - displays a list of content items/products that are recommended to end users when specific scenarios are triggered.
- Targeting - embeds a content item based on the segment the user belongs to.

B. **PIM** blocks:

- Last purchased - displays a list of products that were recently purchased from PIM.
- Last viewed - displays a list of products from PIM that were recently viewed.
- Product collection - displays a list of specifically selected products.
- Recently added - displays a list of products that were recently added to PIM.

C. **Commerce** blocks:

- Bestsellers - displays a list of products from PIM that were recently a bestseller.
- Orders - displays a list of orders associated with a particular company or individual customer.
