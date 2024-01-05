---
description: View matchers are used in template configuration to decide when to use which template and controller.
page_type: reference
---

# View matcher reference

You can use the following matchers to [match content views](template_configuration.md#view-rules-and-matching):

| Identifier | Matches |
|------|------|
| [`Id\Content`](#idcontent) | ID number of the Content item. |
| [`Id\ContentType`](#idcontenttype) | ID number of the Content Type that the Content item belongs to. |
| [`Identifier\ContentType`](#identifiercontenttype) | Identifier of the Content Type that the Content item belongs to. |
| [`Id\ContentTypeGroup`](#idcontenttypegroup) | ID number of the group containing the Content Type that the Content item belongs to. |
| [`Id\Location`](#idlocation) | ID number of a Location. |
| [`Id\LocationRemote`](#idlocationremote) | Remote ID number of a Location. |
| [`Id\ParentContentType`](#idparentcontenttype) | ID number of the parent Content Type. |
| [`Identifier\ParentContentType`](#identifierparentcontenttype) | Identifier of the parent Content Type. |
| [`Id\ParentLocation`](#idparentlocation) | ID number of the parent Location. |
| [`Id\Remote`](#idremote) | Remote ID of a Content item. |
| [`Id\Section`](#idsection) | ID number of the Section that the Content item belongs to. |
| [`Identifier\Section`](#identifiersection) | Identifier of the Section that the Content item belongs to. |
| [`Depth`](#depth) | Depth of the Location. The depth of a top level Location is 1. |
| [`UrlAlias`](#urlalias) | Virtual URL of the Location. |
| [Product attribute value](#product-attribute-value) | Value of product attributes. |
| [Product code](#product-code) | Product code. |
| [Product type](#product-type) | Product type. |
| [Product availability](#product-availability) | Product availability. |
| [Product](#product) | Whether the object is a product. |
| [Product catalog root](#product-catalog-root) | Whether the Location is the root of a product catalog. |
| [Taxonomy entry ID](#taxonomy-entry-id) | ID of taxonomy entry. |
| [Taxonomy entry identifier](#taxonomy-entry-identifier) | Identifier of taxonomy entry. |
| [Taxonomy entry level](#taxonomy-entry-level) | Level of taxonomy entry. |
| [Taxonomy type](#taxonomy-type) | Taxonomy type. |


!!! tip

    Each matcher has a scalar value or an array of scalar values. When an array is passed, it matches on one of its values.

    You can also create [custom view matchers](create_custom_view_matcher.md).

## Id\Content

Matches the ID number of a Content item.

``` yaml
match:
    Id\Content: 145
```

## Id\ContentType

Matches the ID number of a Content Type that the Content item belongs to.

``` yaml
match:
    Id\ContentType: 2
```

## Identifier\ContentType

Matches the identifier of the Content Type that the Content item belongs to.

``` yaml
match:
    Identifier\ContentType: [blog_post]
```

## Id\ContentTypeGroup

Matches the ID number of the Content Type Group that the Content item belongs to.

``` yaml
match:
    Id\ContentTypeGroup: 1
```

## Id\Location

Matches the ID number of a Location. In the case of a Content item, matched against the main Location.

``` yaml
match:
    Id\Location: 144
```

## Id\LocationRemote

Matches the Remote ID number of a Location. In the case of a Content item, matched against the main Location.

``` yaml
match:
    Id\LocationRemote: 5b1e33529082b68ad3a41b9089136a0a
```

## Id\ParentContentType

Matches the ID number of the parent Content Type. In the case of a Content item, matched against the main Location.

``` yaml
match:
    Id\ParentContentType: 42
```

## Identifier\ParentContentType

Matches the identifier of the parent Content Type. In the case of a Content item, matched against the main Location.

``` yaml
match:
    Identifier\ParentContentType: blog
```

## Id\ParentLocation

Matches the ID number of the parent Location. In the case of a Content item, matched against the main Location.

``` yaml
match:
    Id\ParentLocation: 2
```

## Id\Remote

Matches the remote ID number of a Content item.

``` yaml
match:
    Id\Remote: 145
```

## Id\Section

Matches the ID number of the Section that the Content item belongs to.

``` yaml
match:
    Id\Section: 1
```

## Identifier\Section

Matches the identifier of the Section that the Content item belongs to.

``` yaml
match:
    Identifier\Section: standard
```

## Depth

Matches the depth of the Location. The depth of a top level Location is 1.

``` yaml
match:
    Depth: 2
```

## UrlAlias

Matches the virtual URL of the Location.
Matches when the URL alias of the Location starts with the value passed.

``` yaml
match:
    UrlAlias: 'terms-and-conditions'
```

## Product attribute value

`Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\AttributeValue` matches the value of product attributes.

``` yaml
match:
    '@Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\AttributeValue': { width: 20, height: 10 }
```

## Product code

`Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\ProductCode` matches the product code.

``` yaml
match:
    '@Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\ProductCode': ['DRE1536SF']
```

## Product type

`Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\ProductType` matches the product type.

``` yaml
match:
    '@Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\ProductType': ['dress']
```

## Product availability

`Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\IsAvailable` matches the availability of a product.
Refers to the existence of availability, not to whether the product is in stock.

``` yaml
match:
    '@Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\IsAvailable': true
```

## Product

`Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\IsProduct` matches when the object is a product.

``` yaml
match:
    '@Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\IsProduct': ~
```

## Product catalog root

`Ibexa\Contracts\ProductCatalog\ViewMatcher\LocationBased\RootLocation` matches depending on whether the Location is the root of a product catalog.

``` yaml
match:
    '@Ibexa\Contracts\ProductCatalog\ViewMatcher\LocationBased\RootLocation': true
```

## Taxonomy entry ID

`Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Id` matches based on an ID of the taxonomy entry.

``` yaml
match:
    '@Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Id': [1, 2, 3]'
```

## Taxonomy entry identifier

`Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Identifier` matches based on an identifier of the taxonomy entry.

``` yaml
match:
    '@Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Identifier': ['spring', 'events', 'devices']
```

## Taxonomy entry level

`Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Level` matches based on a level of the taxonomy entry.
With this matcher, you can apply view rules based on a selection of taxonomy entry levels, by using the following logical operators: `<` , `>` , `<=`, `>=`, `=`.

``` yaml
match:
    '@@Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Level': '> 2'
```

## Taxonomy type

`Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Taxonomy` matches based on a type of taxonomy that the taxonomy entry belongs to.

``` yaml
match:
    '@Ibexa\Taxonomy\View\Matcher\TaxonomyEntryBased\Taxonomy': 'product_category'
```