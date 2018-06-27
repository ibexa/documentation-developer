# Bundles starter pack

eZ Platform application is a collection of bundles, similar to Symfony where ["everything is a bundle"](http://symfony.com/doc/current/book/bundles.html). Below bundles are useful additions to a clean eZ installation that will help your project run easier.

For more information about eZ bundle structure checkout:
- [Bundle section](../guide/bundles.md) in our Guide.
- List of [external bundles](https://ezplatform.com/Bundles) compatible with eZ Platform.

## Everyday Platform usage

|Bundle|Description|
|------|-----------|
|[ezmigrationbundle](https://github.com/kaliop-uk/ezmigrationbundle)|This bundle helps to handle eZPlatform / eZPublish5 content upgrades/migrations.|
|[EzCoreExtraBundle](https://github.com/lolautruche/EzCoreExtraBundle)|Adds extra features to eZ Platform: Configurable template variable injection; Context aware Twig global variables; Simplified authorization checks.|
|[TagsBundle](https://github.com/netgen/TagsBundle)|Netgen Tags Bundle is an eZ Platform bundle for taxonomy management and easier classification of content, providing more functionality for tagging content than `ezkeyword` field type included in eZ Platform kernel.|
|[NovaeZSEOBundle](https://github.com/Novactive/NovaeZSEOBundle)|Novactive eZ SEO Bundle is an eZ Platform bundle for SEO management simplifications.|
|[EzSystemsPrivacyCookieBundle](https://github.com/ezsystems/EzSystemsPrivacyCookieBundle)|This bundle adds privacy cookie banner into Symfony 2 application.|
|[CommentsBundle](https://github.com/ezsystems/CommentsBundle)|Comment bundle for eZ Platform integrating with Disqus and Facebook and allowing custom integrations|
|[EzSystemsShareButtonsBundle](https://github.com/ezsystems/EzSystemsShareButtonsBundle)|This bundle adds social share buttons into Symfony 2 application (eZ Publish / eZ Platform).|

## Migration from legacy

For migration from legacy use cases:

|Bundle|Description|
|------|-----------|
|[LegacyBridge](https://github.com/ezsystems/LegacyBridge)|[Community co-maintained] Formerly LegacyBundle, this was moved out and can be used as a optional bridge between eZ Platform and eZ Publish Legacy to simplify migration to eZ Platform|
|[ezplatform-xmltext-fieldtype](https://github.com/ezsystems/ezplatform-xmltext-fieldtype)|[Community co-maintained] XmlText field type for eZ Platform|
|[ezflow-migration-toolkit](https://github.com/ezsystems/ezflow-migration-toolkit)|A set of tools that helps migrate data from legacy eZ Flow extension to eZ Studio landing page management.|
|[ezplatformsearch](https://github.com/netgen/ezplatformsearch)|eZ Platform Search is an eZ Publish legacy extension that integrates eZ Platform search capabilities into eZ Publish legacy.|
|[ngsymfonytools](https://github.com/netgen/ngsymfonytools)|Netgen Symfony Tools is an eZ Publish 4 extension that provides a way to include Twig templates, as well as running Symfony sub-requests, directly from the eZ Publish legacy templates.|
|[NetgenRichTextDataTypeBundle](https://github.com/netgen/NetgenRichTextDataTypeBundle)|Netgen RichText datatype bundle allows eZ Publish Legacy to work with rich text (ezrichtext) field type available in eZ Platform.|

## Contributors

|Bundle|Description|
|------|-----------|
|[RepositoryProfilerBundle](https://github.com/ezsystems/RepositoryProfilerBundle)|Bundle to profile eZ Platform API/SPI and setup scenarios to be able to continuously test to keep track of performance regressions of repository and underlying storage engines(s)|

## Educational

This bundles are not necessarily something you would install but there are useful for learning process:

|Bundle|Description|
|------|-----------|
|[CookbookBundle](https://github.com/ezsystems/CookbookBundle)|This repository contains a eZ Publish 5.x and eZ Platform Cookbook Bundle, full of working examples for using eZ Publish 5.x and eZ Platform Public API (example API usage)|
|[ezplatform-com](https://github.com/ezsystems/ezplatform-com)|eZPlatform.com - The eZ Systems Developer Hub for the Open Source PHP CMS eZ Platform (example site)|
|[ezplatform-ee-demo](https://github.com/ezsystems/ezplatform-ee-demo)|Fork of the "ezplatform-ee" meta repository, contains changes to composer.json, AppKernel.php and config necessary to enable eZ Platform Enterprise Edition Demo (example site)|
|[ezplatform-demo](https://github.com/ezsystems/ezplatform-demo)|Fork of "ezplatform" meta repository, contains code and dependencies for demo distribution of eZ Platform. Not recommended for a clean install for new projects, but great for observation and learning(example site)|
|[TweetFieldTypeBundle](https://github.com/ezsystems/TweetFieldTypeBundle)|This repository contains the bundle that is created in the Field Type Tutorial (example field type)|
|[ezplatform-drawio-fieldtype](https://github.com/ezsystems/ezplatform-drawio-fieldtype)| Bundle providing support for diagrams editing in eZ Platform via draw.io (example field type)|
|[ezplatform-ui-2.0-introduction](https://github.com/ezsystems/ezplatform-ui-2.0-introduction)|eZ Platform is a 100% open source professional CMS (Content Management System) developed by eZ Systems and the eZ Community (code used for 2.0 admin-ui webinar in january)|
