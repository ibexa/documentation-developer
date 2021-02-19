# Shop-related Twig functions

## Functions

|Name|Parameters|Description|
|--- |--- |--- |
|`ses_render_field`|`CatalogElement $catalogElement`</br>`string $fieldIdentifier = ''`</br>`array $params = array()`|Renders a Field of a CatalogElement|
|`ses_product`|`array $params = array()`|Returns a product node</br>`{% set product = ses_product({'sku': line.sku, 'variantCode': line.variantCode }) %}`|
|`ses_variant_product_by_sku`|`string $sku`|Fetches a VariantProductNode for the given SKU|
|`ses_assets_main_image`|`CatalogElement $catalogElement`</br>`string $productId = null`|Returns the main image of CatalogElement or null|
|`ses_assets_image_list`|`CatalogElement $catalogElement`</br>`$productId = null`|Returns the list of images for a CatalogElement or an empty array|
|`ses_render_price`|`CatalogElement $catalogElement`</br>`PriceField $field`</br>`array $params = array()`|Renders a PriceField|
|`ses_render_stock`|`StockField $field = null,`</br>`array $params = array()`|Renders a StockField|
|`ses_render_specification_matrix`|`CatalogElement $catalogElement`|Renders the product specifications|
|`ses_basket`|-|Gets the basket of the current user|
|`ses_wish_list`|-|Gets the wishlist of the current user|
|`ses_total_comparison`|-|Gets total basket lines array for the basket flyout|
|`ses_check_product_in_comparison`|`$sku`</br>`$variantCode = null`|Returns true if product with the given SKU and variant code is already in the product comparison|
|`ses_check_product_in_wish_list`|`$sku`</br>`$variantCode = null`|Returns true if product with the given SKU and variant code is already in the wishList|
|`ses_pagination`|`Pagerfanta $pagerfanta`</br>`$viewName = null`</br>`array $options = array()`|Renders pagination|
|`get_stored_baskets`|-|Returns stored baskets for the current user|
|`ses_user_menu`|-|Returns the rendered user menu|
|`get_search_query`|-|Returns search query|
|`get_siteaccess_locale`|`$siteAccessName = null`|Returns the Symfony locale that matches the given SiteAccess. If no SiteAccess name is given, the current SiteAccess is used.</br>`{% set locale = get_siteaccess_locale('ger') %}`|
|`get_characteristics_b2b`|`VariantProductNode $catalogElement`</br>`array $order = array()`|Returns characteristics sorted for B2B|
|`has_user_role`|`$module`</br>`$function`|Checks if the user has a Role|
|`get_parent_product_catalog`|`CatalogElement $catalogElement`|Returns the Location ID of the parent product catalog|
|`get_data_location_ids`|`$object`|Returns a comma-separated string of `data_locations` of the given element.</br>All parent Locations including the element Location are returned.|
|`set_bold_text`|`$needle`</br>`$haystack`|Returns HTML with added `<strong>` tag(s) to needle occurrences in haystack.</br>Supports multiple words.|
|`has_subcategory`|`$locationId`</br>`$offset`</br>`$limit|Checks if the current category has subcategories|
|`get_customer_sku`|`$sku`</br>`$customerNumber`|Returns customer SKU for the given SKU with customer number|
|`get_sku`|`$customerSku`</br>`$customerNumber = null`|Returns SKU for the given customer SKU with customer number|
|`get_search_result_template`|`$catalogElement`|Renders a search card result of the catalog element|
|`ses_fetch_content_by_identifier`|`string $contentType`</br>`string $identifier`|Fetches a Content item of the specific type and a Field `identifier` with a specific value|
|`ses_config_parameter`|`$code`, `$domain`, `$scope = null`|Returns a SiteAccess parameter from the configuration|
|`st_imageconverter`|`Abstract $imageFieldstring $size`|Provides an image in the required resolution|
|`st_siteaccess_lang`|`string $siteAccessName`|Returns the prioritized language for the given SiteAccess|

## Filters

|Name|Parameters|Description|
|--- |--- |--- |
|date_format|`$date`</br>`$inputFormat = 'Y-m-d'`</br>`$locale = 'en'`</br>`$dateType = '\IntlDateFormatter::GREGORIAN'`</br>`$timeType = '\IntlDateFormatter::NONE'`</br>`$formatPattern = 'dd.MM.yyyy'`|Formats a date value|
|price_format|`$priceValue`</br>`$currency`</br>`$locale`|Formats a price value|
|youtube_video_id|`$youtubeUrl`|Returns a video ID from a Youtube URL|
|shipping|`Basket $basket`|Returns the shipping costs from the basket or null|
|code_label|`$code,`</br>`$context = null`|Returns the translated code label|
|basket_discounts|`Basket $basket`|Returns the discounts from the basket|
|basket_add_costs|`Basket $basket`|Returns the additional costs from the basket|
|basket_add_lines|`Basket $basket`|Returns the additional lines from the basket|
|sort_characteristic_codes|`array $characteristicCodes`</br>`$characteristicIndex`|By default the list of all variant codes is sorted alphabetically in the ASC order|
|sort_characteristics|`array $characteristics`</br>`$type`</br>`array $order = array()`|Returns sorted characteristics|
|ses_format_args|`$args`|Formats exception arguments|
|truncate|`$text`</br>`$limit`</br>`$break = ' '`</br>`$pad = '...'`|Truncates the given text</br>`$break` can be used to indicate where the truncate should break, e.g. words (`$break = ' '`), sentences (`$break = '.'`)|
|st_siteaccess_path|`string $urlPath`</br>`string $siteAccessName = null`|Formats the given URL path into a SiteAccess path, e.g. `home` -> `/de/home`|
|st_siteaccess_url|`string $urlPath`</br>`string $siteAccessName = null`|Formats the given URL path into a SiteAccess URL</br>e.g. `home` -> <your domain>/en/home|
|st_translate|`$messageOrCode`</br>`$context = ''`</br>`$array $parameters = array()`</br>`$domain = null`</br>`$siteaccess = null`|Returns translation for `$messageOrCode`|

## Global variables

The global variable `ses` provides information such as user profile data and delivery addresses.

|Name|Description|
|---|---|
|`ses.profile`|Returns the current customer profile|
|`ses.defaultBuyerAddress`|Returns the default `BuyerParty`|
|`ses.defaultDeliveryParty`|Returns the default `DeliveryParty`|
|`ses.deliveryParty`|Returns `DeliveryParty` by `$deliveryPartyId`. If no `$deliveryPartyId` is given, returns all parties.|
