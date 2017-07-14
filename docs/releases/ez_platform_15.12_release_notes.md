1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Releases](Releases_31429534.html)
4.  [Release Notes](Release-Notes_32867905.html)
5.  [eZ Platform Release notes](eZ-Platform-Release-notes_31429935.html)

# eZ Platform 15.12 Release notes 

Created by Dominika Kurek, last modified by David Christian Liedle on Oct 31, 2016

#### Quick links

-   [Installation instructions](https://doc.ez.no/display/DEVELOPER/Step+1%3A+Installation)[](https://github.com/ezsystems/ezplatform/blob/v15.05/INSTALL.md)
-   [Requirements](https://doc.ez.no/pages/viewpage.action?pageId=31429536)
-   Download: See [share.ez.no/downloads](http://share.ez.no/downloads/downloads/ez-platform-15.12)

15.12 is the first stable release of eZ Platform. 

These release notes describe the first stable Fast-Track release of eZ Platform, as compared to the previous one, 15.11.

# Highlights

## The `ezpublish` folder has been renamed to `app`

The directory that contains the configuration, cache and kernel files had been named `ezpublish` since release 5.0. After serious consideration, it has been renamed to `app`, in order to be closer to the standard Symfony distribution.

## The default installation data have been cleaned up

Since the removal of the demo in the 2015.11 release, a clean SQL dump is now used to install the system. This dump has been cleaned up, and should now provide you with a very clean basis to start your projects. It contains a few content types (folder, article, image, user group, user), as well as the minimal folders (Content, Media, and Users).

It will be installed when executing `php app/console ezplatform:install clean`.

## Online editor improvements

A new feature made it into the Online Editor: image editing. While the feature is still a bit primitive, it will allow you to embed an image Content item into a richtext field ([EZP-25108](http://jira.ez.no/browse/EZP-25108)).

In addition, several issues with the editor were fixed:

-   The "add content" toolbar will show up independently of the focus mode ([EZP-24829](https://jira.ez.no/browse/EZP-24829), [EZP-25182](https://jira.ez.no/browse/EZP-25182)), will disappear when the editor loses focus ([EZP-25181](https://jira.ez.no/browse/EZP-25181)), and will be rendered correctly in IE11/Edge ([EZP-25189](https://jira.ez.no/browse/EZP-25189))
-   html5edit input with HTML entities is now accepted ([EZP-24732](https://jira.ez.no/browse/EZP-24732))
-   Richtext content can now be published with Firefox ([EZP-25161](https://jira.ez.no/browse/EZP-25161))

## Enhanced PlatformUI performances with the combo loader

The assets used by PlatformUI will now be combined into a couple large files. This drastically reduces the amount of HTTP queries required to load the UI, resulting in a much shorter loading time.

## Universal discovery widget search interface

A search form has been added to the universal discovery widget. Combined with the tree based navigation, this makes locating content in the tree easier than before.

## REST API

The REST API views will now include the total number of search hits.

# Changelog

*Changes* (Stories, Improvements and bug fixes) can be found in our issue tracker:  [48 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=fixVersion+in+%28%222015.12%22%2C+2015.11.1%2C+2015.11.2%29+AND+project+%3D+EZP+AND+issuetype+in+%28Story%2C+Improvement%2C+Bug%29+order+by+issuetype++++&src=confmacro)  *(some are still pending additional documentation changes)*

## Known issues & upcoming features

List of issues specifically affecting this release:  [18 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+in+%28bug%29+AND+affectedVersion+%3D+2015.11+ORDER+BY+priority+++++++&src=confmacro)

General "Known issues" in *Platform stack* compared to* Legacy*:  [7 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+affectedVersion+%3D%22Known+Issues+5.x+Stack%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)

Epics tentatively\* planned for first stable release:  [6 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3DPollux+AND+resolution+%3D+Unresolved+ORDER+BY+priority+&src=confmacro)

Epics tentatively\* planned for first LTS release:  [0 issue](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=project+%3D+EZP+AND+issuetype+%3D+Epic+AND+fixVersion%3D%22Mauna+Kea%22+AND+resolution+%3D+Unresolved+ORDER+BY+priority++&src=confmacro)

*'\* Some of these features will not be in the stable releases, the once we first and foremost will aim for having in the release are those mentioned on the [Roadmap](http://ez.no/Blog/What-to-Expect-from-eZ-Studio-and-eZ-Platform).*

 

## Attachments:

![](images/icons/bullet_blue.gif) [notifications.gif](attachments/31430093/31430069.gif) (image/gif)
![](images/icons/bullet_blue.gif) [Solr\_Logo\_on\_white.png](attachments/31430093/31430070.png) (image/png)
![](images/icons/bullet_blue.gif) [Platform 2015.07 - roles UI.PNG](attachments/31430093/31430071.png) (image/png)
![](images/icons/bullet_blue.gif) [Platform 2015.07 - choose translation.PNG](attachments/31430093/31430072.png) (image/png)
![](images/icons/bullet_blue.gif) [eZ Platform 2015.07 - add translation.gif](attachments/31430093/31430073.gif) (image/gif)
![](images/icons/bullet_blue.gif) [platform-custom-policies.png](attachments/31430093/31430074.png) (image/png)
![](images/icons/bullet_blue.gif) [locations\_tab.png](attachments/31430093/31430075.png) (image/png)
![](images/icons/bullet_blue.gif) [PlatformUI-navigation-bar.png](attachments/31430093/31430076.png) (image/png)
![](images/icons/bullet_blue.gif) [Please Help.jpg](attachments/31430093/31430077.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [privacy cookie.PNG](attachments/31430093/31430078.png) (image/png)
![](images/icons/bullet_blue.gif) [move-copy-send to trash.PNG](attachments/31430093/31430079.png) (image/png)
![](images/icons/bullet_blue.gif) [content\_download.PNG](attachments/31430093/31430080.png) (image/png)
![](images/icons/bullet_blue.gif) [variations purging.PNG](attachments/31430093/31430081.png) (image/png)
![](images/icons/bullet_blue.gif) [content type edition.PNG](attachments/31430093/31430082.png) (image/png)
![](images/icons/bullet_blue.gif) [symfony\_black\_02.png](attachments/31430093/31430083.png) (image/png)
![](images/icons/bullet_blue.gif) [symfony\_black\_03.png](attachments/31430093/31430084.png) (image/png)
![](images/icons/bullet_blue.gif) [RichText editor.png](attachments/31430093/31430085.png) (image/png)
![](images/icons/bullet_blue.gif) [Ventoux-Square.jpg](attachments/31430093/31430086.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Getting-Started-with-eZ-Publish-Platform.jpg](attachments/31430093/31430087.jpg) (image/jpeg)
![](images/icons/bullet_blue.gif) [Platform screenshoot alpha1.gif](attachments/31430093/31430088.gif) (image/gif)
![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 19.16.38 .png](attachments/31430093/31430089.png) (image/png)
![](images/icons/bullet_blue.gif) [PrivacyCookieBundle.png](attachments/31430093/31430090.png) (image/png)
![](images/icons/bullet_blue.gif) [Screen Shot 2015-05-12 at 11.46.48 .png](attachments/31430093/31430091.png) (image/png)
![](images/icons/bullet_blue.gif) [iStock\_000032478246XLarge - banner doc.jpg](attachments/31430093/31430092.jpg) (image/jpeg)






