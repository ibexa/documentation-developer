# Ibexa DXP v4.0

**Version number**: v4.0

**Release date**: September 27, 2021

**Release type**: [Fast Track](../community_resources/release_process.md#release-process)

## Notable changes

### New Product Catalog

Lorem ipsum

### Separate recommendations for different websites

Personalization service has been enhanced to allow returning separate recommendations 
for different websites. 
This way you can eliminate irrelevant recommendations when you set up stores that 
operate on different markets or under different brands.

For more information, see [Support for multiple websites](https://doc.ibexa.co/projects/userguide/en/latest/personalization/use_cases/#hosting-multiple-websites).

## Other changes

### Draft locking

You can now configure and use the locking feature to lock a draft of a Content item, 
so that only an assigned person can edit it, and no other user can take it over. 

For more information, see the [developer](../guide/workflow.md#draft-locking) and the [user](https://doc.ibexa.co/projects/userguide/en/master/publishing/editorial_workflow/#draft-locking) documentation.

### Enhanced GraphQL location handling

Lorem ipsum

### Migration API

You can now manage [data migrations](../guide/data_migration.md) by using the PHP API,
including getting migration information and running individual migration files.

See [Managing migrations](../api/public_php_api_managing_migrations.md) for more information.

### Decide whether alternative text for Image field is optional

Alternative text for an Image field is now optional by default. 
You can set it as required when adding the Image field to a Content Type.

### Configure what elements are available in the Page Builder for the Content type

You can now select which page blocks, page layout and what edit mode are available in the Editor mode for the Content type.
For more information, see [Working with Page](https://doc.ibexa.co/projects/userguide/en/latest/site_organization/working_with_page/#configure-blocks-display).

### Purge all submissions of given form

You can purge all submissions of a given form. 
For more information, see [Forms](../guide/form_builder/forms.md#form-submission-purging).

### Hidden eCommerce features

Commerce tab and all its features are now disabled by default.
For more information, see [Enable Commerce features](../guide/config_back_office.md/#enable-commerce-features).

### Category exclusion 

Personalization service has been enhanced with a feature which allows to exclude categories from the recommendation response.
See [Exclusions](https://doc.ibexa.co/projects/userguide/en/master/personalization/filters/#exclusions)

## Deprecations

### Code cleanup results

Lorem ipsum

## Full changelog

See [list of changes in Symfony 5.3.](https://symfony.com/blog/symfony-5-3-3-released)

| Ibexa Content  | Ibexa Experience  | Ibexa Commerce |
|--------------|------------|------------|
| [Ibexa Content v4.0](https://github.com/ibexa/content/releases/tag/v4.0.0) | [Ibexa Experience v4.0](https://github.com/ibexa/experience/releases/tag/v4.0.0) | [Ibexa Commerce v4.0](https://github.com/ibexa/commerce/releases/tag/v4.0.0)
