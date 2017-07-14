1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Releases](Releases_31429534.html)
4.  [Release Notes](Release-Notes_32867905.html)
5.  [eZ Platform Release notes](eZ-Platform-Release-notes_31429935.html)

# eZ Platform 15.11 Release notes

#### Quick links

-   [Installation instructions](https://github.com/ezsystems/ezplatform/tag/1.0.0-beta8/INSTALL.md)[](https://github.com/ezsystems/ezplatform/blob/v15.05/INSTALL.md)
-   [Requirements](https://doc.ez.no/display/TMPA/Requirements+5.4)
-   Download: See [share.ez.no/downloads](http://share.ez.no/downloads/downloads/ez-platform-15.09)

eZ Platform beta 8 is now available for testing. This releases focuses on cleanup, stabilization and the online editor.

# Highlights

## Platform no longer comes with the demo

The `ezsystems/ezplatform` package has been completely cleaned from any reference to the demo and DemoBundle. In addition, we have moved closer from the symfony-standard distribution:

-   A clean AppBundle is now shipped and enabled by default. Unless you have a specific reason not to do so, this is where your projects should start from
-   The `ezpublish` folder now contains an empty `Resources/views` directory. This is where the templates used in the app should go. They can be referenced from templates or yaml files as `"path/to/file"`, relative to the `views` directory
-   Settings have been cleaned up: `ezpublish.yml` has been renamed to `ezplatform.yml`, and greatly simplified. It is now imported from `config.yml` instead of being force-loaded by the kernel

This change should make it much easier to get started on a project. It also enforces a better separation, on our side, of demo related and application related changes.

## Platform UI performances improvements

-   The tree now uses location search instead of content search, leading to fewer HTTP queries ([EZP-24873](https://jira.ez.no/browse/EZP-24873))
-   The breadcrumb has been changed to use the new `AncestorOf` criterion, and should perform much better ([EZP-24871](https://jira.ez.no/browse/EZP-24871))
-   A new "combine" YUI semantic setting has also been introduced. This prepares for the [combo loader feature](https://github.com/ezsystems/PlatformUIBundle/pull/427) that is being worked on. Once approved this should significantly shorten the loading time of the backoffice.

## Online editor embeds

Embed elements can now be added to RichText fields. The editor will be shown the Universal Discovery Widget to browse for the embedded content ([EZP-24894](https://jira.ez.no/browse/EZP-24894)).

Images handing is [under active development,](https://github.com/ezsystems/PlatformUIBundle/pull/436) and will be part of the next release.

In addition, bugs were fixed on the Online Editor:

-   HTML entities in rich text editor were fixed ([EZP-24732](https://jira.ez.no/browse/EZP-24732))
-   Backspace in the richtext editor won't make the state inconsistent anymore ([EZP-25031](https://jira.ez.no/browse/EZP-25031))
-   Heading 1 is now fully visible when editing ([EZP-24970](https://jira.ez.no/browse/EZP-24970))
-   Saved RichText content is now free from unwanted markup and tags ([EZP-24967](https://jira.ez.no/browse/EZP-24967), [EZP-24971](https://jira.ez.no/browse/EZP-24971))

## Role, policies and languages management

Policies ([EZP-24713](https://jira.ez.no/browse/EZP-24713)), roles ([EZP-24700](https://jira.ez.no/browse/EZP-24700)) and languages ([EZP-22658](https://jira.ez.no/browse/EZP-22658)) management have been implemented. Role assignment with limitations is being finished, and should be part of the next release.

In addition, the following improvements have been made

-   Items can be excluded from selection in the universal discovery widget ([EZP-24989](https://jira.ez.no/browse/EZP-24989))
    This mechanism is based on callbacks, and can be re-used in PlatformUI extensions. 
-   The "save" button will be hidden when editing users ([EZP-25016](https://jira.ez.no/browse/EZP-25016))
-   Field definitions position is now calculated automatically ([EZP-24569](https://jira.ez.no/browse/EZP-24569))
-   The preview will now use the previewed content's title ([EZP-24927](https://jira.ez.no/browse/EZP-24927))

## Bug fixes

-   The main location of content can be changed ([EZP-24901](https://jira.ez.no/browse/EZP-24901))
-   Proper feedback will be given when an uploaded file exceeds the maximal size ([EZP-25037](https://jira.ez.no/browse/EZP-25037))
-   The language will be properly set when creating a new content as a child of freshly created one ([EZP-25048](https://jira.ez.no/browse/EZP-25048))
-   Uploading a different file type won't break the file's type anymore ([EZP-25039](https://jira.ez.no/browse/EZP-25039))
-   Selection fields are now validated properly ([EZP-24716](https://jira.ez.no/browse/EZP-24716))
-   Options can be added to a selection field definition ([EZP-25002](https://jira.ez.no/browse/EZP-25002))
-   Visibility is now properly updated in the content details tab ([EZP-24945](https://jira.ez.no/browse/EZP-24945))
-   eng-GB is no longer hardcoded in preview ([EZP-24929](https://jira.ez.no/browse/EZP-24929))
-   Subitems visibility will be updated when changing a location's visibility ([EZP-24964](https://jira.ez.no/browse/EZP-24964))
-   Fixed browser specific issues in Internet Explorer ([EZP-24055](https://jira.ez.no/browse/EZP-24055)), Firefox ([EZP-24907](https://jira.ez.no/browse/EZP-24907)) and Safari ([EZP-24986](https://jira.ez.no/browse/EZP-24986))
-   The first author field will now be automatically filled ([EZP-24050](https://jira.ez.no/browse/EZP-24050))
-   The always available flag is correctly set on created content ([EZP-24766](https://jira.ez.no/browse/EZP-24766), [EZP-25091](https://jira.ez.no/browse/EZP-25091))
-   Field edit display will no longer break when zooming ([EZP-25018](https://jira.ez.no/browse/EZP-25018))
-   Email validation has been improved ([EZP-24962](https://jira.ez.no/browse/EZP-24962), [EZP-25051](https://jira.ez.no/browse/EZP-25051))
-   Non-containers can no longer be used as targets for moving or copying content ([EZP-24973](https://jira.ez.no/browse/EZP-24973))
-   Image, media and binary field values can now be emptied and changed ([EZP-24959](https://jira.ez.no/browse/EZP-24959), [EZP-24922](https://jira.ez.no/browse/EZP-24922))
-   Alternative languages of content with untranslatable fields can now be saved ([EZP-24625](https://jira.ez.no/browse/EZP-24625))
-   Role editing will not report an error anymore when editing a role without changing its name ([EZP-24939](https://jira.ez.no/browse/EZP-24939))
-   Hitting enter in a repository form doesn't report an error anymore ([EZP-24942](https://jira.ez.no/browse/EZP-24942))
-   Notifications will be correct after publishing content ([EZP-25035](https://jira.ez.no/browse/EZP-25035))

## Platform

### XmlText moved to its own package

The XmlText FieldType has been moved to its own package ([EZP-24925](https://jira.ez.no/browse/EZP-24925)). It can be installed by requiring `ezsystems/ezplatform-xmltext-fieldtype`.

### Default view templates

Default templates were added for most views ([EZP-25121](https://jira.ez.no/browse/EZP-25121)). This means that any content will be shown on the site, even if no custom view rule was created for it yet. It will work for content view, with the `full`, `line` and `embed` view types. The default templates can be overridden using container parameters, and customized per siteaccess by means of siteaccess aware settings.

 

## Changelog

*Changes* (Stories, Improvements and bug fixes) can be found in our issue tracker:  [72 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=fixVersion%3D%222015.11%22+AND+project+%3D+EZP+AND+issuetype+in+%28Story%2C+Improvement%2C+Bug%29+order+by+issuetype+++&src=confmacro)  *(some are still pending additional documentation changes)*

### Known issues & upcoming features

List of issues specifically affecting this release:  [18 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+in+%28bug%29+AND+affectedVersion+%3D+2015.11+ORDER+BY+priority+++++++&src=confmacro)

General "Known issues" in *Platform stack* compared to* Legacy*:  [7 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+affectedVersion+%3D%22Known+Issues+5.x+Stack%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)

Epics tentatively\* planned for first stable release:  [6 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3DPollux+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)

Epics tentatively\* planned for first LTS release:  [0 issue](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3D%22Mauna+Kea%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority++&src=confmacro)

*'\* Some of these features will not be in the stable releases, the once we first and foremost will aim for having in the release are those mentioned on the [Roadmap](http://ez.no/Blog/What-to-Expect-from-eZ-Studio-and-eZ-Platform).*

 

## Attachments:

![](images/icons/bullet_blue.gif) [platform-custom-policies.png](attachments/31430067/31430043.png) (image/png)
![](images/icons/bullet_blue.gif) [locations\_tab.png](attachments/31430067/31430044.png) (image/png)
![](images/icons/bullet_blue.gif) [PlatformUI-navigation-bar.png](attachments/31430067/31430045.png) (image/png)
![](images/icons/bullet_blue.gif) [Please Help.jpg](attachments/31430067/31430046.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [privacy cookie.PNG](attachments/31430067/31430047.png) (image/png)
![](images/icons/bullet_blue.gif) [move-copy-send to trash.PNG](attachments/31430067/31430048.png) (image/png)
![](images/icons/bullet_blue.gif) [content\_download.PNG](attachments/31430067/31430049.png) (image/png)
![](images/icons/bullet_blue.gif) [variations purging.PNG](attachments/31430067/31430050.png) (image/png)
![](images/icons/bullet_blue.gif) [content type edition.PNG](attachments/31430067/31430051.png) (image/png)
![](images/icons/bullet_blue.gif) [symfony\_black\_02.png](attachments/31430067/31430052.png) (image/png)
![](images/icons/bullet_blue.gif) [symfony\_black\_03.png](attachments/31430067/31430053.png) (image/png)
![](images/icons/bullet_blue.gif) [RichText editor.png](attachments/31430067/31430054.png) (image/png)
![](images/icons/bullet_blue.gif) [Ventoux-Square.jpg](attachments/31430067/31430055.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Getting-Started-with-eZ-Publish-Platform.jpg](attachments/31430067/31430056.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Platform screenshoot alpha1.gif](attachments/31430067/31430057.gif) (image/gif)
![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 19.16.38 .png](attachments/31430067/31430058.png) (image/png)
![](images/icons/bullet_blue.gif) [PrivacyCookieBundle.png](attachments/31430067/31430059.png) (image/png)
![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 11.46.48 .png](attachments/31430067/31430060.png) (image/png)
![](images/icons/bullet_blue.gif) [iStock\_000032478246XLarge - banner doc.jpg](attachments/31430067/31430061.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [notifications.gif](attachments/31430067/31430062.gif) (image/gif)
![](images/icons/bullet_blue.gif) [Solr\_Logo\_on\_white.png](attachments/31430067/31430063.png) (image/png)
![](images/icons/bullet_blue.gif) [Platform 2015.07 - roles UI.PNG](attachments/31430067/31430064.png) (image/png)
![](images/icons/bullet_blue.gif) [Platform 2015.07 - choose translation.PNG](attachments/31430067/31430065.png) (image/png)
![](images/icons/bullet_blue.gif) [eZ Platform 2015.07 - add translation.gif](attachments/31430067/31430066.gif) (image/gif)


# eZ Platform 15.09 Release notes

# eZ Platform beta now available for testing

#### Quick links

-   [Installation instructions](https://github.com/ezsystems/ezplatform/blob/release-2015.09.01/INSTALL.md)[](https://github.com/ezsystems/ezplatform/blob/v15.05/INSTALL.md)
-   [Requirements](https://doc.ez.no/display/TMPA/Requirements+5.4)
-   Download: See [share.ez.no/downloads](http://share.ez.no/downloads/downloads/ez-platform-15.09), or see *Install* for how to install via composer.

The fifth release of eZ Platform, 15.09, is the first in "beta" stability. It builds upon the [15.07](eZ-Platform-15.07-Release-notes_31429990.html) September alpha release. It most notably provides many new UI features, both in this download and continues to provide a few more additional UI features during it's beta period until end of month.

# Highlights

Along with the [improvements and fixes](#eZPlatform15.09Releasenotes-changelog) listed at the bottom, the most notable changes are the sub-items list in PlatformUI, location & relation tabs, and policies support in custom bundles.

## Platform UI sub-items list

Sub-items will now be listed in PlatformUI. This is a minimum viable feature. In further releases, this will be expanded to improve UX with ability to change sub-items views and ability to easily add subitems. For now the sub-items list view enables repository browsing via the content view. 

Story: [EZP-24824](https://jira.ez.no/browse/EZP-24824)

## Platform UI languages improvements

The list of content languages configured in the system is now correctly passed on to the UI ([EZP-24865](https://jira.ez.no/browse/EZP-24865)), avoiding errors on language selection. 

The language of the edited content can now be selected during editing ([EZP-23768](https://jira.ez.no/browse/EZP-23768))

## New PlatformUI content tabs

Dedicated tabs have been added for relations ([EZP-24509](https://jira.ez.no/browse/EZP-24509)) and locations ([EZP-24815](https://jira.ez.no/browse/EZP-24815)) of any Content. Both will list a content's relations and locations.

The location tab also allows to manage (add, remove, hide/unhide) locations, as well as select a new main location (currently not working).

![](attachments/31430041/31430018.png)

## Other UI improvements

 

-   Content type groups can be managed ([EZP-24454](https://jira.ez.no/browse/EZP-24454))
-   Content types can be removed ([EZP-24453](https://jira.ez.no/browse/EZP-24453))
-   Users other than the admin can now login to Platform UI ([EZP-24753](https://jira.ez.no/browse/EZP-24753))
-   Limited user accounts management has been implemented
-   PJAX error messages are now correctly displayed ([EZP-24787](https://jira.ez.no/browse/EZP-24787))

 

![](attachments/31430041/31430019.png)

## Custom repository policies support

Bundles can now declare custom modules, policies and limitations.

Links: [documentation](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/security/permissions/policies_extensibility.md), [EZP-24862](https://jira.ez.no/browse/EZP-24862).

![](attachments/31430041/31430017.png)

## Repository and Platform improvements

-   Solr support for fullText location search ([EZP-24802](https://jira.ez.no/browse/EZP-24802))
-   ezcontentobject\_attribute stores always available flag to all fields
-   Float Fields now accepts integers ([EZP-24038](https://jira.ez.no/browse/EZP-24038))
-   An ancestor Search criterion has been added ([EZP-24804](https://jira.ez.no/browse/EZP-24804))
-   REST: users can be filtered by email and login ([EZP-24820](https://jira.ez.no/browse/EZP-24820))
-   Repository exceptions can be translated ([EZP-24793](https://jira.ez.no/browse/EZP-24793))
-   Bundles can now expose custom policies that can be checked via the repository ([EZP-24862](https://jira.ez.no/browse/EZP-24862))

 

## Changelog

*Changes* (Stories, Improvements and bug fixes) can be found in our issue tracker:  [67 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=fixVersion%3D%222015.07%22+AND+project+%3D+EZP+AND+issuetype+in+%28Story%2C+Improvement%2C+Bug%29+order+by+issuetype++++++++&src=confmacro)  *(some are still pending additional documentation changes)*

### Known issues & upcoming features

List of issues specifically affecting this release:  [35 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+in+%28bug%29+AND+affectedVersion+%3D+2015.05+ORDER+BY+priority++++++&src=confmacro)

General "Known issues" in *Platform stack* compared to* Legacy*:  [7 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+affectedVersion+%3D%22Known+Issues+5.x+Stack%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)

Epics tentatively\* planned for first stable release:  [6 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3DPollux+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)

Epics tentatively\* planned for first LTS release:  [0 issue](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3D%22Mauna+Kea%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority++&src=confmacro)

*'\* Some of these features will not be in the stable releases, the once we first and foremost will aim for having in the release are those mentioned on the [Roadmap](http://ez.no/Blog/What-to-Expect-from-eZ-Studio-and-eZ-Platform).*

 

## Attachments:

![](images/icons/bullet_blue.gif) [platform-custom-policies.png](attachments/31430041/31430017.png) (image/png)
![](images/icons/bullet_blue.gif) [locations\_tab.png](attachments/31430041/31430018.png) (image/png)
![](images/icons/bullet_blue.gif) [PlatformUI-navigation-bar.png](attachments/31430041/31430019.png) (image/png)
![](images/icons/bullet_blue.gif) [Please Help.jpg](attachments/31430041/31430020.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [privacy cookie.PNG](attachments/31430041/31430021.png) (image/png)
![](images/icons/bullet_blue.gif) [move-copy-send to trash.PNG](attachments/31430041/31430022.png) (image/png)
![](images/icons/bullet_blue.gif) [content\_download.PNG](attachments/31430041/31430023.png) (image/png)
![](images/icons/bullet_blue.gif) [variations purging.PNG](attachments/31430041/31430024.png) (image/png)
![](images/icons/bullet_blue.gif) [content type edition.PNG](attachments/31430041/31430025.png) (image/png)
![](images/icons/bullet_blue.gif) [symfony\_black\_02.png](attachments/31430041/31430026.png) (image/png)
![](images/icons/bullet_blue.gif) [symfony\_black\_03.png](attachments/31430041/31430027.png) (image/png)
![](images/icons/bullet_blue.gif) [RichText editor.png](attachments/31430041/31430028.png) (image/png)
![](images/icons/bullet_blue.gif) [Ventoux-Square.jpg](attachments/31430041/31430029.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Getting-Started-with-eZ-Publish-Platform.jpg](attachments/31430041/31430030.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Platform screenshoot alpha1.gif](attachments/31430041/31430031.gif) (image/gif)
![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 19.16.38 .png](attachments/31430041/31430032.png) (image/png)
![](images/icons/bullet_blue.gif) [PrivacyCookieBundle.png](attachments/31430041/31430033.png) (image/png)
![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 11.46.48 .png](attachments/31430041/31430034.png) (image/png)
![](images/icons/bullet_blue.gif) [iStock\_000032478246XLarge - banner doc.jpg](attachments/31430041/31430035.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [notifications.gif](attachments/31430041/31430036.gif) (image/gif)
![](images/icons/bullet_blue.gif) [Solr\_Logo\_on\_white.png](attachments/31430041/31430037.png) (image/png)
![](images/icons/bullet_blue.gif) [Platform 2015.07 - roles UI.PNG](attachments/31430041/31430038.png) (image/png)
![](images/icons/bullet_blue.gif) [Platform 2015.07 - choose translation.PNG](attachments/31430041/31430039.png) (image/png)
![](images/icons/bullet_blue.gif) [eZ Platform 2015.07 - add translation.gif](attachments/31430041/31430040.gif) (image/gif)


# eZ Platform 15.07 Release notes

# eZ Platform "Alpha4" available for testing

#### Quick links

-   [Installation instructions](https://github.com/ezsystems/ezplatform/blob/v0.10.0/INSTALL.md)[](https://github.com/ezsystems/ezplatform/blob/v15.05/INSTALL.md)
-   [Requirements](https://doc.ez.no/display/TMPA/Requirements+5.4) *(currently same as eZ Publish Platform 5.4)*
-   Upgrading: *As this is a alpha release, there is no upgrade instructions yet, this is planned for Beta.*

-   Download: See [share.ez.no/downloads](http://share.ez.no/downloads/downloads/ez-platform-15.07), or see *Install* for how to install via composer.

The fourth alpha release of eZ Platform,15.07, builds upon the [15.05](eZ-Platform-15.05-Release-notes_31429968.html) July release.  It most noticeably adds support for Solr, as well as many UI enhancements and additions. It also contains most improvements and fixes that are part of the 5.4.3 and 5.4.4 [enterprise releases](http://ez.no/Products/The-eZ-Publish-Platform).

# Highlights

With the many [improvements and fixes](#eZPlatform15.07Releasenotes-changelog) listed at the bottom, the main changes are:

## RichText editor improvements

-   The active element is now highlighted ([EZP-24769](https://jira.ez.no/browse/EZP-24769))
-   The contextual toolbar now works on the following elements:
    -   Headings: change level, or remove heading ([EZP-24725](https://jira.ez.no/browse/EZP-24725))
    -   Paragraphs: change alignment
-   The native Alloy Editor "append content" can be used to add a new heading or an embed element ([EZP-24768](https://jira.ez.no/browse/EZP-24768))

 

## Content language display selection

On Content that has translations, a dropdown will now list the available languages. Selecting one of them will display the Content in that language instead. The Edit button will now use the currently active translation.

Stories: [EZP-23765](https://jira.ez.no/browse/EZP-23765), [EZP-24549](https://jira.ez.no/browse/EZP-24549)

![](attachments/31429990/31429972.png)

## Translate content

When there are multiple languages configured, translations can be added and edited.

Story: [EZP-23766](https://jira.ez.no/browse/EZP-23766)

 

![](attachments/31429990/31429973.gif)

## Roles management UI prototype

An UI to manage Roles and Policies has been started, and can be previewed.

It is currently limited to listing, creating and deleting roles, without policy management, even though policies can already be viewed.

Epic: [EZP-24071](https://jira.ez.no/browse/EZP-24071)

As can be seen in the epic, this feature is being worked on, and will quickly evolve over the next weeks.

![](attachments/31429990/31429971.png)

## Other UI changes

-   **Details of locations** can now be viewed from the backoffice: content id, creator, modification date, remote id... ([EZP-24512](https://jira.ez.no/browse/EZP-24512))
-   **Interactive confirmation messages** as well as **notifications** can now be triggered by server side admin pages ([EZP-24652](https://jira.ez.no/browse/EZP-24652), [EZP-24536](https://jira.ez.no/browse/EZP-24536))
-   **AlloyEditor** has been updated to 0.5.x ([EZP-24712](https://jira.ez.no/browse/EZP-24712))
-   **Section Management** has been reworked, and moved from [ezsystems/platform-ui-bundle](https://github.com/ezsystems/PlaformUIBundle) to [ezsystems/repository-forms](https://github.com/ezsystems/repository-forms) ([EZP-24380](https://jira.ez.no/browse/EZP-24380))
-   Configuration can now be sent to the PlatformUI JS app ([EZP-24129](https://jira.ez.no/browse/EZP-24129))

## Native Solr support

Until now, the `SearchService` was using the Legacy database search implementation. It was quite limited, and performed very badly. The Solr implementation has been worked on since last summer, and finally made it into the product.

After [configuration and setup](https://doc.ez.no/display/EZP/Solr+Search+Engine+Bundle#SolrSearchEngineBundle-HowtosetupSolrSearchengine), Solr will be used by the SearchService for all of your Location, Content and ContentInfo queries. It has very advanced multilanguage capabilities, and will offer great performances whenever you need to grab Content or Locations from the Repository. 

Note that as it is lifts off many limitations, this feature will also be made available to Enterprise customers eZ Publish Platform 5.4 via a specific update.

Documentation: [https://doc.ez.no/display/EZP/Solr+Search+Engine+Bundle
](https://doc.ez.no/display/EZP/Solr+Search+Engine+Bundle)Source: [ezsystems/ezplatform-solr-search-engine](https://github.com/ezsystems/ezplatform-solr-search-engine)
Epic: [EZP-22944](https://jira.ez.no/browse/EZP-22944)

![](attachments/31429990/31429970.png)

## Other Platform changes

-   Locations returned by the REST API will now **include the ContentInfo**[.](https://jira.ez.no/browse/EZP-24672) This should avoid quite a few calls only to get the name, or basic info about the Location's Content ([EZP-24672](https://jira.ez.no/browse/EZP-24672))
-   The **REST API** will now let you **search for Location** in addition to Content. While the existing resource remains valid, note that `/views` should be used instead of `/content/views` ([EZP-24671](https://jira.ez.no/browse/EZP-24671))

## Changelog

*Changes* (Stories, Improvements and bug fixes) can be found in our issue tracker:  [67 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=fixVersion%3D%222015.07%22+AND+project+%3D+EZP+AND+issuetype+in+%28Story%2C+Improvement%2C+Bug%29+order+by+issuetype+++++++&src=confmacro)  *(some are still pending additional documentation changes)*

### Known issues & upcoming features

List of issues specifically affecting this release:  [35 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+in+%28bug%29+AND+affectedVersion+%3D+2015.05+ORDER+BY+priority++++++&src=confmacro)

General "Known issues" in *Platform stack* compared to* Legacy*:  [7 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+affectedVersion+%3D%22Known+Issues+5.x+Stack%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)

Epics tentatively\* planned for first stable release:  [6 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3DPollux+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)

Epics tentatively\* planned for first LTS release:  [0 issue](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3D%22Mauna+Kea%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority++&src=confmacro)

*'\* Some of these features will not be in the stable releases, the once we first and foremost will aim for having in the release are those mentioned on the [Roadmap](http://ez.no/Blog/What-to-Expect-from-eZ-Studio-and-eZ-Platform).*

## Attachments:

![](images/icons/bullet_blue.gif) [Solr\_Logo\_on\_white.png](attachments/31429990/31429970.png) (image/png)
![](images/icons/bullet_blue.gif) [Platform 2015.07 - roles UI.PNG](attachments/31429990/31429971.png) (image/png)
![](images/icons/bullet_blue.gif) [Platform 2015.07 - choose translation.PNG](attachments/31429990/31429972.png) (image/png)
![](images/icons/bullet_blue.gif) [eZ Platform 2015.07 - add translation.gif](attachments/31429990/31429973.gif) (image/gif)
![](images/icons/bullet_blue.gif) [privacy cookie.PNG](attachments/31429990/31429974.png) (image/png)
![](images/icons/bullet_blue.gif) [move-copy-send to trash.PNG](attachments/31429990/31429975.png) (image/png)
![](images/icons/bullet_blue.gif) [content\_download.PNG](attachments/31429990/31429976.png) (image/png)
![](images/icons/bullet_blue.gif) [variations purging.PNG](attachments/31429990/31429977.png) (image/png)
![](images/icons/bullet_blue.gif) [content type edition.PNG](attachments/31429990/31429978.png) (image/png)
![](images/icons/bullet_blue.gif) [symfony\_black\_02.png](attachments/31429990/31429979.png) (image/png)
![](images/icons/bullet_blue.gif) [symfony\_black\_03.png](attachments/31429990/31429980.png) (image/png)
![](images/icons/bullet_blue.gif) [RichText editor.png](attachments/31429990/31429981.png) (image/png)
![](images/icons/bullet_blue.gif) [Ventoux-Square.jpg](attachments/31429990/31429982.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Getting-Started-with-eZ-Publish-Platform.jpg](attachments/31429990/31429983.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Platform screenshoot alpha1.gif](attachments/31429990/31429984.gif) (image/gif)
![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 19.16.38 .png](attachments/31429990/31429985.png) (image/png)
![](images/icons/bullet_blue.gif) [PrivacyCookieBundle.png](attachments/31429990/31429986.png) (image/png)
![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 11.46.48 .png](attachments/31429990/31429987.png) (image/png)
![](images/icons/bullet_blue.gif) [iStock\_000032478246XLarge - banner doc.jpg](attachments/31429990/31429988.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [notifications.gif](attachments/31429990/31429989.gif) (image/gif)


# eZ Platform 15.05 Release notes

# eZ Platform "Alpha3" available for testing

![](attachments/31429968/31429960.png)

#### Quick links

-   [Installation instructions](https://github.com/ezsystems/ezplatform/blob/v0.9.0/INSTALL.md)[](https://github.com/ezsystems/ezplatform/blob/v15.05/INSTALL.md)
-   [Requirements](https://doc.ez.no/display/TMPA/Requirements+5.4) *(currently same as eZ Publish Platform 5.4)*
-   Upgrading: *As this is a alpha release, there is no upgrade instructions yet, this is planned for Beta.*

-   Download: See [share.ez.no/downloads](http://share.ez.no/downloads/downloads/ez-platform-15.05-alpha), or see *Install* for how to install via composer.

*July 6th 2015*

The third alpha release of eZ Platform,15.05 builds upon the [15.03](eZ-Platform-15.03-Release-notes_31429950.html) March release adding additional support for editing- and browsing-capabilities. It also contains several underlying improvements and fixes that will be part of the [5.3.6](https://doc.ez.no/display/TMPA/5.3.5+Release+Notes) and [5.4.3](https://doc.ez.no/display/TMPA/5.4.2+Release+Notes) maintenance versions that will be released soon.

# Highlights

Besides lots of smaller improvements and fixes found bellow, and mentioned above for the 5.x sub release, the main changes are: 

## Improved Symfony 2.7/3.0 support

![](attachments/31429968/31429958.png)

Symfony 2.7 LTS is now fully supported, and no deprecation errors should be thrown anymore. This should also ensure compatibility with the 2.8 and 3.0 releases planned for november this year.

Dynamic settings have been refactored to use the [Expression Language](http://symfony.com/fr/doc/current/components/expression_language/index.html) instead of fake services.

More info: [Symfony 2.7/3.0 epic](https://jira.ez.no/browse/EZP-24094), [Symfony 2.7 announcement blog post](http://symfony.com/blog/symfony-2-7-0-released)

 

## Content Type administration UI

Content types can now be created or edited from PlatformUI, inside the Admin panel. The feature isn't visually integrated yet, but already covers most FieldTypes. Progress can be followed on the Epic above.

Forms themselves use the [Symfony Forms component](http://symfony.com/doc/current/components/form/introduction.html). The implementation has been done in a distinct package, dedicated to providing Forms for the eZ Repository domain: [Repository Forms](https://github.com/ezsystems/repository-forms).

More info: [Content type management epic](http://jira.ez.no/browse/EZP-24070), [repository-forms on Github](https://github.com/ezsystems/repository-forms), [repository-forms on Packagist](https://packagist.org/packages/ezsystems/repository-forms).

 

 

 

 

![](attachments/31429968/31429957.png?effects=border-simple,blur-border)

## Image variations purging

![](attachments/31429968/31429956.png?effects=border-simple,blur-border)

Image variations generated by Imagine can now be purged using the application console. It can either clear all variations, or variations of a particular alias:

``` brush:
# Clear all variations of the large and gallery aliases/filters
php ezpublish/console liip:imagine:cache:remove --filters=large --filters=gallery -v
```

Note that this change comes with a modification of the variations storage path. This change will be transparent from a user's perspective, but you may want to purge the existing variations. To do this, you need to [switch to the legacy handler](https://github.com/ezsystems/ezpublish-kernel/blob/cc3f25fa25393e404f5af2806176fa07835721ef/eZ/Bundle/EzPublishCoreBundle/Resources/config/image.yml#L200) by redeclaring the `ezpublish.image_alias.variation_purger` service to `ezpublish.image_alias.variation_purger.legacy_storage_image_file`.

More info: [Technical specifications](https://github.com/ezsystems/ezpublish-kernel/blob/v6.0.0-alpha3/doc/specifications/image/variation_purging.md), [Implementation story](http://jira.ez.no/browse/EZP-23367).

 

## content/download controller for Binary Files

## Downloading of binary file is now natively supported, and doesn't require a legacy fallback anymore.

A new controller and route have been added, and the Image and BinaryFile content field templates have been updated. Permissions are transparently checked during download, and HTTP resume is supported. The [Route Reference API](https://doc.ez.no/display/EZP/RouteReference), provides facilities to generate the right path from templates, and a valid URI is exposed over REST.

More info: [Documentation](/pages/createpage.action?spaceKey=DEVELOPER&title=Usage%3A+Binary+and+Media+download+todelete&linkCreation=true&fromPageId=31429968), [Specificaftions](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/proposed/content_download/content_download.md), [Implementation story](https://jira.ez.no/browse/EZP-23550), [Content view module epic](https://jira.ez.no/browse/EZP-24144).

 

![](attachments/31429968/31429955.png?effects=border-simple,blur-border)

## Platform UI : move, copy and send content to trash

![](attachments/31429968/31429954.png)

Thanks to the addition of the Universal Discovery Widget in 2015.03, those functions have been added to PlatformUI.

More info: [Content CRUD UI epic](https://jira.ez.no/browse/EZP-22993) 

 

 

 

 

## Platform UI notifications

Notifications will now be displayed upon certain events in the backoffice.

Each notification is either an information (content was published, location was removed...), or an error. A reusable javascript API makes it easy to re-use the system for your own needs, if any, on PlatformUI. A PHP API has also been added in order to send notifications from the Symfony controllers used to implement some parts of the backoffice.

More info: [UI notifications epic](https://jira.ez.no/browse/EZP-24340)

 

![](attachments/31429968/31429952.gif)

## Rich text editing prototype based on Alloy

![](attachments/31429968/31429960.png)

A prototype of the WYSWIGYG editor for the RichText FieldType has been added. It is based on Alloy Editor, itself based on CKEditor. 

To see it in action, you need to create a new Content Type with a RichText Field. A perfect opportunity to test the Content Type admin UI.

More info: [Alloy Editor](http://alloyeditor.com/), [RichText editing epic](https://jira.ez.no/browse/EZP-22949), [prototype screencast](https://www.youtube.com/watch?v=o1r44rmYsdY)

**
**

**
**

## Re-usable privacy cookie handling

The [ezsystems/privacy-cookie-bundle](https://packagist.org/packages/ezsystems/privacy-cookie-bundle) package, introduced in the 15.03 release, has been made much more flexible. It now comes with a Factory interface and a Banner value object, so that it is easy to pick the banner's content in different ways.

The built-in implementation uses a configuration file based Factory, allowing you to configure the cookie banner using simple yaml files.

More info: [github repository](http://github.com/ezsystems/EzSystemsPrivacyCookieBundle) 

![](attachments/31429968/31429953.png?effects=border-simple,blur-border)

## Other notable changes

-   Legacy storage engine performances improvements
    -    [![](https://jira.ez.no/images/icons/issuetypes/bug.png)EZP-24499](https://jira.ez.no/browse/EZP-24499?src=confmacro) - loading Content with many languages & attributes & locations leads to high memory usage Closed
    -    [![](https://jira.ez.no/images/icons/issuetypes/improvement.png)EZP-24539](https://jira.ez.no/browse/EZP-24539?src=confmacro) - Avoid expensive sorting sql when not needed in Search Closed

## Changelog

*Changes* (Stories, Improvements and bug fixes) can be found in our issue tracker:  [51 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=fixVersion%3D%222015.05%22+AND+project+%3D+EZP+AND+issuetype+in+%28Story%2C+Improvement%2C+Bug%29+order+by+issuetype++++&src=confmacro)  *(some are still pending additional documentation changes)*

### Known issues & upcoming features

List of issues specifically affecting this release:  [35 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+in+%28bug%29+AND+affectedVersion+%3D+2015.05+ORDER+BY+priority+++++&src=confmacro)

General "Known issues" in *Platform stack* compared to* Legacy*:  [7 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+affectedVersion+%3D%22Known+Issues+5.x+Stack%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)

Epics tentatively\* planned for first stable release:  [6 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3DPollux+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)

Epics tentatively\* planned for first LTS release:  [0 issue](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3D%22Mauna+Kea%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority++&src=confmacro)

*'\* Some of these features will not be in the stable releases, the once we first and foremost will aim for having in the release are those mentioned on the [Roadmap](http://ez.no/Blog/What-to-Expect-from-eZ-Studio-and-eZ-Platform).*

## Attachments:

![](images/icons/bullet_blue.gif) [notifications.gif](attachments/31429968/31429952.gif) (image/gif)
![](images/icons/bullet_blue.gif) [privacy cookie.PNG](attachments/31429968/31429953.png) (image/png)
![](images/icons/bullet_blue.gif) [move-copy-send to trash.PNG](attachments/31429968/31429954.png) (image/png)
![](images/icons/bullet_blue.gif) [content\_download.PNG](attachments/31429968/31429955.png) (image/png)
![](images/icons/bullet_blue.gif) [variations purging.PNG](attachments/31429968/31429956.png) (image/png)
![](images/icons/bullet_blue.gif) [content type edition.PNG](attachments/31429968/31429957.png) (image/png)
![](images/icons/bullet_blue.gif) [symfony\_black\_02.png](attachments/31429968/31429958.png) (image/png)
![](images/icons/bullet_blue.gif) [symfony\_black\_03.png](attachments/31429968/31429959.png) (image/png)
![](images/icons/bullet_blue.gif) [RichText editor.png](attachments/31429968/31429960.png) (image/png)
![](images/icons/bullet_blue.gif) [Ventoux-Square.jpg](attachments/31429968/31429961.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Getting-Started-with-eZ-Publish-Platform.jpg](attachments/31429968/31429962.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Platform screenshoot alpha1.gif](attachments/31429968/31429963.gif) (image/gif)
![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 19.16.38 .png](attachments/31429968/31429964.png) (image/png)
![](images/icons/bullet_blue.gif) [PrivacyCookieBundle.png](attachments/31429968/31429965.png) (image/png)
![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 11.46.48 .png](attachments/31429968/31429966.png) (image/png)
![](images/icons/bullet_blue.gif) [iStock\_000032478246XLarge - banner doc.jpg](attachments/31429968/31429967.jpg) (image/jpeg)

# eZ Platform 15.03 Release notes

## eZ Platform "Alpha2" available for testing

##### 13th May 2015

![Preview of Platform UI Alpha2 during editing an image](attachments/31429950/31429945.png "Preview of Platform UI during editing an image")

#### Quick links

-   [Install](https://github.com/ezsystems/ezplatform/blob/master/INSTALL.md)
-   [Requirements](https://doc.ez.no/display/TMPA/Requirements+5.4) *(currently same as eZ Publish Platform 5.4)*
-   Upgrading: *As this is a alpha release, there is no upgrade instructions yet, this is planned for Beta during the Summer.*

-   Download: See [share.ez.no/downloads](http://share.ez.no/downloads/downloads/ez-platform-15.03-alpha), or see *Install* for how to install via composer.

The second alpha release of eZ Platform,15.03, builds upon the [15.01](eZ-Platform-15.01-Release-notes_31429941.html) March release adding additional support for editing- and browsing-capabilities. It also contains several underlying improvements and fixes developed for [5.3.5](https://doc.ez.no/display/TMPA/5.3.5+Release+Notes) and [5.4.2](https://doc.ez.no/display/TMPA/5.4.2+Release+Notes), that has also been released recently.

*Next release is planned to be released beginning of June, and will preview several additional features currently not exposed yet.*

## Highlights

Besides lots of smaller improvements and fixes found bellow, and mentioned above for the 5.x sub release, the main visual changes are: 

### Platform UI Bundle with Universal Discovery Widget

 

<table>
<colgroup>
<col width="50%" />
<col width="50%" />
</colgroup>
<tbody>
<tr class="odd">
<td><span class="confluence-embedded-file-wrapper confluence-embedded-manual-size"><img src="attachments/31429950/31429943.png" class="confluence-embedded-image confluence-thumbnail" width="300" /></span></td>
<td><p>One important feature in eZ Publish, and also now eZ Platform, is being able to browse for content you want to select. In eZ Platform we call this Universal Discovery Widget, and in this release you can see more or less the completion of first part of this with possibility to select by browsing the tree (location structure): <span class="jira-issue resolved"> <a href="https://jira.ez.no/browse/EZP-23893?src=confmacro" class="jira-issue-key"><img src="https://jira.ez.no/images/icons/issuetypes/epic.png" class="icon" />EZP-23893</a> - <span class="summary">UDW : Basic tree</span> <span class="aui-lozenge aui-lozenge-subtle aui-lozenge-success jira-macro-single-issue-export-pdf">Closed</span> </span></p>
<p>This is used for Relation, Relation List and Section assignment selection so far, and before July release we hope to complete this part with inclusion of <span class="jira-issue"> <a href="https://jira.ez.no/browse/EZP-24067?src=confmacro" class="jira-issue-key"><img src="https://jira.ez.no/images/icons/issuetypes/epic.png" class="icon" />EZP-24067</a> - <span class="summary">Sub items widget</span> <span class="aui-lozenge aui-lozenge-subtle aui-lozenge-current jira-macro-single-issue-export-pdf">QA</span> </span></p>
<p>Future tentatively planned ways to browse for content includes:</p>
<p></p>
<div id="refresh-module-927678158">
<p></p>
<div id="jira-issues-927678158" style="width: 100%;  overflow: auto;">
<table>
<tbody>
<tr class="odd">
<td><span class="jim-table-header-content">Summary</span></td>
<td><span class="jim-table-header-content">Updated</span></td>
<td><span class="jim-table-header-content">P</span></td>
<td><span class="jim-table-header-content">Status</span></td>
</tr>
<tr class="even">
<td><a href="https://jira.ez.no/browse/EZP-24284?src=confmacro">UDW - Search</a></td>
<td>Jul 04, 2017</td>
<td><img src="https://jira.ez.no/images/icons/priorities/critical.png" alt="Critical" class="icon" /></td>
<td><span class="aui-lozenge aui-lozenge-subtle aui-lozenge-success"> Closed </span></td>
</tr>
<tr class="odd">
<td><a href="https://jira.ez.no/browse/EZP-24285?src=confmacro">UDW - recent content</a></td>
<td>Jun 30, 2016</td>
<td><img src="https://jira.ez.no/images/icons/priorities/major.png" alt="High" class="icon" /></td>
<td><span class="aui-lozenge aui-lozenge-subtle aui-lozenge-complete"> Open </span></td>
</tr>
<tr class="even">
<td><a href="https://jira.ez.no/browse/EZP-24286?src=confmacro">UDW : Bookmark</a></td>
<td>Jun 30, 2016</td>
<td><img src="https://jira.ez.no/images/icons/priorities/minor.png" alt="Medium" class="icon" /></td>
<td><span class="aui-lozenge aui-lozenge-subtle aui-lozenge-complete"> Open </span></td>
</tr>
<tr class="odd">
<td><a href="https://jira.ez.no/browse/EZP-24287?src=confmacro">UDW : ID</a></td>
<td>Jun 30, 2016</td>
<td><img src="https://jira.ez.no/images/icons/priorities/trivial.png" alt="Low" class="icon" /></td>
<td><span class="aui-lozenge aui-lozenge-subtle aui-lozenge-complete"> Open </span></td>
</tr>
</tbody>
</table>
</div>
<div class="refresh-issues-bottom">
<span id="total-issues-count-927678158"> <a href="https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&amp;jqlQuery=key+in+%28EZP-24284%2C+EZP-24285%2C+EZP-24286%2C+EZP-24287%29++order+by+priority+&amp;src=confmacro" title="View all matching issues in JIRA.">4 issues</a> </span>
</div>
</div></td>
</tr>
</tbody>
</table>

### Demo Bundle with privacy cookie banner

|                                        |                                                                                                                                                                                                                                                                                     |
|----------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| ![](attachments/31429950/31429944.png) | Available in this release is a new [PrivacyCookieBundle](https://github.com/ezsystems/EzSystemsPrivacyCookieBundle), providing easy access to setup warning and remembering user input for Privacy banners needed to comply with EU directive commonly referred to as "Cookie law". |

### Other notable changes

-    [![](https://jira.ez.no/images/icons/issuetypes/improvement.png)EZP-24015](https://jira.ez.no/browse/EZP-24015?src=confmacro) - Improve Language Switcher flags and logic Closed
-    [![](https://jira.ez.no/images/icons/issuetypes/story.png)EZP-23730](https://jira.ez.no/browse/EZP-23730?src=confmacro) - As an editor, I want to see the content of the media fields Closed
-    [![](https://jira.ez.no/images/icons/issuetypes/story.png)EZP-23816](https://jira.ez.no/browse/EZP-23816?src=confmacro) - As an editor, I want to be able to fill the Relation field Closed
-    [![](https://jira.ez.no/images/icons/issuetypes/improvement.png)EZP-24213](https://jira.ez.no/browse/EZP-24213?src=confmacro) - FullText stopWordThreshold should be percentage of content count Closed

 

## Changelog

*Changes* (Stories, Improvements and bug fixes) can be found in our issue tracker:  [47 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=fixVersion%3D%222015.03%22+AND+project+%3D+EZP+AND+issuetype+in+%28Story%2C+Improvement%2C+Bug%29+order+by+issuetype++&src=confmacro)  *(some are still pending additional documentation changes)*

### Known issues & upcoming features

-   List of issues specifically affecting this release:  [19 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+in+%28bug%29+AND+affectedVersion+%3D+2015.03+ORDER+BY+priority+++&src=confmacro)
-   General "Known issues" in *Platform stack* compared to* Legacy*:  [7 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+affectedVersion+%3D%22Known+Issues+5.x+Stack%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)
-   Epics tentatively\* planned for first stable release:  [6 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3DPollux+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)
-   Epics tentatively\* planned for first LTS release:  [0 issue](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3D%22Mauna+Kea%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority++&src=confmacro)

*'\* Some of these features will not be in the stable releases, the once we first and foremost will aim for having in the release are those mentioned on the [Roadmap](http://ez.no/Blog/What-to-Expect-from-eZ-Studio-and-eZ-Platform).*

## Attachments:

![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 19.16.38 .png](attachments/31429950/31429943.png) (image/png)
![](images/icons/bullet_blue.gif) [PrivacyCookieBundle.png](attachments/31429950/31429944.png) (image/png)
![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 11.46.48 .png](attachments/31429950/31429945.png) (image/png)
![](images/icons/bullet_blue.gif) [iStock\_000032478246XLarge - banner doc.jpg](attachments/31429950/31429946.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Ventoux-Square.jpg](attachments/31429950/31429947.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Getting-Started-with-eZ-Publish-Platform.jpg](attachments/31429950/31429948.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Platform screenshoot alpha1.gif](attachments/31429950/31429949.gif) (image/gif)


# eZ Platform 15.01 Release notes

## Introducing eZ Platform, "Alpha1"

##### 4th March 2015

<table>
<colgroup>
<col width="100%" />
</colgroup>
<tbody>
<tr class="odd">
<td><span class="confluence-embedded-file-wrapper"><img src="attachments/31429941/31429937.gif" class="confluence-embedded-image" /></span></td>
</tr>
<tr class="even">
<td><p>Welcome to the first release of eZ Platform, 15.01 serves two purposes: As first alpha release of eZ Platform, and also as eZ Publish Community edition v2015.01 by installing optional legacy packages. Further information about eZ Platform (and eZ Studio), and what you can expect, can be found in <a href="http://ez.no/Blog/What-to-Expect-from-eZ-Studio-and-eZ-Platform" class="external-link">recent blog post on ez.no</a>.</p>
<h4 id="eZPlatform15.01Releasenotes-Quicklinks">Quick links</h4>
<ul>
<li><span style="color: rgb(0,51,102);"><span style="color: rgb(0,51,102);"><a href="https://github.com/ezsystems/ezplatform/blob/master/INSTALL.md" class="external-link">Install</a></span></span></li>
<li><span style="color: rgb(0,51,102);"><a href="https://doc.ez.no/display/TMPA/Requirements+5.4">Requirements</a> <span style="color: rgb(128,128,128);"><em>(currently same as eZ Publish Platform 5.4)</em></span></span></li>
<li><p><span style="color: rgb(0,0,0);">Upgrading: <span style="color: rgb(128,128,128);"><em>As this is a alpha release, there is no upgrade instructions yet, this will be available starting with the beta, currently <a href="http://ez.no/Blog/What-Releases-to-Expect-from-eZ-in-2015" class="external-link">scheduled</a> for May</em></span></span></p></li>
<li><p>Download: <em>Download</em> from <a href="http://share.ez.no/downloads/downloads/ez-platform-15.01-alpha" class="external-link">share.ez.no/downloads</a> or see <em>Install</em> for how to install via composer</p></li>
</ul></td>
</tr>
</tbody>
</table>

## Highlights

### Legacy is "gone"

This major milestone, and is what makes the first release of eZ Platform possible. This is further covered in [Core Development blog post](http://share.ez.no/blogs/core-development-team/farewell-ez-publish-legacy-welcome-ez-platform). But in short: the related libraries, services and configuration have been externalized to a new package: [ezsystems/legacy-bridge](https://packagist.org/packages/ezsystems/legacy-bridge). And since the eZ Platform is still in alpha, ezpublish-legacy and legacy-bridge v2015.01 can still easily be installed.

### Ships with Platform UI Bundle v0.5

Platform UI, [revealed last july](http://share.ez.no/blogs/core-development-team/the-future-ez-publish-platform-backend-ui-is-here), has received its first tag: [v0.5](https://github.com/ezsystems/PlatformUIBundle/tree/v0.5.0). It is pre-installed and pre-configured in this release, and it can be accessed via `<example.com>/shell`.

See [blog post from December](http://share.ez.no/blogs/core-development-team/platformui-december-2014-status)for further information about the new User Interface.

### Prototype of native installer

Since we can't rely on legacy anymore, prototype of a native installer has been added, as a console script: `ezpublish/console ezplatform:install`. It is meant to be very simple, fast, easy to automate, and easy to extend.

## Changelog

*Changes* (Stories, Improvements and bug fixes) can be found in our issue tracker:  [87 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=fixVersion%3D%222015.01%22+AND+project+%3D+EZP+AND+issuetype+in+%28Story%2C+Improvement%2C+Bug%29+order+by+issuetype+&src=confmacro)

### Known issues & upcoming features

-   List of issues specifically affecting this release:  [42 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+in+%28bug%29+AND+affectedVersion+%3D+2015.01+ORDER+BY+priority++&src=confmacro)
-   General "Known issues" in *Platform stack* compared to* Legacy*:  [7 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+affectedVersion+%3D%22Known+Issues+5.x+Stack%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)
-   Epics currently planned for first stable release:  [6 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3DPollux+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)
-   Epics currently planned for first LTS release:  [0 issue](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3D%22Mauna+Kea%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority++&src=confmacro)

 

## Attachments:

![](images/icons/bullet_blue.gif) [Platform screenshoot alpha1.gif](attachments/31429941/31429937.gif) (image/gif)
![](images/icons/bullet_blue.gif) [iStock\_000032478246XLarge - banner doc.jpg](attachments/31429941/31429938.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Ventoux-Square.jpg](attachments/31429941/31429939.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Getting-Started-with-eZ-Publish-Platform.jpg](attachments/31429941/31429940.jpg) (image/jpeg)
