# ProductType [[% include 'snippets/commerce_badge.md' %]]

`ProductType` extends [CatalogElement](catalog_element.md) and implements `ProductNodeContainerInterface`.

This class defines the methods needed to instantiate a Product Type.

### Properties for ProductType

|Identifier|Type|Description|
|--- |--- |--- |
|`childProducts`|CatalogElement[]|Array of products that belong to this Product Type|
|`shortDescription`|TextBlockField (FieldInterface)|Short description|
|`longDescription`|TextBlockField (FieldInterface)|Long description|
|`specifications`|AbstractField[]|A list of specifications of a product|
|`imageList`|ImageField[] (FieldInterface[])|A list of images|
|`displayInSearch`|bool|`true` if the ProductType should be displayed in the search result|
|`displayInProductList`|bool|`true` if the ProductType should be displayed in the product list result|

### Methods

|Name|Parameters|Return value|Throws|Description|
|--- |--- |--- |--- |--- |
|`getChildProducts`||`CatalogElement[]`||Returns all child products|
|`addChildProducts`|`ProductNode[]`||InvalidArgumentException|Adds the products passed as argument to the list of child products|
|`hasChildProducts`||int||Returns the number of children|
|`getChildProductBySku`|string|CatalogElement||Returns the child product that has the SKU passed as an argument|
|`addChildProduct`|`ProductNode`|||Adds a single product to the list of child products|

## ProductType search

A `ProductType` element can appear in the result of a search for products.

For this to happen you need to modify the configuration by adding `ses_product_type` to the product list or product search.

`use_display_in_product_list_flag` enables or disables the use of the `productType` flag when displayed in product search and product list.

Additionally, a Product Type indexes all data from its products.
You can disable this using the following configuration:

``` yaml
parameters:
    siso_search.default.cp_to_product_type: false
```

Disabling this feature results in quicker indexing but product data is not indexed alongside Product Types.

Search results display Product Types using the `EshopBundle/Resources/views/Catalog/listProductTypeNode.html.twig` template.
