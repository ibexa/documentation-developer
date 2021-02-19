# Shop cache [[% include 'snippets/commerce_badge.md' %]]

[[= product_name =]] uses different caches for the shop, including HTTP cache, which can greatly increase shop performance.
Dynamic parts of the shop, such as basket preview or prices, are displayed using dynamic caching features such as ESI or JavaScript.

## ESI-rendered blocks in the shop

|Controller|Purpose|Cache settings|
|--- |--- |--- |
|`SilversolutionsEshopBundle:CustomerProfileData:showHeaderLogin`|Displays information about the logged-in user in the top part of the page|Purged after login/logout and delegation process|
|`IbexaPlatformCommerceCheckoutBundle:Basket:showBasketPreview`|Displays a short version of the basket in the top part of the page|Purged when basket changes</br>Tags: `siso_basket_<basketid>`</br>`siso_user_<userid>`|
|`SilversolutionsEshopBundle:PageLayout:getFooter`|Footer information shared among all pages|Caching strategy `service_menu`|
|`SilversolutionsEshopBundle:Bestsellers:getBestsellersEsi`</br>`SilversolutionsEshopBundle:Bestsellers:getCategoryBestsellers`|Bestseller box for catalog pages|Caching strategy `product_list`|
|`SilversolutionsEshopBundle:ProductType:productList`|Product type list page|Caching strategy `product_type_children`|
|`IbexaPlatformCommerceCheckoutBundle:Basket:showStoredBasketPreview`|Displays a badge with the number of products in stored comparison or the number of stored baskets|Caching strategy `basket_preview`</br>Purged when basket changes</br>Tags: `siso_basket_<basketid>`|
|`SilversolutionsEshopBundle:Navigation:showMenu`|Left menu|Tag: `siso_menu`|
|`SilversolutionsEshopBundle:Navigation:showMenu`|Main menu|Tag: `siso_menu`|

All cache blocks are described in the `silver_eshop.default.http_cache` parameter in `parameters.yml`:

``` yaml
silver_eshop.default.http_cache:
    product:
        # Response max age in seconds. Zero means that this response will not be cached.
        max_age: 28800
        vary: ~
    product_list:
        max_age: 28800
        vary: ~
```

## Shop cache tags

[[= product_name_com =]] uses cache tags to tag and purge content.

|Tag|Used for|Purged|
|--- |--- |--- |
|`siso_basket_<id>`|Basket preview in the header|By event, on basket change|
|`siso_menu`|Main menu and left side menus (product catalog)||
|`content-<contentid>`|Textmodules|When content (text modules) are changed|
|`siso_user_<userid>`|User-specific data (shows name of the user)|When the user logs in or out|

## Purging caches

You can purge the shop's HTTP cache with the `ibexa:commerce:purge-http-cache` command.

By default, the command purges all shop-related HTTP caches.
You can specify cache identifiers to purge as a space-separated list, for example:

``` bash
php bin/console ibexa:commerce:purge-http-cache 1056 222 --env="prod"
```
