1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Releases](Releases_31429534.html)
4.  [Release Notes](Release-Notes_32867905.html)

# eZ Platform v1.10.0 

Created by André Rømcke, last modified by Roland Benedetti on Jul 11, 2017

**The FAST TRACK v1.10.0 release of eZ Platform and eZ Platform Enterprise Edition is available as of June 28, 2017.**

If you are looking for the Long Term Support (LTS) release, see[ https://ezplatform.com/Blog/Long-Term-Support-is-Here](https://ezplatform.com/Blog/Long-Term-Support-is-Here)

Upgrade notes

This release contains special steps to follow further described in [Updating eZ Platform](Updating-eZ-Platform_31431770.html).

 

-   [Notable changes since v1.9.0](#eZPlatformv1.10.0-Notablechangessincev1.9.0)
    -   [eZ Platform](#eZPlatformv1.10.0-eZPlatform)
    -   [eZ Platform Enterprise Edition - Studio](#eZPlatformv1.10.0-eZPlatformEnterpriseEdition-Studio)
    -   [eZ Platform Enterprise Edition - Studio Demo](#eZPlatformv1.10.0-eZPlatformEnterpriseEdition-StudioDemo)
-   [Full list of new features, improvements and bug fixes since v1.9.0](#eZPlatformv1.10.0-Fulllistofnewfeatures,improvementsandbugfixessincev1.9.0)

# Notable changes since v1.9.0

## eZ Platform

### Online Editor: Table editing support

This release introduces the ability to add tables in the RichText editor, enabling you to list up tabular data using table headings, merged table cells and more.

![](attachments/34080523/34081094.gif)

This is a first step. We aim to provide more in terms of table support in the editor later. For the time being images and embedding are not supported within the table, as you won't be able to move them out or edit them. We also don't provide yet ability to style the table within the editor.

 

### New Design Engine

This is a new way to handle design, theming and design overrides, similar to what we had in eZ Publish. It enables you to define different Themes which are collections of assets and templates. You can then assemble Themes (that can override each other) to define Designs, and eventually, assign a Design to a SiteAccess. This is a powerful concept that we will aim to use in our out-of-the-box templates and demo sites. It comes especially handy when using eZ Platform for a multisite installation and willing to reuse design parts. Further info can be found in the [Bundle documentation](https://github.com/ezsystems/ezplatform-design-engine/tree/master/doc).

![](attachments/34080523/34081091.png)

### API: Simplified usage with translations

As part of ongoing effort to simplify everyday aspects of the API for v2, [one notable part](https://jira.ez.no/browse/EZP-27428) that did not cause any BC was added to v1.10, enabling you to simplify how you deal with SiteAccess languages and translations.

###### Example

For objects such as Content, ContentType, Field Definitions and more, to get translated name, description or fields you would before this change have to do the following in PHP and Twig:

**Typical use of API prior to v1.10:**

``` brush:
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

``` brush:
$content = $this->contentService->loadContent(
    42,
    $this->configResolver->getParameter('languages')
);

$name = $content->getName();
$value = $content->getFieldValue('body');
```

*Further improvements such as getting the system to inject languages on api calls as shown in the first call above [are planned as part of the API epic](https://jira.ez.no/browse/EZP-26519)**, suggestions for further improvements are always welcome.*

### SOLR: Index time boosting & Improved Facets support

One of the new features in 1.10 *(Solr Bundle 1.4)* is the possibility to [configure index time boosting](Solr-Bundle_31430592.html), which enables you to properly tune the search results to be relevant for your content architecture.

In addition to that, we made progress on providing native support for faceted search within eZ Platform when using the Solr Bundle. You can now use facets based on ContentTypes, Sections and Users, see [Browsing, finding, viewing](31430307.html) page for how to use them. We plan to provide more facets natively in the coming releases.

![](attachments/34080523/34080517.png)

### Cluster migration script

EXPERIMENTAL FEATURE

Starting with 1.10, a new command `ezplatform:io:migrate-files` has been added, allowing you to migrate files from one storage to another, for instance file system to S3, or S3 to NFS or opposite. For documentation check the [technical feature documentation](https://github.com/ezsystems/ezpublish-kernel/blob/6.7/doc/specifications/io/io_migration_script.md) for now.

### Miscellaneous

-   Kernel: Don't store full User object in Sessions anymore, just User Id
    -    [![](https://jira.ez.no/images/icons/issuetypes/bug.png)EZP-24852](https://jira.ez.no/browse/EZP-24852?src=confmacro) - Add UserReference support in Authentication/User providers Closed

## eZ Platform Enterprise Edition - Studio

-   Form deletion is managed more gracefully, including warnings and the option to download collected data before deleting a form ([EZEE-1400](https://jira.ez.no/browse/EZEE-1400))

![Deleting a form with data](attachments/34080523/34081057.gif "Deleting a form with data")

-   [EZEE-1411](https://jira.ez.no/browse/EZEE-1411): Schedule block logic has been updated and improved.

## eZ Platform Enterprise Edition - Studio Demo

-   [DEMO-102](https://jira.ez.no/browse/DEMO-102): [NovaeZSEOBundle](https://github.com/Novactive/NovaeZSEOBundle/) is now included in Studio Demo. [NovaeZSEOBundle](https://github.com/Novactive/NovaeZSEOBundle/) includes a new Field Type that lets you manage your SEO strategy in very advanced and powerful ways.
-   [DEMO-100](https://jira.ez.no/browse/DEMO-100): We also improved the way we provide personalization in the site using a profiling block ([DEMO-94](https://jira.ez.no/browse/DEMO-94)) and letting the end user manage their preferences by themselves. In this new version, the end user, once logged on the site, can access a page where they can define their content preferences. See [here](https://ez.no/Blog/Personalization-Does-Not-Have-to-Be-that-Complex) for more information.

# Full list of new features, improvements and bug fixes since v1.9.0

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th><h3 id="eZPlatformv1.10.0-eZPlatform.1">eZ Platform</h3></th>
<th><h3 id="eZPlatformv1.10.0-eZStudio">eZ Studio</h3></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><a href="https://github.com/ezsystems/ezplatform/releases/tag/v1.10.0" class="external-link">List of changes for final of eZ Platform v1.10.0 on Github</a></td>
<td><a href="https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.10.0" class="external-link">List of changes for final for eZ Platform Enterprise Edition v1.10.0 on Github</a></td>
</tr>
<tr class="even">
<td><a href="https://github.com/ezsystems/ezplatform/releases/tag/v1.10.0-rc2" class="external-link">List of changes for rc2 of eZ Platform v1.10.0 on Github</a></td>
<td><a href="https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.10.0-rc1" class="external-link">List of changes for rc1 for eZ Platform Enterprise Edition v1.10.0 on Github</a></td>
</tr>
<tr class="odd">
<td><a href="https://github.com/ezsystems/ezplatform/releases/tag/v1.10.0-beta3" class="external-link">List of changes for beta3 of eZ Platform v1.10.0 on Github</a></td>
<td><a href="https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.10.0-beta1" class="external-link">List of changes for beta1 of eZ Platform Enterprise Edition v1.10.0 on Github</a></td>
</tr>
</tbody>
</table>

### Acknowledgements

Kudos to [@emodric](https://twitter.com/emodric) for the Tags bundle, [@pspanja](eZ-Platform-v1.10.0_34080523.html) for the work Solr index-time boosting, [@plopix](https://twitter.com/Plopix) for the NovaeZSEOBundle, [@](https://twitter.com/jvieilledent)[jvieilledent](https://twitter.com/jvieilledent)[ ](https://twitter.com/jvieilledent)for the initial work on the design engine and to all others who contributed bug reports, feedback and comments that made this release possible.

### Installation

[Installation Guide](https://doc.ez.no/display/DEVELOPER/Step+1%3A+Installation)

[Technical Requirements](31429536.html)

### Download

#### eZ Platform

-   Download at [eZPlatform.com](http://ezplatform.com/#download)

 

 

#### eZ Enterprise

-   [Customers: eZ Enterprise subscription (BUL License)](https://support.ez.no/Downloads)*
    *
-   [Partners: Test & Trial software access (TTL License)](https://support.ez.no/Downloads)

If you would like to request an eZ Enterprise Demo instance: <http://ez.no/Forms/Discover-eZ-Studio>

 

### Updating

To update to this version, follow the [Updating eZ Platform](https://doc.ez.no/display/DEVELOPER/Updating+eZ+Platform) guide and use v1.10.0 as `<version>`.

**Note:** When updating eZ Platform Enterprise Edition, you need to [add the new EzSystemsPlatformEEAssetsBundle](Updating-eZ-Platform_31431770.html#UpdatingeZPlatform-3.Updatetheapp)

 

## Attachments:

![](images/icons/bullet_blue.gif) [eztags.gif](attachments/34080523/34080514.gif) (image/gif)
![](images/icons/bullet_blue.gif) [contentbrowse.gif](attachments/34080523/34080515.gif) (image/gif)
![](images/icons/bullet_blue.gif) [catsfromtheMET.gif](attachments/34080523/34080516.gif) (image/gif)
![](images/icons/bullet_blue.gif) [Solr\_Logo\_on\_white.png](attachments/34080523/34080517.png) (image/png)
![](images/icons/bullet_blue.gif) [sub-items-improved.png](attachments/34080523/34080518.png) (image/png)
![](images/icons/bullet_blue.gif) [demo-tags.png](attachments/34080523/34080519.png) (image/png)
![](images/icons/bullet_blue.gif) [section-details.png](attachments/34080523/34080520.png) (image/png)
![](images/icons/bullet_blue.gif) [multifile-upload.png](attachments/34080523/34080521.png) (image/png)
![](images/icons/bullet_blue.gif) [content\_browse\_button.png](attachments/34080523/34080522.png) (image/png)
![](images/icons/bullet_blue.gif) [c506a0e0-2cf7-11e7-8bf0-a25de26e4552-1.png](attachments/34080523/34081001.png) (image/png)
![](images/icons/bullet_blue.gif) [delete-form.gif](attachments/34080523/34081057.gif) (image/gif)
![](images/icons/bullet_blue.gif) [platformui-table.gif](attachments/34080523/34081085.gif) (image/gif)
![](images/icons/bullet_blue.gif) [Screen Shot 2017-06-27 at 5.07.45 PM.png](attachments/34080523/34081088.png) (image/png)
![](images/icons/bullet_blue.gif) [Screen Shot 2017-06-27 at 5.12.26 PM.png](attachments/34080523/34081091.png) (image/png)
![](images/icons/bullet_blue.gif) [platformui-table.gif](attachments/34080523/34081094.gif) (image/gif)






