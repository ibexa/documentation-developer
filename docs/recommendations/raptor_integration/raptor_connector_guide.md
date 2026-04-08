---
description:  Discover Raptor integration - an add-on focused on recommendations and tracking customer behaviors.
month_change: true
---

# Raptor integration guide

Discover [Raptor](https://www.raptorservices.com/) integration - an add-on that is focused on recommendations and tracking customer behaviors.
It includes Raptor connector with tracking scripts and events, used to track and analyze customer behaviors, and a set of Recommendation blocks.

## What is Raptor connector

The SiteAccess-aware [Raptor connector](raptor_connector.md) provides a seamless integration between [[= product_name =]] and Raptor recommendation engine.

Its primary goal is to enable editors and managers to deliver personalized experiences across digital channels, which helps to increase conversion rates, drive sales, and improve user engagement.

By bringing content and recommendations together, the connector makes it easy to build and manage personalized experiences.

It provides a seamless integration layer that supports:

- event tracking of user interactions through the Tracking API
- delivery of tailored content through the Recommendations API
- flexible SiteAccess-aware configuration adapted to different sites and contexts

This approach simplifies integration while supporting personalization across different sites and markets.

## Availability

Raptor integration elements, such as tracking, twig functions, and public API, are available in all supported [[= product_name =]] editions starting from [[= latest_tag_5_0 =]] version.

Recommendation blocks provided in Page Builder, are available in [[= product_name_exp =]] edition.

## How does Raptor tracking work

To start [tracking](https://content.raptorservices.com/help-center/introduction-to-tracking-documentation) user interactions, the tracking script needs to be added to the website’s layout.
Tracking can be set up either on the client-side or server-side, depending on how you want to capture and process the events.

The tracking works differently depending on the mode you choose.
In server-side mode, it uses HTML placeholders and comments, handling all tracking without loading scripts in the browser.
In client-side mode, it inserts script tags so tracking runs directly in the browser.

You can switch between server and client tracking at any time by changing the tracking type to fit your setup and needs.

## Capabilities

### Tracking

Raptor [tracking functions](tracking_functions.md) allow you to collect data about how users interact with your products and content.

You can track product visits to better understand what users are viewing.
Provided [Twig functions](../../templating/twig_function_reference/recommendations_twig_functions.md) simplify the implementation, allowing developers to quickly add tracking to templates without complex setup.

This gives you the data you need to better understand user behavior, improve recommendations, and support personalization.

### Recommendation blocks

The Raptor Integration provides a set of ready-to-use recommendation blocks that can be added directly in the [Page Builder](page_builder_guide.md).

These blocks can be configured to adjust how they work and what they display.
Content, Product, and Commerce recommendations can be placed on landing pages using these components.

Editors can use these blocks to display tailored product recommendations, promote related content, and highlight items that are trending or recently viewed.

Recommendation blocks are organized into dedicated categories, each grouping blocks based on the type of recommendation they provide:

- **Recommendations: Content** - presents content recommendations:
    - [Most popular content]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#most-popular-content-block)
    - [Other customers have also seen this content]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#other-customers-have-also-seen-this-content-block)
    - [Personalized content recommendations]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#personalized-content-recommendations-block)
- **Recommendations: Product** - displays product suggestions based on visitors’ browsing history:
    - [Most popular products]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#most-popular-products-block)
    - [Most popular products in category]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#most-popular-products-in-category-block)
    - [Other customers have also seen]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#other-customers-have-also-seen-block)
- **Recommendations: Commerce** - shows recommendations based on visitors' purchase history (buy and basket events):
    - [The Personal Shopping Assistant]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#the-personal-shopping-assistant-block)
    - [User's item history or current basket items sorted by recent items or top items]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/#users-item-history-or-current-basket-items-sorted-by-recent-items-or-top-items-block)

![Recommendation blocks](recommendation_blocks.png)

For a complete description of Recommendation blocks see [Recommendation blocks in User Documentation]([[= user_doc =]]/personalization/raptor_integration/raptor_recommendation_blocks/).

### Advanced usage for complex tracking scenarios

For more complex tracking requirements, [PHP API](tracking_php_api.md) provides direct access to the service.
It lets you track custom user actions, create more detailed tracking logic, and support scenarios not covered by the standard client- or server-side setups.

## Benefits

### Understand user behavior

Thanks to tracking functions, you can capture how users interact with your products and content, giving you valuable insights into their behavior.
It helps you make data-driven decisions to improve engagement and personalize the user experience.

### Highlight recommendations

Use recommendation blocks on your websites to highlight content targeted at your customers.
Deliver relevant content and build trust in your brand.

### Suggest content to boost retention

Help users find content of their interest quicker.
Showing visitors content and products that match their interests helps keep them engaged and encourages them to come back.

### Meet customer expectations and increase engagement

Recommendation blocks highlight products that match customers' interests.
Tailored content boosts engagement by showing visitors information and products that align with their interests and fulfill their needs.
This strengthens the connection between your brand and your audience, encouraging them to spend more time on your site and return more often.

### Increase average order value

Use tracking for predictive analysis and find out what motivates users to put extra items into their carts.
Start building predictions of their behaviors and suggest products your visitors are willing to buy.

### Track performance and increase conversions

Use the Raptor service in your Commerce shop and see how recommendations drive sales.
Keep track of which recommendations are shown to visitors and measure conversion rates to evaluate their effectiveness against your goals.

### Flexible tracking with PHP API

Tracking using PHP API gives you full control over how events are recorded and processed.
You can use it for complex scenarios, so tracking can be adapted to your specific needs or business requirements.
