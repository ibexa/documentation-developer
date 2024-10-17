---
description: Read the content management product guide and learn how to create, modify, and display information to the target audience.
---

# Content management product guide

## What is content management

The term “content management” covers all the tasks that you need to perform to create, edit and present content to its intended audience.

The content management model applied in [[= product_name =]] lies at the foundation of the entire system.
A system that relies on roles and permissions controls access to content items and is granular and powerful enough to be used in managing user accounts, corporate accounts, products, or process definitions.

## Availability

Content management capabilities are available in all [[= product_name =]] editions.

## How does it work

[[= product_name =]] revolves around content management. Many things here are content items, including:

- sites
- folders
- pages
- articles or posts
- products
- forms
- media (for example, images or videos)
- user accounts

You can set up content structure, define the templates to be filled with content, and assign different areas of the structure to your editors.
Next steps would be to create the actual content, and then classify content items, and organize them as necessary.

You can then publish the content directly, by building a website or a web store, or by using external systems together with a [headless CMS](https://developers.ibexa.co/headless-cms) that relies on the [[= product_name =]] technology.

## Content structure

All content in [[= product_name =]] is organized hierarchically, into what is called a [**content tree**](content_tree.md).
This tree-like structure repeats throughout the system, and applies to content, taxonomies, categories, and the like.

Traditional as the structure may look, with relations and multiple location support, a single content item can be referenced by another content item and accessed from different places of the tree, which allows you to build complex architectures with multiple locales and output channels.

![Content structure in a Content Browser](img/content_tree.png)

## Content model

A structure of elements that *store* content information is referred to as the **content model**.
[[= product_name =]] comes with a predefined content model that includes a broad set of various field types and several content types.

You can customize and adapt the content model to your organization's needs and the type of output channel that you use.
If need be, development teams can [create new field types](creating_a_point2d_field_type.md), to enhance editor and visitor experiences.
Content managers or even editors can then apply such field types when they modify existing or create new content types.
The editing interface lets all users, including those with no coding experience, create or modify certain areas of the content model.

For technical details, see [a Content model](content_model.md#content-model).

### Field types

[Field types](field_types.md) are the smallest elements of the content model’s structure.
[[= product_name =]] comes with many built-in field types that cover most common needs, for example, Text line, RichText, Integer, Measurement, or Map location.

Their role is to:

- store data
- validate input data
- make the data searchable
- display fields of a given field type

For a complete list of available field types, see [field type reference](field_type_reference.md).

![Field types and fields](img/field_types.png)

### Fields

Once you use a field type to design and build a content type definition, and define its settings, it becomes a field.

Fields can be as simple as Name, based on a Text line field type, or as complex as page, based on a landing page field type, with multiple options to set and choose from:

![Landing page field settings](img/fields.png)

### Content types

Life gets easier when you have templates to fill in with content. Content types are such templates, which editors use to create content items.
Content types define what fields are available in the content item.

[[= product_name =]] comes with several basic content types, and creating new ones, editing, and deleting them is done by using a visual interface, with no coding skills needed.

![Content types vs. content items](img/content_types.png)

### Content items

Content items are pieces of content, such as, for example, products, articles, blog posts, or media.
In [[= product_name =]], everything is a content item — not only pages, articles or products, but also all media (for example, images or videos) or even user accounts.

Each content item, apart from its name and identifier, contains a composition of fields, which differs depending on the type of content.
For example, articles might have for example, a title, an author, a body, and an image, while products may have, for example, a name, category, price, size, or color.

### Forms

Forms could be seen as a special kind of content items, because their role is to gather information from website users and not present it.
You create them from basic form fields available in [[= product_name =]].
By adding forms to the website, you can increase the website’s functionality and improve user experience.
Certain editions of [[= product_name =]] come with a visual [Form Builder]([[= user_doc =]]/content_management/work_with_forms/).

## Content management capabilities

Each content item has at least one location within the content tree, and can have several versions and multiple translations.
It can also have related assets, such as images or other media, and assigned keywords, or tags.

You can use these characteristics in combination with system features to create the most comprehensive and functional digital presence for your organization.

### Content characteristics

#### Locations

When a content item is created and published, it's assigned a place in the content tree, designated by a location ID.
A single content item can have more than one location ID, which means that the same content can be found on different branches of the tree.
However, a single location can have only one content item assigned to it.

![Locations](img/locations.png)

Locations can be used to control the availability of content items to end users:
you can [hide specific locations]([[= user_doc =]]/content_management/content_organization/manage_locations_urls/#hide-locations) of a content item, while others remain available.
By [swapping locations]([[= user_doc =]]/content_management/content_organization/manage_locations_urls/#swap-locations), you can immediately replace an obsolete version of a content item with an updated one.

#### Versions

Content items can have several [versions]([[= user_doc =]]/content_management/content_versions/).
By default, there are three version statuses available: draft, published, and archived.
Before they're published, drafts can be routed between different user roles for review and approval.

![Versions](img/versions.png)

Editors can [compare different content item versions]([[= user_doc =]]/content_management/workflow_management/work_with_versions/#compare-versions) by using the Compare versions feature.

#### Translations

Content items can have more than one [translation]([[= user_doc =]]/content_management/translate_content/).
If a website has different fronts, for different locales, and different language versions of content exist, [[= product_name =]] serves the one that matches the locale.

![Translations](img/translations.png)

Editors can compare different translations of the same content items with the Compare versions feature mentioned above.

#### Relations

A [relation](content_relations.md) can exist between any two content items in the content tree.
For example, blog posts featured in the website's main page are in a relation with the page that they're embedded in.
Or, instead of direct attachments, an article can use images that are separate content items outside the article, and are referenced through a relation.

## Content arrangement

In [[= product_name =]], content items can be moved and copied between branches of the content tree.
These operations, like in your computer’s file system, can apply both to individual content items and folders or groups.

![Content organization operations](img/content_arrangement.png)

Content items can be hidden when necessary, for example, until a certain event, like a Holiday Sale, or Board announcement comes. Hidden content items aren't visible to website visitors and are greyed out in the content tree.

![Hidden content item](img/hidden_content_item.png)

Editors can also move obsolete content items to Trash, and ultimately delete them.

![Delete confirmation dialog box](img/delete_confirmation.png)

## Content classification

There are multiple tools within [[= product_name =]] that help content managers classify content or restrict access to content to certain recipients.

### Taxonomy

With taxonomy you can create tags or keywords within a tree structure and assign them to content items.
This way you can classify content and make it easier for end users to find the content they need, or browse and view content from a category that suits them best.

![Taxonomy principles](img/taxonomy.png)

### Access control

When your [[= product_name =]] instance has multiple contributors and visitors, administrators can give them access to different areas of the website and different capabilities.
It's done by creating roles, with each role having a different set of [permissions](permission_overview.md), the most fitting example being the `content/edit` permission limited to an `Articles/BookReviews/Historical` subtree of the content tree.

In the next steps, after you create user groups, you’d assign roles to these groups, and add individual users to each of such groups.
For more technical information about permissions and limitations, see [Permission use cases](permission_use_cases.md).

There are, however, mechanisms to control access to content with even more convenience.

### Sections

You can divide your content tree into nominal parts to better organize it.
Once you have defined sections, for example, Media or Forms, and assigned them to content items, you can decide which roles have access to which section of the tree.

The setting is inherited, which means that a child content item inherits a value of this setting from its parent.
Changing a section setting doesn't result in moving a content item to a different location within a content tree.

![Members of the Media Section](img/sections.png)

### Object states

While reviewing the details of each individual content item in your content tree, you can assign a state to it, for example, “Locked” or “Not locked”.
Then you can set a permission that allows or denies users access to content items in a specific state.
This setting isn't inherited.

![Object states in content item’s Details](img/object_states.png)

### User segments

Although segments aren't meant to classify content, they could fall into this category, because their role is about targeting users, and not controlling their access to content.
With segments, you can reach specific groups, or categories, of visitors with specific information about content or products that could be of their interest.
For example, you can build Pages that contain different recommendations, depending on who is visiting them.

![A segment group with two user segments](img/user_segments.png)

## How to get started

Once you have integrated the headless implementation, installed a local instance of [[= product_name =]] or set up an instance on [[= product_name_cloud =]], you're ready to employ the content management features to good use.

Since content management is an ongoing process, and, in your implementation, you might prefer focusing on other areas of configuration, the order of operations below is by all means conventional.

**1\. Create a content model**

Any content that you might want to deliver to a viewer can be structured and split into smaller elements.
Reverse-engineer the intended concepts into individual fields, which can be categorized, and then picked from categories and combined into content items.

Reuse existing fields types or [customize them to fit your needs](create_custom_generic_field_type.md), then [create content types]([[= user_doc =]]/content_management/create_edit_content_items/).

**2\. Define permissions**

Although this step isn't directly related to content management, it's a good time to [set up user roles and permissions]([[= user_doc =]]/permission_management/work_with_permissions/), which users would need to work with content.

**3\. Author content**

[Create various content items]([[= user_doc =]]/content_management/create_edit_content_items/), such as pages, articles, forms, or media. While you fill fields with content, several actions are there to help you with your task.
You can pause and resume the work, preview the results, or send content for review.

![Send to review](img/send_to_review.png)

**4\. Publish**

Again, this isn't part of content management, but at this point you can [publish]([[= user_doc =]]/content_management/publish_instantly/) it right away or [schedule content for publication]([[= user_doc =]]/content_management/schedule_publishing/).

**5\. Organize content**

Organize the content of your website by copying or moving content items, [controlling Locations and URL addresses]([[= user_doc =]]/content_management/content_organization/manage_locations_urls/).
Then work with Tags, sections and object states to [classify]([[= user_doc =]]/content_management/content_organization/classify_content/#sections) it.

## Benefits

The most important benefits of using Content management capabilities of [[= product_name =]] can be gathered into the following groups:

1. Content management capabilities help reduce the effort required to maintain, administer, and distribute digital content, so that you can focus on business operations.

2. Segmentation, translations, and taxonomy make it possible to assist and target visitors from different backgrounds and markets.

3. Granular access control ensures that no content in your control lands before the unauthorized eyes.

## Use cases

[[= product_name =]]’s capabilities prove indispensable in many applications.

### Corporate website

The most common use case for a comprehensive content management system like [[= product_name =]] would be creating and maintaining a multinational company’s digital presence, with both public and intranet channels, multiple websites with overlapping content structures, and business partners and end-customers alike wanting to connect through different channels to access public and classified content.

### B2C web store

Content management could lie at a foundation of a successful global web store, where customers connect through localized websites and branded mobile apps:
individual products can have multiple variants with differing related assets, product descriptions must be available in multiple language versions, and access to certain areas of the store depends on both a country and a segment that the customer comes from.

### B2B store

Extensive content management capabilities would prove themselves in a setting, where multiple buyers from different partner companies connect to an industry leader’s trading website, and they expect to find well organized SKU catalogs that contain basic product information.
From there they would like to access detailed specifications, white papers and application notes.
The same products could come with different brands and at different price points, depending on the customer segment or origin.
