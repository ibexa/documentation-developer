---
description: Try creating a custom page block with specific logic.
edition: experience
---

# Step 4 — Create a custom block

This step guides you through creating a custom block.
The custom block displays a randomly chosen content item from a selected folder.

To create a custom block from scratch you need four elements:

- block configuration
- a template
- a listener
- the listener registered as a service

### Block configuration

In `config/packages/ibexa_fieldtype_page.yaml` add the following block under the `blocks` key:

``` yaml hl_lines="10"
[[= include_file('code_samples/tutorials/page_tutorial/config/packages/ibexa_fieldtype_page.yaml', 24, 42) =]]
```

This configuration defines one attribute, `parent`.
Use it to select the folder containing tips.

### Block template

You also need to create the block template, `templates/blocks/random/default.html.twig`:

``` html+twig
[[= include_file('code_samples/tutorials/page_tutorial/templates/blocks/random/default.html.twig') =]]
```

### Block listener

Block listener provides the logic for the block.
It's contained in `src/Event/RandomBlockListener.php`:

``` php
[[= include_file('code_samples/tutorials/page_tutorial/src/Event/RandomBlockListener.php') =]]
```

At this point the new custom block is ready to be used.

You're left with the last cosmetic changes.
First, the new Block has a broken icon in the **Page blocks** toolbox in page mode.
This is because you haven't provided this icon yet.
If you look back to the YAML configuration, you can see the icon file defined as `random_block.svg` (line 4). Download [the provided file](https://github.com/ibexa/documentation-developer/blob/master/code_samples/tutorials/page_tutorial_starting_point/public/assets/images/blocks/random_block.svg) and place it in `public/assets/images/blocks`.

Finally, add some styling for the new block. Add the following to the end of the `assets/css/style.css` file:

``` css
[[= include_file('code_samples/tutorials/page_tutorial/assets/css/style.css', 208, 228) =]]
```

Run `yarn encore <dev|prod>` to regenerate assets.

Go back to editing the front page.
Drag a Random Block from the **Page blocks** toolbox on the right to the page's side column.
Access the block's settings and choose the "All Tips" folder from the menu. Save and publish all the changes.

Refresh the home page.
The Tip of the Day block displays a random Tip from the "Tips" folder.
Refresh the page a few more times and you can see the tip change randomly.

![Random Block with a Tip](enterprise_tut_random_block.png "Random Block with a Tip")
