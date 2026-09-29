# Page block attributes

Page blocks can contain multiple attributes, of both built-in and custom types.

Editions: Experience

A block has attributes that the editor fills in when adding the block to a Page.

> **Caution: Clear the persistence cache**
>
> Persistence cache must be cleared after any modifications have been made to the block config in Page Builder, such as adding, removing or altering the page blocks, block attributes, validators or views configuration.
>
> To clear the persistence cache, run `php bin/console cache:pool:clear <cache-pool>` command. The default cache pool is named `cache.tagaware.filesystem`. The default cache pool when running Redis or Valkey is named `cache.redis`. If you have customized the [persistence cache configuration](../../../infrastructure_and_maintenance/cache/persistence_cache/index.md#what-is-cached), the name of your cache pool might be different.
>
> In prod mode, you also need to clear the symfony cache by running `./bin/console c:c`. In dev mode, the Symfony cache is rebuilt automatically.

Each block can have the following properties:

| Attribute    | Description                                                                                                                                                                               |
| ------------ | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `type`       | Attribute type.                                                                                                                                                                           |
| `name`       | (Optional) The displayed name for the attribute. You can omit it, block identifier is then used as the name. Translatable using the `ibexa_page_builder_block_config` translation domain. |
| `value`      | (Optional) The default value for the attribute.                                                                                                                                           |
| `category`   | (Optional) The tab where the attribute is displayed in the block edit modal.                                                                                                              |
| `validators` | (Optional) [Validators](../page_block_validators/index.md) checking the attribute value.                                                |
| `options`    | (Optional) Additional options, dependent on the attribute type.                                                                                                                           |

## Block attribute types

The following attribute types are available:

| Type                                                                                                            | Description                                                                                                                                     | Options                                                                                                                                                                                                                                   |
| --------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `integer`                                                                                                       | Integer value                                                                                                                                   | -                                                                                                                                                                                                                                         |
| `string`                                                                                                        | String                                                                                                                                          | -                                                                                                                                                                                                                                         |
| `url`                                                                                                           | URL                                                                                                                                             | -                                                                                                                                                                                                                                         |
| `text`                                                                                                          | Text block                                                                                                                                      | -                                                                                                                                                                                                                                         |
| `richtext`                                                                                                      | Rich text block (see [creating RichText block](../../rich_text/create_custom_richtext_block/index.md)) | -                                                                                                                                                                                                                                         |
| `embed`                                                                                                         | Embedded content item                                                                                                                           | `udw_config_name`: name of the [Universal Discovery Widget's configuration](../../../administration/back_office/browser/browser/index.md#add-new-configuration)                                                                |
| `embedvideo`                                                                                                    | Embedded content item                                                                                                                           | `udw_config_name`: name of the [Universal Discovery Widget's configuration](../../../administration/back_office/browser/browser/index.md#add-new-configuration)                                                                |
| `select`                                                                                                        | Drop-down with options to select                                                                                                                | - `choices` lists the available options in `label: value` form - `multiple`, when set to true, allows selecting more than one option                                                                                                      |
| `checkbox`                                                                                                      | Checkbox                                                                                                                                        | Selects available option if `value: true`. Checkbox appearance in block configuration forms [can be configured](#configure-checkbox-appearance)                                                                                           |
| `multiple`                                                                                                      | Checkbox(es)                                                                                                                                    | `choices` lists the available options in `label: value` form.                                                                                                                                                                             |
| `radio`                                                                                                         | Radio buttons                                                                                                                                   | `choices` lists the available options in `label: value` form.                                                                                                                                                                             |
| `locationlist`                                                                                                  | Location selection                                                                                                                              | `udw_config_name`: name of the [Universal Discovery Widget's configuration](../../../administration/back_office/browser/browser/index.md#add-new-configuration)                                                                |
| `contenttypelist`                                                                                               | List of content types                                                                                                                           | -                                                                                                                                                                                                                                         |
| `schedule_events`, `schedule_snapshots`, `schedule_initial_items`, `schedule_slots`, `schedule_loaded_snapshot` | Used in the Content Scheduler block                                                                                                             | -                                                                                                                                                                                                                                         |
| `nested_attribute`                                                                                              | Defines a group of attributes in a block.                                                                                                       | - `attributes` - a list of attributes in the group. The attributes in the group are [configured](#page-block-attributes) as regular attributes - `multiple`, when set to true. New groups are added dynamically with the **+ Add** button |

When you define attributes, you can omit most keys as long as you use simple types that don't require additional options:

```yaml
attributes:
    first_field: text
    second_field: string
    third_field: integer
```

The `embed`, `embedvideo`, and `locationlist` attribute types use the Universal Discovery Widget (UDW). When creating a block with these types you can use the `udw_config_name` option to configure the UDW behavior. See the [custom block example](../create_custom_page_block/index.md#configure-block) to learn more.

## Custom attribute types

You can create custom attribute type to add to Page blocks.

A custom attribute requires attribute type class, a mapper and a template.

### Block attribute type

First, create the attribute type class.

It can extend one of the types available in `fieldtype-page/src/lib/Form/Type/BlockAttribute/`. You can also use one of the [built-in Symfony types](https://symfony.com/doc/7.4/reference/forms/types.html), for example `AbstractType` for any custom type or `IntegerType` for numeric types.

To define the type, create a `src/Block/Attribute/MyStringAttributeType.php` file:

```php
<?php declare(strict_types=1);

namespace App\Block\Attribute;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MyStringAttributeType extends AbstractType
{
    #[\Override]
    public function getParent(): ?string
    {
        return TextType::class;
    }

    #[\Override]
    public function getBlockPrefix(): string
    {
        return 'my_string_attribute';
    }
}
```

The attribute uses `AbstractType` (line 5) and `TextType` (line 6). Adding `getBlockPrefix` (line 15) returns a unique prefix key for a custom template of the attribute.

### Mapper

At this point, the attribute type configuration is complete, but it requires a mapper. Depending on the complexity of the type, you can use a `GenericFormTypeMapper` or create your own.

#### Generic mapper

For a generic mapper, add a new service definition to `config/services.yaml`:

```yaml
services:
    my_application.block.attribute.my_string:
        class: Ibexa\FieldTypePage\FieldType\Page\Block\Attribute\FormTypeMapper\GenericFormTypeMapper
        arguments:
            $formTypeClass: App\Block\Attribute\MyStringAttributeType
        tags:
            - { name: ibexa.page_builder.form_type_attribute.mapper, alias: my_string }
```

#### Custom mapper

To use a custom mapper, create a class that inherits from `Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Attribute\FormTypeMapper\AttributeFormTypeMapperInterface`, for example in `src/Block/Attribute/MyStringAttributeMapper.php`:

```php
<?php declare(strict_types=1);

namespace App\Block\Attribute;

use Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Attribute\FormTypeMapper\AttributeFormTypeMapperInterface;
use Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockAttributeDefinition;
use Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockDefinition;
use Symfony\Component\Form\FormBuilderInterface;

class MyStringAttributeMapper implements AttributeFormTypeMapperInterface
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $formBuilder
     * @param \Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockDefinition $blockDefinition
     * @param \Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockAttributeDefinition $blockAttributeDefinition
     * @param array $constraints
     *
     * @return \Symfony\Component\Form\FormBuilderInterface
     *
     * @throws \Exception
     */
    public function map(
        FormBuilderInterface $formBuilder,
        BlockDefinition $blockDefinition,
        BlockAttributeDefinition $blockAttributeDefinition,
        array $constraints = []
    ): FormBuilderInterface {
        return $formBuilder->create(
            'value',
            MyStringAttributeType::class,
            [
                'constraints' => $constraints,
            ]
        );
    }
}
```

Then, add a new service definition for your mapper to `config/services.yaml`:

```yaml
    App\Block\Attribute\MyStringAttributeMapper:
            tags:
                - { name: ibexa.page_builder.form_type_attribute.mapper, alias: my_string }
```

### Edit templates

Next, configure a template for the attribute edit form by creating a `templates/themes/admin/custom_form_templates.html.twig` file:

```html+twig
{% block my_string_attribute_widget %}
    <h2>My String</h2>
    {{ form_widget(form) }}
{% endblock %}
```

Add the template to your configuration under the `system.<scope>.page_builder_forms` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    system:
        default:
            page_builder_forms:
                block_edit_form_templates:
                    - { template: '@ibexadesign/custom_form_templates.html.twig', priority: 0 }
```

### Custom attribute configuration

Now, you can create a block containing your custom attribute:

```yaml
ibexa_fieldtype_page:
    blocks:
        my_block:
            name: MyBlock
            category: default
            thumbnail: /bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#edit
            views:
                default: 
                    name: Default block layout
                    template: '@ibexadesign/blocks/my_block.html.twig'
                    priority: -255
            attributes:
                my_string_attribute:
                    type: my_string
                    name: MyString
```

### Nested attribute configuration

The `nested_attribute` attribute is used when you want to create a group of attributes.

First, make sure you have configured the attributes you want to use in the group.

Next, provide the configuration. See the example:

```yaml
ibexa_fieldtype_page:
    blocks:
        block_name:
            category: default
            thumbnail: 'path/icons.svg'
            views:
                default: { name: 'Default block layout', template: 'template.html.twig', priority: -255 }
            attributes:
                group:
                    name: Group name
                    type: nested_attribute
                    options:
                        attributes:
                            attribute_1:
                                name: Name 1
                                type: string
                            attribute_2:
                                name: Name 2
                                type: string
                        multiple: true
```

To set validation for each nested attribute:

```yaml
                    name: Group name
                    type: nested_attribute
                    options:
                        attributes:
                            attribute_1:
                                name: Name 1
                                type: string
                                validators:
                                    not_blank:
                                        message: 'Provide a value'
```

Validators can be also set on a parent attribute (group defining level), it means all validators apply to each nested attribute:

```yaml
                    name: Group name
                    type: nested_attribute
                    options:
                        attributes:
                            attribute_1:
                                name: Name 1
                                type: string
                             attribute_2:
                                name: Name 2
                                type: string
                        multiple: true
                    validators:
                        not_blank:
                            message: 'Provide a value'
```

> **Caution: Moving attributes between groups**
>
> If you move an attribute between groups or add an ungrouped attribute to a group, the block values are removed.

## Help messages for form fields

With the `help`, `help_attr`, and `help_html` field options, you can define help messages for fields in the Page block.

You can set options with the following configuration:

```yaml
ibexa_fieldtype_page:
    blocks:
        block_name:
            attributes:
                attribute_name:
                    options:
                        help:
                            text: 'Some example text'
                            html: true|false
                            attr:
                                class: 'class1 class2'
```

- `help.text` - defines a help message which is rendered below the field (maps to [`help`](https://symfony.com/doc/7.4/reference/forms/types/form.html#help))
- `help.attr` - sets the HTML attributes for the element which displays the help message (maps to [`help_attr`](https://symfony.com/doc/7.4/reference/forms/types/form.html#help-attr))
- `help.html` - enable (default) / disable (set to `true`) escaping the contents of the `help.text` option when rendering in the template (maps to [`help_html`](https://symfony.com/doc/7.4/reference/forms/types/form.html#help-html))

### Help message in nested attributes

You can set the options for root or nested attribute, see the example configuration:

```yaml
ibexa_fieldtype_page:
    blocks:
        slider:
            category: default
            thumbnail: '/bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#edit'
            views:
                default: { name: 'Default block layout', template: 'themes/blocks/slider.html.twig', priority: -255 }
            attributes:
                group:
                    name: Group name
                    type: nested_attribute
                    options:
                        help:
                            text: 'Root class text'
                            html: true # true|false
                            attr:
                                class: 'root-class-1 root-class-2'
                        attributes:
                            integer:
                                name: Age
                                type: integer
                                validators:
                                    not_blank:
                                        message: 'Provide a value'
                                options:
                                    help:
                                        text: 'Nested attribute text'
                                        html: true
                                        attr:
                                            class: 'nested-1 nested-2'
                            string:
                                name: Name
                                type: string
                                validators:
                                    not_blank:
                                        message: 'Provide a value'
```

![Help message](https://doc.ibexa.co/en/5.0/content_management/img/page_block_help_message.png "Help message")

## Configure checkbox appearance

For blocks with an attribute of `checkbox` type, you can change the look of the checkbox in block configuration forms.

You can do it by adding the `block_prefix: block_configuration_attribute_checkbox_toggle` option in the block configuration as follows:

```yaml
<attribute_identifier>:
    name: <name>
    type: checkbox
    options:
        block_prefix: block_configuration_attribute_checkbox_toggle
```

This setting changes the checkbox appearance to a toggle widget.

![Toggle widget](https://doc.ibexa.co/en/5.0/content_management/img/toggle_widget.png)

If you remove the above setting from the configuration, the attribute reverts to the default checkbox appearance.
