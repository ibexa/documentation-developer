# eZ Enterprise v1.4 Release notes

The v1.4.0 release of eZ Enterprise is available as of 30 June 2016. (We've [simplified](http://share.ez.no/blogs/ez/ez-systems-release-cycles-and-version-names-simplified) version names.)

For the release notes of the corresponding *(and included)* eZ Platform release, see [eZ Platform v1.4.0 Release notes](ez_platform_v1.4.0_release_notes.md)

 

### Quick links

-   [Installation instructions](../getting_started/install_ez_platform.md)
-   [Requirements](../getting_started/requirements)
-   [Download](http://share.ez.no/downloads/downloads)

    -   As Customer with eZ Enterprise subscription: <https://support.ez.no/Downloads> *( [BUL](http://ez.no/About-our-Software/Licenses-and-agreements/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1?return=/About-our-Software/Licenses-and-agreements/eZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1?processed=1457699707&return=%2FAbout-our-Software%2FLicenses-and-agreements%2FeZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1?return=%2FAbout-our-Software%2FLicenses-and-agreements%2FeZ-Business-Use-License-Agreement-eZ-BUL-Version-2.1)* * License)*

    -   As Partner with Test & Trial software access: <https://support.ez.no/Downloads> *  *( [TTL](http://ez.no/About-our-Software/Licenses-and-agreements/eZ-Trial-and-Test-License-Agreement-eZ-TTL-v2.0)* * License)* *

    -   If none of the above, request a demo instance: <http://ez.no/Forms/Discover-eZ-Studio>

 

## Changes since 2016.04

### Summary of changes

This release focused on bug fixing and optimization, and the developer effort was concentrated on features that are included in eZ Platform. Thus, no major Studio-specific features appear in this version.

Significant improvements include:

-   v1.0.0 of [RecommendationBundle](https://github.com/ezsystems/EzSystemsRecommendationBundle)released
-   Schedule block algorithm improved
-   Landing Page-related usability fixes

 

## Full list of improvements and bugfixes

|                                                              |                                                                                                                                                                  |                                                                                                                                |
|--------------------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------|
| Key                                                          | Summary                                                                                                                                                          | T                                                                                                                              |
| [EZEE-828](https://jira.ez.no/browse/EZEE-828?src=confmacro) | [Duplicated entry in assetic configuration leads to css 404 problems on linux machines](https://jira.ez.no/browse/EZEE-828?src=confmacro)                        | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-828?src=confmacro)                 |
| [EZEE-817](https://jira.ez.no/browse/EZEE-817?src=confmacro) | [Incorrect header in block settings](https://jira.ez.no/browse/EZEE-817?src=confmacro)                                                                           | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-817?src=confmacro)                 |
| [EZEE-814](https://jira.ez.no/browse/EZEE-814?src=confmacro) | [UnauthorizedException indexing user content object with Recommendation Bundle](https://jira.ez.no/browse/EZEE-814?src=confmacro)                                | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-814?src=confmacro)                 |
| [EZEE-810](https://jira.ez.no/browse/EZEE-810?src=confmacro) | [Not able to set the cursor in the middle of string in any input of block config form](https://jira.ez.no/browse/EZEE-810?src=confmacro)                         | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-810?src=confmacro)                 |
| [EZEE-809](https://jira.ez.no/browse/EZEE-809?src=confmacro) | [Content disappears from Schedule Block timeline when editing a published landing page](https://jira.ez.no/browse/EZEE-809?src=confmacro)                        | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-809?src=confmacro)                 |
| [EZEE-807](https://jira.ez.no/browse/EZEE-807?src=confmacro) | [Schedule Block - remove unnecessary DateTime format](https://jira.ez.no/browse/EZEE-807?src=confmacro)                                                          | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-807?src=confmacro)                 |
| [EZEE-800](https://jira.ez.no/browse/EZEE-800?src=confmacro) | [Content item preview disappears after turning overflow on](https://jira.ez.no/browse/EZEE-800?src=confmacro)                                                    | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-800?src=confmacro)                 |
| [EZEE-799](https://jira.ez.no/browse/EZEE-799?src=confmacro) | [Schedule Block new algorithm implementation](https://jira.ez.no/browse/EZEE-799?src=confmacro)                                                                  | [![Story](https://jira.ez.no/images/icons/issuetypes/story.png)](https://jira.ez.no/browse/EZEE-799?src=confmacro)             |
| [EZEE-794](https://jira.ez.no/browse/EZEE-794?src=confmacro) | [Notifications pop-up page number field size](https://jira.ez.no/browse/EZEE-794?src=confmacro)                                                                  | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-794?src=confmacro)                 |
| [EZEE-790](https://jira.ez.no/browse/EZEE-790?src=confmacro) | [Use view interface in Studio Demo controllers](https://jira.ez.no/browse/EZEE-790?src=confmacro)                                                                | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-790?src=confmacro) |
| [EZEE-788](https://jira.ez.no/browse/EZEE-788?src=confmacro) | [Cannot log in as users other than admin](https://jira.ez.no/browse/EZEE-788?src=confmacro)                                                                      | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-788?src=confmacro)                 |
| [EZEE-780](https://jira.ez.no/browse/EZEE-780?src=confmacro) | [The UI does not seem to handle many input fields there is no way to scroll the block config field](https://jira.ez.no/browse/EZEE-780?src=confmacro)            | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-780?src=confmacro)                 |
| [EZEE-779](https://jira.ez.no/browse/EZEE-779?src=confmacro) | [Schedule block problem with removing and adding once again the same Item](https://jira.ez.no/browse/EZEE-779?src=confmacro)                                     | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-779?src=confmacro)                 |
| [EZEE-778](https://jira.ez.no/browse/EZEE-778?src=confmacro) | [Schedule block issue with removing content item when some item was added again](https://jira.ez.no/browse/EZEE-778?src=confmacro)                               | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-778?src=confmacro)                 |
| [EZEE-776](https://jira.ez.no/browse/EZEE-776?src=confmacro) | [Problem with access to setting in second and next block in one zone](https://jira.ez.no/browse/EZEE-776?src=confmacro)                                          | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-776?src=confmacro)                 |
| [EZEE-773](https://jira.ez.no/browse/EZEE-773?src=confmacro) | [Content issues with studio demo data](https://jira.ez.no/browse/EZEE-773?src=confmacro)                                                                         | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-773?src=confmacro)                 |
| [EZEE-772](https://jira.ez.no/browse/EZEE-772?src=confmacro) | [404 response code from Flex Workflow endpoint](https://jira.ez.no/browse/EZEE-772?src=confmacro)                                                                | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-772?src=confmacro)                 |
| [EZEE-770](https://jira.ez.no/browse/EZEE-770?src=confmacro) | [Schedule grid doesn't display properly in eZ Studio](https://jira.ez.no/browse/EZEE-770?src=confmacro)                                                          | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-770?src=confmacro)                 |
| [EZEE-769](https://jira.ez.no/browse/EZEE-769?src=confmacro) | [Some blocks have not existing view types in clean studio](https://jira.ez.no/browse/EZEE-769?src=confmacro)                                                     | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-769?src=confmacro)                 |
| [EZEE-764](https://jira.ez.no/browse/EZEE-764?src=confmacro) | [When clicking on Content Tree I cannot see it](https://jira.ez.no/browse/EZEE-764?src=confmacro)                                                                | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-764?src=confmacro)                 |
| [EZEE-762](https://jira.ez.no/browse/EZEE-762?src=confmacro) | [eZStudio 2016.04 (1.3) installation from tarball doesn't work](https://jira.ez.no/browse/EZEE-762?src=confmacro)                                                | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-762?src=confmacro)                 |
| [EZEE-752](https://jira.ez.no/browse/EZEE-752?src=confmacro) | [Overflow target schedule block changes are shifted by one](https://jira.ez.no/browse/EZEE-752?src=confmacro)                                                    | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-752?src=confmacro)                 |
| [EZEE-699](https://jira.ez.no/browse/EZEE-699?src=confmacro) | [Not required empty block field prevents submission of configure popup](https://jira.ez.no/browse/EZEE-699?src=confmacro)                                        | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-699?src=confmacro)                 |
| [EZEE-698](https://jira.ez.no/browse/EZEE-698?src=confmacro) | [Landingpage block popup not displaying correctly](https://jira.ez.no/browse/EZEE-698?src=confmacro)                                                             | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-698?src=confmacro)                 |
| [EZEE-697](https://jira.ez.no/browse/EZEE-697?src=confmacro) | [Accessing other content\_types than landing pages in eZ Studio pages on a siteaccess with tree\_root, broken](https://jira.ez.no/browse/EZEE-697?src=confmacro) | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-697?src=confmacro)                 |
| [EZEE-696](https://jira.ez.no/browse/EZEE-696?src=confmacro) | [Siteaccess selection broken, in Page tab, with custom tree\_root setting](https://jira.ez.no/browse/EZEE-696?src=confmacro)                                     | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-696?src=confmacro)                 |
| [EZEE-679](https://jira.ez.no/browse/EZEE-679?src=confmacro) | [Xsd Validation for XML files](https://jira.ez.no/browse/EZEE-679?src=confmacro)                                                                                 | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-679?src=confmacro) |
| [EZEE-670](https://jira.ez.no/browse/EZEE-670?src=confmacro) | [Ends up in non-existing url after publishing](https://jira.ez.no/browse/EZEE-670?src=confmacro)                                                                 | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-670?src=confmacro)                 |
| [EZEE-653](https://jira.ez.no/browse/EZEE-653?src=confmacro) | [Add a Gallery content type in the Media content type group](https://jira.ez.no/browse/EZEE-653?src=confmacro)                                                   | [![Story](https://jira.ez.no/images/icons/issuetypes/story.png)](https://jira.ez.no/browse/EZEE-653?src=confmacro)             |
| [EZEE-628](https://jira.ez.no/browse/EZEE-628?src=confmacro) | [Schedule always shows all blocks, including future ones](https://jira.ez.no/browse/EZEE-628?src=confmacro)                                                      | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-628?src=confmacro)                 |
| [EZEE-569](https://jira.ez.no/browse/EZEE-569?src=confmacro) | [Settings form of RSS block has got broken layout](https://jira.ez.no/browse/EZEE-569?src=confmacro)                                                             | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-569?src=confmacro)                 |
| [EZEE-535](https://jira.ez.no/browse/EZEE-535?src=confmacro) | [Change color of slot indicator to match border color](https://jira.ez.no/browse/EZEE-535?src=confmacro)                                                         | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-535?src=confmacro) |
| [EZEE-445](https://jira.ez.no/browse/EZEE-445?src=confmacro) | [Hide the Landing Page field type on Landing Page Content in content view](https://jira.ez.no/browse/EZEE-445?src=confmacro)                                     | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-445?src=confmacro) |

 [33 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=key+%3D+EZS-788+OR+key+%3D+EZS-773+OR+key+%3D+EZS-776+OR+key+%3D+EZS-770+OR+key+%3D+EZS-769+OR+key+%3D+EZS-764+OR+key+%3D+EZS-762+OR+key+%3D+EZS-653+OR+key+%3D+EZS-535+OR+key+%3D+EZS-445+OR+key+%3D+EZS-799+OR+key+%3D+EZS-779+OR+key+%3D+EZS-780+OR+key+%3D+EZS-698+OR+key+%3D+EZS-699+OR+key+%3D+EZS-790+OR+key+%3D+EZS-679+OR+key+%3D+EZS-752+OR+key+%3D+EZS-807+OR+key+%3D+EZS-778+OR+key+%3D+EZS-809+OR+key+%3D+EZS-800+OR+key+%3D+EZS-794+OR+key+%3D+EZS-817+OR+key+%3D+EZS-810+OR+key+%3D+EZS-670+OR+key+%3D+EZS-828+OR+key+%3D+EZS-569+OR+key+%3D+EZS-696+OR+key+%3D+EZS-697+OR+key+%3D+EZS-814+OR+key+%3D+EZS-772+OR+key+%3D+EZS-628+&src=confmacro "View all matching issues in JIRA.")

 

## Updating

To update to this version, follow the [Updating eZ Platform](../updating/updating_ez_platform.md) guide and use v1.4.0 as `<version>`.
