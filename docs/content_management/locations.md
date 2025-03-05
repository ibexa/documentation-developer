---
description: Locations hold published content items and can be used to control visibility.
---

# Locations

When a new content item is published, it's automatically placed in a new location.

All locations form a tree which is the basic way of organizing content in the system.
Every published content item has a location and, as a consequence, also a place in this tree.

![Content tree - locations](content_management_tree_locations.png "Content tree - locations")

A content item receives a location only once it has been published.
This means that a new unpublished draft doesn't have a location yet.
You can find drats in the **Drafts** tab in the **Content** menu.

![Drafts](content_management_drafts.png "Drafts")

A content item can have more than one location. It's then present in two or more places in the tree.
For example, an article can be at the same time under "Local news" and "Sports news".
Even in such a case, one of these places is always the main location.

You can change the main location in the back office in the **Locations** tab,
or [through the API](managing_content.md#changing-the-main-location).

![Locations](content_management_locations.png "Locations")

## Top level locations

The content tree is hierarchical. It has an empty root location at the top and a structure of dependent locations below it.
Every location (aside from the root) has one parent location and can have any number of children.

Top level locations are direct children of the root of the tree.
The root has location ID 1, isn't related to any content items and should not be used directly.

Under this root there are preset top level locations in each installation which cannot be deleted.

### Content

The top level location for the actual contents of a site
can be viewed by selecting the **Content structure** tab in the Content mode interface.

![Content structure](content_management_tree.png "Content structure")

This part of the tree is typically used, for example, for organizing folders, articles, or information pages.
The default ID number of this location is 2, but it can be [modified via configuration](repository_configuration.md#top-level-locations).
It contains a Folder content item.

### Media

**Media** is the top level location which stores and organizes information
that is frequently used by content items located below the **Content** node.

![Media](content_management_media.png "Media")

It usually contains images, animations, documents and other files.
The default ID number of the **Media** location is 43, but it can be [modified via configuration](repository_configuration.md#top-level-locations).
It contains a Folder content item.

### Users

**Users** is the top level location that contains the built-in system for managing user accounts.

![Users in Admin panel](admin_panel_users.png "Users in Admin panel")

A user is simply a content item of the user account content type.
The users are organized within user group content items below this location.

In other words, the **Users** location contains the actual users and user groups,
which can be viewed by selecting the **Users** tab in the **Admin** Panel.

The default ID number of the **Users** location is 5.
It contains user group content items.

### Forms [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

**Forms** is the top level location that is intended for Forms created using the [Form Builder]([[= user_doc =]]/content_management/work_with_forms/#create-forms).

![Forms](content_management_forms.png "Forms")

### Other top level locations

You should not add any more content directly below location 1, but instead store any content under one of those top-level locations.

## Location visibility

Location visibility allows you to control which parts of the content tree are available on the front page.

![Location visibility](content_management_visibility.png "Location visibility")

Once a content item is published, it cannot be un-published.
When the location of a content item is hidden, the system doesn't display it on the website.

!!! caution "Visibility and permissions"

    The [visibility switcher](https://doc.ibexa.co/en/latest/content_management/locations/#location-visibility) is a convenient feature for withdrawing content from the frontend.
    It acts as a filter in the frontend by default. You can choose to respect it or ignore it in your code.
    It isn't permission-based, and **doesn't restrict access to content**. Hidden content can be read through other means, like the REST API.

    If you need to restrict access to a given content item, you could create a role that grants read access for a given [**Section**](sections.md) or
    [**Object State**](object_states.md), and set a different section or object state for the given content.
    Or use other permission-based [**Limitations**](limitations.md).

If a content item is hidden, it's invisible in all its locations.
If a location is hidden, all of its descendants in the tree are hidden as well.
This means that there are three different visibility statuses:

- Visible
- Hidden
- Hidden by superior

All locations and content items are visible by default.
If a location is made invisible manually, its status is set to Hidden.
All locations under it change status to Hidden by superior.
A content item is Hidden by superior only in locations in which it has a parent location with the Hidden status.

In the following example, the **Content item 1** is Hidden by superior in the **Location A** while still visible in the **Location B**.

![Visibility in two locations](locations_visibility.png)

From the visitor's perspective a location behaves the same whether its status is Hidden or Hidden by superior – it's unavailable on the front page.

The difference is that a location Hidden by superior cannot be revealed separately from their parent(s).
It only becomes visible once all of its parent locations are made visible again.

A Hidden by superior status doesn't override a Hidden status.
This means that if a location is Hidden manually and later one of its ancestors is hidden as well, the first location's status doesn't change – it remains Hidden (not Hidden by superior).
If the ancestor location is made visible again, the first location still remains hidden.

The way visibility works can be illustrated using the following scenarios:

#### Hiding a visible location

![Hiding a visible location](node_visibility_hide.png)

When you hide a location that was visible before, it gets the status Hidden.
Its child locations are Hidden by superior.
The visibility status of child locations that were already Hidden or Hidden by superior doesn't change.

#### Hiding a location which is Hidden by superior

![Hiding a location which is Hidden by superior](node_visibility_hide_invisible.png)

When you explicitly hide a location which was Hidden by superior, it gets the status Hidden.
Since the underlying locations are already either Hidden or Hidden by superior, their visibility status doesn't changed.

#### Revealing a location with a visible ancestor

![Revealing a location with a visible ancestor](node_visibility_unhide1.png)

When you reveal a location which has a visible ancestor, this location and its children become visible.
However, child locations that were explicitly hidden by a user keep their Hidden status
(and their children remain Hidden by superior).

#### Revealing a location with a Hidden ancestor

![Revealing a location with a Hidden ancestor](node_visibility_unhide2.png)

When you reveal a location that has a Hidden ancestor, it **doesn't** become Visible itself.
Because it still has invisible ancestors, its status changes to Hidden by superior.

!!! tip "In short"

    A location can only be Visible when all of its ancestors are Visible as well.

### Visibility mechanics

The visibility mechanics are controlled by two flags: Hidden flag and Invisible flag.
The Hidden flag informs whether the node has been hidden by a user or not.
A raised Invisible flag means that the node is invisible either because it was hidden by a user or by the system.
Together, the flags represent the three visibility statuses:

|Hidden flag|Invisible flag|Status|
|------|------|------|
|-|-|The location is visible.|
|1|1|The location is invisible and it was hidden by a user (Hidden).|
|-|1|The location is invisible and it was hidden by the system because its ancestor is hidden/invisible (Hidden by superior).|

!!! note

    Displaying visible or hidden locations in governed by the [`Visibility` Search Criterion](visibility_criterion.md)
