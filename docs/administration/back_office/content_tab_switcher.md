# Tab switcher in Content edit page

Tabs switcher allows separating the default Field Types in the Content Type from the Field Types that enhance the content with new functionalities.
The best example of such Field Types are SEO or Taxonomy, as these are not typical Field Types but a Field Types that handle functionalities for the whole Content object.

The following example shows how to add a Meta tab with automatically assigned Taxonomy Field Type.

## Add Meta tab

Before you start adding the Meta tab, make sure the Content Type you want to edit has [Taxonomy Entry Assignment Field Type]([[= user_doc =]]/taxonomy/#assign-tag-to-content-from-taxonomy-tree).

Next, provide the semantic configuration:

```yaml
ibexa:
    system:
        admin_group:
            admin_ui_forms:
                content_edit:
                    fieldtypes:
                        ibexa_taxonomy_entry_assignment:
                            meta: true

```

`ibexa_taxonomy_entry_assignment` - identifier for the Field Type

`meta` - when set to `true`, puts the declared Field Type in the Meta tab

![Meta tab](tab_switcher.png)


### Configure Field groups for Meta tab

The default configuration makes the `ibexa_taxonomy_entry_assignment` Field always visible in the Meta tab in the Content form. 
With this new feature, you can indicate what Field types, previously set in the Back Office Content Type, are shown in the Meta tab section in the Content form. 
You can automatically move all Field types from Metadata group to the Meta tab in the Content form.
To do it, use the following configuration:

```yaml
ibexa:
    system:
        admin_group:
            admin_ui_forms:
                content_edit:
                    meta_field_groups_list:
                       - metadata

```

![Meta tab](tab_switcher_meta.png)

To disable the feature:

```yaml
ibexa:
    system:
        admin_group:
            admin_ui_forms:
                content_edit:
                    meta_field_groups_list: []
```


The `meta_field_groups_list` configuration can be easily overriden.

## Add custom tab

First, create an event listener in the `src/EventListener/TextAnchorMenuTabListener.php`:

``` php hl_lines="28 31"
[[= include_file('code_samples/back_office/content_type/src/EventListener/TextAnchorMenuTabListener.php') =]]
```

A new custom tab is defined in the line 28, the line 31 defines items for the second level.

For new tabs it is also required to render its section in the Content editing form. To do it, register the UI Component:

```yaml
[[= include_file('code_samples/back_office/content_type/config/custom_services.yaml') =]]
```

Finally, create the `templates/theme/admin/content_type/edit/custom_tab.html.twig` file:

``` html+twig
[[= include_file('code_samples/back_office/content_type/templates/themes/admin/content_type/edit/custom_tab.html.twig') =]]
```
