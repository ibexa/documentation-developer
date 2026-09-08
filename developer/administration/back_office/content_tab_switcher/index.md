# Tab switcher in content edit page

Tabs switcher allows separating the default field types in the content type from the field types that enhance the content with new functionalities.

Tabs switcher allows separating the default field types in the content type from the field types that enhance the content with new functionalities. The best example of such field types are SEO or Taxonomy, as these aren't typical field types but a field types that handle functionalities for the whole content object.

The following example shows how to add a Meta tab with automatically assigned Taxonomy field type.

## Add Meta tab

Before you start adding the Meta tab, make sure the content type you want to edit has [Taxonomy Entry Assignment field type](../../../../user/content_management/taxonomy/work_with_tags/index.md#add-taxonomy-entry-assignment-field-to-content-type).

Next, provide the semantic configuration under the `ibexa.system.<scope>.admin_ui_forms` [configuration key](../../configuration/configuration/index.md#configuration-files):

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

`ibexa_taxonomy_entry_assignment` - identifier for the field type

`meta` - when set to `true`, puts the declared field type in the Meta tab

![Meta tab](https://doc.ibexa.co/en/5.0/administration/img/tab_switcher.png)

### Configure field groups for Meta tab

The default configuration makes the `ibexa_taxonomy_entry_assignment` field always visible in the Meta tab in the content form. With this new feature, you can indicate what field types, previously set in the back office content type, are shown in the Meta tab section in the content form. You can automatically move all field types from Metadata group to the Meta tab in the content form.

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

![Meta tab](https://doc.ibexa.co/en/5.0/administration/img/tab_switcher_meta.png)

To disable the feature:

```yaml
ibexa:
    system:
        admin_group:
            admin_ui_forms:
                content_edit:
                    meta_field_groups_list: []
```

The `meta_field_groups_list` configuration can be overridden.

## Add custom tab

First, create an event listener in the `src/EventListener/TextAnchorMenuTabListener.php`:

```php
<?php declare(strict_types=1);

namespace App\EventListener;

use Ibexa\AdminUi\Menu\ContentEditAnchorMenuBuilder;
use Ibexa\AdminUi\Menu\Event\ConfigureMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TextAnchorMenuTabListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [ConfigureMenuEvent::CONTENT_EDIT_ANCHOR_MENU => 'onAnchorMenuConfigure'];
    }

    public function onAnchorMenuConfigure(ConfigureMenuEvent $event): void
    {
        // access anchor menu root item
        $menu = $event->getMenu();

        // if you need to access "Content" tab, use ITEM__CONTENT constant:
        $contentTab = $menu[ContentEditAnchorMenuBuilder::ITEM__CONTENT];

        // if you need to access "Meta" tab, use ITEM__META constant:
        $metaTab = $menu[ContentEditAnchorMenuBuilder::ITEM__META];

        // Adding new tab called "New tab"
        $menu->addChild('New tab', ['attributes' => ['data-target-id' => 'ibexa-edit-content-sections-new-tab']]);

        // Add second level item "2nd level item" to previously created "New tab" tab
        $menu['New tab']->addChild('2nd level item', ['attributes' => ['data-target-id' => 'ibexa-edit-content-sections-new-tab-item_2']]);
    }
}
```

A new custom tab is defined in the line 28, the line 31 defines items for the second level.

For new tabs it's also required to render its section in the content editing form. To do it, register the UI Component:

```yaml
services:
    app.custom_content_edit_tab:
        parent: Ibexa\AdminUi\Component\TwigComponent
        arguments:
            $template: '@@ibexadesign/content_type/edit/custom_tab.html.twig'
        tags:
            - { name: ibexa.twig.component, group: 'admin-ui-content-edit-sections' }
```

Finally, create the `templates/themes/admin/content_type/edit/custom_tab.html.twig` file:

```html+twig
{% extends '@ibexadesign/ui/component/anchor_navigation/section_group.html.twig' %}

{% set data_id = 'ibexa-edit-content-sections-new-tab' %}

{% block sections %}
    {% embed '@ibexadesign/ui/component/anchor_navigation/section.html.twig' %}
        {% set data_id = 'ibexa-edit-content-sections-new-tab-item_2' %}
        {% block content %}
            Contents of custom secondary section
        {% endblock %}
    {% endembed %}
{% endblock %}
```
