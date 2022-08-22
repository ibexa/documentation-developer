# Ibexa DXP v4.2

**Version number**: v4.2

**Release date**: August 9, 2022

**Release type**: [Fast Track](https://support.ibexa.co/Public/service-life)

## Notable changes

### Customer Portal [[% include 'snippets/experience_badge.md' %]]

The new Customer Portal allows you to create and manage a business account for your company.
With this new feature, you can easily manage members of your organization,
your shipping information and view your past orders.
You can invite members to your company, activate or deactivate their accounts,
assign them specific roles and limitations, such as a buyer, or sales representative, and group them into teams.

![Customer Portal Back Office](4.2_customer_portal.png)

For more information, see [Back Office comany management documentation](https://doc.ibexa.co/projects/userguide/en/4.2/shop_administration/manage_users).

On their personal accounts in Customer Portal, members of your organisation can view their order history,
other members of their team and information regarding their company, for example, billing addresses.
They can also edit their profile information.

![Customer Portal Frontend](4.2_customer_center.png)

For more information, see [Customer Portal documentation](https://doc.ibexa.co/projects/userguide/en/4.2/shop_administration/customer_portal).

### User management

#### Inviting users

You can [invite users to create their account](https://doc.ibexa.co/projects/userguide/en/4.2/users/user_management/#inviting-users) in the frontend as customers or in the Back Office as members of your team.

![Inviting members of your team](4.2_invite_users.png)

#### Configure register form

Register forms for new users can now be [configured straight in the YAML file](https://doc.ibexa.co/en/4.2/guide/content_rendering/layout/add_register_user_template/#configure-existing-form).

### Catalogs

You can now create catalogs containing sub-sets of products.
Choose products for a catalog by applying filters which enable you to select products,
for example, by product type, price range, availability or category.

![List of products in a catalog](4.2_catalogs_product_list.png)

Catalogs are useful when creating special lists for B2B and B2C uses, for retailers and distributors or for different regions,
or other situations where you need to present a selected set of products.

### Product variants

To cover use cases of products with variable characteristics (such as colors, technical parameters or sizes),
you can now create product variants based on selected attributes.
The system automatically generates variants for the attribute values you select.

![Generating product variants](4.2_product_variants_generate.png)

You can set prices, including custom pricing, as well as availability and stock for each variant separately.

### Product assets

To provide your products with images, you can now upload multiple assets to each product.
Assets are grouped into collections based on attribute values
 and, in this way, are connected to product variants which have these attributes.

![Asset images in product view](4.2_product_assets.png)

### Product completeness

The new product completeness tab, in product view, lists all the parts of a product you can configure:
attributes, assets, prices, availability, and so on.
You can use it to get a quick overview of missing parts in the product configuration
and to instantly move to the proper screen to fill the gaps.

![Product completeness tab](4.2_product_completeness.png)

### Product categories

With product categories, you can organize products that populate the Product Catalog.
You do it, for example, to assist users in searching for products.

For more information, see [Product categories](https://doc.ibexa.co/projects/userguide/en/latest/shop_administration/product_categories/).

![Product categories](4.2_product_categories_rn.png)

### Cross-content type (CCT) recommendations

If a recommendation scenario has more than one Content Type configured, with cross-content type (CCT) parameter in the request,
you can now get recommendations for all these Content Types.

### Taxonomy Field Type

Taxonomy is now [configured with a Field Type](https://doc.ibexa.co/projects/userguide/en/4.2/taxonomy/#add-tag),
so you can use many Fields to add different taxonomy categories, for example, tags and product categories in the same Content Type.

### Address Field Type

With the [new Address Field Type](https://doc.ibexa.co/en/4.2/content_management/field_types/field_type_reference/addressfield), you can now customize address Fields and configure them per country.

![Address Field Type](4.2_address_field_type.png)

### Repeatable migration steps

Data migration now offers [repeatable migration steps](https://doc.ibexa.co/en/4.2/guide/data_migration/importing_data/#repeatable-steps),
especially useful when creating large amounts of data, for example for testing.

You can vary the migration values by using the iteration counter, or by generating random data by using [`FakerPHP`](https://fakerphp.github.io/).

## Other changes

### New product Search Criteria and Sort Clauses

New Search Criteria and Sort Clauses help better fine-tune searches for products.

Price-related Search Criteria enable you to search by base or custom product price:

- [BasePrice](https://doc.ibexa.co/en/4.2/guide/search/criteria_reference/baseprice_criterion/)
- [CustomPrice](https://doc.ibexa.co/en/4.2/guide/search/criteria_reference/customprice_criterion/)

Attribute Criteria search for products based on their attribute values, per attribute type:

- [CheckboxAttribute](https://doc.ibexa.co/en/4.2/guide/search/criteria_reference/checkboxattribute_criterion/)
- [ColorAttribute](https://doc.ibexa.co/en/4.2/guide/search/criteria_reference/colorattribute_criterion/)
- [FloatAttribute](https://doc.ibexa.co/en/4.2/guide/search/criteria_reference/floatattribute_criterion/)
- [IntegerAttribute](https://doc.ibexa.co/en/4.2/guide/search/criteria_reference/integerattribute_criterion/)
- [SelectionAttribute](https://doc.ibexa.co/en/4.2/guide/search/criteria_reference/selectionattribute_criterion/)
- SimpleMeasurementAttribute
- RangeMeasurementAttributeMinimum
- RangeMeasurementAttributeMaximum

Creation date Criteria and Sort Clauses allow searching by date of the product's creation:

- [CreatedAt](https://doc.ibexa.co/en/4.2/guide/search/criteria_reference/createdat_criterion/)
- [CreatedAtRange](https://doc.ibexa.co/en/4.2/guide/search/criteria_reference/createdatrange_criterion/)
- [CreatedAt](https://doc.ibexa.co/en/4.2/guide/search/sort_clause_reference/createdat_sort_clause/)

Finally, you can search product by product category:

- [ProductCategory](https://doc.ibexa.co/en/4.2/guide/search/criteria_reference/productcategory_criterion/)

### API improvements

#### GraphQL

Taxonomy is now covered with GraphQL API.

Querying product attributes with GraphQL is improved with the option to [query by attribute type](https://doc.ibexa.co/en/4.2/api/graphql_queries/#querying-product-attributes).

### New ways to add images in Online Editor

You can now drag and drop images directly into the Online Editor. 
To achieve the same result, you can also click the **Upload image** button and select a file from the disk.
Images that you upload this way are automatically added to the Media library.

!!! note

    In Media library, to avoid potential conflicts, 
    if several images are added with identical file names, 
    each of them is modified by appending a unique prefix.  

![Drag and drop image into the Online Editor](4.2_online_editor_dnd_image.png)

### Content edit tabs

Content editing screen is now enriched with a tab switcher, allowing easy access to metadata such as taxonomies.
The view can be extended with custom tabs.

![Tabs in content edit view](4.2_content_edit_tabs.png)

### Grouped attributes in Page block

If a Page block has multiple attributes, you can now group them with the `nested_attribute` parameter.

![Grouped attributes](4.2_page_block_nested.png)

### Search in URL wildcards

You can now search through the **URL wildcards** table in the Back Office.

### Product price events

The price engine now dispatches [events related to creating, updating and deleting prices](https://doc.ibexa.co/en/4.2/guide/repository/event_reference/catalog_events/#price).

### Data migration

#### Migrations for attributes and attribute groups

Data migration now supports `attribute` and `attribute_group` types when generating migration files.

#### Hide and reveal content actions

You can now hide and reveal Content items in data migrations by using the [`hide` and `reveal` actions](https://doc.ibexa.co/en/4.2/guide/data_migration/data_migration_actions/#available-migration-actions).

### Fastly shielding

Ibexa DXP now supports Fastly shielding.

## Deprecations

### Segmentation

- `SegmentationService::loadSegmentGroup()` and `SegmentationService::loadSegment()` are now deprecated.
Use `SegmentationService::loadSegmentGroupByIdentifier()` and `SegmentationService::loadSegmentByIdentifier()` instead,
which take `SegmentGroup` and `Segment` identifier respectively, instead of numerical IDs.
- `SegmentationService::updateSegmentGroup()` and `SegmentationService::updateSegment()` now take
a `SegmentGroup` and `Segment` objects respectively, instead of numerical IDs.

## Full changelog

| Ibexa Content  | Ibexa Experience  | Ibexa Commerce |
|--------------|------------|------------|
| [Ibexa Content v4.2](https://github.com/ibexa/content/releases/tag/v4.2.0) | [Ibexa Experience v4.2](https://github.com/ibexa/experience/releases/tag/v4.2.0) | [Ibexa Commerce v4.2](https://github.com/ibexa/commerce/releases/tag/v4.2.0)|
