# eZ Platform and eZ Enterprise v1.6.0


**The 1.6.0 release of eZ Platform and Enterprise is available as of October 27th 2016.**

## Notable changes since v1.5.0

### eZ Platform

The eZ Platform User Interface has been improved in many ways during this release, some visible and some more under the hood.

-   Visual preview of the selected item in the UDW, as a first step in the revamp of the UDW finder. See [EZP-25793](https://jira.ez.no/browse/EZP-25793) to see what is planned for the feature further along the line.

![Content preview in UDW](img/better_udw.png)

-   [EZP-26240](https://jira.ez.no/browse/EZP-26240): Server side content validation errors will now be reflected in the UI if the app validation is removed, providing more details.
-   [EZP-26191](https://jira.ez.no/browse/EZP-26191): Draft conflict screen on dashboard:

![Draft conflict screen](img/draft_conflict_screen.png)

-   [EZP-26004](https://jira.ez.no/browse/EZP-26004) & [EZP-26003](https://jira.ez.no/browse/EZP-26003): Search in PlatformUI:

![Search in Platform UI](img/search.png)

Minor styling on different parts, stability on session and error management making the user interface feel more stable.

For developers there were also one such styling change, eZ logo now better matches the Symfony 2.8 web debug toolbar:

![](img/dev_mode.png)

 

Under the hood, quite a bit of work happened at the kernel level:

-   [EZP-26057](https://jira.ez.no/browse/EZP-26057): Permissions improvement API ([\#1720](https://github.com/ezsystems/ezpublish-kernel/pull/1720 "EZP-26057: Permissions API")) Implements a service and moves the API for permissions from the repository to that service
-   [EZP-26381](https://jira.ez.no/browse/EZP-26381): ContentViewBuilder will load the main location if none was asked
-   REST:
    -   [EZP-26179](https://jira.ez.no/browse/EZP-26179): Refactored session REST actions to resolve UI stability issue due to session loss
    -   Exposed "score" and "index" in REST SearchHits, e.g. &lt;searchHit score="1.0" index="installid1234567890"&gt;

    <!-- -->

    -   [EZP-26472](https://jira.ez.no/browse/EZP-26472): Added previous exception to the REST exception output
    -   [EZP-26326](https://jira.ez.no/browse/EZP-26326): Implemented "Filter" and "Query" REST Query parameters to be in sync with the PHP API
    -   Low-hanging-fruit: Made behat REST HTTP client use [standard HTTP verbs](http://restful-api-design.readthedocs.io/en/latest/methods.html) for improved standards compliance

### eZ Enterprise

In eZ Enterprise, most of the new eZ Studio feature development is being worked on in a branch for the next December release, with the **Form Builder** as well as **Date-based Publishing** being the major features. As a result, this release is mostly focused on consolidation and stabilization of eZ Studio with a lot of bug fixes and enhancement brought to the product.

Demo Sites

Beyond eZ Platform and eZ Studio, each release is built and shipped together with our demo sites for both eZ Platform and eZ Studio. They offer ways to test and see best practices on how to use the platform. This time, since v1.5.1, we have a few noticeable improvement to the demo site:

-   Selective rendering of "premium" content for registered end users only. Content is either rendered in full when the end user belongs to the "Members" group, or only as a teaser with a Register button:

![Premium content](img/premium_content.png)

-   Registering new users based on the new UGC framework introduced in v1.5.0. It is accessible through the `/register` route:

![Registration form](img/register.png)

-   Authentication
-   Revamp and improvement of the integration of the Recommendation bundle:

![Recommended articles in Studio Demo](img/recommended_articles.png)

Other bugs have been fixed in the demo bundle data.

## Full list of new features, improvements and bug fixes since v1.5.0


| eZ Platform  | eZ Studio   |
|--------------|-------------|
| [List of changes for final of eZ Platform v1.6.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.6.0)         | [List of changes for final of eZ Studio v1.6.0 on Github](https://github.com/ezsystems/ezstudio/releases/tag/v1.6.0)        |
| [List of changes for rc1 of eZ Platform v1.6.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.6.0-rc1)         | [List of changes for rc1 for eZ Studio v1.6.0 on Github](https://github.com/ezsystems/ezstudio/releases/tag/v1.6.0-rc1)        |
| [List of changes for beta1 of eZ Platform v1.6.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.6.0-beta1)         | [List of changes for beta1 of eZ Studio v1.6.0 on Github](https://github.com/ezsystems/ezstudio/releases/tag/v1.6.0-beta1)        |



### Installation

[Installation Guide](../getting_started/install_ez_platform.md)

[Technical Requirements](../getting_started/requirements.md)

### Download

#### eZ Platform

-   Download at [eZPlatform.com](http://ezplatform.com/#download)

 

 

#### eZ Enterprise

-   [Customers: eZ Enterprise subscription (BUL License)](https://support.ez.no/Downloads)*
    *
-   [Partners: Test & Trial software access (TTL License)](https://support.ez.no/Downloads)

If you would like to request an eZ Enterprise Demo instance: <http://ez.no/Forms/Discover-eZ-Studio>

 

### Updating

**eZ Platform**: To update to this version, follow the [Updating eZ Platform](../updating/updating_ez_platform.md) guide and use v1.6.0 as `<version>`.

 
