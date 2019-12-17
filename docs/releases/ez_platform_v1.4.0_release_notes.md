
# eZ Platform v1.4.0 Release notes

The v1.4.0 release of eZ Platform is available as of 30 June 2016.

For the release notes of the corresponding eZ Studio release, see [eZ Enterprise v1.4 Release notes](ez_enterprise_v1.4_release_notes.md).

### Quick links

-   [Installation instructions](../getting_started/install_ez_platform.md)
-   [Requirements](../getting_started/requirements.md)
-   [Download](http://share.ez.no/latest)

## Changes since v1.3

For list of issues fixed in v1.4.0 see [our issue tracker](https://jira.ez.no/issues/?filter=-1&jql=project%20%3D%20EZP%20AND%20resolution%20!%3D%20Unresolved%20AND%20fixVersion%20in%20(1.4.0-beta1%2C%201.4.0-rc1)%20ORDER%20BY%20updatedDate%20ASC), below is a list of notable bugs/features/enhancements done in the release.

### Content on the fly

It is now possible to create content on the fly, during the editing process. You no longer need to be in the View mode to create a new Content item. Instead you can do it from the Universal Discovery Widget, for example when embedding content in the Online Editor, or when choosing an image linked to a different Content item.

![](https://cloud.githubusercontent.com/assets/12594013/16034938/b0f616a0-3214-11e6-8b9e-a824c1b2d1ca.gif)

This feature is provided as a preview in this release, available from a separate bundle: `EzContentOnTheFlyBundle`

### Dashboard

When logging in to the app you are now greeted with a Dashboard which you can use to quickly view and start editing the most important content. Content in the Dashboard is presented in three blocks:

-   **All Content:** Last Content items that have been modified.
-   **My Drafts:** All your current Content item drafts.
-   **My Content:** All Content items that you have modified.

![Dashboard](img/dashboard.png)

### Managing Content item versions

In the View mode you now have a new tab: **Versions**. It lists all versions of the current Content item, including archived and published versions, as well as drafts. You can view any version, edit an existing draft, delete versions or create a new draft from an existing version.

![Versions of a Content item in Versions tab](img/versions_tab.png)

### Full text search

Full text search is now available, accessible in the Universal Discovery Widget (in the **Search** tab), and in the discovery bar (on the left on the screen).

![](img/ui_simple_search.png)

This feature is provided as a preview in this release, available from a separate bundle: `PlatformUISearchPrototypeBundle`

Needs Solr for now

Full text indexing is currently only working with Solr search engine. To follow status for LegacySearchEngine (SQL) see [![](https://jira.ez.no/images/icons/issuetypes/bug.png)EZP-25088](https://jira.ez.no/browse/EZP-25088?src=confmacro) Closed

### Location swap

It is now possible to swap two Content items in their Locations. You can do it in the **Location** tab of any Content item.

Thanks go to [Carlos Revillo](https://doc.ez.no/display/~desorden) for the contribution.

![Location swap ](img/location_swap.png)

### User registration

Registering new users is now available through a `/register` route.

![User registration form](img/user_registration_form.png)

### User-Generated Content improved

User-generated content, accessible through the ` content/create/nodraft` route, now covers more Field Types, including Selection and Checkbox, as needed by User Registration.

See [User Generated Content](../guide/user_generated_content.md) for more information.

### Query Controller

Added a Query controller which makes it easier to run a repository query and display the results in a template, with built-in "children" query controller you will no longer need to create own controllers whenever you need to simply list up children of a location.

See the [Query controller page](../guide/content_rendering.md) for more information.



### Docker Tools Beta

In this release we are starting to share tools to help you use Docker with eZ Platform. What we share today has gone through several iterations to try to become as simple as possible. It uses plain Docker and Docker Compose to avoid having to learn anything specific with these tools, and it uses official docker images to take advantage of continued innovation by Docker Inc. and the ecosystem.

## Updating

To update to this version, follow the [Updating eZ Platform](../updating/updating_ez_platform.md) guide and use v1.4.0 as `<version>`.

 

## Packages versions in this release

| Package Name                        | 1.4.0 version |
|-------------------------------------|---------------|
| behatbundle                         | 6.3.0         |
| ez-support-tools                    | 0.1.0.1       |
| ezplatform-solr-search-engine       | 1.0.3         |
| ezpublish-kernel                    | 6.4.0         |
| platform-ui-assets-bundle           | 2.1.0         |
| repository-forms                    | 1.3.0         |
| ezplatform-xmltext-fieldtype        | 1.1.2         |
| platform-ui-bundle                  | 1.4.0         |
| comments-bundle                     | 6.0.0         |
| content-on-the-fly-prototype-bundle | 0.1.1         |
| platform-ui-search-prototype-bundle | 0.1.3         |
