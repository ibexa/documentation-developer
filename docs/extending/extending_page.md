# Creating custom Page blocks [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

To create an Example Page block, use the following YAML configuration in an application or a bundle,
under the `ezplatform_page_fieldtype` key, e.g. in `config/packages/ezplatform_page_fieldtype.yaml`:

!!! caution

    Page block configuration is not SiteAccess-aware.

``` yaml
ezplatform_page_fieldtype:
    blocks:
        example_block:
            name: Example Block
            # The group that contains the block in the Elements menu
            category: Example
            thumbnail: assets/images/ez-icons.svg#block-visible-recurring
            configuration_template: blocks/config.html.twig
            views:
                default:
                    template: blocks/template.html.twig
                    name: Default view
                    priority: -255
                special:
                    template: blocks/special_template.html.twig
                    name: Special view
                    priority: 50
            attributes:
                name:
                    type: text
                    validators:
                        not_blank:
                            message: Please provide a name
                email:
                    type: string
                    name: E-mail address
                    validators:
                        regexp:
                            options:
                                pattern: '/^\S+@\S+\.\S+$/'
                            message: Provide a valid e-mail address
                topics:
                    type: select
                    name: Select topics
                    value: value2
                    options:
                        multiple: true
                        choices:
                            'Sports': value1
                            'Culture': value2
                            'Politics': value3
```

You can define multiple views for a block, with separate templates.

`priority` defines the order of block views on the block configuration screen.
The highest number will show first on the list.

!!! tip

    Default views have a `priority` of -255.
    It's good practice to keep the value between -255 and 255.

Now, you can add your example block in the Site tab.

![Example Block](img/extending_example_page_block.png)

## Block attributes

A block has a number of attributes, each with the following properties:

|||
|----|----|
|`type`|Type of attribute.|
|`name`|The displayed name for the attribute. You can omit it, block identifier will then be used as the name.|
|`value`|The default value for the attribute.|
|`category`|The tab where the attribute is displayed in the block edit modal.|
|`validators`|Available validators are `not_blank` and `regexp`.|
|`options`|Additional options, dependent on the attribute type.|

#### Available attribute types

