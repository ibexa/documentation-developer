---
description: Integrate the tracking script to collect user interactions.
month_change: true
---

# Tracking script

`ibexa_tracking_script` function allows to embed main tracking script into the website.
It loads the initial script into `window.raptor`, enabling event tracking, for example, page visits, product views, or buys, from the frontend.
It can be overridden in multiple ways to support custom implementations and to render code snippet through [[= product_name_base =]] Design Engine.

Tracking can be conditionally initialized depending on cookie consent logic.
By default, the function returns the script for client-side use, while it can return nothing when used server-side.

## Embed tracking script

To enable tracking, tracking script must be embedded into the website’s layout.

