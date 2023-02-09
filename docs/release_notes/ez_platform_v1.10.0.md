# eZ Platform v1.10.0


**The FAST TRACK v1.10.0 release of eZ Platform and eZ Platform Enterprise Edition is available as of June 28, 2017.**

If you are looking for the Long Term Support (LTS) release, see[ https://ezplatform.com/Blog/Long-Term-Support-is-Here](https://ezplatform.com/Blog/Long-Term-Support-is-Here)

## Notable changes since v1.9.0

### eZ Platform

#### Online Editor: Table editing support

This release introduces the ability to add tables in the RichText editor, enabling you to list up tabular data using table headings, merged table cells and more.

![](platformui-table.gif)

This is a first step. We aim to provide more in terms of table support in the editor later. For the time being images and embedding are not supported within the table, as you won't be able to move them out or edit them. We also don't provide yet ability to style the table within the editor.

 

#### New Design Engine

This is a new way to handle design, theming and design overrides, similar to what we had in eZ Publish. It enables you to define different Themes which are collections of assets and templates. You can then assemble Themes (that can override each other) to define Designs, and eventually, assign a Design to a SiteAccess. This is a powerful concept that we will aim to use in our out-of-the-box templates and demo sites. It comes especially handy when using eZ Platform for a multisite installation and willing to reuse design parts. Further info can be found in the [Bundle documentation](https://github.com/ezsystems/ezplatform-design-engine/tree/master/doc).

![](newdesigntable.png)

#### API: Simplified usage with translations

As part of ongoing effort to simplify everyday aspects of the API for v2, [one notable part](https://jira.ez.no/browse/EZP-27428) that did not cause any BC was added to v1.10, enabling you to simplify how you deal with SiteAccess languages and translations.

###### Example

For objects such as Content, ContentType, Field Definitions and more, to get translated name, description or fields you would before this change have to do the following in PHP and Twig:

**Typical use of API prior to v1.10:**

``` bash
$content = $this->contentService->loadContent(
    42,
    $this->configResolver->getParameter('languages')
);

$name = $this->translationHelper->getTranslatedContentName($content);
$field = $this->translationHelper->getTranslatedField($content, 'body');
$value = $field->value;
```

As long as languages are provided to API when retrieving a given object, this can now be simplified to:

**As of v1.10:**

``` bash
$content = $this->contentService->loadContent(
    42,
    $this->configResolver->getParameter('languages')
);

$name = $content->getName();
$value = $content->getFieldValue('body');
```

*Further improvements such as getting the system to inject languages on api calls as shown in the first call above [are planned as part of the API epic](https://jira.ez.no/browse/EZP-26519)**, suggestions for further improvements are always welcome.*

#### SOLR: Index time boosting & Improved Facets support

One of the new features in 1.10 *(Solr Bundle 1.4)* is the possibility to [configure index time boosting](https://doc.ibexa.co/en/latest/guide/search/solr/#boost-configuration), which enables you to properly tune the search results to be relevant for your content architecture.

In addition to that, we made progress on providing native support for faceted search within eZ Platform when using the Solr Bundle. You can now use facets based on ContentTypes, Sections and Users, see [Performing a Faceted Search](https://doc.ibexa.co/en/latest/api/public_php_api_search/#faceted-search) page for how to use them. We plan to provide more facets natively in the coming releases.

#### Cluster migration script

EXPERIMENTAL FEATURE

Starting with 1.10, a new command `ezplatform:io:migrate-files` has been added, allowing you to migrate files from one storage to another, for instance file system to S3, or S3 to NFS or opposite. For documentation check the [technical feature documentation](https://github.com/ezsystems/ezpublish-kernel/blob/6.7/doc/specifications/io/io_migration_script.md) for now.

#### Miscellaneous

-   Kernel: Don't store full User object in Sessions anymore, just User Id
    -    [![](https://jira.ez.no/images/icons/issuetypes/bug.png)EZP-24852](https://jira.ez.no/browse/EZP-24852?src=confmacro) - Add UserReference support in Authentication/User providers Closed

### eZ Platform Enterprise Edition - Studio

-   Form deletion is managed more gracefully, including warnings and the option to download collected data before deleting a form ([EZEE-1400](https://jira.ez.no/browse/EZEE-1400))

![Deleting a form with data](delete-form.gif "Deleting a form with data")

-   [EZEE-1411](https://jira.ez.no/browse/EZEE-1411): Schedule block logic has been updated and improved.

### eZ Platform Enterprise Edition - Studio Demo

-   [DEMO-102](https://jira.ez.no/browse/DEMO-102): [NovaeZSEOBundle](https://github.com/Novactive/NovaeZSEOBundle/) is now included in Studio Demo. NovaeZSEOBundle includes a new Field Type that lets you manage your SEO strategy in very advanced and powerful ways.
-   [DEMO-100](https://jira.ez.no/browse/DEMO-100): We also improved the way we provide personalization in the site using a profiling block and letting the end user manage their preferences by themselves. In this new version, the end user, once logged on the site, can access a page where they can define their content preferences. See [here](https://ez.no/Blog/Personalization-Does-Not-Have-to-Be-that-Complex) for more information.

## Full list of new features, improvements and bug fixes since v1.9.0

| eZ Platform | eZ Studio |
|-------------|-----------|
| [List of changes for final of eZ Platform v1.10.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.10.0) | [List of changes for final for eZ Platform Enterprise Edition v1.10.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.10.0) |
| [List of changes for rc2 of eZ Platform v1.10.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.10.0-rc2) | [List of changes for rc1 for eZ Platform Enterprise Edition v1.10.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.10.0-rc1) |
| [List of changes for beta3 of eZ Platform v1.10.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.10.0-beta3) | [List of changes for beta1 of eZ Platform Enterprise Edition v1.10.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.10.0-beta1) |

### Acknowledgements

Kudos to [@emodric](https://twitter.com/emodric) for the Tags bundle, [@pspanja]() for the work Solr index-time boosting, [@plopix](https://twitter.com/Plopix) for the NovaeZSEOBundle, [@](https://twitter.com/jvieilledent)[jvieilledent](https://twitter.com/jvieilledent)[ ](https://twitter.com/jvieilledent)for the initial work on the design engine and to all others who contributed bug reports, feedback and comments that made this release possible.

### Installation

[Installation Guide](https://doc.ibexa.co/en/latest/getting_started/install_ez_platform)

[Technical Requirements](https://doc.ibexa.co/en/latest/getting_started/requirements)

### Download

#### eZ Platform

- Download at [eZPlatform.com](http://ezplatform.com/#download)

#### eZ Enterprise

- [Customers: eZ Enterprise subscription (BUL License)](https://support.ez.no/Downloads)
- Partners: Test & Trial software access (TTL License)

If you would like to become familiar with the products, [request a demo](https://www.ibexa.co/forms/request-a-demo).
