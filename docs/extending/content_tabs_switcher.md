# Add tabs switcher in Content edit

If you want to separate typical/default Fieldtypes in the Content Type from Fieldtypes that enrich the content with new functionality, you can use a tab switcher.

For example, SEO or Taxonomy, as these are not typical Fieldtypes but a fieldtypes which handle functionality for the whole Content object.
See the example below to add a Meta tab with the Tags Fieldtype.

## Add Meta tab

First, go to Admin -> Content Types and add the **Taxonomy Entry Assignment** Fieldtype to the Content Type. 

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

`ibexa_taxonomy_entry_assignment` - fieldtype identifier
`meta` - when set to `true`, puts the fieldtype in the Meta tab

The new tab with Taxonomy field in the Content Type edit mode.

## Add custom tab

First, create an EventListener in the `src/EventListener/TextAnchorMenuTabListener.php`:

``` php
[[= include_file('code_samples/back_office/content_type/src/EventListener/TextAnchorMenuTabListener.php') =]]
```


### Register the service and render

```yaml
    app.my_component:
        parent: Ibexa\AdminUi\Component\TwigComponent
        arguments:
            $template: 'my_template.html.twig'
        tags:
            - { name: ibexa.admin_ui.component, group: 'content-edit-sections' }
```

### Add template