|Type|Description|Options|
|----|----|----|
|`integer`|Integer value|-|
|`string`|String|-|
|`url`|URL|-|
|`text`|Text block|-|
|`richtext`|Rich text block (see [creating richtext block](richtext_block.md)|-|
|`embed`|Embedded Content item|-|
|`select`|Drop-down with options to select|`choices` lists the available options</br>`multiple`, when set to true allows selecting more than one option.
|`multiple`|Checkbox(es)|`choices` lists the available options.|
|`radio`|Radio buttons|`choices` lists the available options.|
|`locationlist`|Location selection|-|
|`contenttypelist`|List of Content Types|-|
|`schedule_events`,</br>`schedule_snapshots`,</br>`schedule_initial_items`,</br>`schedule_slots`,</br>`schedule_loaded_snapshot`|Used in the Content Scheduler block|-|

When defining attributes you can omit most keys as long as you use simple types that do not require additional options:

``` yaml
attributes:
    first_field: text
    second_field: string
    third_field: integer
```

!!! tip "Hiding blocks"

    To hide a block from the block menu in Page Builder, set its `visible` property to `false`:

    ``` yaml
    example_block:
        # ...
        visible: false
    ```

#### Custom block attributes

You can create Page blocks with custom attributes.

First, define the attribute type.
You can use one of the types available in `ezplatform-page-fieldtype/src/lib/Form/Type/BlockAttribute/*`.

You can also use one of the [built-in Symfony types](https://symfony.com/doc/5.0/reference/forms/types.html), e.g. `AbstractType` for any custom type or `IntegerType` for numeric types.

To define the type, create a file `src/Block/Attribute/MyStringAttributeType.php` that contains:

``` php hl_lines="5 6 15"
<?php declare(strict_types=1);

namespace App\Block\Attribute;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MyStringAttributeType extends AbstractType
{
    public function getParent()
    {
        return TextType::class;
    }

    public function getBlockPrefix()
    {
        return 'my_string_attribute';
    }
}
```

Note that the attribute uses `AbstractType` (line 5) and `TextType` (line 6).
Adding `getBlockPrefix` (line 15) returns a unique prefix key for a custom template of the attribute.

Next, configure a template by creating a `templates/custom_form_templates.html.twig` file:

``` html+twig
{% block my_string_attribute_widget %}
    <div style='background: red'>
        <h2>My String</h2>
        {{ form_widget(form) }}
    </div>
{% endblock %}

{# more templates here #}
```

Add the template to your configuration:

``` yaml
system:
    default:
        page_builder_forms:
            block_edit_form_templates:
                - { template: custom_form_templates.html.twig, priority: 0 }
```

At this point, the attribute type configuration is complete, but it requires a mapper.
Depending on the complexity of the type, you can use a `GenericFormTypeMapper` or create your own.

For a generic mapper, add a new service definition to `config/services.yaml`:

``` yaml
 my_application.block.attribute.my_string:
        class: EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Attribute\FormTypeMapper\GenericFormTypeMapper
        arguments:
            $formTypeClass: App\Block\Attribute\MyStringAttributeType
        tags:
            - { name: ezplatform.page_builder.attribute_form_type_mapper, alias: my_string }
```

For creating your own mapper, create a class that inherits from `EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Attribute\FormTypeMapper\AttributeFormTypeMapperInterface`.
Then, register the class along with a tag by creating a `src/Block/Attribute/MyStringAttributeMapper.php` file:

``` php
<?php declare(strict_types=1);

namespace App\Block\Attribute;

use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\BlockAttributeDefinition;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\BlockDefinition;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Attribute\FormTypeMapper\AttributeFormTypeMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

class MyStringAttributeMapper implements AttributeFormTypeMapperInterface
{
    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $formBuilder
     * @param \EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\BlockDefinition $blockDefinition
     * @param \EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\BlockAttributeDefinition $blockAttributeDefinition
     * @param array $constraints
     *
     * @return \Symfony\Component\Form\FormBuilderInterface
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

The final step is to add a new service definition for your mapper to `config/services.yaml`:

``` yaml
App\Block\Attribute\MyStringAttributeMapper:
        tags:
            - { name: ezplatform.page_builder.attribute_form_type_mapper, alias: my_string }
```

Now, create a block containing your custom attribute:

``` yaml hl_lines="9 10 11 12"
ezplatform_page_fieldtype:
    blocks:
        my_block:
            name: MyBlock
            category: default
            thumbnail: images/thumbnails/my_block.svg
            views:
                default: { name: Default block layout, template: my_block.html.twig, priority: -255 }
            attributes:
                my_string_attribute:
                    type: my_string
                    name: MyString

```

## Overwriting existing blocks

You can overwrite the following properties in the existing blocks:

- `thumbnail`
- `category`
- `name`
- `views`

## Block configuration modal

The block configuration modal by default contains two tabs, Basic and Design.

In Design you can choose the view that will be used for the block and its styling.

- **Class** indicates the CSS class used for this block.
- **Style** defines the CSS rules.

You can disable the Design tab by setting `ezsettings.default.page_builder.block_styling_enabled` to `false`.
It is set to `true` by default.

#### Block modal template

The template for the configuration modal of built-in Page blocks is contained in
`vendor/ezsystems/ezplatform-page-builder/src/bundle/Resources/views/page_builder/block/config.html.twig`.

You can override it using the `configuration_template` setting:

``` yaml
ezplatform_page_fieldtype:
    blocks:
        example_block:
            name: Example Block
            configuration_template: blocks/config/template.html.twig
            # ...
```

The template can extend the default `config.html.twig` and modify its blocks.
Blocks `basic_tab_content` and `design_tab_content` correspond to the Basic and Design tabs in the modal.

The following example wraps all form fields for block attributes in an ordered list:

``` html+twig
{% extends '@EzPlatformPageBuilder/page_builder/block/config.html.twig' %}

{% block basic_tab_content %}
<div class="ez-block-config__fields">
    {{ form_row(form.name) }}
    {% if attributes_per_category['default'] is defined %}
        <ol>
        {% for identifier in attributes_per_category['default'] %}
            {% block config_entry %}
                <li>
                {{ form_row(form.attributes[identifier]) }}
                </li>
            {% endblock %}
        {% endfor %}
        </ol>
    {% endif %}
</div>
{% endblock %}
```

#### Exposing content relations from blocks

Page blocks, for example Embed block or Collection block, can embed other Content items.
Publishing a Page with such blocks creates Relations to those Content items.

When creating a custom block with embeds, you can ensure such Relations are created using the block Relation collection event.

The event is dispatched on content publication. You can hook your event listener to one of the events:

- `\EzSystems\EzPlatformPageFieldType\Event\BlockRelationEvents::COLLECT_BLOCK_RELATIONS` (`ezplatform.ezlandingpage.block.relation`)
- `ezplatform.ezlandingpage.block.relation.{blockTypeIdentifier}`

To expose relations, pass an array containing Content IDs to the `\EzSystems\EzPlatformPageFieldType\Event\CollectBlockRelationsEvent::setRelations()` method.

You don't have to keep track of Relations. If embedded Content changes, old Relations will be removed automatically.

Providing Relations will also invalidate HTTP cache for your block response in one of the related Content items changes.

#### Block render response

Block responses dispatch their response events which enables you to modify the Response object.
You can use them for example to change cache headers.

You can hook into `BlockResponseEvents` events:

- `BlockResponseEvents::BLOCK_RESPONSE` (`ezplatform.ezlandingpage.block.response`)
- `ezplatform.ezlandingpage.block.response.{blockTypeIdentifier}`

Aside from `Request` and `Response` objects it also includes `BlockContext` and `BlockValue` data.

## Block templates

All Page blocks, both those that come out of the box and custom ones, can have multiple templates. This allows you to create different styles for each block and let the editor choose them when adding the block from the UI. The templates are defined in your configuration files like in the following example, with `simplelist` and `special` being the template names:

``` yaml
blocks:
    contentlist:
        views:
            simplelist:
                template: blocks/contentlist_simple.html.twig
                name: Simple Content List
            special:
                template: blocks/contentlist_special.html.twig
                name: Special Content List
```

Some blocks can have slightly more complex configuration. An example is the Collection block, which requires an `options` key.
This key defines which Content Types can be added to it.
See [this example from the Demo](https://github.com/ezsystems/ezplatform-ee-demo/blob/master/config/packages/default_layouts.yml#L186):

``` yaml
blocks:
    collection:
        thumbnail: '/bundles/ezplatformadminui/img/ez-icons.svg#collection'
        views:
            cards:
                template: '@ezdesign/blocks/collection/cards.html.twig'
                name: 'Cards'
                options:
                    match: [article, blog_post, image, product, place]

            list:
                template: '@ezdesign/blocks/collection/list.html.twig'
                name: 'List'
                options:
                    match: [article, blog_post, image, product, place]
```

## Block definition events

The following events are available to influence Page block definition:

- `ezplatform.ezlandingpage.block.definition.{block_identifier}` is called when retrieving block definition. You can use it to influence any definition parameters. This includes the block's attributes. You can, e.g. add or remove some attributes.

!!! caution

    You need to be careful when removing block attributes. If you modify the attributes of a block used on an existing Page, an error may occur.

This event serves only to manipulate the block configuration, it does not add any logic to it.

- `ezplatform.ezlandingpage.block.definition.{block_identifier}.attribute.{block_attribute_identifier}` works like the previous event, but is called for a specific block attribute, not the whole block. You can use it to manipulate attributes, validators, etc.

The following example shows how the built-in Collection block uses events
to assign different options to an attribute of a block depending on the selected view:

``` php
<?php

class CollectionBlockListener implements EventSubscriberInterface
{
    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
           // ...
           BlockDefinitionEvents::getBlockAttributeDefinitionEventName('collection', 'locationlist') => 'onLocationListAttributeDefinition',
        ];
    }

    // ...

    /**
     * @param BlockAttributeDefinitionEvent $event
     */
    public function onLocationListAttributeDefinition(BlockAttributeDefinitionEvent $event)
    {
        $definition = $event->getDefinition();
        $configuration = $event->getConfiguration();

        $options = $definition->getOptions();
        $options['match'] = $this->getViewMatchConfiguration($configuration);

        $definition->setOptions($options);
    }

    /**
     * @param array $configuration
     *
     * @return array
     */
    private function getViewMatchConfiguration(array $configuration): array
    {
        $list = [];

        foreach ($configuration['views'] as $viewName => $viewConfig) {
            if (!isset($viewConfig['options'])
                || !isset($viewConfig['options']['match'])
                || empty($viewConfig['options']['match'])
            ) {
                $list[$viewName] = [];
                continue;
            }
            $list[$viewName] = $viewConfig['options']['match'];
        }

        return $list;
    }
}
```

### Block name translation

A practical example of how you can use the `BlockDefinitionEvents` API is translating the block name.
You can modify the `name` attribute of the Page block so that it displays a translation
in one of the defined languages.

The example uses a [Symfony Translator](https://github.com/symfony/symfony/blob/5.1/src/Symfony/Component/Translation/Translator.php) module and its `trans()` method.
The method takes three arguments: an identifier of the block name, an array of parameters,
and the domain of the translation.

Start with adding a new language package to your project.
For example, to translate your application into French, run the following command:

  `composer require ezplatform-i18n/ezplatform-i18n-fr_fr`

Then, create a translatable Page block by adding the following YAML configuration
under the `ezplatform_page_fieldtype` key:

``` yaml
ezplatform_page_fieldtype:
    blocks:
        translate_block:
            name: Translatable Block
            # The group that contains the block in the Elements menu
            category: Example
            thumbnail: assets/images/ez-icons.svg#block-visible-recurring
            views:
                default:
                    template: "@ezdesign/blocks/translate_block.html.twig"
                    name: Default view
                    priority: -255
            attributes:
                name:
                    type: text
                    validators:
                        not_blank:
                            message: Please provide a name
                email:
                    type: string
                    name: E-mail address
                    validators:
                        regexp:
                            options:
                                pattern: '/^\S+@\S+\.\S+$/'
                            message: Provide a valid e-mail address
