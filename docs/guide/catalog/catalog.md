# Catalog [[% include 'snippets/commerce_badge.md' %]]

Products in the catalog can be stored in the content model,
or in optimized eContent storage, which is able to store up to two million products  

A storage engine is responsible for handling products. It consists of:

- a catalog data provider which manages the access to the product data itself (e.g. access method using database queries)
- a catalog factory which is responsible for building `CatalogNodes` and `ProductNodes`

## Product catalog objects

- A [`catalogElement`](catalog_api/catalog_element.md) represents a product group/category. It has a name, a code and a place in the catalog tree. It also can have additional Fields.
- A [`productType`](catalog_api/producttype.md) represents a collection of similar products that differ only in some characteristics. It is used to show a list of products in a tabular way. Every product can be added to the basket directly from this overview page.
- A [`productNode`](catalog_api/productnode.md) inherits from the `catalogElement` and offers additional attributes such as SKU, images, price and other attributes.
