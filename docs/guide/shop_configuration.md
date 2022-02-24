# Shop configuration

To change configuration settings for the shop, go to **eCommerce** > **Configuration settings**.

For some of the settings, you can configure them differently for different SiteAccesses.

!!! note

    Make sure you have Commerce enabled. For more information, see [Enable Commerce features](../guide/config_back_office.md#enable-commerce-features).

![](img/shop_configuration_settings.png)

!!! caution

    Settings made in the Back Office always override the configuration in YAML files.

## Catalog

|Name|Description|
|--- |--- |
|Layout product category page|Layout for the product category page.</br>`category` - Show category boxes only.</br>`product_list` - Show products only.</br>`both` - Show both categories and products.|
|Last viewed product limit|The maximum number of last viewed products to store (per user).|
|Product description character limit|Number of characters from the Subtitle Field that are visible as description in the list views and search results.|

## Price

|Name|Description|
|--- |--- |
|Automatic currency conversion|When enabled, calculates the price using the configured conversion rate if no price is set up for the current currency.|
|Currency conversion rate|The conversion rate between currencies.|
|Default currency|Used as a fallback when SiteAccess-specific currency is not set.|
|Base currency|Base currency of the shop, used for the Fields "Product unit price" and "Fallback shipping price". The base currency is used for the automatic currency conversion.|
|Price providers|Price engines used for generating price and stock information in different parts of the shop. This configuration works as a chain, so if the first engine fails, the second one is used.|

## Advanced catalog features 

|Name|Description|
|--- |--- |
|User interface for ordering variants|User interface used for ordering variants on the product detail page. `B2B` is optimized for ordering more than one product at once. `B2C` enables ordering a single product only, but is more user friendly.

## Fallback configuration for price engine

This fallback configuration is used if no shipping costs are set in price and stock management.

|Name|Description|
|--- |--- |
|Fallback costs for shipping|Shipping cost used when the free shipping limit is not reached.|
|Fallback VAT Code for shipping costs|VAT code for shipping.|

## Basket

|Name|Description|
|--- |--- |
|Duration of storing anonymous baskets|How long anonymous baskets are stored (in hours).|
|Update product data after this time|How long  product data is cached in the basket. Use a "1 hour" syntax.|

## Stored basket

|Name|Description|
|--- |--- |
|Display stock as a column|When enabled, stock information is displayed in a separate column, otherwise, it is displayed inline (inside the product name column).|
|Description character limit|Number of characters from the Subtitle Field that are visible as description.|

## Wishlist

|Name|Description|
|--- |--- |
|Description character limit|Number of characters from the Subtitle Field that are visible as description.|

## Miscellaneous

|Name|Description|
|--- |--- |
|Number of bestsellers displayed on bestseller page|The limit of bestselling items displayed on the bestseller page.|
|Number of bestsellers displayed on catalog pages|The limit of bestselling items displayed on catalog pages.|
|Number of bestsellers displayed in a slider|The limit of bestselling items displayed in a slider.|
|Bestseller threshold|How often a product has to be bought to count as a bestseller.|

## Checkout

|Name|Description|
|--- |--- |
|Payment method PayPal|Enables PayPal in checkout.|
|Payment method "invoice"|Enables invoice in checkout.|
|Shipping method "standard"|Enables the standard shipping method in checkout.|
|Shipping method "express"|Enables the express shipping method in checkout.|
