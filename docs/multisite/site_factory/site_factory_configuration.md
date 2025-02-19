---
description: Configure Site Factory, including site skeletons.
edition: experience
---

# Site Factory configuration

## Parent location

When working with the [Site Factory](site_factory.md), you can define the parent location for a new site in the configuration.
Each new site is created in the designated location.

To define a parent location, add a new configuration key to the site template definition.
Each template is assigned to its own location.
This can be either a location ID (for example, `62`), or a recommended remote location ID (for example, `1548b8cd8dd4c6b5082e566615d45e91`).

Add the configuration key to your template under the `ibexa_site_factory` [configuration key](configuration.md#configuration-files):

``` yaml hl_lines="7 12"
ibexa_site_factory:
    templates:
        site1:
            siteaccess_group: example_site_factory_group_1
            name: example_site_1
            thumbnail: /path/to/image/example-thumbnail_1.png
            parent_location_id: 62
        site2:
            siteaccess_group: example_site_factory_group_2
            name: example_site_2
            thumbnail: /path/to/image/example-thumbnail_2.png
            parent_location_remote_id: 1548b8cd8dd4c6b5082e566615d45e91
```

Now, you can see the path to the new site's parent location under design selection.
If you have sufficient permissions, you can change the defined location during site creation.
If the parent location isn't defined, you have to choose it from Universal Discovery Widget.

## Site skeletons

The Site skeleton enables you to copy an entire content structure of the site design to the defined location.

Site skeleton copying is a one-off operation, it only happens during the site creation process.
After that, you cannot copy the Site skeleton again, for example in the edit view.

You can create as many skeletons as you need and assign them to templates.
Remember that one template can only have one Site skeleton.

If the design doesn't have a defined Site skeleton, a directory of the new site is created in a standard Site Factory process.

To define a Site skeleton, add the `site_skeleton_id` or `site_skeleton_remote_id` key to the site template definition.
This can be either a location ID (for example, `5966`), or a remote location ID (for example, `3bed95afb1f8126f06a3c464e461e1ae66`).

``` yaml hl_lines="7 12"
ibexa_site_factory:
    templates:
        site1:
            siteaccess_group: example_site_factory_group_1
            name: example_site_1
            thumbnail: /path/to/image/example-thumbnail_1.png
            site_skeleton_id: 5966
        site2:
            siteaccess_group: example_site_factory_group_2
            name: example_site_2
            thumbnail: /path/to/image/example-thumbnail_2.png
            site_skeleton_remote_id: 3bed95afb1f8126f06a3c464e461e1ae66
```

Now, you can choose a design with a defined Site skeleton, and decide if you want to use its skeleton by toggling **Generate site using site skeleton**.

## User group skeletons

With user group skeletons you can define policies and limitations that apply to selected groups of users who can access the site.

You can create many user group skeletons and associate them with many templates.
One template can have many user group skeletons assigned.

To create a user group skeleton, first go to **Admin** -> **Site skeletons** and add a user group to the list of available skeletons.
Then, review the detailed information of the newly created user group skeleton, copy the location ID or the Location remote ID, and add a configuration key to the site template definition:

``` yaml
ibexa_site_factory:
    templates:
        <site_name>:
            # ...
            user_group_skeleton_ids: [ <id_skeleton1>, <id_skeleton2>, ... ]
            user_group_skeleton_remote_ids: [ <id_skeleton3>, <id_skeleton4>, ... ]
```

Manage the permissions associated to the user group skeleton by [assigning roles]([[= user_doc =]]/permission_management/work_with_permissions/#assign-a-role-to-users).
Make sure that the roles that you assign to the user group skeleton don't contain location-based limitations.
User group skeletons cannot contain individual user content items either.

User group skeletons are retained after deleting the site.

## Automatic update of roles

Role definitions can contain user/login policies with limitations that limit user access to certain sites.
To avoid the need to add the new SiteAccess to limitations for all roles,
you can decide that the roles you select are automatically updated when the site is created, updated, or deleted.

Under the `ibexa_site_factory` [configuration key](configuration.md#configuration-files), add a list of roles which should have access to the frontend when a site is created in Site Factory, for example:

``` yaml
ibexa_site_factory:
    # ...
    enabled: true
    update_roles: [Anonymous, Administrator]
```

For more information about roles and policies, see [Permissions](permissions.md).
