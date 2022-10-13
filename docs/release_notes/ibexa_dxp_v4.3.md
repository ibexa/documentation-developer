---
description: Ibexa DXP v4.3 adds the improvements to the Customer Portal, PIM and SEO.
---

# Ibexa DXP v4.3

**Version number**: v4.3

**Release date**: October 14, 2022

**Release type**: [Fast Track](https://support.ibexa.co/Public/service-life)

**Update**: [v4.2.x to v4.3]()

## Notable changes

### Customer Portal [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

### SEO

## Other changes

### PIM improvements

When querying for products you can now use one of two price-related Sort Clauses:

- [`BasePrice` Sort Clause] sorts results by the products' base prices
- [`CustomPrice` Sort Clause] enables sorting by the custom price configured for the provided customer group.

This release also includes a number of usability improvements in PIM,
such as full information about available attribute values or improved display of Selection attributes.

In catalogs, you can now configure default filters that are always added to a catalog,
as well as define filter order and group custom filters.

Filtering by the Color attribute is now possible.

### Debian 11

Ibexa DXP now supports Debian 11 "bullseye" operating system.

### API improvements

PIMs Catalogs functionality is now covered in REST API, including:

- Getting catalog list
- Creating, modifying, copying and deleting catalogs
- Changing catalog status
- Getting catalog filters and sorting options

### Taxonomy improvements

Objects of `\Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry`type, which are returned by `TaxonomyService`, now contains the information about nesting level in the tree.

## Full changelog

| Ibexa Content  | Ibexa Experience  | Ibexa Commerce |
|--------------|------------|------------|
| [Ibexa Content v4.3](https://github.com/ibexa/content/releases/tag/v4.3.0) | [Ibexa Experience v4.3](https://github.com/ibexa/experience/releases/tag/v4.3.0) | [Ibexa Commerce v4.3](https://github.com/ibexa/commerce/releases/tag/v4.3.0)|
