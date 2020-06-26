# eZ Platform v3.1

**Version number**: v3.1

**Release date**: June XX, 2020

**Release type**: Fast Track

## Overview

## Notable changes

## New features

This release of eZ Platform introduces the following new features:

### URL management UI

You can now manage URL addresses and URL wildcards with a comfortable user interface that is available in the Back Office. You can create, modify and delete URL wildcards, as well as decide if the user should be redirected to the new address on clicking the link.

!!! note

  As of this release, the Link manager is no longer part of the Content panel, and now it belongs to the Admin panel of the Back Office.

![URL Management UI](img/3_1_URL_Management.png "URL Management UI")

For more information about URL management, see [URL management](../guide/url_management.md) in the developer documentation.

### Tree view in the Universal Discovery Widget

The Universal Discovery Widget, referred to as the Content Browser in User Documentation, has been updated by adding the Tree view. 
You can now switch between the Grid, Panels and Tree views to browse and manage user accounts, media files, content items and forms. 
Selections that you make in one view survive when you switch to the other view.

![Tree view in the Content Browser](img/3_1_Content_browser_Tree_view.png "Tree view in Content Browser")

For more information about configuring the Universal Discovery Widget, see [URL management](../extending/extending_udw.md) in the developer documentation.

### Search

#### ezplatform-search

[`ezplatform-search`](https://github.com/ezsystems/ezplatform-search) is a new repository
that contains search functionalities that are not dependent on the search engine

#### Search controller

A customizable search controller has been extracted and placed in `ezplatform-search`.

!!! enterprise

    ### Site Factory
    
    #### Site skeleton
    
    You can now create multiple content structures that can be used as Site skeletons for the new sites.
    
    For more information about Site skeleton, see [Configure Site skeleton](../guide/site_factory.md#configure-site-skeleton).
    
    #### Defining parent Location
    
    You can now define the parent Location for every new site in the template configuration.
    
    For more information about defining parent Location, see [Configure parent Location](../guide/site_factory.md#configure-parent-location).
      

## Requirement changes

This release changes support for ...

For full list of supported versions, see [Requirements](../getting_started/requirements.md).

## Full changelog

| eZ Platform  | eZ Enterprise  |
|--------------|------------|
| [eZ Platform v3.1.0](https://github.com/ezsystems/ezplatform/releases/tag/v3.1.0) | [eZ Enterprise v3.1.0](https://github.com/ezsystems/ezplatform-ee/releases/tag/v3.1.0) |
