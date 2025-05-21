---
description: Learn how to use your custom field type by adding a field to a content type and creating an instance.
---

# Step 5 - Add a new Point 2D field

All actions in this step are done in the admin interface also called the back office.
Go to the admin interface (`<yourdomain>/admin`) and log in with the default username: `admin` using the password specified during installation.

## Add new content type

In the back office, the main menu, go to the **Content types** page.
Under **Content** category, create a new content type:

![Creating new content type](create_new_content_type.png)

New content type should have the following settings:

- **Name:** Point 2D
- **Identifier:** point_2d
- **Fields:** point2d.name

![Adding new field](point2d_field_definition.png)

Next, define **point2d** with the following fields:

|Field type|Name|Identifier|Required|Translatable|
|----------|----|----------|--------|------------|
| point2d  |Point 2D|`point_2d` | yes | no|

![Defining Point 2D](new_field_definition.png)

Save everything and go back to the **Content/Content structure** tab.

## Create your content

In **Content structure**, select **Create content**. There, under **Content**, you should see Point 2D content type you added.
Click it to create new content.

![Selecting Point 2D from sidebar](menu_point2d.png)

Here, you can fill in coordinates of your point, for example, 3, 5.
Provided coordinates are used as a title for a new point.

![Creating Point 2D](creating_new_point2d.png)

Click **Publish**. Now, you should see a new **(3,5)** point in the content tree.

!!! tip

    If you cannot see the results or encounter an error, clear the cache and reload the application.

![New Point 2D](new_point2d.png)
