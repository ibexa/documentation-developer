---
description: Content Relations control links between different content items, either created explicitly or by linking inside RichText fields.
---

# Content Relations

Content items are located in a tree structure through the locations they're placed in.
However, content items themselves can also be related to one another.

![Content Relations](content_management_relations.png "Content Relations")

A **Relation** can exist between any two content items in the repository.
For example, images are linked to news articles they're used in.
Instead of using a fixed set of image attributes, the images are stored as separate content items outside the article.

In the system you can find different types of Relations.
Content can have Relations on item or on field level.

*Relations at field level* are created using one of two special field types: Content relation (single) and Content relations (multiple).
These fields allow you to select one or more other content items in the field value, which are linked to these fields.

*Relations at content item level* can be of three different types:

- *Common Relations* are created between two content items using the public PHP API.
- *RichText linked Relations* are created using a field of the RichText type.
When an internal link (a link to another location or content item) is placed in a RichText field,
the system automatically creates a Relation.
The Relation is automatically removed from the system when the link is removed from the content item.
- *RichText embedded Relations* also use a RichText field.
When an Embed element is placed in a RichText field, the system automatically creates a Relation
between the embedded content item and the one with the RichText field.
The Relation is automatically removed from the system when the link is removed from the content item.
