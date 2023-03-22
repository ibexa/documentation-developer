---
description: Add anchor menu to the Content Type configuration screen, to make Field Type settings of your choice more prominent.
---

# Add anchor menu to Content Type edit screen

With the anchor menu you can increase visibility of certain [Field Types](field_types.md), which provide more complex functionality, by separating them from the [Field definitions](content_model.md#field-definitions) section in [Content Type](content_model.md#content-types) configuration screen. 
The two examples of such Field Types would be [SEO]([[= user_doc =]]/search_engine_optimization/work_with_seo/) or [Taxonomy Entry Assignment]([[= user_doc =]]/content_management/taxonomy/work_with_tags/), because they handle functionalities that apply to all Content items of the Content Type, but you can use this feature with [custom Field Types](create_custom_generic_field_type.md).

The SEO Field Type is promoted on the Content Type edit screen by default.
See the following example to learn how you can add a Field Type as an anchor menu.

## Modify YAML configuration

In a YAML configuration file, for example, in `config/packages/ibexa_admin_ui.yaml`, add:

```yaml
ibexa:
    system:
        admin_group:
            admin_ui_forms:
                content_type_edit:
                    field_types:
                        field_type_identifier:
                            meta: true
                            position: 100

```

Where keys have the following meaning:

- `field_type_identifier` - replace with an identifier of the Field Type that you want to make more prominent. In case of SEO, this key is `ibexa_seo`. 
- `meta` - when this flag is set to `true`, it separates the Field Type from the **Field definitions** section and puts it in an anchor menu
- `position` - decides about the Field Type's position on the Content Type edit screen and in the Content item, in relation to other Field Types

Additionally, setting `meta` to `true` adds a toggle for enabling or disabling the Field Type. 
In case of SEO, it adds the **Enable SEO for this content type** toggle.
Enable the toggle to display the SEO section on the Content item edit page. 

!!! note

    If you add multiple Field Types as anchor menus, they are automatically separated and displayed as separate sections. 