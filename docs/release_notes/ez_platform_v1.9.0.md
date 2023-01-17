# eZ Platform v1.9.0


**The FAST TRACK v1.9.0 release of eZ Platform and eZ Platform Enterprise Edition is available as of April 19, 2017.**

If you are looking for the Long Term Support (LTS) release, see[ https://ezplatform.com/Blog/Long-Term-Support-is-Here](https://ezplatform.com/Blog/Long-Term-Support-is-Here)


## Notable changes since v1.8.0

### eZ Platform

#### Multifile upload

You can now create collections of content quickly: upload multiple files in bulk and they will be imported directly into the content repository. The files will automatically be imported as content using the Content Type that matches their MIME type. Go to the content view, drag and drop or select multiple files in the sub-items area and you will get direct access for further editing. As ever, this solution can be customized so that you create your own matching rules.

![](catsfromtheMET.gif)

#### Content browser

In version 1.8 we introduced a new Content Browser in the Universal Discovery Widget (UDW). This Content Browser is now used to browse content everywhere, also when accessing the content tree through the left pane in Platform UI. This allows users to reach the entire repository from this toolbar (which was previously limited in terms of number of items per level), it also provides a much more consistent user experience. To reflect this change, the Content tree button has been renamed **Content browse**.

![](contentbrowse.gif)

#### Miscellaneous

-   The Details tab in content view now provides information about the Section the Content item belongs to.

![Section details in Details tab](section-details.png "Section details in Details tab")

-   You can now edit a Content item directly from its parent's Sub-items table, and sort the table:

![Sub-items table with Edit button and sorting](sub-items-improved.png "Sub-items table with Edit button and sorting")

-   You can now restore from Trash content whose original Location has been deleted.
-   Pasted thead/tfood tags are now kept in RichText Field Type, and its Online Editor
-   Solr 6 is now supported in [Solr Bundle](https://doc.ibexa.co/en/latest/guide/search/solr)

### eZ Platform Enterprise Edition - Studio

-   It is now possible to configure Landing Page blocks used by the Landing Page editor in a simpler way. The configuration is done in a YAML file (see <https://jira.ez.no/browse/EZEE-1421>)
-   *..lots of other bug fixes and smaller improvements..*

### eZ Platform Enterprise Edition - Studio Demo

#### Tag and taxonomy management

The eZ Enterprise Demo now uses the [Netgen Tags bundle](https://github.com/netgen/TagsBundle). This bundle was recently ported to eZ Platform and provides a powerful, solid and user-friendly way to categorize content using tags. The solution lets editors and administrators define their taxonomies in a dedicated interface. These taxonomies that are immediately available for editors working on content who want to categorize any content types. 

![](eztags.gif)

#### Miscellaneous

-   [DEMO-94](https://jira.ez.no/browse/DEMO-94): As an editor, I want to personalize content based on user persona
-   [DEMO-87](https://jira.ez.no/browse/DEMO-87): As an editor, I want to embed a video

## Full list of new features, improvements and bug fixes since v1.8.0

| eZ Plaform   | eZ Studio  |
|--------------|------------|
| [List of changes for final of eZ Platform v1.9.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.9.0)         | [List of changes for final for eZ Platform Enterprise Edition v1.9.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.9.0)       |
| [List of changes for rc1 of eZ Platform v1.9.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.9.0-rc1)         | [List of changes for rc1 for eZ Platform Enterprise Edition v1.9.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.9.0-rc1)       |
| [List of changes for beta2 of eZ Platform v1.9.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.9.0-beta2)         | [List of changes for beta1 of eZ Platform Enterprise Edition v1.9.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.9.0-beta1)       |


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

### Updating

To update the product, follow the [updating guide](https://doc.ibexa.co/en/latest/updating/updating/).
