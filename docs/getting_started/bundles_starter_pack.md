# Bundles starter pack

eZ Platform application is a collection of bundles, similar to Symfony where ["everything is a bundle"](https://symfony.com/doc/3.4/bundles.html). Bundles listed below are useful additions to your clean eZ Platform installation. By using them you can improve your Platform usage.

For more information about eZ Platform bundle structure check out:

- [Bundle section](../guide/bundles.md) in our Guide.
- List of [external bundles](https://ezplatform.com/Bundles) compatible with eZ Platform.

## Everyday Platform usage

|Bundle|Description|
|------|-----------|
|[ezmigrationbundle](https://github.com/kaliop-uk/ezmigrationbundle)|helps to handle content upgrade/migration|
|[EzCoreExtraBundle](https://github.com/lolautruche/EzCoreExtraBundle)|adds: configurable template variable injection; context aware Twig global variables; simplified authorization checks|
|[TagsBundle](https://github.com/netgen/TagsBundle)|helps with taxonomy management and classification of content|
|[NovaeZSEOBundle](https://github.com/Novactive/NovaeZSEOBundle)|simplifies SEO management|
|[EzSystemsPrivacyCookieBundle](https://github.com/ezsystems/EzSystemsPrivacyCookieBundle)|adds privacy cookie banner|
|[CommentsBundle](https://github.com/ezsystems/CommentsBundle)|integrates comments with Disqus and Facebook, also allows custom comment system/services integrations|
|[EzSystemsShareButtonsBundle](https://github.com/ezsystems/EzSystemsShareButtonsBundle)|adds social share buttons|

## Migration from legacy

|Bundle|Description|
|------|-----------|
|[LegacyBridge](https://github.com/ezsystems/LegacyBridge)|optional bridge between eZ Platform and eZ Publish Legacy that simplifies migration to eZ Platform [Community co-maintained]|
|[ezplatform-xmltext-fieldtype](https://github.com/ezsystems/ezplatform-xmltext-fieldtype)|XmlText field type for eZ Platform [Community co-maintained]|
|[ezflow-migration-toolkit](https://github.com/ezsystems/ezflow-migration-toolkit)|set of tools that helps migrate data from legacy eZ Flow extension to eZ Studio landing page management|
|[ezplatformsearch](https://github.com/netgen/ezplatformsearch)|eZ Publish Legacy extension that integrates eZ Platform search capabilities into eZ Publish Legacy|
|[ngsymfonytools](https://github.com/netgen/ngsymfonytools)|eZ Publish 4 extension that provides a way to include Twig templates, as well as running Symfony sub-requests, directly from the eZ Publish legacy templates|
|[NetgenRichTextDataTypeBundle](https://github.com/netgen/NetgenRichTextDataTypeBundle)|allows eZ Publish Legacy to work with RichText (ezrichtext) field type available in eZ Platform|

## Contributors

|Bundle|Description|
|------|-----------|
|[RepositoryProfilerBundle](https://github.com/ezsystems/RepositoryProfilerBundle)| profiles Platform API/SPI and sets up scenarios to be able to continuously test to keep track of performance regressions of repository and underlying storage engines|

## Educational

This bundles are not necessarily something you would install but they are useful for learning process:

|Bundle|Description|
|------|-----------|
|[CookbookBundle](https://github.com/ezsystems/CookbookBundle)|working examples for using eZ Platform public PHP API|
|[ezplatform-com](https://github.com/ezsystems/ezplatform-com)|the eZ Systems Developer Hub for the Open Source PHP CMS eZ Platform (example site)|
|[ezplatform-ee-demo](https://github.com/ezsystems/ezplatform-ee-demo)|fork of the "ezplatform-ee" meta repository, contains changes to composer.json, AppKernel.php and config necessary to enable eZ Platform Enterprise Edition Demo. Not recommended for a clean install for new projects, but great for observation and learning (example site)|
|[ezplatform-demo](https://github.com/ezsystems/ezplatform-demo)|fork of "ezplatform" meta repository, contains code and dependencies for demo distribution of eZ Platform. Not recommended for a clean installation for new projects, but great for observation and learning(example site)|
|[TweetFieldTypeBundle](https://github.com/ezsystems/TweetFieldTypeBundle)|bundle that is created in the [Field Type Tutorial](../tutorials/field_type/creating_a_tweet_field_type.md) (example field type)|
|[ezplatform-drawio-fieldtype](https://github.com/ezsystems/ezplatform-drawio-fieldtype)| provides support for diagrams editing in eZ Platform via draw.io (example field type)|
|[ezplatform-ui-2.0-introduction](https://github.com/ezsystems/ezplatform-ui-2.0-introduction)|an example of eZ Platform extensibility in version 2|
