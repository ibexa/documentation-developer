# Field Type template

## Defining your Field Type template

You need to define a **template containing a block** dedicated to the Field display in order to be used by [`ez_render_field()` Twig helper](../guide/twig_functions_reference.md#ez_render_field). Only with it it can be correctly displayed.

This block consists of a piece of template receiving specific variables you can use to make the display vary.

You will find examples with built-in Field Types in [EzPublishCoreBundle/Resources/views/content\_fields.html.twig](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig)

**Template for a Field Type with `myfieldtype` identifier**

``` twig
{% block myfieldtype_field %}
{# Your code here #}
{% endblock %}
```

By convention, your block **must** be named `<fieldTypeIdentifier>_field`.

## Exposed variables

| Name | Type | Description |
|------|------|-------------|
| field | `eZ\Publish\API\Repository\Values\Content\Field` | The field to display |
| contentInfo | `eZ\Publish\API\Repository\Values\Content\ContentInfo` | The ContentInfo to which the field belongs to |
| versionInfo | `eZ\Publish\API\Repository\Values\Content\VersionInfo` | The VersionInfo to which the field belongs to |
| fieldSettings | mixed | Settings of the field (depends on the Field Type) |
|parameters | hash | Options passed to `ez_render_field()` under the parameters key |
|attr | hash | The attributes to add the generate the HTML markup. Contains at least a class entry, containing <fieldtypeidentifier>-field |

## Reusing blocks

To ease Field Type template development, you can take advantage of all defined blocks by using the [block() function](http://twig.sensiolabs.org/doc/functions/block.html).

You can for example use `simple_block_field`, `simple_inline_field` or `field_attributes` blocks provided in [content\_fields.html.twig](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig#L413).

!!! caution

    To be able to reuse built-in blocks, **your template must inherit from `EzPublishCoreBundle::content_fields.html.twig`**.

## Registering your template

To make your template available, you must register it in the system.

**app/config/ezplatform.yml**

``` yaml
ezpublish:
    system:
        my_siteaccess:
            field_templates:
                -
                    template: "AcmeTestBundle:fields:my_field_template.html.twig"
                    # Priority is optional (default is 0). The higher it is, the higher your template gets in the list.
                    priority: 10
```

You can define these rules in a dedicated file instead of `app/config/ezplatform.yml`. Read the [cookbook recipe to learn more about it](../cookbook/importing_settings_from_a_bundle.md).

