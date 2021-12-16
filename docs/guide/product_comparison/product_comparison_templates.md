# Product comparison templates [[% include 'snippets/commerce_badge.md' %]]

## Template list

|Path|Description|
|--- |--- |
|`Comparison/comparison_list.html.twig`|Main page for comparison.|
|`Comparison/comparison.html.twig`|A single comparison list.|

## Custom Twig functions

### `ibexa_commerce_comparison_category`

Returns the comparison category for the catalog element.
This function is a wrapper for `ComparisonServiceInterface::getComparisonCategory()`.

``` html+twig
{{ ibexa_commerce_comparison_category(catalogElement) }}
```
