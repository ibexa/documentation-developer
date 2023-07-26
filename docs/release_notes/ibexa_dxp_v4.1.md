---
description: Ibexa DXP v4.1 enhances the PIM capabilities, adds a Measurement Field Type and attribute and a Dynamic Targeting block for the Page Builder.
---

# Ibexa DXP v4.1

**Version number**: v4.1

**Release date**: April 15, 2022

**Release type**: [Fast Track](https://support.ibexa.co/Public/service-life)

## Notable changes

### Product catalog enhancements

With this release, product catalog brings new PHP APIs, productivity boost from new product search criteria and sort classes, advanced filtering in REST endpoints, auto-generated identifiers, product list sorting, and more.

You can now use [advanced filtering on products, product types, attributes, and others in REST endpoints](https://doc.ibexa.co/en/latest/api/rest_api_reference/rest_api_reference.html#product-catalog-filter-currencies).

Currencies, regions and customer groups can now be resolved automatically in the PHP API
based on the current context (for example, selected locale).

A new Color attribute enables adding a product attribute that uses the color picker to select a precise color.

The product catalog is now fully integrated with the transactional system integration, enabling a full purchasing process.
  
### Measurement Field Type and attribute

With the new Measurement Field Type users can now add a Measurement Field, with different pre-built units, to content:

![Adding a Measurement Field to Content Type definition](4.1_measurement_ft.png)

The new Measurement product attribute enables describing products with different types and units of measurement:

![Adding measurement attribute values to product](4.1_measurement_attribute.png)

### Dynamic targeting block [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

[Dynamic targeting block](https://doc.ibexa.co/projects/userguide/en/latest/site_organization/working_with_page/#dynamic-targeting-block) for the Page Builder provides recommendation items based on users related to the configured Segments.

![Dynamic targeting block](4.1_page_builder_dynamic_targeting.png)

### User interface improvements

Several improvements to the Back Office interface enhance the user experience.
These include:

- "Go to top" button
- new DateTime widget
- view switcher between lists, grids and calendar.

Several new options have been added to the Content Tree's contextual menu, including Hide/Reveal, Create, Edit and Add translation, Add/Remove from bookmarks.

![New Content Tree options](4.1_content_tree.png)

## Other changes

### GraphlQL

Product catalog is now fully covered in GraphQL API.

### Taxonomy language switcher

A language switcher in Taxonomy view enables quick switching between different translations of the tag tree.

![Language switcher in Taxonomy tree](4.1_taxonomy_lang_switcher.png)

### Image optimization

Images modified in the Image Editor are now optimized for reduced file size.
You can use external libraries to [optimize different image formats](https://doc.ibexa.co/en/latest/guide/images/#image-optimization).

### Expanded data migrations

[Data migration](data_migration.md) now covers additional objects:

- [database settings](https://doc.ibexa.co/en/latest/guide/data_migration/importing_data/#settings)
- [segments](https://doc.ibexa.co/en/latest/guide/data_migration/importing_data/#segments)
- [prices](https://doc.ibexa.co/en/latest/guide/data_migration/importing_data/#prices) with `create` mode
- [settings](https://doc.ibexa.co/en/latest/guide/data_migration/importing_data/#settings)

Data migration now also offers a locking capability,
which prevents multiple processes from executing the same migration and causing duplicated records.

## Full changelog

| Ibexa Content  | Ibexa Experience  | Ibexa Commerce |
|--------------|------------|------------|
| [Ibexa Content v4.1](https://github.com/ibexa/content/releases/tag/v4.1.0) | [Ibexa Experience v4.1](https://github.com/ibexa/experience/releases/tag/v4.1.0) | [Ibexa Commerce v4.1](https://github.com/ibexa/commerce/releases/tag/v4.1.0)
