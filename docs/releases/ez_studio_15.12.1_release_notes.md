1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Releases](Releases_31429534.html)
4.  [Release Notes](Release-Notes_32867905.html)
5.  [eZ Enterprise Release notes](eZ-Enterprise-Release-notes_31430108.html)
6.  [eZ Studio 15.12 Release notes](eZ-Studio-15.12-Release-notes_31430118.html)

# eZ Studio 15.12.1 Release notes 

Created by Dominika Kurek on Apr 18, 2016

#### Table of contents:

-   [Changes since 15.12](#eZStudio15.12.1Releasenotes-Changessince15.12)
    -   [Summary of changes](#eZStudio15.12.1Releasenotes-Summaryofchanges)
    -   [Full list of improvements](#eZStudio15.12.1Releasenotes-Fulllistofimprovements)
    -   [Full list of bugfixes](#eZStudio15.12.1Releasenotes-Fulllistofbugfixes)
-   [Upgrading a 15.12 Studio project](#eZStudio15.12.1Releasenotes-Upgradinga15.12Studioproject)

 

The first sub-release of [eZ Studio 15.12](eZ-Studio-15.12-Release-notes_31430118.html) is available as of February 2nd.

For the release notes of the corresponding *(and included)* eZ Platform sub-release, see [eZ Platform 15.12.1 Release Notes](eZ-Platform-15.12.1-Release-Notes_31430110.html).

 

## Changes since 15.12

### Summary of changes

-   Enhanced Landing Page drag-and-drop interactions, including a better visualization of dropping blocks onto the page:

![Dropping a block onto a Landing Page](attachments/31430124/31430123.png)

 

-   Timeline toolbar now covers all changes in all Schedule Blocks on a given Landing Page.
-   Timeline toolbar is now also available in View mode on Landing Pages:

![Landing Page in View mode with a Timeline](attachments/31430124/31430122.png)

 

-   Added an Approval Timeline which lists all review requests for a given Content item:

![Approval timeline screen](attachments/31430124/31430120.png)

-   Modified template of the notification email sent to reviewers from Flex Workflow.
-   Minor UI improvements (including: updated icons, labels, date picker and others):

![Datepicker](attachments/31430124/31430121.png)

 

-   Added notification when copying a URL.
-   Numerous bug fixes.

 

### Full list of improvements

 

|                                                              |                                                                                                                                                                             |                                                                                                                                   |
|--------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------|
| Key                                                          | Summary                                                                                                                                                                     | T                                                                                                                                 |
| [EZEE-509](https://jira.ez.no/browse/EZEE-509?src=confmacro) | [Get information about content workflow status and messages history from backend](https://jira.ez.no/browse/EZEE-509?src=confmacro)                                         | [![Feature](https://jira.ez.no/images/icons/issuetypes/newfeature.png)](https://jira.ez.no/browse/EZEE-509?src=confmacro)         |
| [EZEE-508](https://jira.ez.no/browse/EZEE-508?src=confmacro) | [Schedule block: when removing content from the future the content is not moved to the history](https://jira.ez.no/browse/EZEE-508?src=confmacro)                           | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-508?src=confmacro)                    |
| [EZEE-506](https://jira.ez.no/browse/EZEE-506?src=confmacro) | [As a user, I want to see approval timeline in content editor mode](https://jira.ez.no/browse/EZEE-506?src=confmacro)                                                       | [![Story](https://jira.ez.no/images/icons/issuetypes/story.png)](https://jira.ez.no/browse/EZEE-506?src=confmacro)                |
| [EZEE-500](https://jira.ez.no/browse/EZEE-500?src=confmacro) | [The timeline should display all future changes from all the schedule blocks at once](https://jira.ez.no/browse/EZEE-500?src=confmacro)                                     | [![Sub-task](https://jira.ez.no/images/icons/issuetypes/subtask_alternate.png)](https://jira.ez.no/browse/EZEE-500?src=confmacro) |
| [EZEE-499](https://jira.ez.no/browse/EZEE-499?src=confmacro) | [Add the timeline to the Page view](https://jira.ez.no/browse/EZEE-499?src=confmacro)                                                                                       | [![Sub-task](https://jira.ez.no/images/icons/issuetypes/subtask_alternate.png)](https://jira.ez.no/browse/EZEE-499?src=confmacro) |
| [EZEE-498](https://jira.ez.no/browse/EZEE-498?src=confmacro) | [Show a dashed frame when dragging over valid target area](https://jira.ez.no/browse/EZEE-498?src=confmacro)                                                                | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-498?src=confmacro)    |
| [EZEE-497](https://jira.ez.no/browse/EZEE-497?src=confmacro) | [Change Schedule block's Delete label](https://jira.ez.no/browse/EZEE-497?src=confmacro)                                                                                    | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-497?src=confmacro)    |
| [EZEE-496](https://jira.ez.no/browse/EZEE-496?src=confmacro) | [Change Schedule block's Settings label](https://jira.ez.no/browse/EZEE-496?src=confmacro)                                                                                  | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-496?src=confmacro)    |
| [EZEE-494](https://jira.ez.no/browse/EZEE-494?src=confmacro) | [Datepicker add animation and CSS changes](https://jira.ez.no/browse/EZEE-494?src=confmacro)                                                                                | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-494?src=confmacro)    |
| [EZEE-493](https://jira.ez.no/browse/EZEE-493?src=confmacro) | [When clicking on Copy URL user gets a notification that confirms the action done](https://jira.ez.no/browse/EZEE-493?src=confmacro)                                        | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-493?src=confmacro)    |
| [EZEE-487](https://jira.ez.no/browse/EZEE-487?src=confmacro) | [Draggable interaction - show dashed frame in place of selected element](https://jira.ez.no/browse/EZEE-487?src=confmacro)                                                  | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-487?src=confmacro)    |
| [EZEE-486](https://jira.ez.no/browse/EZEE-486?src=confmacro) | [Refine dragging interaction with elements](https://jira.ez.no/browse/EZEE-486?src=confmacro)                                                                               | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-486?src=confmacro)    |
| [EZEE-485](https://jira.ez.no/browse/EZEE-485?src=confmacro) | [Change cursor to show that an element is draggable](https://jira.ez.no/browse/EZEE-485?src=confmacro)                                                                      | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-485?src=confmacro)    |
| [EZEE-451](https://jira.ez.no/browse/EZEE-451?src=confmacro) | [When switching from Page to Content I'm not redirected to a correct page in PlatformUI](https://jira.ez.no/browse/EZEE-451?src=confmacro)                                  | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-451?src=confmacro)                    |
| [EZEE-450](https://jira.ez.no/browse/EZEE-450?src=confmacro) | [Replace Slot Icon and label](https://jira.ez.no/browse/EZEE-450?src=confmacro)                                                                                             | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-450?src=confmacro)    |
| [EZEE-449](https://jira.ez.no/browse/EZEE-449?src=confmacro) | [Change the page title](https://jira.ez.no/browse/EZEE-449?src=confmacro)                                                                                                   | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-449?src=confmacro)    |
| [EZEE-412](https://jira.ez.no/browse/EZEE-412?src=confmacro) | [Update Flex Workflow email template](https://jira.ez.no/browse/EZEE-412?src=confmacro)                                                                                     | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-412?src=confmacro)    |
| [EZEE-402](https://jira.ez.no/browse/EZEE-402?src=confmacro) | [Dynamic Landing page, define width & height for resizable Page Description input box](https://jira.ez.no/browse/EZEE-402?src=confmacro)                                    | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-402?src=confmacro)    |
| [EZEE-392](https://jira.ez.no/browse/EZEE-392?src=confmacro) | [Moving blocks on landing pages is tricky](https://jira.ez.no/browse/EZEE-392?src=confmacro)                                                                                | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-392?src=confmacro)                    |
| [EZEE-373](https://jira.ez.no/browse/EZEE-373?src=confmacro) | [As a User, I want to be able to access the Scheduled Block toolbar at all times](https://jira.ez.no/browse/EZEE-373?src=confmacro)                                         | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-373?src=confmacro)    |
| [EZEE-326](https://jira.ez.no/browse/EZEE-326?src=confmacro) | [As an editor I would like to see the now time indicator in the timeline when scheduling content inside a schedule block](https://jira.ez.no/browse/EZEE-326?src=confmacro) | [![Story](https://jira.ez.no/images/icons/issuetypes/story.png)](https://jira.ez.no/browse/EZEE-326?src=confmacro)                |
| [EZEE-185](https://jira.ez.no/browse/EZEE-185?src=confmacro) | [As an editor I would like to see overflow block select field hidden when overflow is turned off](https://jira.ez.no/browse/EZEE-185?src=confmacro)                         | [![Improvement](https://jira.ez.no/images/icons/issuetypes/improvement.png)](https://jira.ez.no/browse/EZEE-185?src=confmacro)    |

 [22 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=key+%3D+EZS-373+OR+key+%3D+EZS-392+OR+key+%3D+EZS-326+OR+key+%3D+EZS-402+OR+key+%3D+EZS-185+OR+key+%3D+EZS-451+OR+key+%3D+EZS-485+OR+key+%3D+EZS-450+OR+key+%3D+EZS-449+OR+key+%3D+EZS-486+OR+key+%3D+EZS-487+OR+key+%3D+EZS-499+OR+key+%3D+EZS-500+OR+key+%3D+EZS-494+OR+key+%3D+EZS-496+OR+key+%3D+EZS-497+OR+key+%3D+EZS-498+OR+key+%3D+EZS-493+OR+key+%3D+EZS-508+OR+key+%3D+EZS-412+OR+key+%3D+EZS-509+OR+key+%3D+EZS-506++++&src=confmacro "View all matching issues in JIRA.")

 

### Full list of bugfixes

 

|                                                                |                                                                                                                                                           |                                                                                                                 |
|----------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------|
| Key                                                            | Summary                                                                                                                                                   | T                                                                                                               |
| [EZP-25291](https://jira.ez.no/browse/EZP-25291?src=confmacro) | [No \`languageCode\` is set when creating a new content after canceling previous new content creation](https://jira.ez.no/browse/EZP-25291?src=confmacro) | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZP-25291?src=confmacro) |
| [EZEE-521](https://jira.ez.no/browse/EZEE-521?src=confmacro)   | [The preview height is incorrect](https://jira.ez.no/browse/EZEE-521?src=confmacro)                                                                       | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-521?src=confmacro)  |
| [EZEE-518](https://jira.ez.no/browse/EZEE-518?src=confmacro)   | [On Publish action page is reloaded twice](https://jira.ez.no/browse/EZEE-518?src=confmacro)                                                              | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-518?src=confmacro)  |
| [EZEE-505](https://jira.ez.no/browse/EZEE-505?src=confmacro)   | [When navigating in the Page mode the URL in the browser address bar is not updating](https://jira.ez.no/browse/EZEE-505?src=confmacro)                   | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-505?src=confmacro)  |
| [EZEE-490](https://jira.ez.no/browse/EZEE-490?src=confmacro)   | [Getting error when opening landing page editor](https://jira.ez.no/browse/EZEE-490?src=confmacro)                                                        | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-490?src=confmacro)  |
| [EZEE-475](https://jira.ez.no/browse/EZEE-475?src=confmacro)   | [ContentTypes to be displayed change is not stored after publish](https://jira.ez.no/browse/EZEE-475?src=confmacro)                                       | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-475?src=confmacro)  |
| [EZEE-459](https://jira.ez.no/browse/EZEE-459?src=confmacro)   | [Block not found exception on publish after adding extra block](https://jira.ez.no/browse/EZEE-459?src=confmacro)                                         | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-459?src=confmacro)  |
| [EZEE-458](https://jira.ez.no/browse/EZEE-458?src=confmacro)   | ["button.removeTarget is not a function" error on logout](https://jira.ez.no/browse/EZEE-458?src=confmacro)                                               | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-458?src=confmacro)  |
| [EZEE-444](https://jira.ez.no/browse/EZEE-444?src=confmacro)   | [Blocks are not rendered in the correct order when opening a landing page in the editor](https://jira.ez.no/browse/EZEE-444?src=confmacro)                | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-444?src=confmacro)  |
| [EZEE-442](https://jira.ez.no/browse/EZEE-442?src=confmacro)   | [\[IE11\] The filled slots number is displayed incorrectly](https://jira.ez.no/browse/EZEE-442?src=confmacro)                                             | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-442?src=confmacro)  |
| [EZEE-441](https://jira.ez.no/browse/EZEE-441?src=confmacro)   | [Scroll in editing Landing Page on IE don't work, on FF works slowly](https://jira.ez.no/browse/EZEE-441?src=confmacro)                                   | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-441?src=confmacro)  |
| [EZEE-411](https://jira.ez.no/browse/EZEE-411?src=confmacro)   | [Flex workflow not working when receiving notification](https://jira.ez.no/browse/EZEE-411?src=confmacro)                                                 | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-411?src=confmacro)  |
| [EZEE-406](https://jira.ez.no/browse/EZEE-406?src=confmacro)   | [Landing Page editing is blocked when page does not have any blocks (empty zones)](https://jira.ez.no/browse/EZEE-406?src=confmacro)                      | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-406?src=confmacro)  |
| [EZEE-403](https://jira.ez.no/browse/EZEE-403?src=confmacro)   | [Embed block preview layout position](https://jira.ez.no/browse/EZEE-403?src=confmacro)                                                                   | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-403?src=confmacro)  |
| [EZEE-398](https://jira.ez.no/browse/EZEE-398?src=confmacro)   | [\[IE\] Schedule block Timeline colour rendering is broken](https://jira.ez.no/browse/EZEE-398?src=confmacro)                                             | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-398?src=confmacro)  |
| [EZEE-397](https://jira.ez.no/browse/EZEE-397?src=confmacro)   | [\[IE\] Content List & Keyword block empty field validation always fails](https://jira.ez.no/browse/EZEE-397?src=confmacro)                               | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-397?src=confmacro)  |
| [EZEE-396](https://jira.ez.no/browse/EZEE-396?src=confmacro)   | [\[IE\] Landing Page zones layout is broken](https://jira.ez.no/browse/EZEE-396?src=confmacro)                                                            | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-396?src=confmacro)  |
| [EZEE-394](https://jira.ez.no/browse/EZEE-394?src=confmacro)   | [\[IE\] Basics section layout is broken](https://jira.ez.no/browse/EZEE-394?src=confmacro)                                                                | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-394?src=confmacro)  |
| [EZEE-393](https://jira.ez.no/browse/EZEE-393?src=confmacro)   | [I can't select the block that I just added to my page](https://jira.ez.no/browse/EZEE-393?src=confmacro)                                                 | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-393?src=confmacro)  |
| [EZEE-391](https://jira.ez.no/browse/EZEE-391?src=confmacro)   | [Adding a gallery block to a new landing page breaks the layout view](https://jira.ez.no/browse/EZEE-391?src=confmacro)                                   | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-391?src=confmacro)  |
| [EZEE-312](https://jira.ez.no/browse/EZEE-312?src=confmacro)   | [Cogwheel stuck when creating "Landing Page"](https://jira.ez.no/browse/EZEE-312?src=confmacro)                                                           | [![Bug](https://jira.ez.no/images/icons/issuetypes/bug.png)](https://jira.ez.no/browse/EZEE-312?src=confmacro)  |

 [21 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=key+%3D+EZS-312+OR+key+%3D+EZS-391+OR+key+%3D+EZS-393+OR+key+%3D+EZS-393+OR+key+%3D+EZS-406+OR+key+%3D+EZS-394+OR+key+%3D+EZS-398+OR+key+%3D+EZP-25291+OR+key+%3D+EZS-397+OR+key+%3D+EZS-396+OR+key+%3D+EZS-441+OR+key+%3D+EZS-442+OR+key+%3D+EZS-444+OR+key+%3D+EZS-403+OR+key+%3D+EZS-458+OR+key+%3D+EZS-459+OR+key+%3D+EZS-475+OR+key+%3D+EZS-490+OR+key+%3D+EZS-505+OR+key+%3D+EZS-518+OR+key+%3D+EZS-521+OR+key+%3D+EZS-411++&src=confmacro "View all matching issues in JIRA.")

 

 

## Upgrading a 15.12 Studio project

You can easily upgrade your existing Studio project in version 15.12 (1.0) using Composer.

Start from the project root. First, create a new branch from:

a) your master project branch, or 

b) the branch you are upgrading on:

**From your master branch**

``` brush:
git checkout -b upgrade-1.1.0
```

In case of different localization of the sources, add `ezsystems/ezstudio` as an upstream remote:

**From the upgrade-1.1.0 branch**

``` brush:
git remote add ezstudio http://github.com/ezsystems/ezstudio.git
```

Then pull the tag into your branch:

**From the upgrade-1.1.0 branch**

``` brush:
git pull ezstudio v1.1.0
```

You will get conflicts, and it is perfectly normal. The most common ones will be on `composer.json` and `composer.lock`.

If you get a **lot** of conflicts (on the `doc` folder for instance), and eZ Platform was installed from the [share.ez.no](http://share.ez.no) tarball, it might be because of incomplete history. You will have to run `git fetch ezstudio --unshallow` to load the full history, and run the merge again.

The latter can be ignored, as it will be regenerated when we execute composer update later. The easiest way is to checkout the version from the tag, and add it to the changes:

**From the upgrade-1.1.0 branch**

``` brush:
git checkout --theirs composer.lock && git add composer.lock
```

#### Merging composer.json

##### Manual merging

Conflicts in `composer.json` need to be fixed manually. If you're not familiar with the diff output, you may checkout the tag's version, and inspect the changes. It should be readable for most:

**From the upgrade-1.1.0 branch**

``` brush:
git checkout --theirs composer.json && git diff composer.json
```

You should see what was changed, as compared to your own version, in the diff output. The 1.1.0 tag changes the requirements for all of the `ezsystems/` packages. Those should be left untouched. All of the other changes should be removals of your project's additions. You can use `git checkout -p` to selectively cancel those changes:

``` brush:
git checkout -p composer.json
```

Answer `no` (do not discard) to the requirement changes of `ezsystems` dependencies, and `yes` (discard) to removals of your changes.

##### Using composer require

You may also checkout your own composer.json, and run the following commands to update the `ezsystems` packages requirements from v1.0.x to v1.1.0:

``` brush:
git checkout --ours composer.json
composer require --no-update "ezsystems/ezpublish-kernel:~6.1.0"
composer require --no-update "ezsystems/platform-ui-bundle:~1.1.0"
composer require --no-update "ezsystems/studio-ui-bundle:~1.1.0"
composer require --no-update "ezsystems/ezstudio-demo-bundle:~1.1.0"
composer require --no-update "ezsystems/landing-page-fieldtype-bundle:~1.1.0"
composer require --no-update "ezsystems/flex-workflow:~1.1.0"
composer require --dev --no-update "ezsystems/behatbundle:~6.1.0"

# PHP requirement is now 5.5+, and 7.0 is now supported for dev use (see top of this page for requirements link)
composer require --no-update "php:~5.5|~7.0"

# As there are some bugs with Symfony 2.8, make sure to pull in Symfony 2.7 LTS updates
composer require --no-update "symfony/symfony:~2.7.0" 
 
# This command will remove platform.php: "5.4.4" as php 5.4 is no longer supported
composer config --unset platform.php
```

#### Fixing other conflicts (if any)

Depending on the local changes you have done, you may get other conflicts: configuration files, kernel... 

There shouldn't be many, and you should be able to figure out which value is the right one for all of them:

-   Edit the file, and identify the conflicting changes. If a setting you have modified has also been changed by us, you should be able to figure out which value is the right one.
-   Run `git add conflicting-file` to add the changes

#### Updating composer.lock

At this point, you should have a composer.json file with the correct requirements. Run `composer update` to update the dependencies. 

``` brush:
composer update --with-dependencies ezsystems/ezpublish-kernel ezsystems/platform-ui-bundle ezsystems/repository-forms ezsystems/studio-ui-bundle ezsystems/ezstudio-demo-bundle ezsystems/landing-page-fieldtype-bundle ezsystems/flex-workflow
```

In order to restrict the possibility of unforeseen updates of 3rd party packages, we recommend by default that `composer update` is restricted to the list of packages we have tested the update for. You may remove this restriction, but be aware that you might get a package combination we have not tested.

On PHP conflict

Because from this release onwards eZ Platform is compatible only with PHP 5.5 and higher, the update command above will fail if you use an older PHP version. Please update PHP to proceed.

#### Commit, test and merge

Once all the conflicts have been resolved, and `composer.lock` updated, the merge can be committed. Note that you may or may not keep `composer.lock`, depending on your version management workflow. If you do not wish to keep it, run `git reset HEAD <file>` to remove it from the changes. Run `git commit`, and adapt the message if necessary. You can now test the project, run integration tests... once the upgrade has been approved, go back to `master`, and merge the `upgrade-1.1.0` branch:

``` brush:
git checkout master
git merge upgrade-1.1.0
```

 

 

## Attachments:

![](images/icons/bullet_blue.gif) [approval\_timeline.png](attachments/31430124/31430120.png) (image/png)
![](images/icons/bullet_blue.gif) [new\_datepicker.png](attachments/31430124/31430121.png) (image/png)
![](images/icons/bullet_blue.gif) [LP\_in\_view\_mode.png](attachments/31430124/31430122.png) (image/png)
![](images/icons/bullet_blue.gif) [LP\_drag\_and\_drop\_improved.png](attachments/31430124/31430123.png) (image/png)






