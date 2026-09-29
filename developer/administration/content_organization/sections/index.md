# Sections

Sections are used to divide content items in the tree.

Sections are used to divide content items in the tree into groups that are more manageable by content editors. Division into sections allows you, among others, to set [permissions](../../../permissions/permission_overview/index.md) for only a part of the tree.

![Sections screen](https://doc.ibexa.co/en/5.0/administration/img/admin_panel_sections.png "Sections screen")

Technically, a section is a number, a name, and an identifier. Content items are placed in sections by being assigned the section ID. One item can be in only one section.

When a new content item is created, its section ID is set to the default section (which is usually Standard). When the item is published it is assigned to the same section as its parent. Because content must always be in a section, unassigning happens by choosing a different section to move it into. If a content item has multiple location assignments then it is always the section ID of the item referenced by the parent of the main location that is used. In addition, if the main location of a content item with multiple location assignments is changed then the section ID of that item is updated.

When content is moved to a different location, the item itself and all of its subtree are assigned to the section of the new location. It works only for copy and move. Assigning a new section to a parent content item doesn't affect the subtree, meaning that subtree cannot currently be updated this way.

Sections can only be removed if no content items are assigned to them. Even then, it should be done carefully. When a section is deleted, it's only its definition itself that is removed. Other references to the section remain and thus the system most likely loses consistency.

> **Caution: Caution**
>
> Removing sections may corrupt permission settings, template output and other things in the system.

Section ID numbers aren't recycled. If a section is removed, its ID number cannot be reused when a new section is created.
