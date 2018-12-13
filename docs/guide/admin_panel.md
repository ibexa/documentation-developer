# Administration panel

Once you set up your environment you can start your work as administrator.
Your most useful tools can be found in **Admin Panel** and in drop-down menu under your user name.

## Systemn Information

You can chceck it in System information 

The system information panel in Platform UI has been improved, and reimplemented in a new package, ezsystems/ez-support-tools.
This change will make it easier to add custom panels to the UI, or customize existing ones.

## Sections

Sections are used to divide Content items in the tree into groups that are more easily manageable by content editors.
Division into Sections allows you, among others, to set permissions for only a part of the tree.

Technically, a Section is a number, a name and an identifier.
Content items are placed in Sections by being assigned the Section ID, with one item able to be in only one Section.

When a new Content item is created, its Section ID is set to the default Section (which is usually Standard).
When the item is published it is assigned to the same Section as its parent.
Because Content must always be in a Section, unassigning happens by choosing a different Section to move it into.
If a Content item has multiple Location assignments then it is always the Section ID of the item referenced by the parent of the main Location that will be used.
In addition, if the main Location of a Content item with multiple Location assignments is changed then the Section ID of that item will be updated.

When content is moved to a different Location, the item itself and all of its subtree will be assigned to the Section of the new Location.
Note that it works only for copy and move; assigning a new section to a parent's Content does not affect the subtree, meaning that Subtree cannot currently be updated this way.

Sections can only be removed if no Content items are assigned to them.
Even then, it should be done carefully. When a Section is deleted, it is only its definition itself that will be removed.
Other references to the Section will remain and thus the system will most likely lose consistency.
That is why removing Sections may corrupt permission settings, template output and other things in the system.
Section ID numbers are not recycled. If a Section is removed, its ID number will not be reused when a new Section is created.

[Sections](repository.md/#sections)

## Roles and users

A User by default does not have access to anything.
To get access they need to inherit Roles, typically assigned to the User Group they belong to.

Each Role can contain one or more Policies.
A Policy is a rule that gives access to a single function in a module.
For example, a section/assign Policy allows the User to assign content to Sections.

When you add a Policy to a Role, you can also restrict it using one or more Limitations.
A Policy with a Limitation will only apply when the condition in the Limitation is fulfilled.
For example, a content/publish Policy with a ContentType Limitation on the "Blog Post" Content Type will allow the User to publish only Blog Posts, and not other Content.

Note that Policies on one Role are connected with the and relation, not or, so when Policy has more than one Limitation, all of them have to apply.

Remember that a Limitation specifies what a User can do, not what they can't do.
A Section Limitation, for example, gives the User access to the selected Section, not prohibits it.

See Available Limitations for further information.

To take effect, a Role must be assigned to a User or User Group. Every User or User Group can have many roles.
A User can also belong to many groups, for example, Administrators, Editors, Subscribers.

Best practice is to avoid assigning Roles to Users directly; instead, make sure you model your content (types, structure, sections, etc.) in a way that can be reflected in generic roles.
Besides being much easier to manage and keep on top of security-wise, this also makes sure your system performs best.
The more Role assignments and complex Policies you add for a given User, the more complex the search/load queries powering the whole CMS will be, as they always take permissions into account.

To set possible roles for users like editor, contributor, visitor etc. you should 

[Use Cases](guide/permissions.md/#use-cases)

## Languages

eZ Platform offers the ability to create multiple language versions (translations) of a Content item.
Translations are created per version of the item, so each version of the content can have a different set of translations.

A version always has at least one translation which by default is the initial/main translation.
Further versions can be added, but only for languages that have previously been added to the global translation list, that is a list of all languages available in the system.e maximum number of languages in the system is 64.

Different translations of the same Content item can be edited separately.
This means that different users can work on translations into different languages at the same time.

You can control whether a User or User group is able to translate content or not.
You do this by adding a Language limitation to Policies that allow creating or editing content.
This limitation enables you to define which Role can work with which languages in the system.
(For more information of the permissions system, see Permissions.)

In addition, you can also control the access to the global translation list by using the Content/Translations Policy.
This Policy allows users to add and remove languages from the global translation list.

[Languages](internationalization.md)

## Content Types

[Content Types characteristic](content_model.md/#content-types)
[Creating Content Type](getting_started/first_steps.md/#create-a-content-type)

## Object States

Object states are user-defined states that can be assigned to Content items.
Object states are contained in groups.
If a state group contains any states, each Content item is automatically assigned a state from this group.

You can assign states to content in the Back Office in the Content item's Details tab.

By default, eZ Platform contains one Object state group: "Lock", with states "Locked" and "Not locked".

Object states can be used in conjunction with permissions, in particular with the ObjectStateLimitation.
Their specific use cases depend on your needs and the setup of your permission system.

More information [Objects States](repository.md/#object-states)