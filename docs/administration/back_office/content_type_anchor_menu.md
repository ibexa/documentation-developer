---
description: Add anchor menu to the Content Type configuration screen, to make Field Type settings of your choice more prominent.
---

# Add anchor menu to Content Type edit screen

With the anchor menu you can promote certain [Field Types](field_types.md), which provide more complex functionality, by detaching them from the [Field definitions](content_model.md#field-definitions) section in [Content Type](content_model.md#content-types) configuration screen. 
The best example of such Field Types are [SEO]([[= user_doc =]]/search_engine_optimization/work_with_seo/) or [Taxonomy Entry Assignment]([[= user_doc =]]/content_management/taxonomy/work_with_tags/), because they handle functionalities that apply to the whole Content item.

The SEO Field Type is promoted on the Content Type edit screen by default.
See the following example to learn how to add an anchor menu for the Taxonomy Entry Assignment Field Type.

In a YAML configuration file, for example, in `config/packages/ibexa_admin_ui.yaml`, provide the following configuration:

```yaml
ibexa:
    system:
        admin_group:
            admin_ui_forms:
                content_type_edit:
                    field_types:
                        ibexa_taxonomy_entry_assignment:
                            meta: true
                            position: 100

```

Where keys have the following meaning:

- `ibexa_taxonomy_entry_assignment` - an identifier for the Field Type
- `meta` - when set to `true`, it separates the Field Type from the **Field definitions** section, puts it in an anchor menu
- `position` - decides about the Field Type's position on the Content Type edit screen and in the Content item, in relation to other Field Types

Additionally, setting `meta` to `true` adds a toggle for enabling or disabling the Field Type. In this case, it adds the **Enable Taxonomy Entry Assignment for this content type** toggle.

!!! note

    If you add multiple Field Types as anchor menus, they are automatically separated and displayed as separate sections. 