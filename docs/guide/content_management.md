# Content management

## Locations

When a new Content item is published, it is automatically placed in a new Location.

All Locations form a tree which is the basic way of organizing content in the system.
Every published Content item has a Location and, as a consequence, also a place in this tree.

![Content Tree](img/content_management_tree.png "Content Tree")

A Content item receives a Location only once it has been published.
This means that a new unpublished draft does not have a Location yet.
Drafts cannot be found in the Content browser. You can find them on the **My dashboard** page, 
or in your user menu under **Drafts**.

![Drafts](img/content_management_drafts.png "Drafts")

A Content item can have more than one Location. It is then present in two or more places in the tree.
For example, an article can be at the same time under "Local news" and "Sports news".
Even in such a case, one of these places is always the main Location.

You can change the main Location in the Back Office in the Locations tab,
or [through the API](../api/public_php_api_managing_content.md#changing-the-main-location).

![Locations](img/content_management_locations.png "Locations")

### Top level Locations

The content tree is hierarchical. It has an empty root Location at the top and a structure of dependent Locations below it.
Every Location (aside from the root) has one parent Location and can have any number of children.

Top level Locations are direct children of the root of the tree.
The root has Location ID 1, is not related to any Content items and should not be used directly.

Under this root there are preset top level Locations in each installation which cannot be deleted:

![Content and Media top Locations](img/content_structure_media_library.png)

#### Content

The top level Location for the actual contents of a site
can be viewed by selecting the **Content structure** tab in the Content mode interface.

![Content structure](img/content_management_tree.png "Content structure")

This part of the tree is typically used for organizing folders, articles, information pages, etc.
The default ID number of this Location is 2, but it can be [modified via configuration](config_repository.md#top-level-locations).
It contains a Folder Content item.

#### Media

**Media** is the top level Location which stores and organizes information
that is frequently used by Content items located below the **Content** node.

![Media](img/content_management_media.png "Media")

It usually contains images, animations, documents and other files.
The default ID number of the **Media** Location is 43, but it can be [modified via configuration](config_repository.md#top-level-locations).
It contains a Folder Content item.

#### Users

**Users** is the top level Location that contains the built-in system for managing User accounts.

![Users in admin panel](img/admin_panel_users.png "Users in admin panel")

A User is simply a Content item of the User account Content Type.
The Users are organized within User Group Content items below this Location.

In other words, the **Users** Location contains the actual Users and User Groups,
which can be viewed by selecting the **Users** tab in the Admin Panel.
The default ID number of the **Users** Location is 5, but it can be [modified via configuration](config_repository.md#top-level-locations).
It contains a User Group Content item.

#### Forms [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

**Forms** is the top level Location that is intended for Forms created using the [Form Builder](https://doc.ezplatform.com/projects/userguide/en/master/creating_content_advanced/#forms).

![Forms](img/content_management_forms.png "Forms")

#### Other top level Locations

You should not add any more content directly below Location 1, but instead store any content under one of those top-level Locations.

### Location visibility

Location visibility allows you to control which parts of the content tree are available on the front page.

![Location visibility](img/content_management_visibility.png "Location visibility")

Once a Content item is published, it cannot be un-published.
Limiting visibility is the only way to withdraw content from the website without moving it to Trash.
When the Location of a Content item is hidden, any access to it will be denied, preventing the system from displaying it.

If a Content item is hidden, it is invisible in all its Locations.
If a Location is hidden, all of its descendants in the tree will be hidden as well.
This means that there are three different visibility statuses:

- Visible
- Hidden
- Hidden by superior

All Locations and Content items are visible by default.
If a Location is made invisible manually, its status is set to Hidden.
All Locations under it will change status to Hidden by superior.
A Content item is Hidden by superior only in Locations in which it has a parent Location with the Hidden status.

In the following example, the **Content item 1** is Hidden by superior in the **Location A** while still visible in the **Location B**.

![Visibility in two locations](img/locations_visibility.png)

From the visitor's perspective a Location behaves the same whether its status is Hidden or Hidden by superior –
it will be unavailable on the front page.

The difference is that a Location Hidden by superior cannot be revealed separately from their parent(s).
It will only become visible once all of its parent Locations are made visible again.

A Hidden by superior status does not override a Hidden status.
This means that if a Location is Hidden manually and later one of its ancestors is hidden as well,
the first Location's status does not change – it remains Hidden (not Hidden by superior).
If the ancestor Location is made visible again, the first Location still remains hidden.

The way visibility works can be illustrated using the following scenarios:

##### Hiding a visible Location

![Hiding a visible Location](img/node_visibility_hide.png)

When you hide a Location that was visible before, it will get the status Hidden.
Its child Locations will be Hidden by superior.
The visibility status of child Locations that were already Hidden or Hidden by superior will not change.

##### Hiding a Location which is Hidden by superior

![Hiding a Location which is Hidden by superior](img/node_visibility_hide_invisible.png)

When you explicitly hide a Location which was Hidden by superior, it will get the status Hidden.
Since the underlying Locations are already either Hidden or Hidden by superior, their visibility status will not be changed.

##### Revealing a Location with a visible ancestor

![Revealing a Location with a visible ancestor](img/node_visibility_unhide1.png)

When you reveal a Location which has a visible ancestor, this Location and its children will become visible.
However, child Locations that were explicitly hidden by a user will keep their Hidden status
(and their children will remain Hidden by superior).

##### Revealing a Location with a Hidden ancestor

![Revealing a Location with a Hidden ancestor](img/node_visibility_unhide2.png)

When you reveal a Location that has a Hidden ancestor, it will **not** become Visible itself.
Because it still has invisible ancestors, its status will change to Hidden by superior.

!!! tip "In short"

    A Location can only be Visible when all of its ancestors are Visible as well.

#### Visibility mechanics

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

    Displaying visible or hidden Locations in governed by the [`Visibility` Search Criterion](../guide/search/criteria_reference/visibility_criterion.md)

!!! caution "Visibility and permissions"

    The Location visibility flag is not permission-based and thus acts as a simple potential filter.
    **It is not meant to restrict access to content**.

    If you need to restrict access to a given Content item, use [**Sections**](admin_panel.md#sections) or other [**Limitations**](limitations.md), which are permission-based.

## Content availability

The Default content availability flag enables you to control whether content is available when its translation is missing.

You can set the flag in Content Type definition by checking the "Make content available even with missing translations" option.
It is automatically applied to any new Content item of this Type.

![Default content availability](img/availability_flag.png "Default content availability")

A Content item with this flag will be available in its main language
even if it is not translated into the language of the current SiteAccess.

Without the flag, a Content item will not be available at all if it does not have a language version
corresponding to the current SiteAccess.

!!! note

    There is currently no way in the Back Office to edit the Content availability flag
    for an already published Content item.
    
    To do this via [PHP API](../api/public_php_api_creating_content.md#updating-content), set the [`alwaysAvailable` property](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/API/Repository/Values/Content/ContentMetadataUpdateStruct.php#L52) of the Content metadata.

The Default availability flag is used for the out-of-the box Content Types representing content
that should always be visible to the user, such as media files or user Content items.

You can also use it for organizational Content Types.

For example, you can assign the flag to a Blog Content Type which is intended to contain Blog Posts
in multiple languages. If the Blog is in English only, it would not be visible for readers
using the Norwegian or German SiteAcceses.
However, if you set the default availability flag for the Blog Content Type,
it will be displayed to them in English (if it is set as a main language) and will enable the users to browse individual
posts in other languages.

## Content Relations

Content items are located in a tree structure through the Locations they are placed in.
However, Content items themselves can also be related to one another.

![Content Relations](img/content_management_relations.png "Content Relations")

A **Relation** can exist between any two Content items in the Repository.
For example, images are linked to news articles they are used in.
Instead of using a fixed set of image attributes, the images are stored as separate Content items outside the article.

There are different types of Relations available in the system.
Content can have Relations on item or on Field level.

*Relations at Field level* are created using one of two special Field Types: Content relation (single) and Content relations (multiple).
These Fields allow you to select one or more other Content items in the Field value, which will be linked to these Fields.

*Relations at Content item level* can be of three different types:

- *Common Relations* are created between two Content items using the Public API.
- *RichText linked Relations* are created using a Field of the RichText type.
When an internal link (a link to another Location or Content item) is placed in a RichText Field,
the system automatically creates a Relation.
The Relation is automatically removed from the system when the link is removed from the Content item.
- *RichText embedded Relations* also use a RichText Field.
When an Embed element is placed in a RichText Field, the system automatically creates a Relation
between the embedded Content item and the one with the RichText Field.
The Relation is automatically removed from the system when the link is removed from the Content item.
