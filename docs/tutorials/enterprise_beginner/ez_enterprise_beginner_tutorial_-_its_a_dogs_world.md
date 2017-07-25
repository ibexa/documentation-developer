# eZ Enterprise Beginner Tutorial - It's a Dog's World

This tutorial will guide you through the process of making and customizing a front page for your website. For this purpose we will use a feature of eZ Platform Enterprise Edition called **Landing Page**. 

Landing Page is a special type of page that lets the Editor easily create and customize a complex, multi-zone entrance point to your website. In this tutorial you will learn both how to make use of out-of-the-box elements of the feature and how to extend it to fit your specific needs.

### Intended audience

This tutorial is intended for a beginner with basic knowledge of the workings of eZ Platform. Ideally, you should be familiar with the concepts covered in the [Building a Bicycle Route Tracker in eZ Platform tutorial](../platform_beginner/building_a_bicycle_route_tracker_in_ez_platform.md).

### Learning outcomes

After going through this tutorial, you will:

- Have a working knowledge of Landing Page functionality and architecture
- Be able to create a Landing Page and customize its layout
- Be able to prepare and customize Schedule blocks
- Be able to create a custom block to be placed on a Landing Page

## The Story Behind the Tutorial

*You have been commissioned with creating a website for the It's a Dog's World magazine, a periodical for dog owners. It's a Dog's World is a magazine focused on content-rich articles, a comprehensive encyclopedia of dog breeds and useful dog care advice.*

*Your main objective is to create a welcome page that would showcase the magazine's three most important types of content: articles, dog breed information and tips.*

We will do this by means of a Landing Page, making use of its specific blocks, and crafting our own as well.

![It's a Dog's World - final result](img/enterprise_tut_main_screen.png "It's a Dog's World - final result")

### Why use a Landing Page?

A Landing Page is particularly fitted to what you need to do in this tutorial. You can build and customize it once, and later the magazine's editor can create and publish new content that will automatically land in the correct place on the front page.

For showcasing articles we will use a Schedule block, a special Landing Page element that lets you plan the times and order at which content will air.

We will display entries from the Dog Breed encyclopedia using a Content List block. This block will automatically find all Dog Breed Content items and display their previews in a separate column.

Finally, we will display one random tip of the day using a special, custom block we will build during this tutorial.
