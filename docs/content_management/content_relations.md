---
description: Content Relations control links between different Content items, either created explicitly or by linking inside RichText Fields.
---

# Content Relations

Content items are located in a tree structure through the Locations they are placed in.
However, Content items themselves can also be related to one another.

![Content Relations](content_management_relations.png "Content Relations")

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
