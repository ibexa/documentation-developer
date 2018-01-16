# Creating Landing Page blocks (Enterprise)

A Landing Page has a customizable layout with multiple zones where you can place predefined blocks with content.

By default eZ Enterprise comes with a number of preset Landing Page blocks. You can, however, add custom blocks to your configuration. There are two ways to do this: the full way and an [easier, YAML-based method](#defining-landing-page-blocks-in-the-configuration-file).

## Block Class

The class for the block must implement the `BlockType` interface:

``` php
EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockType
```

Most methods are implemented in a universal way by using the `AbstractBlockType` abstract class:

``` php
EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType
```

If your block does not have specific attributes or a structure, you can extend the `AbstractBlockType` class, which contains simple generic converters designated for the block attributes.

For example:

``` php
<?php
namespace AcmeBundle\Block;

use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType;

class ExampleBlock extends AbstractBlockType
{
   // Class body
}
```

### Class definition

A block **must** have a definition set using two classes:

#### BlockDefinition

The `BlockDefinition` class describes a block:

|Attribute|Type|Definition|
|------|------|------|
|$type|string|block type|
|$name|string|block name|
|$category|string|block category|
|$thumbnail|string|path to block thumbnail image|
|$templates|array|array of available paths of templates</br>See [Block templates](#block-templates) below|
|$attributes|array|array of block attributes (objects of `BlockAttributeDefinition` class)|

#### BlockAttributeDefinition

The `BlockAttributeDefinition` class defines the attributes of a block:

|Attribute|Type|Definition|
|------|------|------|
|`$id`|string|block attribute ID|
|`$name`|string|block attribute name|
|`$type`|string|block attribute type, available options are:</br>`integer`</br>`string`</br>`url`</br>`text`</br>`embed`</br>`select`</br>`multiple`</br>`radio`|
|`$regex`|string|block attribute regex used for validation|
|`$regexErrorMessage`|string|message displayed when regex does not match|
|`$required`|bool|`TRUE` if attribute is required|
|`$inline`|bool|indicates whether block attribute input should be rendered inline in a form|
|`$values`|array|array of chosen values|
|`$options`|array|array of available options|

### Class methods

When extending `AbstractBlockType` you **must** implement at least 3 methods:

#### `createBlockDefinition()`

This method must return an `EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition` object.

Example of the built-in Gallery block:

``` php
public function createBlockDefinition()
{
    return new BlockDefinition(
        'gallery',
        'Gallery Block',
        'default',
        'bundles/ezsystemslandingpagefieldtype/images/thumbnails/gallery.svg',
        [],
        [
            new BlockAttributeDefinition(
                'contentId',
                'Folder',
                'embed',
                '/^([a-zA-Z]:)?(\/[a-zA-Z0-9_\/-]+)+\/?/',
                'Choose an image folder'
            ),
        ]
    );
}
```

#### `getTemplateParameters(BlockValue $blockValue)`

This method returns an array of parameters to be displayed in rendered view of block. You can access them directly in a block template (e. g. via twig `{{ title }}` ).

When parameters are used in the template you call them directly without the `parameters` array name:

| Correct | Not Correct |
|---------|-------------|
| `<h1>{{ title }}</h1>` | `<h1>{{ parameters.title }}</h1>` |

`getTemplateParameters()` method implementation using the example of the built-in RSS block:

``` php
public function getTemplateParameters(BlockValue $blockValue)
{
    $attributes = $blockValue->getAttributes();
    $limit = (isset($attributes['limit'])) ? $attributes['limit'] : 10;
    $offset = (isset($attributes['offset'])) ? $attributes['offset'] : 0;
    $parameters = [
        'title' => $attributes['title'],
        'limit' => $limit,
        'offset' => $offset,
        'feeds' => $this->RssProvider->getFeeds($attributes['url']),
    ];

    return $parameters;
}
```

#### `checkAttributesStructure(array $attributes)`

This method validates the input fields for a block. You can specify your own conditions to throw the `InvalidBlockAttributeException` exception.

This `InvalidBlockAttributeException` exception has the following parameters:

| Name           | Description                                            |
|----------------|--------------------------------------------------------|
|  `blockType` |  name of a block                                       |
|  `attribute` |  name of the block's attribute which failed validation |
|  `message`   |  a short information about an error                    |
|  `previous`  |  previous exception, null by default                   |

For example to validate an RSS block:

``` php
public function checkAttributesStructure(array $attributes)
{
    if (!isset($attributes['url'])) {
        throw new InvalidBlockAttributeException('RSS', 'url', 'URL must be set.');
    }

    if (isset($attributes['limit']) && (($attributes['limit'] < 1) || (!is_numeric($attributes['limit'])))) {
        throw new InvalidBlockAttributeException('RSS', 'limit', 'Limit must be a number greater than 0.');
    }

    if (isset($attributes['offset']) && (($attributes['offset'] < 0) || (!is_numeric($attributes['limit'])))) {
        throw new InvalidBlockAttributeException('RSS', 'offset', 'Offset must be a number no less than 0.');
    }
}
```

## Adding the class to the container

The **services.yml** file must contain info about your block class.

The description of your class must contain a tag which provides:

- tag name: `landing_page_field_type.block_type`
- tag alias: `<name of a block>`

For example:

``` yaml
# service id
acme.block.example:
    # block's class with namespace
    class: AcmeBundle\Block\ExampleBlock
    tags:
        # service definition must contain tag with
        # "landing_page_field_type.block_type" name and block name as an alias
        - { name: landing_page_field_type.block_type, alias: example}
```

## Block templates

The templates for the new blocks are configured in your YAML config.

``` yaml
blocks:
    example:
        views:
            test:
                template: AcmeBundle:blocks:example.html.twig
                name: Example Block View
```

## Example

For a full working example of creating a new Landing Page block, see [step 4 of the Enterprise tutorial](../tutorials/enterprise_beginner/4_creating_a_custom_block.md).

!!! tip

    If you want to make sure that your block is only available in the Element menu in a specific situation, you can override the `isAvailable` method, which makes the block accessible by default:

    ``` php
    public function isAvailable()
        {
            return true;
        }
    ```


## Custom editing UI

If you want to add a custom editing UI to your new block, you need to provide the code for the custom popup UI in Javascript (see the code for `ezs-scheduleblockview.js` or `ezs-tagblockview.js` in the StudioUIBundle in your installation for examples).

Once it is ready, create a plugin for `eZS.LandingPageCreatorView` that makes a use of the `addBlock` public method from `eZS.LandingPageCreatorView`, see the example below:

``` php
YUI.add('ezs-addcustomblockplugin', function (Y) {
    'use strict';

    var namespace = 'Any.Namespace.Of.Your.Choice',

    Y.namespace(namespace);
    NS = Y[namespace];

    NS.Plugin.AddCustomBlock = Y.Base.create('addCustomBlockPlugin', Y.Plugin.Base, [], {
        initializer: function () {
            this.get('host').addBlock('custom', NS.CustomBlockView);
        },
    }, {
        NS: 'dashboardPlugin'
    });

    Y.eZ.PluginRegistry.registerPlugin(
        NS.Plugin.AddCustomBlock, ['landingPageCreatorView']
    );
});
```

## Defining Landing Page blocks in the configuration file

There is a faster and simpler way to create Landing Page block types
using only the YAML configuration in an application or a bundle, under the `ez_systems_landing_page_field_type` key.

``` yaml
ez_systems_landing_page_field_type:
    blocks:
        example_block:
            initialize: true
            name: Example Block
            category: default
            thumbnail: bundles/ezsystemslandingpageblocktemplate/images/templateblock.svg
            views:
                default:
                    template: blocks/template.html.twig
                    name: Default view
                special:
                    template: blocks/special_template.html.twig
                    name: Special view
            attributes:
                handle:
                    type: text
                    regex: /[\s]/
                    regexErrorMessage: Invalid text
                    required: true
                    inline: false
                    values: []
                    options: []
                flavor:
                    type: multiple
                    required: true
                    inline: false
                    values: [value2]
                    options:
                        value1: vanilla
                        value2: chocolate
```

!!! tip

    Configuration keys have to match `BlockDefinition` and `BlockAttributeDefinition` property names.

Below you can find a few important notes:

- You can omit the `name` attribute. Values are going to be generated automatically in the following fashion: `new_value` =&gt; `New Value`
- `category` is not in use - it will be implemented in the future.
- In most cases blocks have only a single view, therefore you can define it as: `views: EzSystemsLandingPageBlockTemplateBundle::template.html.twig`.
- In case of multiple views you can omit `name` and simplify it as follows:

``` yaml
views:
    default: blocks/template.html.twig
    special: blocks/special_template.html.twig
```

- When defining attributes you can omit most keys as long as you use simple types:

``` yaml
attributes:
    first_field: text
    second_field: string
    third_field: integer
```

Keep in mind that other types such as `multiple`, `select`, `radio` have to use the `options` key.

#### Block type class and service

If `intialize` is set to` true`, you no longer have to register a service associated with the new block.
It will use a generic service which exposes all attribute values to the views.

You can overwrite the `ez_systems.landing_page.block.{NEW_BLOCK_IDENTIFIER}` service with your own implementation.
Just make sure your class extends the `ConfigurableBlockType` class.

Some hints regarding custom service implementation:

- do not override the `createBlockDefinition()` method unless you want to make further modifications to the `\EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition` object created from your YAML config. Do not forget to run `parent::createBlockDefinition()` to retrieve the original object.
- implement other methods such as `checkAttributesStructure()` and `getTemplateParameters()` to provide more complex validation and implement the block functionality.

#### Overwriting existing blocks

You can overwrite following properties in the existing blocks:

- `thumbnail`
- `name`
- `category`
- `views`

!!! caution

    It is not possible to overwrite or add any attributes to existing blocks as there is no possibility to modify BlockType implementation, and therefore to use or display those new attributes.

`\EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType::isFinal` indicates whether the block can be overwritten by the configuration. All blocks can be overwritten by default. 
