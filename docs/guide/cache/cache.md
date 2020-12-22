# Cache [[% include 'snippets/commerce_badge.md' %]]

[[= product_name_com =]] uses different caches, including HTTP cache, which can greatly increase shop performance.
Dynamic parts of the shop such as basket preview or prices are displayed using dynamic caching features such as ESI or JavaScript.

This ensures that only small parts of a page have to be generated in real time.

## Usaging ESI-rendered blocks

|Controller|Purpose|Cache settings|
|--- |--- |--- |
|`SilversolutionsEshopBundle:CustomerProfileData:showHeaderLogin`|Displays information about the logged-in user in the top part of the page|Purged after login/logout and delegate process|
|`SilversolutionsEshopBundle:Basket:showBasketPreview`|Displays a short version of the basket in the top part of the page|Purged when basket changes.</br>Tags: `siso_basket_<basketid>`</br>`siso_user_<userid>`|
|`SilversolutionsEshopBundle:PageLayout:getFooter`|Footer information shared among all pages|caching strategy `service_menue`|
|`SilversolutionsEshopBundle:Bestsellers:getBestsellersEsi`|Bestseller Box for catalog pages|caching strategy `product_list`|
|`SilversolutionsEshopBundle:Bestsellers:getCategoryBestsellers`</br>`SilversolutionsEshopBundle:EzFlow:showLastViewedProducts`|Shows last viewed products e.g. on Landing Page|caching strategy `product_list`|
|`SisoSearchBundle:Search:productList`|Shows the product list for the logged-in user|no caching|
|`SilversolutionsEshopBundle:ProductType:productList`|Product type list page|caching strategy `product_type_children`|
|`SilversolutionsEshopBundle:Basket:showStoredBasketPreview`|User menu: displays a badge with the number of products in stored comparison or the number of stored baskets|caching strategy `basket_preview`</br>Purged when basket changes.</br>Tags: `siso_basket_<basketid>`|
|`SilversolutionsEshopBundle:Navigation:showMenu`|Left menu|Tag: `siso_menu`|
|`SilversolutionsEshopBundle:Navigation:showMenu`|Main menu|Tag: `siso_menu`|

Caching strategies are defined in configuration, see: [HTTP caching](content_cache_refresh/http_caching.md).

## Usage of cache tags

[[= product_name_com =]] uses cache tags to tag and purge content.

|Tag|Used for|Purged|
|--- |--- |--- |
|`siso_basket_<id>`|Basket preview in the header|By event, on basket change|
|`siso_menu`|Main menu and left side menus (product catalog)||
|`content-<contentid>`|Textmodules|When content (text modules) are changed|
|`siso_user_<userid>`|User-specific data (shows name of the user)|When the user logs in or out|
