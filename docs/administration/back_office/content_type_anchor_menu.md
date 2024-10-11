---
description: Add anchor menu to the content type configuration screen, to make field type settings of your choice more prominent.
---

# Add anchor menu to content type edit screen

With the anchor menu you can increase visibility of certain [field types](field_types.md), which provide more complex functionality, 
by separating them from the [field definitions](content_types.md#field-definitions) section in [content type](content_types.md) configuration screen. 
One example of such field type would be [SEO]([[= user_doc =]]/search_engine_optimization/work_with_seo/), 
because it handles functionality that applies to all content items of the content type.
You can use the anchor menu feature with other field types, including [custom ones](create_custom_generic_field_type.md).

See the following example to learn how you can add a field type as an anchor menu.

## Modify YAML configuration

Modify the field type visibility under the `ibexa.system.<scope>.admin_ui_forms.content_type_edit.field_types` [configuration key](configuration.md#configuration-files):

```yaml
ibexa:
    system:
        admin_group:
            admin_ui_forms:
                content_type_edit:
                    field_types:
                        <field_type_identifier>:
                            meta: true
                            position: 100

```

Where keys have the following meaning:

- `field_type_identifier` - replace this key with an identifier of the field type that you want to make more prominent. In case of SEO, this key is `ibexa_seo`. 
- `meta` - when this flag is set to `true`, it separates the field type from the **Field definitions** section and puts it in an anchor menu
- `position` - decides about the field type's position on the content type edit screen and in the content item, in relation to other field types

Additionally, setting `meta` to `true` adds a toggle for enabling or disabling the field type. 
In case of SEO, it adds the **Enable SEO for this content type** toggle.
Enable the toggle to display the SEO section on the content item edit page. 

![SEO anchor menu](content_type_edit_screen_anchor_menu.png)

!!! note

    If you add multiple field types as anchor menus, they're automatically displayed as separate sections. 
