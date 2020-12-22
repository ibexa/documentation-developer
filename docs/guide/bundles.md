# Bundles

A bundle in Symfony (and [[= product_name =]]) is a separate part of your application that implements a feature.
You can create bundles yourself or make use of available open-source bundles.
You can also reuse the bundles you create in other projects or share them with the community.

Many [[= product_name =]] functionalities are provided through separate bundles included in the installation.
You can see the bundles that are automatically installed with [[= product_name =]] in [composer.json](https://github.com/ezsystems/ezplatform/blob/3.0/composer.json).

## Working with bundles

All bundles containing built-in [[= product_name =]] functionalities are installed automatically.
Additionally, you can install community-developed bundles from [[[= product_name =]] Packages.](https://ezplatform.com/packages)

To learn how to create your own bundles, see [Symfony documentation on bundles.](https://symfony.com/doc/5.0/bundles.html)

### Overriding third-party bundles

When you use an external bundle, you can override its parts, such as templates, controllers, etc.
To do so, make use of [Symfony's bundle override mechanism](https://symfony.com/doc/5.0/bundles/override.html).
Note that when overriding files, the path inside your application has to correspond to the path inside the bundle.

### Removing bundles

To remove a bundle (either one you created yourself, or an out-of-the-box one that you do not need),
see the [How to Remove a Bundle](http://symfony.com/doc/5.0/bundles/remove.html) instruction in Symfony doc.

## Built-in bundles

The following tables give an overview of the main [[= product_name =]] bundles.

### Core bundles

|Bundle|Description|
|---------|-----------|
|[ezplatform-kernel](https://github.com/ezsystems/ezplatform-kernel)|contains the core of the whole [[= product_name =]] application e.g. EzPublishCoreBundle|
|[ezplatform-content-forms](https://github.com/ezsystems/ezplatform-content-forms)|provides form-based integration for the Symfony Forms into Content and User objects in kernel|
|[ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine)|[Solr-powered](http://lucene.apache.org/solr/) search handler for [[= product_name =]]|
|[ez-support-tools](https://github.com/ezsystems/ez-support-tools)|provides functionality for system information|
|[ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache)|HTTP cache handling for [[= product_name =]], using multi tagging (incl Varnish xkey)|
|[ezplatform-admin-ui](https://github.com/ezsystems/ezplatform-admin-ui)|contains Back Office interface for [[= product_name =]] v2+|
|[ezplatform-admin-ui-assets](https://github.com/ezsystems/ezplatform-admin-ui-assets)|contains assets for AdminUI|
|[ezplatform-design-engine](https://github.com/ezsystems/ezplatform-design-engine)|design fallback system for [[= product_name =]] similar to legacy design fallback system|
|[ezplatform-standard-design](https://github.com/ezsystems/ezplatform-standard-design)|defines standard Design and Theme to be handled by ezplatform-design-engine|
|[ezplatform-cron](https://github.com/ezsystems/ezplatform-cron)|exposes cron/cron package for use in [[= product_name =]] (or just plain Symfony) via a simple command `ezplatform:cron:run`|
|[ezplatform-graphql](https://github.com/ezsystems/ezplatform-graphql)|defines GraphQL server for [[= product_name =]]|
|[ezplatform-matrix-fieldtype](https://github.com/ezsystems/ezplatform-matrix-fieldtype)|dedicated to Matrix Field Type for [[= product_name =]], it replaces previous version found on `ezcommunity/EzMatrixFieldTypeBundle`|
|[ezplatform-query-fieldtype](https://github.com/ezsystems/ezplatform-query-fieldtype)|Field Type that lists Content items based by querying the Repository|
|[ezplatform-rest](https://github.com/ezsystems/ezplatform-rest)|contains REST API|
|[ezplatform-richtext](https://github.com/ezsystems/ezplatform-richtext)|Field Type for supporting rich formatted text stored in a structured XML format|
|[ezplatform-user](https://github.com/ezsystems/ezplatform-user)|dedicated to [[= product_name =]] User management.|
|[BehatBundle](https://github.com/ezsystems/BehatBundle)|common reusable sentence implementations and other common needs for Behat testing in bundles/projects|

[[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

|Bundle|Description|
|---------|-----------|
|date-based-publisher|provides the date based publishing functionality for [[= product_name_exp =]]|
|ezplatform-workflow|implementation of a collaboration feature that lets you send content draft to any user for a review or rewriting|
|ezplatform-page-fieldtype|Page handling Field Type|
|ezplatform-page-builder|contains [[= product_name_exp =]] Page editor|
|ezplatform-ee-installer|provides `ezplatform:install` Symfony console command which is the installer for [[= product_name_exp =]] v2|
|ezplatform-http-cache-fastly|extends ezplatform-http-cache to support Fastly, for use on Platform.sh PE or standalone|
|ezplatform-calendar|extends the Back Office by adding the calendar tab with the calendar widget|
|ezplatform-version-comparison|allows comparing between two versions of the same Field|
|ezplatform-form-builder|enables creating Form Content items with multiple form fields|
|ezplatform-site-factory|enables configuration of sites from UI|
|ezplatform-elastic-search-engine|provides integration with Elasticsearch search engine |

### Optional bundles

|Bundle|Description|
|---------|-----------|
|[ezplatform-i18n](https://github.com/ezsystems/ezplatform-i18n)|centralized internationalization|
|[ezplatform-multi-file-upload](https://github.com/ezsystems/ezplatform-multi-file-upload)|allows uploading multiple files as new content items at once|
|[ezplatform-demo-assets](https://github.com/ezsystems/ezplatform-demo-assets)|contains binary install data for ezsystems/ezplatform-demo|

[[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

|Bundle|Description|
|---------|-----------|   
|ezstudio-personalized-block|Ibexa Personalized Block Bundle|

### Education

|Bundle|Description|
|------|-----------|
|[ezplatform-com](https://github.com/ezsystems/ezplatform-com)|the Ibexa Developer Hub for [[= product_name =]] (example site)|
|[ezplatform-ee-beginner-tutorial](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial)|resources used in the [[= product_name_exp =]] Beginner Tutorial|
|[docker-php](https://github.com/ezsystems/docker-php)|contains PHP docker image example|

### Documentation - additional resources

|Repository|Description|
|------|-----------|
|[developer-documentation](https://github.com/ezsystems/developer-documentation)|source for the developer documentation for [[= product_name =]], an open source CMS based on the Symfony Full Stack Framework in PHP. https://doc.ezplatform.com|
|[user-documentation](https://github.com/ezsystems/user-documentation)|source for the user documentation for [[= product_name =]], an open source CMS based on the Symfony Full Stack Framework in PHP|
