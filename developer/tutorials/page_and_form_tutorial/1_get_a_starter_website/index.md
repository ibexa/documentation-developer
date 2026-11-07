# Step 1 — Get a starter website

Start the tutorial by getting a clean installation of Ibexa Experience and preparing initial content.

Editions: Experience

To set up the starter website, you need to follow these steps:

## Get a clean Ibexa DXP installation

To begin the tutorial, you need a clean installation of Ibexa Experience.

Get it by following the [Install Ibexa DXP](../../../getting_started/install_ibexa_dxp/index.md) guide.

## Add content types

Log in to the back office – add `/admin` to your installation's address (`<yourdomain>/admin`) and log in as `admin` user using the password specified during installation. Disable the Focus mode, go to content types screen and in the Content group add two content types with the following settings:

### Dog Breed

- **Name:** Dog Breed
- **Identifier:** `dog_breed`
- **Fields:**

| Field type  | Name              | Identifier          | Required | Searchable | Translatable |
| ----------- | ----------------- | ------------------- | -------- | ---------- | ------------ |
| Text line   | Name              | `name`              | yes      | yes        | yes          |
| Text line   | Short Description | `short_description` | yes      | yes        | yes          |
| Image Asset | Photo             | `photo`             | yes      | no         | no           |
| RichText    | Full Description  | `full_description`  | yes      | yes        | yes          |

### Tip

- **Name:** Tip
- **Identifier:** `tip`
- **Fields:**

| Field type | Name  | Identifier | Required | Searchable | Translatable |
| ---------- | ----- | ---------- | -------- | ---------- | ------------ |
| Text line  | Title | `title`    | yes      | yes        | yes          |
| Text block | Body  | `body`     | no       | no         | yes          |

### Modify existing Article content type

You also need to modify the built-in Article content type. It makes inserting photos into articles easier. Edit it to remove the Image field that has a Content Relation (ibexa_object_relation) type, and create a new field in its place:

| Field type  | Name  | Identifier | Required | Searchable | Translatable |
| ----------- | ----- | ---------- | -------- | ---------- | ------------ |
| Image Asset | Image | `image`    | yes      | no         | no           |

![New image field in the Article content type](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_image_in_article_ct.png)

## Add template, configuration and style files

> **Tip: Tip**
>
> For an introduction on how to use templates in Ibexa DXP, see [Beginner tutorial](../../beginner_tutorial/beginner_tutorial/index.md).

First, to remove the welcome page, go to `config/packages/` and delete the `ibexa_welcome_page.yaml` file.

Place the [`pagelayout.html.twig`](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/templates/pagelayout.html.twig) and [`pagelayout_menu.html.twig`](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/templates/pagelayout_menu.html.twig) files in the `templates` folder. Create a new folder, called `full`, in `templates`. Place further template files in it:

- [`article.html.twig`](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/templates/full/article.html.twig)
- [`dog_breed.html.twig`](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/templates/full/dog_breed.html.twig)
- [`folder.html.twig`](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/templates/full/folder.html.twig)
- [`tip.html.twig`](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/templates/full/tip.html.twig)

Place two configuration files in the `config/packages` folder:

- [`views.yaml`](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/config/packages/views.yaml)
- [`image_variations.yaml`](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/config/packages/image_variations.yaml)

In the `assets` folder in the project root:

- in the `css` folder add the following stylesheet: [`style.css`](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/assets/css/style.css) to it
- add the [`header.jpg`](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/assets/images/header.jpg) file to the `assets/images` folder

In the `webpack.config.js` file in the project root folder, add the following line after `Encore.addEntry('app', './assets/app.js');`:

```js
Encore.addStyleEntry('tutorial', [path.resolve(__dirname, './assets/css/style.css')]);
```

Next, in the terminal run the commands:

```bash
yarn encore <dev|prod>
php bin/console cache:clear
```

> **Tip: Tip**
>
> Compiling assets with Webpack Encore is explained in [the beginner tutorial](../../beginner_tutorial/3_customize_the_front_page/index.md#configuring-webpack).

In the `src` folder create a `QueryType` subfolder and add [`MenuQueryType.php`](https://github.com/ibexa/documentation-developer/blob/5.0/code_samples/tutorials/page_tutorial_starting_point/src/QueryType/MenuQueryType.php) to it.

This file takes care of displaying the top menu (for more information, see [the documentation](../../../templating/queries_and_controllers/content_queries/index.md#query-types)).

The structure of the new and modified files should look like:

![File structure](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_file_structure.png)

## Create content

Now return to the back office and create some content for your website.

First, you can hide unneeded content items from the project root.

Go to **Content structure** and select "Ibexa Digital Experience Platform". In the **Sub-items** tab, select all the current sub-items and click the **Hide Location** icon:

![Hiding content items you don't need](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_hide_content.png)

Next, under "Ibexa Digital Experience Platform", create three Folders. Call them *All Articles*, *Dog Breed Catalog* and *All Tips*. Remember that you can **Save and close** them, but you should use the **Publish** button.

Next, create a few content items of proper content types in each of these folders:

- 4 Articles (at least, to best see the effects of the Content Scheduler block that you can create in step 3.)
- 3 Dog Breeds
- 3 Tips

### Add images

When you need an image, you can use one from [this image pack](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/photos.zip). This lets you compare effects of your work to screenshots in the tutorial.

At this point you're ready to proceed with the next step.
