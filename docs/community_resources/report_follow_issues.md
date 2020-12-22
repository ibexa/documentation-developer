# Report and follow issues

The development of Ibexa projects is organized using a bugtracker. It can be found here: <https://issues.ibexa.co/>. Its role is to centralize references to all improvements, bug fixes and documentation being added to Ibexa projects.

The first thing you should do in order to be able to get involved and have feedback on what is happening on Ibexa projects is to create a JIRA account.

**Note:** The term "issue" is used to refer to a bugtracker item regardless of its type (bug, improvement, story, etc.)

!!! caution "Security issues"

    If you discover a security issue, please do not report it using regular channels, but instead take a look at [Security section](../guide/reporting_issues.md).

## How to find an existing issue

When you have a great idea or if you have found a bug, you may want to create a new issue to let everyone know about it. Before doing that, you should make sure no one has made a similar report before.

In order to do that, you should use the search page available in the top menu (under **Issues/Search for issues**) or the search box in the top right corner. Using filters and keywords you should be able to search and maybe find an issue to update instead of creating a new one.

## How to improve existing issues

Existing issues need to be monitored, sorted and updated in order to be processed in the best way possible.

In case of bugs, trying to reproduce them, in order to confirm that they are (still) valid, is a great help for developers who will later troubleshoot and fix them. By doing that you can also provide extra information, if needed, such as:

- Extra steps to reproduce
- Context/environment-specific information
- Links to duplicate or related issues

In case of improvements, you can add extra use cases and spot behaviors that might be tricky or misleading.

## How to follow an issue

Every issue has a "Start watching this issue" link. It lets you receive notifications each time the issue is updated.

This way you can get and provide feedback during the issue's life. You are also informed about ongoing development regarding the issue and can try out patches before they are integrated into the product.

## How to report an issue

!!! note "Issues in [[= product_name_exp =]] [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]"

    If you have an Enterprise subscription, report your issues through the [support portal](https://support.ez.no)
    instead of JIRA. This ensures the issue can be quickly prioritized according to its impact.

If you cannot find an issue matching what you are about to report using the search page, you can create a new one.
Click **Create** at the top of the bugtracker window and fill in the form:

|||
|------|------|
|**Project**|Select **eZ Publish/Platform** if your issue affects platform as a standalone project, or **eZ Platform Enterprise Edition** if it is needed in order to reproduce the issue.|
|**Issue type**|Choose **Bug** or **Improvement** depending on what you are reporting, do not use other issue types (they are for internal use only).|
|**Summary**|Write a short sentence describing what you are reporting.|
|**Security level**|Select security if you are reporting a security issue. It will make your issue visible only to you and the core dev team until it is fixed and distributed.|
|**Priority**|Select the priority you consider the issue to be. Please try to keep a cool head while selecting it. A 1 pixel alignment bug is not a "blocker".|
|**Component/s**|This is important, as it will make your issue appear on the radar (dashboards, filters) of people dealing with various parts of Ibexa projects.|
|**Affect version/s**|Add the versions of the application you experienced the issue on.|
|**Fix version/s**|Leave blank.|
|**Assignee**|Leave blank, unless you are willing to work on the issue yourself.|
|**Reporter**|Leave as is (yourself).|
|**Environment**|Enter specific information regarding your environment that could be relevant in the context of the issues.|
|**Description**|This is the most important part of the issue report. In case of a bug, it **must** contain explicit steps to reproduce your issue. Anybody should be able to reproduce it at first try. In case of an improvement, it needs to contain use cases and detailed information regarding the expected behavior.|
|**Labels**|Leave blank.|
|**Epic Link**|Leave blank.|
|**Sprint**|Leave blank.|
