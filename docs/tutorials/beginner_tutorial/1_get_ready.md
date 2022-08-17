---
description: Start the tutorial by getting a clean installation of Ibexa DXP.
---

# Step 1 — Get ready

To begin the tutorial, you need a clean installation of [[= product_name =]].

Get it by following the [install Ibexa DXP](install_ibexa_dxp.md) guide.
You will need a web server, a relational database and PHP.

The clean installation contains only a root Content item which displays a welcome page.

![Front page after clean installation](bike_tutorial_homepage_install_clean.png)

You will replace the welcome page with your own in step 3.

To remove it for now, go to `config/packages/` and delete the `ibexa_welcome_page.yaml` file.

You can now start creating the content model.
