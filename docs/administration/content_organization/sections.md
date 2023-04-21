---
description: Sections are used to divide Content items in the tree.
---

## Sections

Sections are used to divide Content items in the tree into groups that are more easily manageable by content editors.
Division into Sections allows you, among others, to set [permissions](permission_overview.md) for only a part of the tree.

![Sections screen](admin_panel_sections.png "Sections screen")

Technically, a Section is a number, a name and an identifier.
Content items are placed in Sections by being assigned the Section ID. One item can be in only one Section.

When a new Content item is created, its Section ID is set to the default Section (which is usually Standard).
When the item is published it is assigned to the same Section as its parent. Because content must always be in a Section, unassigning happens by choosing a different Section to move it into.
If a Content item has multiple Location assignments then it is always the Section ID of the item referenced by the parent of the main Location that will be used.
In addition, if the main Location of a Content item with multiple Location assignments is changed then the Section ID of that item will be updated.

When content is moved to a different Location, the item itself and all of its subtree will be assigned to the Section of the new Location.
Note that it works only for copy and move; assigning a new Section to a parent Content item does not affect the subtree, meaning that subtree cannot currently be updated this way.

Sections can only be removed if no Content items are assigned to them. Even then, it should be done carefully.
When a Section is deleted, it is only its definition itself that will be removed.
Other references to the Section will remain and thus the system will most likely lose consistency.

!!! caution

    Removing Sections may corrupt permission settings, template output and other things in the system.

Section ID numbers are not recycled. If a Section is removed, its ID number will not be reused when a new Section is created.

### Registering users

Registration form for your website is placed under this address: <yourdomain>/register.
By default, new Users created in this way are placed in the Guest accounts group.
To give your users a possibility to register themselves, follow the instructions 
on [enabling account registration](8_enable_account_registration.md).