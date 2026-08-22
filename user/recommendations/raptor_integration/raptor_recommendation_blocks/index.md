# Recommendation block reference

Recommendation Page Builder blocks - Raptor integration.

Editions: Experience

The [Raptor](https://www.raptorservices.com/) integration add-on introduces a set of recommendation blocks. These blocks are available in [Page Builder](../../../content_management/create_edit_pages/index.md#page-builder-interface) and can be configured to control their behavior and output.

![Recommendation blocks](https://doc.ibexa.co/projects/userguide/en/5.0/recommendations/raptor_integration/img/recommendation_blocks.png)

Each recommendation block corresponds to a specific Raptor module. You can configure it in the [Raptor Control Panel](https://controlpanel.raptorsmartadvisor.com/) where parameters and settings can be modified.

![Raptor module](https://doc.ibexa.co/projects/userguide/en/5.0/recommendations/raptor_integration/img/raptor_module.png)

In Page Builder, only the required parameters for each block can be configured. Additional, optional settings are available through the **Go to advanced settings in Raptor** link. It redirects to the respective module configuration in the Raptor Control Panel, where these settings can be adjusted and saved.

![Advanced settings](https://doc.ibexa.co/projects/userguide/en/5.0/recommendations/raptor_integration/img/advanced_settings.png)

Raptor recommendations can be added to a landing page by using blocks that belong to the following categories:

## Recommendations: Content

The following blocks can be used to present content recommendations:

| Block                                                                                                                                       | Description                                                                                                                        |
| ------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| [Content that has been seen along with the item category](#content-that-has-been-seen-along-with-the-item-category-block)                   | Displays content frequently viewed together with items from the same category.                                                     |
| [Items associated with the given Content](#items-associated-with-the-given-content-block)                                                   | Generates a list of complementary and relevant products that customers often view with a given content.                            |
| [Merchandising content sorted by personal preferences and popularity](#merchandising-content-sorted-by-personal-preferences-and-popularity) | Sorts merchandising content by personal preferences and popularity.                                                                |
| [Most popular content](#most-popular-content-block)                                                                                         | Highlights the most frequently viewed content.                                                                                     |
| [Other customers have also seen this content](#other-customers-have-also-seen-this-content-block)                                           | Displays content viewed by other users with similar behavior.                                                                      |
| [Personalized content recommendations](#personalized-content-recommendations-block)                                                         | Provides personalized content recommendations based on user behavior and preferences.                                              |
| [User's content history](#users-content-history-block)                                                                                      | Compiles either a chronological list of recent interacted content or a list of most interacted content while the user is browsing. |

### Content that has been seen along with the item category block

Shows content that is often viewed together with items in the same category. Helps users discover related content.

This block uses the [GetContentBasedOnProductCategoryWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetContentBasedOnProductCategoryWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Product category** - Select product category.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

### Items associated with the given Content block

Generates a list of complementary and relevant products that customers often view with a given content. Increases average visits on products to increase the average order value.

This block uses the [GetItemsBasedOnContentWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetItemsBasedOnContentWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Select content for recommendations (optional)** - Choose content to show associated products for. Leave empty to use current page content.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

### Merchandising content sorted by personal preferences and popularity

Uses merchandising content and sorts it by personal preferences and popularity. Gives better control over recommendations while keeping content relevant to each customer.

This block uses the [GetMerchandisingContentWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetMerchandisingContentWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **FeedID** - Enter an identifier of the Feed.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

### Most popular content block

Highlights the most trending or popular content that is most frequently viewed by users across the website. It helps identify popular and relevant content items.

This block uses the [GetPopularContentWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetPopularContentWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

### Other customers have also seen this content block

Highlights content viewed by other users with similar behavior. Usually applied on the content page, returns content that is often viewed together with the given content. It increases the engagement of the customers by helping identify related and relevant content.

This block uses the [GetSimilarContentWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetSimilarContentWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Select content for recommendations** - Select content to be used for recommendations. This content is used as the basis for recommendations, allowing Raptor to suggest similar or related items.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

### Personalized content recommendations block

Generates complementary, personalized content tailored to each user based on their behavior and preferences. Increases relevance and engagement through personalized suggestions.

This block uses the [GetUserContentRecommendationsWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetUserContentRecommendationsWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

### User's content history block

Compiles either a chronological list of recent interacted content or a list of most interacted content while the user is browsing on your site.

This block uses the [GetUserContentHistoryWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetUserContentHistoryWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

## Recommendations: Product

The following blocks can be used to display product suggestions based on visitors’ browsing history:

| Block                                                                                                                                                                           | Description                                                             |
| ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------- |
| [Items of Customized Feeds sorted by personal preferences and popularity or trendiness](#items-of-customized-feeds-sorted-by-personal-preferences-and-popularity-or-trendiness) | Sorts Customized Feeds items using preferences, popularity, and trends. |
| [Most popular products](#most-popular-products-block)                                                                                                                           | Presents trending and highly popular products.                          |
| [Most popular products in category](#most-popular-products-in-category-block)                                                                                                   | Highlights products that are most popular in the category.              |
| [Other customers have also seen](#other-customers-have-also-seen-block)                                                                                                         | Shows products also viewed by other customers.                          |

### Items of Customized Feeds sorted by personal preferences and popularity or trendiness

Uses items from Customized Feeds and sorts them based on user preferences, popularity, and current trends. Helps customers discover more relevant content and enhances the overall customer experience.

This block uses the [GetMerchandisingItemsWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetMerchandisingItemsWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **FeedID** - Enter an identifier of the Feed.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

### Most popular products block

Presents products that are currently trending and widely popular among users. Its behavior is defined by the calculation type, interaction type, and aggregation period. Helps quickly identify top-performing and popular items.

This block uses the [GetPopularItemsWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetPopularItemsWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

Toggle the **Show only available items** option on to display only products that are currently in stock.

### Most popular products in category block

Displays the most popular products within a selected category. Its behavior is defined by the interaction type and aggregation period. Helps identify the most popular items within a specific category.

This block uses the [GetPopularItemsInCategoryWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetPopularItemsInCategoryWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Product category** - Select product category.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

Toggle the **Show only available items** option on to display only products that are currently in stock.

### Other customers have also seen block

Shows products viewed by users with similar behavior. Usually applied on the product page, returns items that are often viewed together with the given product. Enhances user experience by suggesting related products.

This block uses the [GetSimilarItemsWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetSimilarItemsWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Product code** - Enter a product code to be used as a base product or select the base product from the Product catalog.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

Toggle the **Show only available items** option on to display only products that are currently in stock.

## Recommendations: Commerce

The following blocks can be used to show recommendations based on visitors purchase history (buy and basket events):

| Block                                                                                                         | Description                                                                         |
| ------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------- |
| [Other customers have also purchased](#other-customers-have-also-purchased-block)                             | Displays items purchased by other customers who bought the same product.            |
| [The Personal Shopping Assistant](#the-personal-shopping-assistant-block)                                     | Assists users by suggesting relevant products in real time based on their activity. |
| [The Personal Shopping Assistant (additional sales)](#the-personal-shopping-assistant-additional-sales-block) | Encourages additional purchases by suggesting complementary items.                  |
| [The Personal Shopping Assistant (conversion)](#the-personal-shopping-assistant-conversion-block)             | Helps users discover better product matches through recommendations.                |
| [User's item history](#users-item-history-block)                                                              | Displays the user’s item history or current basket, sorted by recent or top items.  |

### Other customers have also purchased block

Suggests products commonly bought together. Helps users find related products to encourage additional purchases.

This block uses the [GetPIMRelatedItemsWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetPIMRelatedItemsWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Product code** - Enter a product code to be used as a base product or select the base product from the Product catalog.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

Toggle the **Show only available items** option on to display only products that are currently in stock.

### The Personal Shopping Assistant block

Provides real-time product recommendations based on user behavior. The web personal shopping assistant recommends items at each step of the customer journey, with a short-term focus. It helps users discover relevant items while browsing by providing personalized recommendations based on their current behavior.

This block uses the [GetUserItemRecommendationsWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetUserItemRecommendationsWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Product (optional)** - Add or select base product.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

Toggle the **Show only available items** option on to display only products that are currently in stock.

### The Personal Shopping Assistant (additional sales) block

Encourages users to purchase additional products. It offers complementary cross-selling at every stage of the customer journey, increasing the overall value of the sale.

This block uses the [GetUserCrossSellingItemsWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetUserCrossSellingItemsWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

Toggle the **Show only available items** option on to display only products that are currently in stock.

### The Personal Shopping Assistant (conversion) block

Guides users to the right product using similar product recommendations. This module suggests items based on user actions, helping them explore the product assortment and discover alternatives. It improves product fit and engagement.

This block uses the [GetUserLookAlikeItemsWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetUserLookAlikeItemsWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

Toggle the **Show only available items** option on to display only products that are currently in stock.

### User's item history block

Shows the user’s past or current basket items, sorted by recent activity or top items. Makes it easier to find and review previously viewed or added products. This module can be configured to return recently viewed items, most interacted items, or items currently in the basket.

This block uses the [GetUserItemHistoryWeb](https://controlpanel.raptorsmartadvisor.com/pc/customer/tnt/product/web/module/GetUserItemHistoryWeb) Raptor recommendation strategy.

On the **Properties** tab, set values in the following fields:

- **Name** – Enter a name for the page block.
- **Name displayed on page (optional)** - Enter a name for the block to be displayed on the page.
- **Recommendations limit** - Set the number of recommendations to be displayed. Default = 4.

Toggle the **Show only available items** option on to display only products that are currently in stock.

> **Tip: Tip**
>
> For a list of all blocks available in Page Builder, see [Block reference](../../../content_management/block_reference/index.md).
