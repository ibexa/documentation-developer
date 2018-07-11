# Repository

The content Repository is where all your content is stored.

## Locations

A Content item could not function in the system without having a place – a Location – assigned to it. When a new Content item is published, a new Location is automatically created and the item is placed in it.

Together, all Locations form a tree which is the basic way of organizing Content in the system and specific to eZ Platform. Every published Content item has a Location and, as a consequence, also a place in this tree.

A Content item receives a Location only once it has been published. This means that a freshly created draft does not have a Location yet.

A Content item can have more than one Location. This can be used to have the same content in two or more places in the tree, for example an article at the same time on the front page and in the archive. Even in such a case, one of these places is always the main Location.

The tree is hierarchical, with an empty root Location (which is not assigned any Content item) and a structure of dependent Locations below it. Every Location (aside from the root) has one parent Location and can have any number of children. There are no Locations outside this tree.

### Top level Locations

Top level Locations are direct children of the root of the tree. The root has Location ID 1, is not related to any Content items and should not be used directly.

Under this root there are preset top level Locations in each installation which cannot be deleted:

![Content and Media top Locations](img/content_structure_media_library.png)

#### Content

"Content" is the top level Location for the actual contents of a site. This part of the tree is typically used for organizing folders, articles, information pages, etc. This means that it contains the actual content structure of the site, which can be viewed by selecting the "Content structure" tab in the Content mode interface. The default ID number of the "Content" Location is 2; it references a "Folder" Content item.

#### Media

"Media" is the top level Location which stores and organizes information that is frequently used by Content items located below the "Content" node. It usually contains images, animations, documents and other files. They can be viewed by selecting the "Media library" tab in the Content mode interface. The default ID number of the "Media" Location is 43; it references a "Folder" Content item.

#### Users

![Users in admin panel](img/admin_panel_users.png)

"Users" is the top level Location that contains the built-in system for managing User accounts. A User is simply a Content item of the "User account" Content Type. The Users are organized within "User Group" Content items below this Location. In other words, the "Users" Location contains the actual Users and User Groups, which can be viewed by selecting the "Users" tab in the Admin Panel. The default identification number of the "Users" Location is 5; it references a "User Group" Content item.

#### Other top level Locations

Another top level location, with the ID 48, corresponds to "Setup" and is not regularly used to store content.

You should not add any more content directly below Location 1, but instead store any content under one of those top-level Locations.

### Location visibility

Location visibility is a mechanism which allows you to control which parts of the content tree are available to the visitor.

Given that once a Content item is published, it cannot be un-published, limiting visibility is the only method used to withdraw content from the website without moving it to Trash. When the Location of a Content item is hidden, any access to it will be denied, preventing the system from displaying it.

Visibility does not need to be set individually for every Location. Instead, when a Location is hidden, all of its descendants in the tree will be hidden as well. This means that a Location can have one of three different visibility statuses:

- Visible
- Hidden
- Hidden by superior

By default all Locations are Visible. If a Location is made invisible manually, its status is set to Hidden. At the same time all Locations under it will change status to Hidden by superior.

From the visitor's perspective a Location behaves the same whether its status is Hidden or Hidden by superior – it will be unavailable in the website. The difference is that a Location Hidden by superior cannot be revealed manually. It will only become visible once all of its ancestor Locations are made Visible again.

A Hidden by superior status does not override a Hidden status. This means that if a Location is Hidden manually and later one of its ancestors is Hidden as well, the first Location's status does not change – it remains Hidden (not Hidden by superior). If the ancestor Location is made visible again, the first Location still remains Hidden.

The way visibility works can be illustrated using the following scenarios:

##### Hiding a visible Location

![Hiding a visible Location](img/node_visibility_hide.png)

When you hide a Location that was visible before, it will get the status Hidden. Underlying Locations will be marked Hidden by superior. The visibility status of underlying Locations that were already Hidden or Hidden by superior will not be changed.

##### Hiding a Location which is Hidden by superior

![Hiding a Location which is Hidden by superior](img/node_visibility_hide_invisible.png)

When you explicitly hide a Location which was Hidden by superior, it will get the status Hidden. Since the underlying Locations are already either Hidden or Hidden by superior, their visibility status will not be changed.

##### Revealing a Location with a visible ancestor

![Revealing a Location with a visible ancestor](img/node_visibility_unhide1.png)

When you reveal a Location which has a visible ancestor, this Location and its children will become visible. However, underlying Locations that were explicitly hidden by a user will retain the Hidden status (and their children will be remain Hidden by superior).

##### Revealing a Location with a Hidden ancestor

![Revealing a Location with a Hidden ancestor](img/node_visibility_unhide2.png)

When you reveal a Location that has a Hidden ancestor, it will **not** become Visible itself. Because it still has invisible ancestors, its status will change to Hidden by superior.

!!! tip "In short"

    A Location can only be Visible when all of its ancestors are Visible as well.

#### Visibility mechanics

The visibility mechanics are controlled by two flags: Hidden flag and Invisible flag. The Hidden flag informs whether the node has been hidden by a user or not. A raised Invisible flag means that the node is invisible either because it was hidden by a user or by the system. Together, the flags represent the three visibility statuses:

|Hidden flag|Invisible flag|Status|
|------|------|------|
|-|-|The Location is visible.|
|1|1|The Location is invisible and it was hidden by a user.|
|-|1|The Location is invisible and it was hidden by the system because its ancestor is hidden/invisible.|

!!! caution "Visibility and permissions"

    The Location visibility flag is not permission-based and thus acts as a simple potential filter. **It is not meant to restrict access to content**.

    If you need to restrict access to a given Content item, use **Sections** or other **Limitations**, which are permission-based.