```

Create the `templates/themes/standard/blocks` folder. 
In that folder, add a Twig template called `translate_block.html.twig`:

``` html+twig
<h1>{{ name|default('Hello stranger') }}!</h1>
```

Next, implement the logic that is responsible for label translation. 
Begin with implementing an event subscriber that listens to the block definition event. 
For example, create an `src/Event/Subscriber/TranslateBlockNameSubscriber.php` file that contains the following code:

``` php
<?php

declare(strict_types=1);

namespace App\Event\Subscriber;

use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\BlockDefinitionEvents;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\Event\BlockDefinitionEvent;
use EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Definition\Event\BlockAttributeDefinitionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class TranslateBlockNameSubscriber implements EventSubscriberInterface
{
    /** @var \Symfony\Contracts\Translation\TranslatorInterface */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BlockDefinitionEvents::getBlockDefinitionEventName('translate_block') => 'onBlockDefinition',
            BlockDefinitionEvents::getBlockAttributeDefinitionEventName('translate_block', 'name') => 'onNameAttributeDefinition'
        ];
    }

    public function onBlockDefinition(BlockDefinitionEvent $event): void
    {
        $event->getDefinition()->setName(
            $this->translator->trans('translate_block.name', [], 'translate_block')
        );
    }

    public function onNameAttributeDefinition(BlockAttributeDefinitionEvent $event): void
    {
        $event->getDefinition()->setName(
            $this->translator->trans('translate_block.attribute.name.name', [], 'translate_block')
        );
    }
}
```

Then, register a new service in the `config/services.yaml` file:

``` yaml
App\Event\Subscriber\TranslateBlockNameSubscriber:
    tags:
        - { name: event_subscriber }
