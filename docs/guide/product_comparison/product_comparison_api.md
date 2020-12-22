# Product comparison API [[% include 'snippets/commerce_badge.md' %]]

## Basket type

Comparison is a [basket](../basket/basket.md) with a special type `comparison`. 

No events are thrown when adding products to a comparison, so adding to comparison is quicker than adding items to a basket.
However, there is no data validation in the background.
Data validation, such as for the minimum order amount or for mixing of downloads with normal products,
is done when adding those items into the shopping basket.

## Additional attributes

New attributes are added to `comparison` baskets to handle the necessary additional data for the comparison list.
These attributes are not declared in the `Basket` class, but must be added dynamically by the `ComparisonServiceInterface` implementation.

### `comparisonAttributes`

`comparisonAttributes` is an associative array which defines the comparable attributes for the current object's comparison category.
`comparisonAttributes` has the following sub-structure:

``` php
array(
    'Group Name' => array( // attribute group (e.g. 'Technical information')
        'list' => array( // static array key
            array (
                'name' => (string) '', // label of the comparison attribute
                'priority' => (int) 0, // index of order for the comparison attribute list
            ),
        ),
        // [...]
    ),
    // [...]
)
```

### `comparisonElements`

`comparisonElements` is an array which contains the data for the product columns in the comparison list.
`comparisonElements` has the following sub-structure:

``` php
array(
    array(
        'catalogElement' => (ProductNode) object, // the respective CatalogElement / ProductNode for the current column
        'attributes' => array(), // same structure as $comparisonAttributes, except that 'name' contains the attribute's value instead of the label
        'basketLineId' => (int) 0, // the ID of the respective (comparison-)basket line (product column in the comparison list)
    ),
    // [...]
)
```

## Service

The `ComparisonServiceInterface` interface determines methods necessary for implementing different comparison services.

`getComparisonCategory(CatalogElement $catalogElement)` determines the correct comparison category for the given catalog element.

`getComparisonInformation(array $comparisonList)` determines the necessary comparison information for every given comparison category

## Category logic

To change the logic that determines to which categories to assign particular products,
you need to override the comparison service or implement a new one.

First, the service must implement `ComparisonServiceInterface`.
The `getComparisonCategory()` method takes a catalog element (products included) as an argument.
This method must implement the logic to determine the comparison category for the passed product.

The standard logic implementation:

1. Tries to get product type from the `catalogElement`
1. Tries to get the type from parent element category
1. If everything else fails, places the product in the default category
