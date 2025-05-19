---
description: You can report encountered issues to Ibexa DXP JIRA or use it to follow the development of new features and fixes.
---

# Report and follow issues

[[= product_name =]] uses [JIRA](https://issues.ibexa.co) to track product development, improvements, and bugs.

## Finding an existing issue

Before you create a new bug report or an improvement suggestion, search the JIRA project for similar reported issues.
If you find any, update them with your comment or additional information instead of creating a new one.

## Reporting an issue

!!! caution "Security issues"

    If you discover a security issue, please don't report it through regular channels, but instead take a look at the [Security section](reporting_issues.md).

If you have an [[= product_name =]] subscription, report your issues through the [Service portal](https://support.ibexa.co) instead of JIRA.
This ensures the issue can be quickly prioritized according to its impact.

If you cannot find an existing ticket matching what your issue, you can create a new one.
Click **Create** at the top of the bugtracker window and fill in the following fields:

|||
|------|------|
|**Project**|Select **[[= product_name_base =]] IBX**.|
|**Issue type**|Choose **Bug** or **Improvement** depending on what you're reporting, don't use other issue types (they're for internal use only).|
|**Summary**|Write a short sentence describing what you're reporting.|
|**Priority**|Select the priority you consider the issue to be. Please try to keep a cool head while selecting it. A 1 pixel alignment bug isn't a "blocker".|
|**Component/s**|This is important, as it makes your issue appear on the radar (dashboards, filters) of people dealing with various parts of [[= product_name_base =]] projects.|
|**Affect version/s**|Add the versions of the application you experienced the issue on.|
|**Assignee**|Leave blank, unless you're willing to work on the issue yourself.|
|**Reporter**|Leave as is (yourself).|
|**Environment**|Enter specific information regarding your environment that could be relevant in the context of the issues.|
|**Description**|This is the most important part of the issue report. In case of a bug, it **must** contain explicit steps to reproduce your issue. Anybody should be able to reproduce it at first try. In case of an improvement, it needs to contain use cases and detailed information regarding the expected behavior.|
|**Product**|Select which flavor of [[= product_name =]] the issue concerns.|
