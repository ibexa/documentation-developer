---
description: Locations hold published content items and can be used to control visibility.
---

# Locations

When a new content item is published, it's automatically placed in a new Location.

All Locations form a tree which is the basic way of organizing content in the system.
Every published content item has a Location and, as a consequence, also a place in this tree.

![Content tree - locations](content_management_tree_locations.png "Content tree - locations")

A content item receives a Location only once it has been published.
This means that a new unpublished draft doesn't have a Location yet.
You can find drats in the **Drafts** tab in the **Content** menu.

![Drafts](content_management_drafts.png "Drafts")

A content item can have more than one Location. It's then present in two or more places in the tree.
For example, an article can be at the same time under "Local news" and "Sports news".
Even in such a case, one of these places is always the main Location.

You can change the main Location in the back office in the **Locations** tab,
or [through the API](managing_content.md#changing-the-main-location).

![Locations](content_management_locations.png "Locations")

## Top level Locations

The content tree is hierarchical. It has an empty root Location at the top and a structure of dependent Locations below it.
Every Location (aside from the root) has one parent Location and can have any number of children.

Top level Locations are direct children of the root of the tree.
The root has Location ID 1, isn't related to any content items and should not be used directly.

Under this root there are preset top level Locations in each installation which cannot be deleted.

### Content

The top level Location for the actual contents of a site
can be viewed by selecting the **Content structure** tab in the Content mode interface.

![Content structure](content_management_tree.png "Content structure")

This part of the tree is typically used for organizing folders, articles, information pages, etc.
The default ID number of this Location is 2, but it can be [modified via configuration](repository_configuration.md#top-level-locations).
It contains a Folder content item.

### Media

**Media** is the top level Location which stores and organizes information
that is frequently used by content items located below the **Content** node.

![Media](content_management_media.png "Media")

It usually contains images, animations, documents and other files.
The default ID number of the **Media** Location is 43, but it can be [modified via configuration](repository_configuration.md#top-level-locations).
It contains a Folder content item.

### Users

**Users** is the top level Location that contains the built-in system for managing user accounts.

![Users in Admin panel](admin_panel_users.png "Users in Admin panel")

A user is simply a content item of the user account content type.
The users are organized within user group content items below this Location.

In other words, the **Users** Location contains the actual users and user groups,
which can be viewed by selecting the **Users** tab in the **Admin** Panel.

The default ID number of the **Users** Location is 5.
It contains user group content items.

### Forms [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

**Forms** is the top level Location that is intended for Forms created using the [Form Builder](https://doc.ibexa.co/projects/userguide/en/latest/content_management/work_with_forms/#create-forms).

![Forms](content_management_forms.png "Forms")

### Other top level Locations

You should not add any more content directly below Location 1, but instead store any content under one of those top-level Locations.

## Location visibility

Location visibility allows you to control which parts of the content tree are available on the front page.

![Location visibility](content_management_visibility.png "Location visibility")

Once a content item is published, it cannot be un-published.
When the Location of a content item is hidden, the system doesn't display it on the website.

!!! caution "Visibility and permissions"

    The [visibility switcher](https://doc.ibexa.co/en/latest/content_management/locations/#location-visibility) is a convenient feature for withdrawing content from the frontend.
    It acts as a filter in the frontend by default. You can choose to respect it or ignore it in your code.
    it'sn't permission-based, and **doesn't restrict access to content**. Hidden content can be read through other means, like the REST API.

    If you need to restrict access to a given content item, you could create a role that grants read access for a given [**Section**](sections.md) or
    [**Object State**](object_states.md), and set a different Section or Object State for the given Content.
    Or use other permission-based [**Limitations**](limitations.md).

If a content item is hidden, it's invisible in all its Locations.
If a Location is hidden, all of its descendants in the tree are hidden as well.
This means that there are three different visibility statuses:

- Visible
- Hidden
- Hidden by superior

All Locations and content items are visible by default.
If a Location is made invisible manually, its status is set to Hidden.
All Locations under it change status to Hidden by superior.
A content item is Hidden by superior only in Locations in which it has a parent Location with the Hidden status.

In the following example, the **Content item 1** is Hidden by superior in the **Location A** while still visible in the **Location B**.

![Visibility in two locations](locations_visibility.png)

From the visitor's perspective a Location behaves the same whether its status is Hidden or Hidden by superior –
it's unavailable on the front page.

The difference is that a Location Hidden by superior cannot be revealed separately from their parent(s).
It only becomes visible once all of its parent Locations are made visible again.

A Hidden by superior status doesn't override a Hidden status.
This means that if a Location is Hidden manually and later one of its ancestors is hidden as well,
the first Location's status doesn't change – it remains Hidden (not Hidden by superior).
If the ancestor Location is made visible again, the first Location still remains hidden.

The way visibility works can be illustrated using the following scenarios:

#### Hiding a visible Location

![Hiding a visible Location](node_visibility_hide.png)

When you hide a Location that was visible before, it gets the status Hidden.
Its child Locations are Hidden by superior.
The visibility status of child Locations that were already Hidden or Hidden by superior doesn't change.

#### Hiding a Location which is Hidden by superior

![Hiding a Location which is Hidden by superior](node_visibility_hide_invisible.png)

When you explicitly hide a Location which was Hidden by superior, it gets the status Hidden.
Since the underlying Locations are already either Hidden or Hidden by superior, their visibility status doesn't changed.

#### Revealing a Location with a visible ancestor

![Revealing a Location with a visible ancestor](node_visibility_unhide1.png)

When you reveal a Location which has a visible ancestor, this Location and its children become visible.
However, child Locations that were explicitly hidden by a user keep their Hidden status
(and their children remain Hidden by superior).

#### Revealing a Location with a Hidden ancestor

![Revealing a Location with a Hidden ancestor](node_visibility_unhide2.png)

When you reveal a Location that has a Hidden ancestor, it **doesn't** become Visible itself.
Because it still has invisible ancestors, its status changes to Hidden by superior.

!!! tip "In short"

    A Location can only be Visible when all of its ancestors are Visible as well.

### Visibility mechanics

The visibility mechanics are controlled by two flags: Hidden flag and Invisible flag.
The Hidden flag informs whether the node has been hidden by a user or not.
A raised Invisible flag means that the node is invisible either because it was hidden by a user or by the system.
Together, the flags represent the three visibility statuses:

|Hidden flag|Invisible flag|Status|
|------|------|------|
|-|-|The Location is visible.|
|1|1|The Location is invisible and it was hidden by a user (Hidden).|
|-|1|The Location is invisible and it was hidden by the system because its ancestor is hidden/invisible (Hidden by superior).|

!!! note

    Displaying visible or hidden Locations in governed by the [`Visibility` Search Criterion](visibility_criterion.md)
