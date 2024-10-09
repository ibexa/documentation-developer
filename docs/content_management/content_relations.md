---
description: Content Relations control links between different content items, either created explicitly or by linking inside RichText Fields.
---

# Content Relations

Content items are located in a tree structure through the Locations they're placed in.
However, content items themselves can also be related to one another.

![Content Relations](content_management_relations.png "Content Relations")

A **Relation** can exist between any two content items in the Repository.
For example, images are linked to news articles they're used in.
Instead of using a fixed set of image attributes, the images are stored as separate content items outside the article.

There are different types of Relations available in the system.
Content can have Relations on item or on Field level.

*Relations at Field level* are created using one of two special Field Types: Content relation (single) and Content relations (multiple).
These Fields allow you to select one or more other content items in the Field value, which will be linked to these Fields.

*Relations at content item level* can be of three different types:

- *Common Relations* are created between two content items using the public PHP API.
- *RichText linked Relations* are created using a Field of the RichText type.
When an internal link (a link to another Location or content item) is placed in a RichText Field,
the system automatically creates a Relation.
The Relation is automatically removed from the system when the link is removed from the content item.
- *RichText embedded Relations* also use a RichText Field.
When an Embed element is placed in a RichText Field, the system automatically creates a Relation
between the embedded content item and the one with the RichText Field.
The Relation is automatically removed from the system when the link is removed from the content item.
