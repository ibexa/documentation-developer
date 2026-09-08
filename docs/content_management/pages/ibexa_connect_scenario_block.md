---
description: Work with Ibexa Connect scenario block that retrieves and displays data from an Ibexa Connect webhook.
---

# [[= product_name_connect =]] scenario block

[[= product_name_connect =]] scenario block retrieves and displays data from an [[= product_name_connect =]] webhook.
Scenario block is a regular [Page block](page_blocks.md) and can be configured on field definition level as any other block.

## Configure [[= product_name_connect =]] scenario block in Page Builder

To use the [[= product_name_connect =]] scenario block, in your Page add the [[= product_name_connect =]] block by dragging it from the menu to a drop zone and enter block settings.

- In the **Basic** tab in **Webhook link** field, provide a link to an [[= product_name_connect =]] webhook, for example, `https://connect.ibexa.co/3/scenarios/688/edit`:

![Ibexa Connect Basic tab](ibexa_connect_basic_tab.png)

- In the **Design** tab, extend the drop-down list in the **View** field and choose one of the [views configured for the block](page_blocks.md#block-templates).

![Ibexa Connect Design tab](ibexa_connect_design_tab.png)

Click **Submit** button to confirm.
After submitting the block, page refreshes and [[= product_name_connect =]] block displays data from provided [[= product_name_connect =]] webhook.

![Ibexa Connect webhook preview](ibexa_connect_webhook_preview.png)
