---
description: Learn how to create a content model consisting of Content Types and a few sample Content items.
---

# Step 2 — Create the content model

How your content is structured is a very important part of an [[= product_name =]] project. Think of it as the database design of your application.

To get full information, read the [content model](content_model.md) documentation page.
Below is a short introduction that only covers points needed for this tutorial.

## Content model overview

The [[= product_name =]] content Repository is centered around **Content items**. A Content item is a single piece of content, for example an article, a product review, a place, etc.

Every Content item is an instance of a **Content Type**. Content Types define what **Fields** are included in each Content item.
For example, an article could include Fields such as *title*, *image*, *abstract*, *article's body*, *publication date* and *list of authors*.

Fields can belong to one of the installed **Field Types**, about 30 in the default distribution.
Each Field Type is built to represent a specific type of data: a text line, a block of rich text, an image, a collection of relations to Content items, etc.
You can find a complete list in the [Field Types reference](field_type_reference.md) section.
Every Field Type may have its own options, and comes with its own editing and viewing interfaces.

## Add a Content Type

The site will use two Content Types: **Ride** and **Landmark**.
A Ride is a route of a bike trip. It can include one or more Landmarks - interesting places you can see along the way.
More than one Ride can visit the same Landmark, so it is similar to an N-N relationship model in a database.

In this step you'll add the first Content Type, Ride.

Go to the admin interface (`<yourdomain>/admin`) and log in with the default username: `admin` and the default password: `publish`. 

Go to the left side menu and choose **Content Types**.


You will see a list of **Content Type groups**. They are used to group Content Types in a logical way.

Select **Content** and then click the **Add new** button. 

![Add a Content Type button](bike_tutorial_create_content_type.png)

Fill the form with this basic info: 

- **Name**: Ride
- **Identifier**: `ride`

Then create all Fields with the following information: 

| Field Type   | Name             | Identifier       |  Required | Searchable | Translatable |
| ------------ | ---------------- | ---------------- | --------- | ---------- | ------------ |
| Text line    | Name             | `name`           | yes       | yes        | yes          |
| Image Asset  | Photo            | `photo`          | no        | no         | no           |
| Rich text    | Description      | `description`    | yes       | yes        | yes          |
| Map location | Starting point   | `starting_point` | yes       | yes        | no           |
| Map location | Ending point     | `ending_point`   | yes       | yes        | no           |
| Integer      | Length           | `length`         | yes       | yes        | no           |

Confirm the creation of the Content Type by selecting **Create**.

## Create Rides

!!! note

    If you are using [[= product_name_exp =]], the root Content item in your installation is
    a Page called "Ibexa Digital Experience Platform".
    
    For this tutorial, swap it with its child, a Folder called "Ibexa Platform".
    
    To do this, go to "Ibexa Digital Experience Platform", select the **Locations** tab
    and in the **Swap Locations** section navigate to "Ibexa Platform".
    
    You can learn how to work with Pages in [another tutorial](page_and_form_tutorial.md).

Go back to the content by selecting **Content structure** in the left menu. 
Then browse the Content tree and create a Folder named *All Rides* using the **Create content** button on the top right of the screen. 
Publish the Folder.

While in the folder, create a few of Rides using the **Create content** button, add photos and publish them.

![Ready for Step 3](bike_tutorial_all_rides_admin.png)

Once you have two or more Rides in the Folder, you are ready to customize the homepage of the website.
