1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Releases](Releases_31429534.html)
4.  [Release Notes](Release-Notes_32867905.html)

# eZ Platform and eZ Enterprise v1.6.0 

Created by Roland Benedetti, last modified by Dominika Kurek on Jan 30, 2017

**The 1.6.0 release of eZ Platform and Enterprise is available as of October 27th 2016.**

-   [Notable changes since v1.5.0](#eZPlatformandeZEnterprisev1.6.0-Notablechangessincev1.5.0)
    -   [eZ Platform](#eZPlatformandeZEnterprisev1.6.0-eZPlatform)
    -   [eZ Enterprise](#eZPlatformandeZEnterprisev1.6.0-eZEnterprise)
-   [Full list of new features, improvements and bug fixes since v1.5.0](#eZPlatformandeZEnterprisev1.6.0-Fulllistofnewfeatures,improvementsandbugfixessincev1.5.0)

# Notable changes since v1.5.0

## eZ Platform

The eZ Platform User Interface has been improved in many ways during this release, some visible and some more under the hood.

-   Visual preview of the selected item in the UDW, as a first step in the revamp of the UDW finder. See [EZP-25793](https://jira.ez.no/browse/EZP-25793) to see what is planned for the feature further along the line.

![Content preview in UDW](attachments/32867909/32868022.png)

-   [EZP-26240](https://jira.ez.no/browse/EZP-26240): Server side content validation errors will now be reflected in the UI if the app validation is removed, providing more details.
-   [EZP-26191](https://jira.ez.no/browse/EZP-26191): Draft conflict screen on dashboard:

![Draft conflict screen](attachments/32867909/32868024.png)

-   [EZP-26004](https://jira.ez.no/browse/EZP-26004) & [EZP-26003](https://jira.ez.no/browse/EZP-26003): Search in PlatformUI:

![Search in Platform UI](attachments/32867909/32868025.png)

Minor styling on different parts, stability on session and error management making the user interface feel more stable.

For developers there were also one such styling change, eZ logo now better matches the Symfony 2.8 web debug toolbar:

![](attachments/32867909/32868320.png)

 

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

## eZ Enterprise

In eZ Enterprise, most of the new eZ Studio feature development is being worked on in a branch for the next December release, with the **Form Builder** as well as **Date-based Publishing** being the major features. As a result, this release is mostly focused on consolidation and stabilization of eZ Studio with a lot of bug fixes and enhancement brought to the product.

Demo Sites

Beyond eZ Platform and eZ Studio, each release is built and shipped together with our demo sites for both eZ Platform and eZ Studio. They offer ways to test and see best practices on how to use the platform. This time, since v1.5.1, we have a few noticeable improvement to the demo site:

-   Selective rendering of "premium" content for registered end users only. Content is either rendered in full when the end user belongs to the "Members" group, or only as a teaser with a Register button:

![Premium content](attachments/32867909/32868026.png)

-   Registering new users based on the new UGC framework introduced in v1.5.0. It is accessible through the `/register` route:

![Registration form](attachments/32867909/32868027.png)

-   Authentication
-   Revamp and improvement of the integration of the Recommendation bundle:

![Recommended articles in Studio Demo](attachments/32867909/32868028.png)

Other bugs have been fixed in the demo bundle data.

# Full list of new features, improvements and bug fixes since v1.5.0

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<thead>
<tr class="header">
<th><h3 id="eZPlatformandeZEnterprisev1.6.0-eZPlatform.1">eZ Platform</h3></th>
<th><h3 id="eZPlatformandeZEnterprisev1.6.0-eZStudio">eZ Studio</h3></th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><a href="https://github.com/ezsystems/ezplatform/releases/tag/v1.6.0" class="external-link">List of changes for final of eZ Platform v1.6.0 on Github</a></td>
<td><a href="https://github.com/ezsystems/ezstudio/releases/tag/v1.6.0" class="external-link">List of changes for final of eZ Studio v1.6.0 on Github</a></td>
</tr>
<tr class="even">
<td><a href="https://github.com/ezsystems/ezplatform/releases/tag/v1.6.0-rc1" class="external-link">List of changes for rc1 of eZ Platform v1.6.0 on Github</a></td>
<td><a href="https://github.com/ezsystems/ezstudio/releases/tag/v1.6.0-rc1" class="external-link">List of changes for rc1 for eZ Studio v1.6.0 on Github</a></td>
</tr>
<tr class="odd">
<td><a href="https://github.com/ezsystems/ezplatform/releases/tag/v1.6.0-beta1" class="external-link">List of changes for beta1 of eZ Platform v1.6.0 on Github</a></td>
<td><a href="https://github.com/ezsystems/ezstudio/releases/tag/v1.6.0-beta1" class="external-link">List of changes for beta1 of eZ Studio v1.6.0 on Github</a></td>
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

**eZ Platform**: To update to this version, follow the [Updating eZ Platform](https://doc.ez.no/display/DEVELOPER/Updating+eZ+Platform) guide and use v1.6.0 as `<version>`.

 

## Attachments:

![](images/icons/bullet_blue.gif) [better\_udw.png](attachments/32867909/32868022.png) (image/png)
![](images/icons/bullet_blue.gif) [draft\_conflict\_screen.png](attachments/32867909/32868024.png) (image/png)
![](images/icons/bullet_blue.gif) [search.png](attachments/32867909/32868025.png) (image/png)
![](images/icons/bullet_blue.gif) [premium\_content.png](attachments/32867909/32868026.png) (image/png)
![](images/icons/bullet_blue.gif) [register.png](attachments/32867909/32868027.png) (image/png)
![](images/icons/bullet_blue.gif) [recommended\_articles.png](attachments/32867909/32868028.png) (image/png)
![](images/icons/bullet_blue.gif) [eZ Platform 1.6.0 in dev mode.png](attachments/32867909/32868320.png) (image/png)






