# Twig extension [[% include 'snippets/commerce_badge.md' %]]

[[= product_name_com =]] offers the following Twig functions and filter for use in templates:

## Functions

|Name|Parameters|Description|
|--- |--- |--- |
|`ses_render_field`|`CatalogElement $catalogElement`</br>`string $fieldIdentifier = ''`</br>`array $params = array()`|Renders a CatalogElement containing a Field|
|`ses_navigation`|`array $params = array()`|Returns navigation node tree|
|`ses_product`|`array $params = array()`|Returns a product node</br>`{% set product = ses_product({'sku': line.sku, 'variantCode': line.variantCode }) %}`|
|`ses_variant_product_by_sku`|`string $sku`|Fetches a VariantProductNode for the given SKU|
|`ses_assets_main_image`|`CatalogElement $catalogElement`</br>`string $productId = null`|Returns the main image of CatalogElement or null|
|`ses_assets_image_list`|`CatalogElement $catalogElement`</br>`$productId = null`|Returns the list of images for a CatalogElement or an empty array|
|`ses_variants_sort`|`VariantProductNode $node`</br>`$order = array()`|Returns all product variants in a given order|
|`ses_render_price`|`CatalogElement $catalogElement`</br>`PriceField $field`</br>`array $params = array()`|Renders a PriceField|
|`ses_render_stock`|`StockField $field = null,`</br>`array $params = array()`|Renders a StockField|
|`ses_basket`|-|Gets the basket of the current user|
|`ses_wish_list`|-|Gets the wishlist of the current user|
|`ses_total_comparison`|-|Gets total basket lines array for basket flyout|
|`ses_check_product_in_comparison`|`$sku`</br>`$variantCode = null`|Returns true if product with the given SKU and variant code is already in the product comparison|
|`ses_check_product_in_wish_list`|`$sku`</br>`$variantCode = null`|Returns true if product with the given SKU and variant code is already in the wishList|
|`ses_pagination`|`Pagerfanta $pagerfanta`</br>`$viewName = null`</br>`array $options = array()`|Renders pagination|
|`get_stored_baskets`|-|Returns stored baskets for the current user|
|`ses_user_menu`|-|Returns rendered user menu</br>Combines parts of all configured bundles|
|`ses_track_basket`|`Basket $basket`</br>`$mode`</br>`array $params = array()`|Returns a list with rendered template snippets for basket tracking|
|`ses_track_product`|`ProductNode $catalogElement`</br>`$mode`</br>`array $params = array()`|Returns a list with rendered template snippets for product tracking|
|`ses_track_base`|`array $params = array()`|Returns a list with rendered template snippets for general tracking|
|`get_search_query`|-|Returns search query|
|`get_siteaccess_locale`|`$siteAccessName = null`|Returns the Symfony locale that matches the given SiteAccess. If no SiteAccess name is given, the current SiteAccess is used.</br>`{% set locale = get_siteaccess_locale('ger') %}`|
|`get_characteristics_b2b`|`VariantProductNode $catalogElement`</br>`array $order = array()`|Returns characteristic sorted for B2B|
|`has_user_role`|`$module`</br>`$function`|Checks if the user has a Role|
|`get_parent_product_catalog`|`CatalogElement $catalogElement`|Fetches the parent product catalog element for the `$identifier`|
|`get_data_location_ids`|`$object`|Returns a comma-separated string of `data_locations` of the given element.</br>All parent Locations including the element Location are returned.|
|`set_bold_text`|`$needle`</br>`$haystack`|Returns HTML with added `<strong>` tag(s) to needle occurrences in haystack.</br>Supports multiple words.|
|`has_subcategory`|`$locationId`</br>`$offset`</br>`$limit|Checks if the current category has subcategories|
|`get_customer_sku`|`$sku`</br>`$customerNumber`|Returns customer SKU for the given SKU with customer number|
|`get_sku`|`$customerSku`</br>`$customerNumber = null`|Returns SKU for th given customer SKU with customer number|
|`get_search_result_template`|`$catalogElement`|Selects the correct template according to catalog element type|
|`ses_fetch_content_by_identifier`|`string $contentType`</br>`string $identifier`|Fetches a Content item of the specific type and a Field `identifier` with a specific value|
|`ses_config_parameter`|`$code, $domain, $scope = null`|Returns a SiteAccess parameter from the configuration|
|`st_imageconverter`|`Abstract $imageFieldstring $size`|Provides an image in the required resolution|
|`st_siteaccess_lang`|`string $siteAccessName`|Returns the prioritiest language for given siteaccess|
|`st_tag`|`$component`</br>`$target`</br>`$action`</br>`$id = null`</br>`$value = null`|Returns the selector tag for Behat tests or for Google tag management|

## Filters

|Name|Parameters|Description|
|--- |--- |--- |
|date_format|`$date`</br>`$inputFormat = 'Y-m-d'`</br>`$locale = 'en'`</br>`$dateType = '\IntlDateFormatter::GREGORIAN'`</br>`$timeType = '\IntlDateFormatter::NONE'`</br>`$formatPattern = 'dd.MM.yyyy'`|Formats a date value|
|price_format|`$priceValue`</br>`$currency`</br>`$locale`|Formats a price value</br>default parameters in `silver.eshop.yml`</br>`silver_eshop.default.price_format_currency: EUR`</br>`silver_eshop.default.price_format_locale: en`|
|youtube_video_id|`$youtubeUrl`|Returns a video ID from a Youtube URL|
|shipping|`Basket $basket`|Returns the shipping costs from the basket or null|
|code_label|`$code,`</br>`$context = null`|Returns the translated code label. This can be e.g. country code or a different code.</br>If the context is `country`, first Symfony Intl Bundle is used to resolve the country code to a country name, otherwise just the translation for the code is returned|
|basket_discounts|`Basket $basket`|Returns the discounts from the basket|
|basket_add_costs|`Basket $basket`|Returns the additional costs from the basket|
|basket_add_lines|`Basket $basket`|Returns the additional lines from the basket|
|code_label|`$code`</br>`$context = null`|Returns the translated code label.</br>If the context is `country`, first Symfony Intl Bundle is used to resolve the country code to country name|
|sort_characteristic_codes|`array $characteristicCodes`</br>`$characteristicIndex`|By default the list of all variant codes is sorted alphabetically in the ASC order|
|sort_characteristics|`array $characteristics`</br>`$type`</br>`array $order = array()`|Returns sorted characteristics|
|ses_format_args|`$args`|Formats exception arguments|
|truncate|`$text`</br>`$limit`</br>`$break = ' '`</br>`$pad = '...'`|Truncates the given text</br>`$break` can be used to indicate where the truncate should break, e.g. words (`$break = ' '`), sentences (`$break = '.'`)|
|st_siteaccess_path|`string $urlPath`</br>`string $siteAccessName = null`|Formats the given URL path into a SiteAccess path, e.g. `home` -> `/de/home`|
|st_siteaccess_url|`string $urlPath`</br>`string $siteAccessName = null`|Formats the given URL path into a SiteAccess URL</br>e.g. `home` -> <your domain>/en/home|
|st_translate|`$messageOrCode`</br>`$context = ''`</br>`$array $parameters = array()`</br>`$domain = null`</br>`$siteaccess = null`|Returns translation for `$messageOrCode`|
|st_resolve_template|`$templateName, $theme = null`|Returns resolved template name with `TemplateResolverService`|

## Global variables

There is a central global variable `ses` provided by the `EshopBundle`.
This variable is an instance of the `GlobalVariables` class which provides methods and is inherited from the Symfony global variable class.
All methods from the global template variable `app` are also available in `ses`.

|           |                                              |
| --------- | -------------------------------------------- |
| Class     | `GlobalVariables`                            |
| Namespace | `Silversolutions\Bundle\EshopBundle\Twig` |

### Methods for global variable `ses`

#### `getProfile()`

Aliases:

- `getProfileData()`
- `getCustomerProfileData()`

This method returns the current customer profile.

``` html+twig
Current customer number: {{ ses.profile.sesUser.customerNumber }}
```

- `ses` - global Twig variable
- `profile` - `public method GlobalVariables::getProfile()`
- `sesUser` - `SesUser` from `CustomerProfileData` returned by `getProfile()`
- `customerNumber` - readable variable from `SesUser->customerNumber`

#### `getDefaultBuyerAddress()`

This method returns the default BuyerParty.

``` html+twig
{% set buyerAddress = ses.defaultBuyerAddress %}
Street name of buyer address: {{ buyerAddress.PostalAddress.StreetName }}
```

#### `getDefaultDeliveryParty()`

This method returns the default DeliveryParty.

``` html+twig
{% set deliveryAddress = ses.defaultDeliveryParty %}
Street name of default delivery address: {{ buyerAddress.PostalAddress.StreetName }}
```

#### `getDeliveryParty($deliveryPartyId = null)`

This method returns `DeliveryParty` by `$deliveryPartyId`. If no `$deliveryPartyId` is given, all parties will be returned

``` html+twig
{% set deliveryAddresses = ses.deliveryParty %}
{% for address in deliveryAddresses %}
    Street Number {{ loop.index }}: {{ deliveryAddress.PostalAddress.StreetName }}
{% endfor %}
```