## Content Relations

Content items are located in a tree structure through the Locations they are placed in. However, Content items themselves can also be related to one another.

A Relation can be created between any two Content items in the Repository. This feature is typically used in situations when you need to connect and/or reuse information that is scattered around in the system. For example, it allows you to add images to news articles. Instead of using a fixed set of image attributes, the images are stored as separate Content items outside the article.

There are different types of Relations available in the system. First of all, content can be related on item or on Field level.

Relations at Field level are created using one of two special Field Types: Content relation (single) and Content relations (multiple). As the names suggest, such Fields allow you to select one or more other Content items in the Field value, which will be linked to these Fields. Content relation (single) is an example of a one-to-one relationship, and Content relations (multiple) – a one-to-many relationship.

Relations at item level can be of three different types:

1. Common relations are created between two Content items using the Public API.
1. RichText linked relations are created using a Field of the RichText type. Whenever an internal link (a link to another Location or Content item) is inserted into a Field represented by this Field Type, the system will automatically create a relation of this type. Note that such a relation is automatically removed from the system when the corresponding link is removed from the Content item.
1. RichText embedded relations also use a RichText Field. Whenever an Embed element is inserted into a Field represented by this Field Type, the system will automatically create a relation of this type, that is relate the embedded Content item to the one that is being edited. Note that a relation of this type is automatically removed from the system when the corresponding element is removed.

## Sections

Sections are used to divide Content items in the tree into groups that are more easily manageable by content editors. Division into Sections allows you, among others, to set permissions for only a part of the tree.

Technically, a Section is a number, a name and an identifier. Content items are placed in Sections by being assigned the Section ID, with one item able to be in only one Section.

When a new Content item is created, its Section ID is set to the default Section (which is usually Standard). When the item is published it is assigned to the same Section as its parent. Because Content must always be in a Section, unassigning happens by choosing a different Section to move it into. If a Content item has multiple Location assignments then it is always the Section ID of the item referenced by the parent of the main Location that will be used. In addition, if the main Location of a Content item with multiple Location assignments is changed then the Section ID of that item will be updated.

When content is moved to a different Location, the item itself and all of its subtree will be assigned to the Section of the new Location. Note that it works only for copy and move; assigning a new section to a parent's Content does not affect the subtree, meaning that Subtree cannot currently be updated this way.

Sections can only be removed if no Content items are assigned to them. Even then, it should be done carefully. When a Section is deleted, it is only its definition itself that will be removed. Other references to the Section will remain and thus the system will most likely lose consistency. That is why removing Sections may corrupt permission settings, template output and other things in the system.

Section ID numbers are not recycled. If a Section is removed, its ID number will not be reused when a new Section is created.

![Sections screen](img/admin_panel_sections.png)

## Services: Public API

The Public API exposes Symfony services for all of its Repository services.

| Service ID                           | Type                                           |
|--------------------------------------|------------------------------------------------|
| `ezpublish.api.service.content`      | `eZ\Publish\API\Repository\ContentService`     |
| `ezpublish.api.service.content_type` | `eZ\Publish\API\Repository\ContentTypeService` |
| `ezpublish.api.service.field_type`   | `eZ\Publish\API\Repository\FieldTypeService`   |
| `ezpublish.api.service.language`     | `eZ\Publish\API\Repository\LanguageService`    |
| `ezpublish.api.service.location`     | `eZ\Publish\API\Repository\LocationService`    |
| `ezpublish.api.service.object_state` | `eZ\Publish\API\Repository\ObjectStateService` |
| `ezpublish.api.service.role`         | `eZ\Publish\API\Repository\RoleService`        |
| `ezpublish.api.service.search`       | `eZ\Publish\API\Repository\SearchService`      |
| `ezpublish.api.service.section`      | `eZ\Publish\API\Repository\SectionService`     |
| `ezpublish.api.service.trash`        | `eZ\Publish\API\Repository\TrashService`       |
| `ezpublish.api.service.url_alias`    | `eZ\Publish\API\Repository\URLAliasService`    |
| `ezpublish.api.service.url_wildcard` | `eZ\Publish\API\Repository\URLWildcardService` |
| `ezpublish.api.service.user`         | `eZ\Publish\API\Repository\UserService`        |

## SPI and API repositories

The `ezpublish-api` and `ezpublish-spi` repositories are read-only splits of `ezsystems/ezpublish-kernel`
They are available to make dependencies easier and more lightweight.

### API

This package is a split of the eZ Platform Public API. It includes the **services interfaces** and **domain objects** from the `eZ\Publish\API` namespace.

It offers a lightweight way to make your project depend on eZ Platform API and Domain objects, without depending on the whole `ezpublish-kernel`.

The repository is read-only, automatically updated from https://github.com/ezsystems/ezpublish-kernel.

Requiring `ezpublish-api` in your project (on the example of version 6.7):

```
"require": {
    "ezsystems/ezpublish-api": "~6.7"
}
```

### SPI

This package is a split of the eZ Platform SPI (persistence interfaces).

It can be used as a dependency, instead of the whole `ezpublish-kernel`, by packages implementing custom eZ Platform storage engines, or by any package that requires classes from the `eZ\Publish\SPI` namespace.

The repository is read-only, automatically updated from https://github.com/ezsystems/ezpublish-kernel.

Requiring `ezpublish-spi` in your project (on the example of version 6.7):

```
"require": {
    "ezsystems/ezpublish-spi": "~6.7"
}
```