```

You provide the translations of custom block labels in XLIFF files, one for the original language of the site, and one for each intended translation language.
You create the XLIFF files with an editor of your choice, for example [JMSTranslationBundle](https://github.com/schmittjoh/JMSTranslationBundle). 
The XLIFF files are stored in the `translations` directory at the root of your project.
A name of the translation file corresponds to the domain that you defined above, and the language, for example `translate_block.en.xlf` for English and `translate_block.fr.xlf` for French.

A file that contains English translations might look as follows:

``` xml
<?xml version="1.0" encoding="utf-8"?>
<xliff xmlns="urn:oasis:names:tc:xliff:document:1.2" xmlns:jms="urn:jms:translation" version="1.2">
    <file source-language="en" target-language="en" datatype="plaintext" original="not.available">
        <header>
            <tool tool-id="JMSTranslationBundle" tool-name="JMSTranslationBundle" tool-version="1.1.0-DEV"/>
        </header>
        <body>
            <trans-unit id="1ea2690f8eed8fc946f92cf94ac56b8b93e46afe" resname="translate_block.name">
                <source>My translatable block</source>
                <target state="new">My translatable block</target>
                <note>key: translate_block.name</note>
            </trans-unit>
            <trans-unit id="1ea2690f8efd8fc946f92cf94ac56b8b93e46afe" resname="translate_block.attribute.name.name">
                <source>Hello stranger</source>
                <target state="new">Hello stranger</target>
                <note>key: translate_block.attribute.name.name</note>
            </trans-unit>
        </body>
    </file>
</xliff>
```

To provide strings in French, add them in the <target> tags of the `translate_block.fr.xlf` file. For example:

``` xml
<?xml version="1.0" encoding="utf-8"?>
<xliff xmlns="urn:oasis:names:tc:xliff:document:1.2" xmlns:jms="urn:jms:translation" version="1.2">
    <file source-language="en" target-language="fr" datatype="plaintext" original="not.available">
        <header>
            <tool tool-id="JMSTranslationBundle" tool-name="JMSTranslationBundle" tool-version="1.1.0-DEV"/>
        </header>
        <body>
            <trans-unit id="1ea2690f8eecffc946f92cf94ac56b8b93e46afe" resname="translate_block.name">
                <source>My translatable block</source>
                <target state="new">Mon bloc traduisible</target>
                <note>key: translate_block.name</note>
            </trans-unit>
            <trans-unit id="1ea2690f8efd8fc912392cf94ac56b8b93e46afe" resname="translate_block.attribute.name.name">
                <source>Hello stranger</source>
                <target state="new">Bonjour étranger</target>
                <note>key: translate_block.attribute.name.name</note>
            </trans-unit>
        </body>
    </file>
