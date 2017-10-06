# Step 1 - Getting your starter website

!!! tip

    You can find all files used and modified in this step on [GitHub](https://github.com/ezsystems/ezstudio-beginner-tutorial/tree/step1).

To start working on the scenario of this tutorial, you need to have a minimal working website making use of fundamental eZ Platform functionalities. You need to build it by hand from the ground up, starting with a clean eZ Enterprise installation. Just remember that if you decide to change anything from the way it is shown here, you will need to double-check all code that will be provided here and make sure it fits your website.

!!! note

    Remember to start working with a **clean** eZ Enterprise installation, **not** Studio Demo.

    To be able to follow all steps of the tutorial, make sure you are installing eZ Enterprise v1.7.0 or later.

## Setting up the website

To set up your starter website by hand, you need to follow these steps:

### 1. Get a clean eZ Enterprise installation

See [Install eZ Platform](../../getting_started/install_ez_platform.md) for a guide to installing eZ Enterprise.

### 2. Create Content Types

Log in to the back end – add `/admin` to your installation's address (e.g. `tutorial.lh/admin`) and log in using `admin` as the login and `publish` as the password. In the Admin Panel go to Content Types and create two Content Types (under the Content category) with the following settings:

#### Dog Breed

**Name:** Dog Breed

**Identifier:** dog\_breed

**Content name pattern:** &lt;name&gt;

**Fields:**

| Field Type | Name              | Identifier         | Required | Searchable | Translatable |
|------------|-------------------|--------------------|----------|------------|--------------|
| TextLine   | Name              | name               | Y        | Y          | Y            |
| TextLine   | Short Description | short\_description | Y        | Y          | Y            |
| Image      | Photo             | photo              | Y        |            |              |
| RichText   | Full Description  | description        | Y        | Y          | Y            |

#### Tip

**Name:** Tip

**Identifier:** tip

**Content name pattern:** &lt;title&gt;

**Fields:**

| Field Type | Name  | Identifier | Required | Searchable | Translatable |
|------------|-------|------------|----------|------------|--------------|
| TextLine   | Title | title      | Y        | Y          | Y            |
| TextBlock  | Body  | body       |          |            | Y            |

#### Modify existing Article Content Type

You also need to make one modification of the preexisting Article Content Type. Edit this type, remove the Image field that is of the Content Relation type, and create a new Field in its place:

| Name  | Identifier | Field Type | Required | Searchable | Translatable |
|-------|------------|------------|----------|------------|--------------|
| Image | image      | Image      |          |            | Y            |

![New image Field in the Article Content Type](img/enterprise_tut_image_in_article_ct.png)

Now inserting photos into articles will be easier. Reaching the final result of the tutorial without this change would require you to spend more time creating content, which we want to avoid in this case.

### 3. Add template, configuration and style files

Place the [`pagelayout.html.twig`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/app/Resources/views/pagelayout.html.twig) and [`pagelayout_menu.html.twig`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/app/Resources/views/pagelayout_menu.html.twig) files in your `app/Resources/views` folder. Create a new folder, called `full`, under `views`. Place further template files in it:

- [`article.html.twig`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/app/Resources/views/full/article.html.twig)
- [`dog_breed.html.twig`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/app/Resources/views/full/dog_breed.html.twig)
- [`folder.html.twig`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/app/Resources/views/full/folder.html.twig)
- [`tip.html.twig`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/app/Resources/views/full/tip.html.twig)

Place two configuration files in your `app/config` folder:

- [`views.yml`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/app/config/views.yml)
- [`image_variations.yml`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/app/config/image_variations.yml)

Modify the `config.yml` file that is located in this folder and add the following lines at the end of the imports block:

``` yaml
# in app/config/config.yml
    - { resource: views.yml }
    - { resource: image_variations.yml }
```

Create an `assets/css` subfolder in the `web` folder and add this stylesheet file to it: [`style.css`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/web/assets/css/style.css).

Create an `images` folder under `web/assets` and add the [`header.jpg`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/web/assets/images/header.jpg) file to it.

In the `src/AppBundle` folder create a `QueryType` subfolder and add `LocationChildrenQueryType.php` to it. This file allows your folders to display all content that they contain (read up on it [in the documentation](../../guide/content_rendering.md#query-controller)).

Finally, add the following files in `src/`, to create dynamic links in the top menu:

- [`Controller/MenuController.php`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/src/AppBundle/Controller/MenuController.php)
- [`DependencyInjection/AppExtension.php`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/src/AppBundle/DependencyInjection/AppExtension.php)
- [`QueryType/MenuQueryType.php`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/src/AppBundle/QueryType/MenuQueryType.php)
- [`Resources/config/services.yml`](https://github.com/ezsystems/ezstudio-beginner-tutorial/blob/step1/src/AppBundle/Resources/config/services.yml)

All the files we've placed in `src/`are not the scope of this tutorial and we won't go here into detail on how they work.

This is what the structure of the new and modified files should look like (excluding preexisting files):

![File structure](img/enterprise_tut_file_structure.png)

### 4. Create content

Now return to the app and create some content for your website.

First, make three Folders under the Home Content item. Call them All Articles, Dog Breed Catalog and All Tips.

Next, create a few Content items of proper Content Types in each of these folders:

- 6 Articles (at least, to best see the effects of Schedule blocks that we will deal with in step 3.)
- 3 Dog Breeds
- 3 Tips

 When you need an image, preferably use one from our [image pack](img/photos.zip), as this will let you compare the effect of your work to screenshots in the tutorial text.

At this point you are ready to proceed with the next step.
