# Step 5 - Add a new Point 2D field

All actions in this step are done in the admin interface also called the Back Office.
Go to the admin interface (`<yourdomain>/admin`) and log in with the default username: `admin` and the default password: `publish`. 

## Add new Content Type

In the Back Office, select **Admin** and navigate to the **Content Types** tab.
Under **Content** category, create a new Content Type:

![Creating new Content Type](img/create_new_content_type.png)

New Content Type should have the following settings:

- **Name:** Point 2D
- **Identifier:** point_2d
- **Fields:** point2d.name

![Adding new field](img/point2d_field_definition.png)

Next, define **point2d** with the following Fields:

|Field Type|Name|Identifier|Position|Required|Translatable|
|----------|----|----------|--------|--------|------------|
| point2d  |Point 2D|`point_2d` | 1 | no | no|

![Defining Point 2D](img/new_field_definition.png)

Save everything and go back to the **Content/Content structure** tab.

## Create your content

In **Content structure**, from the right sidebar menu, select **Create**. There, under **Content**, you should see Point 2D Content Type you just added. Click it to create new content.

![Selecting Point 2D from sidebar](img/menu_point2d.png)

In **New Point 2D** tab, you can fill in coordinates of your point, e.g. 3, 5. Provided coordinates will be used as a title for a new point.

![Creating Point 2D](img/creating_new_point2d.png)

Click **Publish**. Now, you should see a new **(3,5)** point in the content tree.

![New Point 2D](img/new_point2d.png)
