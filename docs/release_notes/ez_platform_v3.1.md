# eZ Platform v3.1

**Version number**: v3.1

**Release date**: July 15, 2020

**Release type**: Fast Track

## Notable changes

[eZ Commerce](https://github.com/ezsystems/ezcommerce) now uses Symfony 5 and is fully integrated into the eZ Platform Back Office.

Refer to [eZ Commerce documentation](https://doc.ezplatform.com/projects/ezcommerce/en/latest/) for more information.

## New features

This release of eZ Platform introduces the following new features:

!!! dxp

    ### Site Factory

    #### Site skeleton

    You can now create multiple content structures that can be used as Site skeletons for the new sites.

    For more information about Site skeleton, see [Configure Site skeleton](https://doc.ibexa.co/en/latest/guide/multisite/site_factory_configuration/#site-skeletons).

    #### Defining parent Location

    You can now define the parent Location for every new site in the template configuration.

    For more information about defining parent Location, see [Configure parent Location](https://doc.ibexa.co/en/latest/guide/multisite/site_factory_configuration/#parent-location).
    
    ### Elasticsearch
    
    You can now use [Elasticsearch](https://www.elastic.co/) in your eZ Platform installation
    through the `PlatformElasticSearchEngineBundle`.
    
    See [Elasticsearch documentation](https://doc.ibexa.co/en/latest/guide/search/elastic) to learn how to set up, configure and user Elasticsearch with eZ Platform.
    
    ### Page Builder
    
    You can now filter elements in the sidebar during site creation process to get to the desired blocks faster.

    ![](3_1_filter_elements.png)

    ### Field Group permissions

    The new [Field Group Limitation](https://doc.ibexa.co/en/latest/guide/limitation_reference/#field-group-limitation)
    enables you to control who can edit content Fields per Field group.
    
    ### Version comparison
    
    You can now compare additional Fields in version comparison of Content item:
    
    - Content Relation and Content Relations
    - Image Asset and Image
    - Matrix
    - Media
    
    For overview of additional Fields, see [User documentation on Comparing versions.]([[= user_doc =]]/publishing/publishing/#comparing-versions)
    
### URL management UI

You can now manage URL addresses and URL wildcards with a comfortable user interface that is available in the Back Office. You can create, modify and delete URL wildcards, as well as decide if the user should be redirected to the new address on clicking the link.

!!! note

    As of this release, the Link manager is no longer part of the Content panel, and now it belongs to the Admin panel of the Back Office.

![URL Management UI](3_1_URL_Management.png "URL Management UI")

For more information on how to manage URLs, see [URL management](https://doc.ibexa.co/en/latest/guide/url_management).

### Tree view in the Universal Discovery Widget

The Universal Discovery Widget, referred to as the Content Browser in User Documentation, has been updated by adding the Tree view.
You can now switch between the Grid, Panels and Tree views to browse and manage user accounts, media files, content items and forms.
Selections that you make in one view survive when you switch to the other view.

![Tree view in the Content Browser](3_1_Content_browser_Tree_view.png "Tree view in Content Browser")

For more information about configuring the Universal Discovery Widget, see [Extending Universal Discovery Widget](https://doc.ibexa.co/en/latest/extending/extending_udw).

### Field group display

Display of Field groups has been improved in content preview and editing.

When editing, Field groups are now presented in tabs:

![Field group tabls in Content editing](3.1_collapsible_fields_edit.png)

In Content preview, the group sections are collapsible:

![Collapsible Field groups in Content view](3.1_collapsible_fields.png)

### Saving incomplete draft

When users create or edit a Content item or a Page, they can now save it without completing all the required fields.
They can then return to editing, or pass the content to another contributor.
Validation that used to happen at each save operation now, by default, happens when you click the **Publish** button.

The `ContentService::validate()` method has been added that you can use to trigger validation of individual fields 
or whole Content items for completeness at other stages of the editing process.

### Search

#### ezplatform-search

[`ezplatform-search`](https://github.com/ezsystems/ezplatform-search) is a new repository
that contains search functionalities that are not dependent on the search engine.

#### Search controller

A customizable search controller has been extracted and placed in `ezplatform-search`.

#### Searching in trash

You can now search through the contents of Trash and sort the search results based on a number of Search Criteria and Sort Clauses that can be used by the `\eZ\Publish\API\Repository\TrashService::findTrashItems` method only.

For more information, see [Searching in trash](https://doc.ibexa.co/en/latest/api/public_php_api_search/#searching-in-trash).

### Repository filtering

[Repository filtering](https://doc.ibexa.co/en/latest/api/public_php_api_search/#repository-filtering) enables you to filter content and Locations using a defined Filter,
without the `SearchService`.

### PermissionResolver

You can now have a Service that provides both `PermissionResolver` and `PermissionCriterionResolver` by injecting `eZ\Publish\API\Repository\PermissionService`.

## Behavior changes

### Landing Page drafts

When you start creating a Landing Page, a new draft is now automatically created.

## Deprecations

### Search engine tags

The `ezpublish.searchEngine` and `ezpublish.searchEngineIndexer` tags have been deprecated
in favor of `ezplatform.search_engine` and `ezplatform.search_engine.indexer`.

## Full changelog

| eZ Platform  | eZ Enterprise  |
|--------------|------------|
| [eZ Platform v3.1.0](https://github.com/ezsystems/ezplatform/releases/tag/v3.1.0) | [eZ Enterprise v3.1.0](https://github.com/ezsystems/ezplatform-ee/releases/tag/v3.1.0) |
| [eZ Platform v3.1.0-rc2](https://github.com/ezsystems/ezplatform/releases/tag/v3.1.0-rc2) | [eZ Enterprise v3.1.0-rc2](https://github.com/ezsystems/ezplatform-ee/releases/tag/v3.1.0-rc2) |
| [eZ Platform v3.1.0-rc1](https://github.com/ezsystems/ezplatform/releases/tag/v3.1.0-rc1) | [eZ Enterprise v3.1.0-rc1](https://github.com/ezsystems/ezplatform-ee/releases/tag/v3.1.0-rc1) |
| [eZ Platform v3.1.0-beta1](https://github.com/ezsystems/ezplatform/releases/tag/v3.1.0-beta1) | [eZ Enterprise v3.1.0-beta1](https://github.com/ezsystems/ezplatform-ee/releases/tag/v3.1.0-beta1) |
