# eZ Platform v1.8.0

**The FAST TRACK v1.8.0 release of eZ Platform and eZ Platform Enterprise Edition is available as of February 16, 2017.**

If you are looking for the Long Term Support (LTS) release, see[ https://ezplatform.com/Blog/Long-Term-Support-is-Here](https://ezplatform.com/Blog/Long-Term-Support-is-Here)

## Notable Changes Since v1.7.0 LTS

### eZ Platform

#### User Interface

-   In Universal Discovery Widget (UDW) the browse view now uses a completely new browser widget, which replaces Treeview. This solves limitations on how many items you can browse for, and provides a more intuitive user experience.

![](udw.png)

-   Improvements in the Online Editor:
    -   You now have the ability to rearrange elements in the editor by moving them up and down.
    -   You can now add links to internal content items in the Online Editor, decide in which tab the link should open, and set link title:![](link-options-oe.png)
-   Improvements to the Sub-Items view of a Content Item: You can now sort content items by clicking column headings

![](subitem-sorting.png)

-   The main titles of the ContentTypeView now expand and retract with an accordion function
-   Updated and added icons for the Admin Interface
-   The whole interface of PlatformUI is now translatable using Crowdin, including in-context translation where you can navigate the interface while translating. A glossary has been established to aid in unified usage of terminology throughout. [Contributions welcome](https://crowdin.com/project/ezplatform)!

#### Under the Hood

-   New opt-in approach to HttpCache to improve usability as well as performance by means of:
    -   Cache multi-tagging: allowing you to tag pages with a path, location, type, parent, etc. so the repository can clear cache in a more targeted, accurate, and flexible way, getting rid of any "clear all" situations on complex operations.
    -   For Varnish this uses [xkey](https://github.com/varnish/varnish-modules/blob/master/docs/vmod_xkey.rst) instead of BAN, enabling greater performance by allowing you to control grace time.
    -   This also places HttpCache in a separate repo, allowing it to grow independently: see <https://github.com/ezsystems/ezplatform-http-cache>
-   New `content/publish` policy to be able to configure `content/edit` rights independently from publish rights
-   Community-provided translations of the user interface may be imported individually to conserve resources
-   Replaced deprecated templating helper assets with assets packages service
-   Localization of handlebar templates
-   Also part of v1.7.1 from the end of January:
    -   Solr: Solving last issues in UI hindering relative ranking of search results from working properly
    -   API: Respect `defaultAlwaysAvailable` setting on `newContentCreateStruct` solving issues with for instance Kaliop Migrations bundle use
    -   Landing pages: Better support for wider range of multi-site setups
    -   Online Editor: Ability to change a paragraph to header and back

 *For the complete list of fixes and improvements, see the GitHub release notes: <https://github.com/ezsystems/ezplatform/releases/tag/v1.8.0>*

### eZ Platform Enterprise Edition

#### Studio

-   New fields are available for the Form Builder:
    -   URL
    -   Date
    -   Checkbox
    -   Radio
    -   Dropdown
    -   Captcha
    -   File Upload

 

![](formb.png)

#### Under the Hood

-   StudioUI is now fully ready for Internationalization

### Updated eZ Platform/EE Demo Distributions

-   You can now search and filter products in the Product Page of the EE Demo distribution:

![](demo-product-filters.png)

## Full list of new features, improvements and bug fixes since v1.7.0 LTS:

| eZ Plaform   | eZ Studio  |
|--------------|------------|
| [List of changes for final of eZ Platform v1.8.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.8.0)         | [List of changes for final for eZ Platform Enterprise Edition v1.8.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.8.0)       |
| [List of changes for rc1 of eZ Platform v1.8.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.8.0-rc1)         | [List of changes for rc1 for eZ Platform Enterprise Edition v1.8.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.8.0-rc1)       |
| [List of changes for beta1 of eZ Platform v1.8.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.8.0-beta1)         | [List of changes for beta2 of eZ Platform Enterprise Edition v1.8.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.8.0-beta2)       |


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
