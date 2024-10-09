---
description: Add anchor menu to the content type configuration screen, to make Field Type settings of your choice more prominent.
---

# Add anchor menu to content type edit screen

With the anchor menu you can increase visibility of certain [Field Types](field_types.md), which provide more complex functionality, 
by separating them from the [Field definitions](content_types.md#field-definitions) section in [content type](content_types.md) configuration screen. 
One example of such Field Type would be [SEO]([[= user_doc =]]/search_engine_optimization/work_with_seo/), 
because it handles functionality that applies to all content items of the content type.
You can use the anchor menu feature with other Field Types, including [custom ones](create_custom_generic_field_type.md).

See the following example to learn how you can add a Field Type as an anchor menu.

## Modify YAML configuration

Modify the Field Type visibility under the `ibexa.system.<scope>.admin_ui_forms.content_type_edit.field_types` [configuration key](configuration.md#configuration-files):

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

- `field_type_identifier` - replace this key with an identifier of the Field Type that you want to make more prominent. In case of SEO, this key is `ibexa_seo`. 
- `meta` - when this flag is set to `true`, it separates the Field Type from the **Field definitions** section and puts it in an anchor menu
- `position` - decides about the Field Type's position on the content type edit screen and in the content item, in relation to other Field Types

Additionally, setting `meta` to `true` adds a toggle for enabling or disabling the Field Type. 
In case of SEO, it adds the **Enable SEO for this content type** toggle.
Enable the toggle to display the SEO section on the content item edit page. 

![SEO anchor menu](content_type_edit_screen_anchor_menu.png)

!!! note

    If you add multiple Field Types as anchor menus, they're automatically displayed as separate sections. 
