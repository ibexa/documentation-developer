---
description: Configure Site Factory, including site skeletons.
---

# Site Factory configuration

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
