1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Releases](Releases_31429534.html)
4.  [Release Notes](Release-Notes_32867905.html)

# eZ Platform v1.9.0 

Created by Dominika Kurek, last modified on Apr 24, 2017

**The FAST TRACK v1.9.0 release of eZ Platform and eZ Platform Enterprise Edition is available as of April 19, 2017.**

If you are looking for the Long Term Support (LTS) release, see[ https://ezplatform.com/Blog/Long-Term-Support-is-Here](https://ezplatform.com/Blog/Long-Term-Support-is-Here)

**
**

-   [Notable changes since v1.8.0](#eZPlatformv1.9.0-Notablechangessincev1.8.0)
    -   [eZ Platform](#eZPlatformv1.9.0-eZPlatform)
    -   [eZ Platform Enterprise Edition - Studio](#eZPlatformv1.9.0-eZPlatformEnterpriseEdition-Studio)
    -   [eZ Platform Enterprise Edition - Studio Demo](#eZPlatformv1.9.0-eZPlatformEnterpriseEdition-StudioDemo)
-   [Full list of new features, improvements and bug fixes since v1.8.0](#eZPlatformv1.9.0-Fulllistofnewfeatures,improvementsandbugfixessincev1.8.0)

# Notable changes since v1.8.0

## eZ Platform

### Multifile upload

You can now create collections of content quickly: upload multiple files in bulk and they will be imported directly into the content repository. The files will automatically be imported as content using the Content Type that matches their MIME type. Go to the content view, drag and drop or select multiple files in the sub-items area and you will get direct access for further editing. As ever, this solution can be customized so that you create your own matching rules.

![](attachments/34079907/34080180.gif)

### Content browser

In version 1.8 we introduced a new Content Browser in the Universal Discovery Widget (UDW). This Content Browser is now used to browse content everywhere, also when accessing the content tree through the left pane in Platform UI. This allows users to reach the entire repository from this toolbar (which was previously limited in terms of number of items per level), it also provides a much more consistent user experience. To reflect this change, the Content tree button has been renamed **Content browse**.

![](attachments/34079907/34080181.gif)

### Miscellaneous

-   The Details tab in content view now provides information about the Section the Content item belongs to.

![Section details in Details tab](attachments/34079907/34079914.png "Section details in Details tab")

-   You can now edit a Content item directly from its parent's Sub-items table, and sort the table:

![Sub-items table with Edit button and sorting](attachments/34079907/34080043.png "Sub-items table with Edit button and sorting")

-   You can now restore from Trash content whose original Location has been deleted.
-   Pasted thead/tfood tags are now kept in RichText Field Type, and its Online Editor
-   Solr 6 is now supported in [Solr Bundle](Solr-Bundle_31430592.html)
    ![](attachments/34079907/34080150.png)

## eZ Platform Enterprise Edition - Studio

-   It is now possible to configure Landing Page blocks used by the Landing Page editor in a simpler way. The configuration is done in a YAML file (see <https://jira.ez.no/browse/EZEE-1421>)
-   *..lots of other bug fixes and smaller improvements..*

## eZ Platform Enterprise Edition - Studio Demo

### Tag and taxonomy management

The eZ Enterprise Demo now uses the [Netgen Tags bundle](https://github.com/netgen/TagsBundle). This bundle was recently ported to eZ Platform and provides a powerful, solid and user-friendly way to categorize content using tags. The solution lets editors and administrators define their taxonomies in a dedicated interface. These taxonomies that are immediately available for editors working on content who want to categorize any content types. 

 

![](attachments/34079907/34080183.gif)

### Miscellaneous

-   [DEMO-94](https://jira.ez.no/browse/DEMO-94): As an editor, I want to personalize content based on user persona
-   [DEMO-87](https://jira.ez.no/browse/DEMO-87): As an editor, I want to embed a video

# Full list of new features, improvements and bug fixes since v1.8.0

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th><h3 id="eZPlatformv1.9.0-eZPlatform.1">eZ Platform</h3></th>
<th><h3 id="eZPlatformv1.9.0-eZStudio">eZ Studio</h3></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><a href="https://github.com/ezsystems/ezplatform/releases/tag/v1.9.0" class="external-link">List of changes for final of eZ Platform v1.9.0 on Github</a></td>
<td><a href="https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.9.0" class="external-link">List of changes for final for eZ Platform Enterprise Edition v1.9.0 on Github</a></td>
</tr>
<tr class="even">
<td><a href="https://github.com/ezsystems/ezplatform/releases/tag/v1.9.0-rc1" class="external-link">List of changes for rc1 of eZ Platform v1.9.0 on Github</a></td>
<td><a href="https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.9.0-rc1" class="external-link">List of changes for rc1 for eZ Platform Enterprise Edition v1.9.0 on Github</a></td>
</tr>
<tr class="odd">
<td><a href="https://github.com/ezsystems/ezplatform/releases/tag/v1.9.0-beta2" class="external-link">List of changes for beta2 of eZ Platform v1.9.0 on Github</a></td>
<td><a href="https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.9.0-beta1" class="external-link">List of changes for beta1 of eZ Platform Enterprise Edition v1.9.0 on Github</a></td>
</tr>
</tbody>
</table>

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

To update to this version, follow the [Updating eZ Platform](https://doc.ez.no/display/DEVELOPER/Updating+eZ+Platform) guide and use v1.9.0 as `<version>`.

 

## Attachments:

![](images/icons/bullet_blue.gif) [content\_browse\_button.png](attachments/34079907/34079906.png) (image/png)
![](images/icons/bullet_blue.gif) [multifile-upload.png](attachments/34079907/34079912.png) (image/png)
![](images/icons/bullet_blue.gif) [section-details.png](attachments/34079907/34079914.png) (image/png)
![](images/icons/bullet_blue.gif) [demo-tags.png](attachments/34079907/34079917.png) (image/png)
![](images/icons/bullet_blue.gif) [demo-tags.png](attachments/34079907/34079915.png) (image/png)
![](images/icons/bullet_blue.gif) [sub-items-improved.png](attachments/34079907/34080043.png) (image/png)
![](images/icons/bullet_blue.gif) [Solr\_Logo\_on\_white.png](attachments/34079907/34080150.png) (image/png)
![](images/icons/bullet_blue.gif) [catsfromtheMET.gif](attachments/34079907/34080180.gif) (image/gif)
![](images/icons/bullet_blue.gif) [contentbrowse.gif](attachments/34079907/34080182.gif) (image/gif)
![](images/icons/bullet_blue.gif) [contentbrowse.gif](attachments/34079907/34080181.gif) (image/gif)
![](images/icons/bullet_blue.gif) [eztags.gif](attachments/34079907/34080183.gif) (image/gif)






