# Step 1 - Getting Ready

eZ Platform is a CMS written in PHP7 using Symfony3 Full Stack.

You will need a web server, a relational database and PHP7.1 in order to follow this tutorial. An \*AMP web server is sufficient. You can use a local server on your own computer.

Once you have [installed eZ Platform](../../getting_started/install_ez_platform.md), [configured your server](../../getting_started/requirements_and_system_configuration.md), [created your database](#database-creation), and [started your web server](../../getting_started/starting_ez_platform.md#web-server), you need to create a database for this tutorial.

!!! tip

    You can use [the local PHP built-in web server](../../getting_started/starting_ez_platform.md#phps-built-in-server) for this Tutorial!

!!! note

    Note that if you are using your own custom installation of eZ Platform, some of the code provided in this tutorial might not work properly. Please check that all code provided in this tutorial fits your project.

#### Database Creation

In this tutorial, we'll use the database name "`ezplatformtutorial`".

You can create this using a GUI tool, or on the command line. For MySQL you can use this query: `CREATE DATABASE ezplatformtutorial CHARACTER SET UTF8`. You can perform the equivalent action on the database of your choice. We've seen good results with MariaDB, PostgreSQL, and others.

## Now you are ready to begin the Tutorial!

As we did a clean install, the root content will be displayed using the default content view template.

![Front page after clean installation](img/bike_tutorial_homepage_install_clean.png "Our website is quite raw for the moment.")

We will customize this default content view template in the next steps. After that, we'll create your Content Model and populate your content tree.
