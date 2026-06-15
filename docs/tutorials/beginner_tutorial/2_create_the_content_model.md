---
description: Learn how to create a content model consisting of content types and a few sample content items.
---

# Step 2 — Create the content model

How your content is structured is an important part of an [[= product_name =]] project.
Think of it as the database design of your application.

To get full information, read the [content model](content_model.md) documentation page.
Below is a short introduction that only covers points needed for this tutorial.

## Content model overview

The [[= product_name =]] content repository is centered around **content items**.
A content item is a single piece of content, for example an article, a product review, a place, and more.

Every content item is an instance of a content type.
Content types define what **Fields** are included in each content item.
For example, an article could include fields such as *title*, *image*, *abstract*, *article's body*, *publication date* and *list of authors*.

Fields can belong to one of the installed **field types**, about 30 in the default distribution.
Each field type is built to represent a specific type of data: a text line, a block of rich text, an image, a collection of relations to content items, and more.
You can find a complete list in the [field types reference](field_type_reference.md) section.
Every field type may have its own options, and comes with its own editing and viewing interfaces.

## Add a content type

The site use two content types: **Ride** and **Landmark**.
A Ride is a route of a bike trip.
It can include one or more Landmarks - interesting places you can see along the way.
More than one Ride can visit the same Landmark, so it's similar to an N-N relationship model in a database.

In this step you add the first content type, Ride.

Go to the admin interface (`<yourdomain>/admin`) and log in with the default username: `admin` using the password specified during installation.

In the upper-right corner, click the avatar icon to unfold the drop-down menu and disable the [Focus mode]([[= user_doc =]]/getting_started/discover_ui/#focus-mode).

In the main menu, go to **Content** -> **Content types**.

You can see a list of **Content type groups**.
They're used to group content types in a logical way.

Select **Content** and then click the **Create** button. 

![Add a content type button](bike_tutorial_create_content_type.png)

Fill the form with this basic info: 

- **Name**: Ride
- **Identifier**: `ride`

Then create all fields with the following information: 

| Field type   | Name             | Identifier       |  Required | Searchable | Translatable |
| ------------ | ---------------- | ---------------- | --------- | ---------- | ------------ |
| Text line    | Name             | `name`           | yes       | yes        | yes          |
| Image Asset  | Photo            | `photo`          | no        | no         | no           |
| Rich text    | Description      | `description`    | yes       | yes        | yes          |
| Map location | Starting point   | `starting_point` | yes       | yes        | no           |
| Map location | Ending point     | `ending_point`   | yes       | yes        | no           |
| Integer      | Length           | `length`         | yes       | yes        | no           |

Confirm the creation of the content type by clicking **Save and close**.

## Create Rides

!!! note

    If you're using [[= product_name_exp =]], the root content item in your installation is a Page called "Ibexa Digital Experience Platform".

    For this tutorial, swap it with its child, a Folder called "Ibexa Platform".

    To do this, in the main menu go to **Content** -> **Content structure** -> **Ibexa Digital Experience Platform**, select the **Locations** tab and in the **Swap Locations** section navigate to "Ibexa Platform".

    You can learn how to work with Pages in [another tutorial](page_and_form_tutorial.md).

Go back to the content by selecting **Content structure** in the main menu.
Then browse the content tree and create a Folder named *All Rides* by clicking the **Create content** button on the top right of the screen.
Publish the Folder.

While in the folder, create a few of Rides using the **Create content** button, add photos and publish them.

![Ready for Step 3](bike_tutorial_all_rides_admin.png)

Once you have two or more Rides in the Folder, you're ready to customize the homepage of the website.
