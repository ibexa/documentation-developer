---
description: Start the tutorial by getting a clean installation of Ibexa Experience and preparing initial content.
edition: experience
---

# Step 1 — Get a starter website

To set up the starter website, you need to follow these steps:

## Get a clean [[= product_name =]] installation

To begin the tutorial, you need a clean installation of [[= product_name_exp =]].

Get it by following the [Install Ibexa DXP](install_ibexa_dxp.md) guide.

## Add Content Types

Log in to the Back Office – add `/admin` to your installation's address (`<yourdomain>/admin`) and log in using `admin` as the login and `publish` as the password. Go to Content Types screen and (under the Content category) add two Content Types with the following settings:

### Dog Breed

- **Name:** Dog Breed
- **Identifier:** `dog_breed`
- **Fields:**

| Field Type | Name              | Identifier          | Required | Searchable | Translatable |
|------------|-------------------|---------------------|----------|------------|--------------|
| Text line  | Name              | `name`              | yes      | yes        | yes          |
| Text line  | Short Description | `short_description` | yes      | yes        | yes          |
| Image Asset | Photo             | `photo`             | yes      | no         | no           |
| RichText   | Full Description  | `description`       | yes      | yes        | yes          |

### Tip

- **Name:** Tip
- **Identifier:** `tip`
- **Fields:**

| Field Type  | Name  | Identifier | Required | Searchable | Translatable |
|-------------|-------|------------|----------|------------|--------------|
| Text line   | Title | `title`    | yes      | yes        | yes          |
| Text block  | Body  | `body`     | no       | no         | yes          |

### Modify existing Article Content Type

You also need to modify the built-in Article Content Type. It will make inserting photos into articles easier.
Edit it to remove the Image Field that has a Content Relation (ezobjectrelation) type, and create a new Field in its place:

| Field Type | Name  | Identifier | Required | Searchable | Translatable |
|------------|-------|------------|----------|------------|--------------|
| Image Asset | Image | `image`    |yes       |no          | no           |

![New image Field in the Article Content Type](enterprise_tut_image_in_article_ct.png)

## Add template, configuration and style files

!!! tip

    For an introduction on how to use templates in [[= product_name =]], take a look at the [Beginner tutorial](beginner_tutorial.md).

First, to remove the welcome page, go to `config/packages/` and delete the `ibexa_welcome_page.yaml` file.

Place the [`pagelayout.html.twig`](https://github.com/ezsystems/developer-documentation/blob/master/code_samples/tutorials/page_tutorial_starting_point/templates/pagelayout.html.twig) and [`pagelayout_menu.html.twig`](https://github.com/ezsystems/developer-documentation/blob/master/code_samples/tutorials/page_tutorial_starting_point/templates/pagelayout_menu.html.twig) files in the `templates` folder. Create a new folder, called `full`, in `templates`. Place further template files in it:

- [`article.html.twig`](https://github.com/ezsystems/developer-documentation/blob/master/code_samples/tutorials/page_tutorial_starting_point/templates/full/article.html.twig)
- [`dog_breed.html.twig`](https://github.com/ezsystems/developer-documentation/blob/master/code_samples/tutorials/page_tutorial_starting_point/templates/full/dog_breed.html.twig)
- [`folder.html.twig`](https://github.com/ezsystems/developer-documentation/blob/master/code_samples/tutorials/page_tutorial_starting_point/templates/full/folder.html.twig)
- [`tip.html.twig`](https://github.com/ezsystems/developer-documentation/blob/master/code_samples/tutorials/page_tutorial_starting_point/templates/full/tip.html.twig)

Place two configuration files in the `config/packages` folder:

- [`views.yaml`](https://github.com/ezsystems/developer-documentation/blob/master/code_samples/tutorials/page_tutorial_starting_point/config/packages/views.yaml)
- [`image_variations.yaml`](https://github.com/ezsystems/developer-documentation/blob/master/code_samples/tutorials/page_tutorial_starting_point/config/packages/image_variations.yaml)

In the `assets` folder in the project root:

- create a `css` folder and add the following stylesheet: [`style.css`](https://github.com/ezsystems/developer-documentation/blob/master/code_samples/tutorials/page_tutorial_starting_point/assets/css/style.css) to it
- add the [`header.jpg`](https://github.com/ezsystems/developer-documentation/blob/master/code_samples/tutorials/page_tutorial_starting_point/assets/images/header.jpg) file to the `assets/images` folder

In the `webpack.config.js` file in the project root folder, add the following line after `Encore.addEntry('app', './assets/app.js');`:

``` js
Encore.addStyleEntry('tutorial', [path.resolve(__dirname, './assets/css/style.css')]);
```

Next, in the terminal run the commands:

``` bash
yarn encore <dev|prod>
php bin/console cache:clear
```

!!! tip

    Compiling assets with Webpack Encore is explained in [the beginner tutorial](3_customize_the_front_page.md#configuring-webpack).

In the `src` folder create a `QueryType` subfolder and add [`QueryType/MenuQueryType.php`](https://github.com/ezsystems/developer-documentation/blob/master/code_samples/tutorials/page_tutorial_starting_point/src/QueryType/MenuQueryType.php) to it.

This file takes care of displaying the top menu (read up on it [in the documentation](content_queries.md#query-types)).
It is not the scope of this tutorial and we won't go here into detail on how it works.

This is what the structure of the new and modified files should look like:

![File structure](enterprise_tut_file_structure.png)

## Create content

Now return to the Back Office and create some content for your website.

First, you can hide unneeded Content items from the project root.

Go to **Content structure** and select "Ibexa Digital Experience Platform".
In the **Sub-items** section, select all the current sub-items and click the **Hide** icon:

![Hiding Content items you do not need](enterprise_tut_hide_content.png)

Next, under "Ibexa Digital Experience Platform", create three Folders. Call them 'All Articles', 'Dog Breed Catalog' and 'All Tips'.
Remember that you save and close them by using the 'Publish' button.

Next, create a few Content items of proper Content Types in each of these folders:

- 4 Articles (at least, to best see the effects of the Content Scheduler block that you will create in step 3.)
- 3 Dog Breeds
- 3 Tips

### Add images

When you need an image, you can use one from [this image pack](img/photos.zip).
This will let you compare effects of your work to screenshots in the tutorial.

At this point you are ready to proceed with the next step.
