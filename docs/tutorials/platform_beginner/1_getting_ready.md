1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Tutorials](Tutorials_31429522.html)
4.  [Building a Bicycle Route Tracker in eZ Platform](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html)
5.  [Part 1: Setting up eZ Platform](31431610.html)

# Step 1 - Getting Ready 

Created by Sarah Haïm-Lubczanski, last modified by Dominika Kurek on Jul 05, 2017

eZ Platform is a new CMS written in PHP5 using Symfony2 Full Stack.

You will need a web server, a relational database and PHP5.x+ in order to follow this tutorial. An \*AMP web server is sufficient. You can use a local server on your own computer.

Once you have [installed eZ Platform](https://doc.ez.no/x/opPfAQ), [configured your server](https://doc.ez.no/pages/viewpage.action?pageId=31429536), and created your database (see aside) [started your web server](https://doc.ez.no/display/DEVELOPER/Web+Server), you need to create a database for this tutorial.

 

Tip: you can use [the local PHP built-in web server]() for this Tutorial !

Note that if you are using your own custom installation of eZ Platform, some of the code provided in this tutorial might not work properly. Please check that all code provided in this tutorial fits your project.

**Database Creation**

 In this tutorial, we'll use the database name "`ezplatformtutorial`".

You can create this using a GUI tool, or on the command line. For MySQL you can use this query: `` `CREATE DATABASE ezplatformtutorial CHARACTER SET UTF8` ``. You can perform the equivalent action on the database of your choice. We've seen good results with MariaDB, PostgreSQL, and others.

## **Now you are ready to begin the Tutorial!**

As we did a clean install, the root content will be displayed using the default content view template.

 

![](attachments/31431834/32869383.png?effects=border-simple,blur-border)

*Our website is quite raw for the moment.*

We will customize this default content view template in the next steps. After that, we'll create your Content Model and populate your content tree.

 

 ⬅ Previous: [Introduction of the Tutorial](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html)

Next: [Step 2 - Create your content model](Step-2---Create-your-content-model_31431844.html) ➡

[ ](Building-a-Bicycle-Route-Tracker-in-eZ-Platform_31431606.html)

 

**Tutorial path**

 

 

## Attachments:

![](images/icons/bullet_blue.gif) [eZ\_Platform\_homepage\_install\_clean\_1\_7.png](attachments/31431834/32869383.png) (image/png)






