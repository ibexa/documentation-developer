# Importing products (API) [[% include 'snippets/commerce_badge.md' %]]

Importing products by means of the API includes the following parts of the system:

- eContent repository: helper methods for automatic metadata generation.
- catalog data (categories, products and related attributes) need to be stored individually for every language used in the shop
- available classes for new database objects can be obtained from the `sve_class` table (by default only two classes: 1 = category, 2 = product)

## Attributes

Every catalog class defines a number of valid attributes for their elements. The name identifier, ID and Content Type of all attributes are stored in the table `sve_class_attributes`.

The `node_id` of the product, `attribute_id` and language code fields are required.

After a new product is created, attributes can be associated with the product using its `node_id`.
In addition, creating a new attribute requires its ID and the language code.

Attributes use three data types to store their data (text, float and int).
The API provides a corresponding setter method for every data type that needs to be called explicitly on import.

|Data type|Method|
|--- |--- |
|float|setDataFloat|
|int|setDataInt|
|text/string|setDataText|

## Importing a category

A category has `class_id` = 1.

Categories are used to group products by setting the `parent_id` of the product to the `node_id` of the category.
The root node of the tree is 2 (the parent of the first category).

For example:

``` php
// get the Doctrine repository
$objectRepo = $this->em->getRepository(SveObject::class);

$categoryName = 'My category';
$categoryNodeId = $objectRepo->getNextNodeId();

$econtentCategory = new SveObject();
$econtentCategory->setClassId(1); // 2 = product, 1 = category
$econtentCategory->setParentId(2); // root node
$econtentCategory->setBlocked(false);
$econtentCategory->setHidden(false);
$econtentCategory->setSection(1); // 1 = Standard

$econtentCategory->setChangeDate(new \DateTime());
$objectRepo->generateMetaData($econtentCategory, $categoryNodeId, $categoryName);
$this->em->persist($econtentCategory);
$this->em->flush();

// import an attribute for the new category
$econtentAttribute = new SveObjectAttributes();
$econtentAttribute->setNodeId($categoryNodeId);
$econtentAttribute->setAttributeId(101); // 201 = ses_name
$econtentAttribute->setLanguage('eng-GB');

$econtentAttribute->setDataText($categoryName);
$this->em->persist($econtentAttribute);
$this->em->flush();
```

## Importing a product

A product has `class_id` = 2.

Creating a product requires the `parent_id` (its Location in the product tree/catalog).
Changing the `parent_id` moves the product in the tree. After creation, the product's `node_id` serves as its unique identifier.

Product entities provide getters and setters for their attributes.

To import into the `*_tmp` table, use `$nodeId = $objectRepo->getNextNodeId();`.

Use the `generateMetaData()` method to generate metadata such as the URL alias of the product.

The following example creates a product object in the database and sets its properties.
It creates attributes and associates them with the object.
Different attributes have different data types (text is default).

``` php
// create a product and set its data fields
$productNodeId = $objectRepo->getNextNodeId();

$econtentProduct = new SveObject();
$econtentProduct->setClassId(2); // 2 = product, 1 = category
$econtentProduct->setParentId($categoryNodeId);
$econtentProduct->setMainNodeId($productNodeId);
$econtentProduct->setBlocked(false);
$econtentProduct->setHidden(false);
$econtentProduct->setSection(1); // 1 = Standard

$econtentProduct->setChangeDate(new \DateTime());
$objectRepo->generateMetaData($econtentProduct, $productNodeId, 'New Product');

$this->em->persist($econtentProduct);
$this->em->flush();

// import an attribute for the new product
$econtentAttribute = new SveObjectAttributes();
$econtentAttribute->setNodeId($productNodeId);
$econtentAttribute->setAttributeId(201); // 201 = ses_name
$econtentAttribute->setLanguage('eng-GB');

$econtentAttribute->setDataText((string)'product name');

$this->em->persist($econtentAttribute);
$this->em->flush();
```

Create the index for the new products (in temporary area):

``` bash
php bin/console silversolutions:indexecontent
```

After the import, the database tables and Solr cores have to be switched:

``` 
php bin/console silversolutions:indexecontent swap
php bin/console silversolutions:econtent-tables-swap
```

For more information, see [Staging system](../../econtent_features/staging_system.md) and [Indexing econtent data](../../econtent_features/indexing_econtent_data/indexing_econtent_data.md).
