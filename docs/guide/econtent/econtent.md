# eContent [[% include 'snippets/commerce_badge.md' %]]

The eContent storage provider can store product data in an efficient way.
It enables storing data (mostly for products and product groups) in database tables with a simple structure. 

During the import the database tables are filled and the eContent data provider and eContent factory are there to get the information from the database and create catalog elements.

Main advantages of using eContent as the data provider:

- Fast imports (e.g. from ERP or PIM systems)
- Supports more than one million products
- Search-ready
- Fast access
- Avoids storing products in the content model
- Allows imports during production and switching catalogs

## Content model vs. eContent data provider

[[= product_name_com =]] uses an almost generic way to access the catalog.
The catalog can be stored in the content model or in eContent. 

If eContent is used, there are a few restrictions that have to be considered:

- A product cannot be embedded by using the standard embed feature. [[= product_name_com =]] offers an alternative feature which enables embedding products in RichtText Fields.
- eContent products are not visible in the Back Office.

It depends on the requirements of the customer to decide which provider should be used. The following table compares the main features:

| Feature                              | content model                                | eContent                                     |
| ------------------------------------ | -------------------------------------------- | -------------------------------------------- |
| Flexible data model                   | yes  | yes  |
| Translations                         | yes  | yes  |
| Interface for editing                | yes  | no |
| Versioning                           | yes  | no |
| Simple segmentation          | yes  | yes  |
| Extended segmentation        | no | yes  |
| Fast imports (e.g. from PIM)         | no | yes  |
| Support of large catalogs              | no | yes  |
| Staging (live and temporary space) | no | yes  |
