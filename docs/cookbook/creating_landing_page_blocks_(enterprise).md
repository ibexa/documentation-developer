# Creating Landing Page blocks (Enterprise)

## Description

V1.2

A Landing Page has a customizable layout with multiple zones where you can place predefined blocks with content.

By default eZ Enterprise comes with a number of preset Landing Page blocks. You can, however, add custom blocks to your configuration. There are two ways to do this: the full way and an [easier, YAML-based method](#defining-landing-page-blocks-in-the-configuration-file).

## Full customization

### Block configuration

In the Demo installation the layout configuration is stored in `ezstudio-demo-bundle/Resources/config/default_layouts.yml`:

``` yaml
# Example default_layouts.yml
blocks:
    gallery:
        views:
            gallery:
                template: eZStudioDemoBundle:blocks:gallery.html.twig
                name: Default Gallery Block template
    keyword:
        views:
            keyword:
                template: eZStudioDemoBundle:blocks:keyword.html.twig
                name: Default Keyword Block template
    rss:
        views:
            rss:
                template: eZStudioDemoBundle:blocks:rss.html.twig
                name: Default RSS Block template
    tag:
        views:
            tag:
                template: eZStudioDemoBundle:blocks:tag.html.twig
                name: Default Tag Block template
```

### Creating a new block

#### Creating a class for the block

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
namespace AcmeDemoBundle\Block;

use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType;

/**
* RSS block
* Renders feed from a given URL.
*/
class RSSBlock extends AbstractBlockType
{
   // Class body
}
```

#### Describing a class definition

A block **must** have a definition set using two classes:

##### BlockAttributeDefinition

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

#### BlockDefinition

The `BlockDefinition` class describes a block:

|Attribute|Type|Definition|Note|
|------|------|------|------|
|$type|string|block type||
|$name|string|block name||
|$category|string|block category||
|$thumbnail|string|path to block thumbnail image||
|$templates|array|array of available paths of templates|Retrieved from the config file (default_layouts.yml)|
|$attributes|array|array of block attributes (objects of `BlockAttributeDefinition` class)||

When extending `AbstractBlockType` you **must** implement at least 3 methods:

##### `createBlockDefinition()`

This method must return an `EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition`  object.

Example of a Gallery block:

``` php
/**
 * Creates BlockDefinition object for block type.
 *
 * @return \EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition
 */
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

##### `getTemplateParameters(BlockValue $blockValue)`

This method returns an array of parameters to be displayed in rendered view of block. You can access them directly in a block template (e. g. via twig `{{ title }}` ).

When parameters are used in the template you call them directly without the `parameters` array name:

| Correct | Not Correct |
|---------|-------------|
| `<h1>{{ title }}</h1>` | `<h1>{{ parameters.title }}</h1>` |

Example of the `getTemplateParameters()` method implementation:

``` php
/**
* @param \EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockValue $blockValue
*
* @return array
*/
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

##### `checkAttributesStructure(array $attributes)`

This method validates the input fields for a block. You can specify your own conditions to throw the `InvalidBlockAttributeException` exception.

This `InvalidBlockAttributeException` exception has the following parameters:

| Name           | Description                                            |
|----------------|--------------------------------------------------------|
|  **blockType** |  name of a block                                       |
|  **attribute** |  name of the block's attribute which failed validation |
|  **message**   |  a short information about an error                    |
|  **previous**  |  previous exception, null by default                   |

For example:

``` php
/**
 * Checks if block's attributes are valid.
 *
 * @param array $attributes
 *
 * @throws \EzSystems\LandingPageFieldTypeBundle\Exception\InvalidBlockAttributeException
 */
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

When the class is created make sure it is added to a container.

#### Adding the class to the container

The **services.yml** file must contain info about your block class.

The description of your class must contain a tag which provides:

- tag name: `landing_page_field_type.block_type`
- tag alias: `<name of a block>`

For example:

``` yaml
acme.landing_page.block.rss:                                             # service id
       class: AcmeDemoBundle\FieldType\LandingPage\Model\Block\RSSBlock # block's class with namespace
       tags:                                                            # service definition must contain tag with
           - { name: landing_page_field_type.block_type, alias: rss}    # "landing_page_field_type.block_type" name and block name as an alias
```

### Custom editing UI

If you want to add a custom editing UI to your new block, you need to provide the code for the custom popup UI in Javascript (see the code for [eZS.ScheduleBlockView](https://github.com/ezsystems/StudioUIBundle/blob/ea683e0443bc3660e9ee25fe24e435d99e1133ff/Resources/public/js/views/blocks/ezs-scheduleblockview.js) or [eZS.TagBlockView](https://github.com/ezsystems/StudioUIBundle/blob/162d6b9b967cb549f32bc06c4405d3809d8546f0/Resources/public/js/views/blocks/ezs-tagblockview.js) for examples).

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

!!! note "Upcoming feature - multiple block templates"

    The ability to configure different templates (views) for one Landing Page block is upcoming. See [EZS-1008](https://jira.ez.no/browse/EZS-1008) to follow its progress.

### Example

#### Block Class

``` php
// TagBlock.php
<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\Block;

use EzSystems\LandingPageFieldTypeBundle\Exception\InvalidBlockAttributeException;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockAttributeDefinition;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockType;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockValue;

/**
 * Tag block
 * Renders simple HTML.
 */
class TagBlock extends AbstractBlockType implements BlockType
{
    /**
     * Returns array of parameters required to render block template.
     *
     * @param array $blockValue Block value attributes
     *
     * @return array Template parameters
     */
    public function getTemplateParameters(BlockValue $blockValue)
    {
        return ['block' => $blockValue];
    }

    /**
     * Creates BlockDefinition object for block type.
     *
     * @return \EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition
     */
    public function createBlockDefinition()
    {
        return new BlockDefinition(
            'tag',
            'Tag Block',
            'default',
            'bundles/ezsystemslandingpagefieldtype/images/thumbnails/tag.svg',
            [],
            [
                new BlockAttributeDefinition(
                    'content',
                    'Content',
                    'text',
                    '/[^\\s]/',
                    'Provide html code'
                ),
            ]
        );
    }

    /**
     * Checks if block's attributes are valid.
     *
     * @param array $attributes
     *
     * @throws \EzSystems\LandingPageFieldTypeBundle\Exception\InvalidBlockAttributeException
     */
    public function checkAttributesStructure(array $attributes)
    {
        if (!isset($attributes['content'])) {
            throw new InvalidBlockAttributeException('Tag', 'content', 'Content must be set.');
        }
    }
}
```

!!! tip "V1.7"

    If you want to make sure that your block is only available in the Element menu in a specific situation, you can override the `isAvailable` method, which makes the block accessible by default:

    ``` php
    public function isAvailable()
        {
            return true;
        }
    ```

#### service.yml configuration

``` yaml
# services.yml
ezpublish.landing_page.block.tag:
    class: EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\Block\TagBlock
    tags:
        - { name: landing_page_field_type.block_type, alias: tag }
```

#### Block template

`{{ block.attributes.content|raw }}`

## Defining Landing Page blocks in the configuration file

There is an alternative way to define/configure Landing Page block types that requires modifying the `config.yml` in an application or a bundle and using the `ez_systems_landing_page_field_type` key.

``` yaml
# example.yml
ez_systems_landing_page_field_type:
    blocks:
        new_block_name:
            initialize: true
            name: New Block Name
            category: default
            thumbnail: bundles/ezsystemslandingpageblocktemplate/images/templateblock.svg
            views:
                default:
                    template: EzSystemsLandingPageBlockTemplateBundle::template.html.twig
                    name: Default view
            attributes:
                text_field:
                    type: text
                    required: true
                    inline: false
                    values: []
                    options: []
                width:
                    type: multiple
                    regex: /[\s]/
                    regexErrorMessage: Invalid text
                    required: true
                    inline: false
                    values: [value2]
                    options:
                        value1: label1
                        value2: label2
```

Note to developers: Configuration keys have to match `BlockDefinition` and `BlockAttributeDefinition` property names.

The presented configuration is introduced to make defining blocks faster and more developer-friendly. Below you can find a few important notes:

- The `name` attribute can be omitted and values are going to be generated automatically in the following fashion: `new_value` =&gt; `New Value`
- For now `category` is not needed for blocks - it's for future purposes.
- In most cases blocks have only a single view, therefore you can define it as: `views: EzSystemsLandingPageBlockTemplateBundle::template.html.twig`.
- In case of multiple views you can omit `name` and simplify it as follows:

``` yaml
views:
    default: EzSystemsLandingPageBlockTemplateBundle::template.html.twig
    another_view: EzSystemsLandingPageBlockTemplateBundle::another_view.html.twig
```

- When defining attributes you can omit most keys as long as you use simple types:

``` yaml
attributes:
    first_field: text
    second_field: string
    third_field: integer
```

Keep in mind that other types such as `multiple`, `select`, `radio` have to utilize the `options` key.

#### Block type class and service

If parameter `intialize `is set to` true`, you no longer have to register a service associated with the new block. It will use a generic service which exposes all attribute values to the views.

You are allowed to overwrite the `ez_systems.landing_page.block.{NEW_BLOCK_IDENTIFIER}` service with your own implementation. Just make sure your class is extending the `ConfigurableBlockType` class.

Some hints regarding custom service implementation:

- do not override the `createBlockDefinition()` method unless you want to make further modifications to the `\EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition` object created from your YAML config. Do not forget to run `parent::createBlockDefinition()` to retrieve the original object.
- implement other methods such as `checkAttributesStructure()` and `getTemplateParameters()`to provide more complex validation and implement the block functionality.

#### Overwriting existing blocks

This is the way to overwrite following properties in the existing blocks:

- `thumbnail`
- `name`
- `category`
- `views`

!!! caution

    It is not possible to overwrite or add any attributes to existing blocks as there is no possibility to modify BlockType implementation, and therefore to use or display those new attributes.

`\EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType::isFinal` indicates whether the block can be overwritten by the configuration. All blocks can be overwritten by default. 

#### Test

To test the new functionality you can copy [webhdx/EzLandingPageBlockTemplateBundle](https://github.com/webhdx/EzLandingPageBlockTemplateBundle) to your codebase. A new block has been already defined in `Resources/config/blocks.yml` and you can try different options there.
