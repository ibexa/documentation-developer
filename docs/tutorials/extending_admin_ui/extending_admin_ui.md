# Extending Admin UI

## Introduction

This tutorial aims at providing a step-by-step guide on how to extend the eZ Platform Back Office provided by [the eZ Platform Admin UI bundle](https://github.com/ezsystems/ezplatform-admin-ui). 

In this tutorial, you will create a new part of the application allowing you to browse your content by Content Type instead of using the tree structure.

You will learn to extend two points of the Back Office:

- Add a tab in the Dashboard listing all Articles
- Add a menu item that lists all Content items filtered by Content Type

To follow this tutorial you need to:

- be comfortable with eZ Platform's content model (Content, Location, Content Type, etc.)
- have basic to intermediate level in PHP and JavaScript
- have a basic knowledge of Symfony's concepts (Bundle, Controller and routing)
