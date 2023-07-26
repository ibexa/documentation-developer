# Ibexa DXP v4.0

**Version number**: v4.0

**Release date**: February 4, 2022

**Release type**: [Fast Track](https://support.ibexa.co/Public/service-life)

## Notable changes

### Redesigned user interface

The the Back Office has undergone a complete redesign, including revised look and feel,
simplified navigation and more streamlined workflows.

![New UI](4.0_new_ui.png)

!!! tip

    Read more about the rationale and process for the redesign on [Ibexa blog](https://www.ibexa.co/blog/ibexa-dxp-v4.0-preview-redesigned-user-interface-elevates-the-user-experience).

### New product catalog

New product catalog enables easy management of products, stock and prices.

Products are now organized into product types, each offering a specific set of attributes
that you can use to provide information about a product.
You can also set VAT rates per product type.

![Product catalog](4.0_catalog.png)

#### Price management

You can now configure prices with discounts per product and per customer group.
Separate currencies enable you to set different price rules for different currencies.

![Price management](4.0_product_price.png "Managing prices in the new product catalog")

### Taxonomy management

You can now organize content adding tags and create taxonomy categories to make it easy for your 
site users to browse and to deliver content appropriate for them.

### Separate recommendations for different websites

Personalization service has been enhanced to allow returning separate recommendations 
for different websites. 
This way you can eliminate irrelevant recommendations when you set up stores that 
operate on different markets or under different brands.

For more information, see [Support for multiple websites](https://doc.ibexa.co/projects/userguide/en/latest/personalization/use_cases/#multiple-website-hosting).

## Other changes

### Draft locking

You can now configure and use the locking feature to lock a draft of a Content item, 
so that only an assigned person can edit it, and no other user can take it over. 

For more information, see the [Draft locking](https://doc.ibexa.co/en/latest/guide/workflow/workflow/#draft-locking)
and the relevant [user documentation](https://doc.ibexa.co/projects/userguide/en/latest/publishing/editorial_workflow/#releasing-locked-drafts).

### Online Editor is now based on CKEditor

You can now edit content of RichText Fields using CKEditor and extend its functionality with many elements.

For more information, see [Extend Online Editor](https://doc.ibexa.co/en/latest/extending/extending_online_editor/).

### Enhanced GraphQL location handling

GraphQL now enables better querying of Locations and URLs.

### Migration API

You can now manage [data migrations](https://doc.ibexa.co/en/latest/guide/data_migration/data_migration/) by using the PHP API,
including getting migration information and running individual migration files.

See [Managing migrations](https://doc.ibexa.co/en/latest/api/public_php_api_managing_migrations/) for more information.

### Decide whether alternative text for Image field is optional

Alternative text for an Image field is now optional by default. 
You can set it as required when adding the Image field to a Content Type.

### Configure what elements are available in the Page Builder for the Content type [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

You can now select which page blocks, page layout and what edit mode are available in the Editor mode for the Content type.
For more information, see [Working with Page](https://doc.ibexa.co/projects/userguide/en/latest/site_organization/working_with_page/#configure-block-display).

### Purge all submissions of given form [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

You can purge all submissions of a given form. 
For more information, see [Forms](https://doc.ibexa.co/en/latest/guide/form_builder/forms/#form-submission-purging).

### External datasource handling

Pesronalization has been given an option to fetch content feed from external sources.

### Category exclusion 

Personalization service has been enhanced with a feature which allows to exclude categories from the recommendation response.
See [Exclusions](https://doc.ibexa.co/projects/userguide/en/latest/personalization/filters/#exclusions).

## Deprecations

### Code cleanup results

v4.0 sees significant code cleanup, including renaming of namespaces, services, REST API endpoints
and many other internal names.

Refer to [Ibexa DXP v4.0 deprecations and backwards compatibility breaks](ibexa_dxp_v4.0_deprecations.md)
for full details of changes and how they influence your project.

## Full changelog

| Ibexa Content  | Ibexa Experience  | Ibexa Commerce |
|--------------|------------|------------|
| [Ibexa Content v4.0](https://github.com/ibexa/content/releases/tag/v4.0.0) | [Ibexa Experience v4.0](https://github.com/ibexa/experience/releases/tag/v4.0.0) | [Ibexa Commerce v4.0](https://github.com/ibexa/commerce/releases/tag/v4.0.0)