</xliff>
```

After you add new files with translations, run `php bin/console cache:clear` to clear the cache.

A language to be displayed is selected automatically based on [user preferences or browser setup](../../guide/back_office_translations/#selecting-back-office-language).

!!! note "Additional information"

    For more information, see the following articles:

    - [Back office translations](../guide/back_office_translations.md)
    - [Symfony translations](https://symfony.com/doc/current/translation.html)
    - [Setting language preferences in a browser](https://www.w3.org/International/questions/qa-lang-priorities)

## Block rendering events

The following events are available to influence Page block rendering:

 - `ezplatform.ezlandingpage.block.render.pre` is called before rendering any block.
 - `ezplatform.ezlandingpage.block.render.post` is called after rendering any block.
 - `ezplatform.ezlandingpage.block.render.{block_identifier}.pre` is also called before rendering any block. This event contains the block logic (when needed).

Example of the built-in Banner block:

``` php
<?php

class BannerBlockListener implements EventSubscriberInterface
{
    /** @var \eZ\Publish\API\Repository\ContentService */
    private $contentService;

    /**
     * BannerBlockListener constructor.
     *
     * @param \eZ\Publish\API\Repository\ContentService $contentService
     */
    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    /**
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            BlockRenderEvents::getBlockPreRenderEventName('banner') => 'onBlockPreRender',
        ];
    }

    /**
     * @param \EzSystems\EzPlatformPageFieldType\FieldType\Page\Block\Renderer\Event\PreRenderEvent $event
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\NotFoundException
     * @throws \eZ\Publish\API\Repository\Exceptions\UnauthorizedException
     */
    public function onBlockPreRender(PreRenderEvent $event)
    {
        $blockValue = $event->getBlockValue();
        $renderRequest = $event->getRenderRequest();

        $parameters = $renderRequest->getParameters();

        $contentIdAttribute = $blockValue->getAttribute('contentId');
        $parameters['content'] = $this->contentService->loadContent($contentIdAttribute->getValue());

        $renderRequest->setParameters($parameters);
    }
}
```

The `onBlockPreRender` method adds `content` to `View` parameters.

- `ezplatform.ezlandingpage.block.render.{block_identifier}.post` is called after rendering a specific block. It can be used to wrap HTML output.

## Extensibility on block creation

The `customizeNewBlockNode` extension point enables you to manipulate the block preview wrapper node.
You can use it e.g. to add a custom CSS class or a custom event listener when a new block is created.

``` js
/**
     * Extension point to customize the new block HTML attributes
     *
     * @function customizeNewBlockNode
     * @param {HTMLElement} block
     * @param {Object} meta
     * @param {String} meta.blockType
     * @param {String} meta.pageLayoutIdentifier
     * @param {String} meta.zoneId
     * @returns {HTMLElement}
     */
window.eZ.pageBuilder.callbacks.customizeNewBlockNode = function (blockNode, meta) {};
```

## Extensibility on block preview update

When block preview is updated, JavaScript event `ez-post-update-blocks-preview` is fired.
You can use it to run your own JS scripts, such as reinitializing the work of a slider
or any other JS-based feature implemented inside your block preview.

``` js
(function () {
    window.document.body.addEventListener('ez-post-update-blocks-preview', () => console.log('block updated'), false);
})();
```

!!! caution "Extending Page Builder configuration"

    If your bundle overrides Page Builder configuration, the bundle must be registered *before*
    `EzPlatformPageFieldTypeBundle()` in `AppKernel.php`.

    Also, `EzPlatformPageFieldTypeBundle()` must be registered *after* `EzPlatformPageBuilderBundle()`.
    Watch out for this if you update bundles selectively:

    ```php
    new Acme\PageBuilderCustomizationBundle\AcmePageBuilderCustomizationBundle(),
    new EzSystems\EzPlatformPageBuilderBundle\EzPlatformPageBuilderBundle(),
    new EzSystems\EzPlatformPageFieldTypeBundle\EzPlatformPageFieldTypeBundle(),
    ```
