# Step 6 - Introduce a template

!!! tip

    You can find all files used and modified in this step on [GitHub](https://github.com/ezsystems/TweetFieldTypeBundle/tree/step6_introduce_a_template_v2).

In order to display data of the Field Type from templates, you need to create and register a template for it.

!!! tip

    See documentation about [Field Type templates](../../api/field_type_form_and_template.md) and about [importing configuration from a bundle](../../guide/bundles.md#importing-configuration-from-a-bundle).

In short, such a template must:

- extend `EzPublishCoreBundle::content_fields.html.twig`
- define a dedicated Twig block for the type, named by convention `<TypeIdentifier_field>`, in this case, `eztweet_field`
- be registered in parameters

## `eztweet.html.twig` template

The first thing to do is create the template. It will define the default display of a tweet.
Remember that [Field Type templates can be overridden](../../guide/twig_functions_reference.md#override-a-field-template-block) in order to tweak what is displayed and how.

Each Field Type template receives a set of variables that can be used to achieve the desired goal.
The variable important in this case is `field`, an instance of `eZ\Publish\API\Repository\Values\Content\Field`.
In addition to its own metadata (`id`, `fieldDefIdentifier`, etc.), it exposes the Field Value (`Tweet\Value`) through the `value` property.

A basic template (`TweetFieldTypeBundle/Resources/views/fields/eztweet.html.twig`) is:

``` html+twig
{% block eztweet_field %}
    {% apply spaceless %}
        {{ field.value.contents|raw }}
    {% endapply %}
{% endblock %}
```

`field.value.contents` is piped through the `raw` twig operator, since the variable contains HTML code.
Without it, the HTML markup would be visible directly, because Twig escapes variables by default.
Notice that the code is nested within a `apply spaceless` tag, so that you can format the template in a readable manner
without jeopardizing the display with unwanted spaces.

### Using the content field helpers

Even though the above will work just fine, a few helpers will enable you to get something a bit more flexible.
The [EzPublishCoreBundle::content_fields.html.twig](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig) template,
where the native Field Type templates are implemented, provides a few helpers: `simple_block_field`, `simple_inline_field` and `field_attributes`.
The first two are used to display a Field either as a block or inline.
`field_attributes` makes it easier to use the `attr` variable that contains additional (HTML) attributes for the field.

Let's try to display the value as a block element.

First, you need to make the template inherit from `content_fields.html.twig`.
Then, create a `field_value` variable that will be used by the helper to print out the content inside the markup.
The helper will use `field_attributes` to add the HTML attributes to the generated `div`.

``` html+twig
{% extends "EzPublishCoreBundle::content_fields.html.twig" %}

{% block eztweet_field %}
    {% apply spaceless %}
        {% set field_value %}
            {{ field.value.contents|raw }}
        {% endset %}
        {{ block( 'simple_block_field' ) }}
    {% endapply %}
{% endblock %}
```

`fieldValue` is set to the markup you had above, using a `{% set %}` block.
You then call the `block` function to process the `simple_block_field` template block.

## Registering the template

As explained in the [FieldType template documentation](../../api/field_type_form_and_template.md#registering-your-template), a Field Type template needs to be registered in the eZ Platform semantic configuration.

To make sure the configuration is part of the bundle and no manual configuration is required,
you need to make the bundle extend the eZ Platform semantic configuration.

To do so, you are going to make the bundle's dependency injection extension (`DependencyInjection/EzSystemsTweetFieldTypeExtension.php`)
implement `Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface`.
This interface will let you prepend bundle configuration:

``` php
<?php

use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Yaml\Yaml;

class EzSystemsTweetFieldTypeExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        $config = Yaml::parse(file_get_contents(__DIR__.'/../Resources/config/ez_field_templates.yml'));
        $container->prependExtensionConfig('ezpublish', $config);
    }
}
```

Next, provide the template mapping in `Resources/config/ez_field_templates.yml`:

``` yml
system:
    default:
        field_templates:
            - {template: EzSystemsTweetFieldTypeBundle:fields:eztweet.html.twig, priority: 0}
```

Notice that you do not need to provide the `ezpublish` YAML block here.
This is because you already import the configuration under the `ezpublish` namespace in the `prepend` method.
