---
description: Ibexa DXP v3.3 is a Long Term Support release that offers a new Personalization UI, Image Editor and a data migration bundle.
---

# Ibexa DXP v3.3

**Version number**: v3.3

**Release date**: January 18, 2021

**Release type**: [Long Term Support](https://support.ibexa.co/Public/service-life)

## Notable changes

### New Personalization UI

This release brings a completely reconstructed user interface of the Personalization feature.

![Personalization dashboard](3.3_perso_ui.png "Personalization dashboard")

### Symfony Flex

Ibexa DXP is now installed using [Symfony Flex](https://symfony.com/doc/current/quick_tour/flex_recipes.html).

See [the updated installation instruction](https://doc.ibexa.co/en/3.3/getting_started/install_ez_platform) for a new guide to installing the product.

### Image Editor

With the Image Editor, users can now perform basic operations, such as cropping or flipping an image,
or setting a point of focus. 
The Image Editor is available when browsing the Media library, or creating or editing Content items 
that contain an `ezimage` or `ezimageasset` Field.

You can modify the Image Editor's default settings to change its appearance or behavior.
For more information, see [Configuring the Image Editor](https://doc.ibexa.co/en/3.3/guide/image_editor).

### Migration bundle

The new [migration bundle](https://doc.ibexa.co/en/3.3/guide/data_migration) enables you to export and import your Repository data by using YAML files.

## Other changes

### Extended Search API capabilities

Search API has been extended with the following capabilities:

- [Score Sort Clause](https://doc.ibexa.co/en/3.3/guide/search/sort_clause_reference/score_sort_clause) orders search results by their score.
- [CustomField Sort Clause](https://doc.ibexa.co/en/3.3/guide/search/sort_clause_reference/customfield_sort_clause) sorts search results by raw search index fields.
- [ContentTranslatedName Sort Clause](https://doc.ibexa.co/en/3.3/guide/search/sort_clause_reference/contenttranslatedname_sort_clause) sorts search results by the Content items' translated names.

You can now access [additional search result data from PagerFanta](https://doc.ibexa.co/en/3.3/api/public_php_api_search/#additional-search-result-data).

### PHP API improvements

You can now use the following new PHP API methods:

- [`UserService::loadUserGroupByRemoteId`](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/UserService.php#L71)
- [`PasswordHashService::getDefaultHashType`](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/PasswordHashService.php#L18)
- [`PasswordHashService::getSupportedHashTypes`](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/PasswordHashService.php#L25)
- [`PasswordHashService::isHashTypeSupported`](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/PasswordHashService.php#L30)
- [`PasswordHashService::createPasswordHash`](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/PasswordHashService.php#L37)
- [`PasswordHashService::isValidPassword`](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/PasswordHashService.php#L44)

### Query Field Location handling

The [Query Field Type](https://doc.ibexa.co/en/3.3/guide/content_rendering/queries_and_controllers/content_queries/#content-query-field) now enables getting results for the current Location of a Content item.

## Deprecations

### Trusted proxy configuration

If you configure trusted proxies in the `.env` file, you now need to add them to the configuration in the following way:

``` yaml
framework:
    trusted_proxies: '%env(TRUSTED_PROXIES)%'
```

## Full changelog

See [list of changes in Symfony 5.2.](https://symfony.com/blog/symfony-5-2-curated-new-features)

| Ibexa Content  | Ibexa Experience  | Ibexa Commerce |
|--------------|------------|------------|
| [Ibexa Content v3.3.0](https://github.com/ibexa/content/releases/tag/v3.3.0) | [Ibexa Experience v3.3.0](https://github.com/ibexa/experience/releases/tag/v3.3.0) | [Ibexa Commerce v3.3.0](https://github.com/ibexa/commerce/releases/tag/v3.3.0)|

## v3.3.15 

### Symfony 5.4

The version v3.3.15 moves Ibexa DXP to Symfony 5.4.
For more information, see [Symfony 5.4 documentation](https://symfony.com/releases/5.4) and [update documentation](update_from_3.3.md#3315).
