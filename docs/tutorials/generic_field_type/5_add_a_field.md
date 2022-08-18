---
description: Learn how to use your custom Field Type by adding a Field to a Content Type and creating an instance.
---

# Step 5 - Add a new Point 2D Field

All actions in this step are done in the admin interface also called the Back Office.
Go to the admin interface (`<yourdomain>/admin`) and log in with the default username: `admin` and the default password: `publish`. 

## Add new Content Type

In the Back Office, in the left menu navigate to the **Content Types** page.
Under **Content** category, create a new Content Type:

![Creating new Content Type](create_new_content_type.png)

New Content Type should have the following settings:

- **Name:** Point 2D
- **Identifier:** point_2d
- **Fields:** point2d.name

![Adding new field](point2d_field_definition.png)

Next, define **point2d** with the following Fields:

|Field Type|Name|Identifier|Required|Translatable|
|----------|----|----------|--------|------------|
| point2d  |Point 2D|`point_2d` | yes | no|

![Defining Point 2D](new_field_definition.png)

Save everything and go back to the **Content/Content structure** tab.

## Create your content

In **Content structure**, select **Create content**. There, under **Content**, you should see Point 2D Content Type you just added. Click it to create new content.

![Selecting Point 2D from sidebar](menu_point2d.png)

Here, you can fill in coordinates of your point, e.g. 3, 5. Provided coordinates will be used as a title for a new point.

![Creating Point 2D](creating_new_point2d.png)

Click **Publish**. Now, you should see a new **(3,5)** point in the content tree.

!!! tip

    If you cannot see the results or encounter an error, clear the cache and reload the application.

![New Point 2D](new_point2d.png)
