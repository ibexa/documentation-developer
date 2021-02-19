# eContent

The eContent data provider stores product data in database tables with a simple structure. 

The eContent data provider and eContent factory get the information from the database to create catalog elements.

Using eContent has the following limitations:

- eContent products are not visible in the Back Office.
- An eContent product cannot be embedded by using the standard embed feature.

## eContent Back Office [[% include 'snippets/commerce_badge.md' %]]

You can see an overview of the data model for eContent in the Back Office in **Control center**.

The model itself has to be defined by using SQL. 
The **eContent types** tab shows an overview of:

- the defined eContent types (for example, `product_group` or `product`)
- the list of attributes per eContent type
