# Product comparison templates [[% include 'snippets/commerce_badge.md' %]]

## Template list

|Path|Description|
|--- |--- |
|`Comparison/comparison_list.html.twig`|Entry page for the comparison list|
|`Basket/messages.html.twig`|Template with success/error/notice messages for baskets|
|`parts/user_menu.html.twig`|HTML content for the right-hand user menu navigation with links to a comparison|

## Custom Twig functions

### `ses_comparison_category`

Returns the comparison category for the catalog element.
This function is a wrapper for `ComparisonServiceInterface::getComparisonCategory()`.

``` html+twig
{{ ses_comparison_category(catalogElement) }}
```
