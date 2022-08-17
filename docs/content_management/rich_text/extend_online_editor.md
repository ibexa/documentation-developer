---
description: Add custom tags and styles to enrich the functionality of the Online Editor.
---

# Extend Online Editor

[[= product_name =]] users edit the contents of RichText Fields, for example, 
in the Content box of a Page, by using the Online Editor.

You can extend the Online Editor by adding custom tags and styles, defining custom 
data attributes, re-arranging existing buttons, grouping buttons into custom toolbar, 
and creating [custom buttons](https://ckeditor.com/docs/ckeditor4/latest/guide/widget_sdk_tutorial_1.html#widget-toolbar-button) and [custom plugins](https://ckeditor.com/docs/ckeditor4/latest/guide/dev_plugins.html).

Online Editor is based on the CKEditor5.
Refer to [CKEditor5 documentation](https://ckeditor.com/docs/ckeditor5/latest/index.html) to learn 
how you can extend the Online Editor with even more elements.
For more information about extending the Back Office, see [Extend Back Office](back_office.md).

## Configure custom tags

With custom tags, you can enhance the Online Editor with features that go beyond the built-in ones.
You configure custom tags under the `ezrichtext` key.

Start preparing the tag by adding a configuration file: 

```yaml
[[= include_file('code_samples/back_office/online_editor/custom_tags/factbox/config/packages/custom_tags.yaml') =]]
```

Custom tags can have as many attributes as needed.
Supported attribute types are:
`string`, `number`, `boolean`, `link`, and `choice`.
The latter requires that you provide a list of choices in the `choices` key.

You must provide your own files for the Twig template and the icon.
Place the `factbox.html.twig` template in the 
`templates/themes/<your-theme>/field_type/ezrichtext/custom_tags` directory:

```html+twig
[[= include_file('code_samples/back_office/online_editor/custom_tags/factbox/templates/themes/standard/field_type/ezrichtext/custom_tags/factbox.html.twig') =]]
```

!!! tip

    If an attribute is not required, check if it is defined by adding a check 
    in the template, for example:

    ```html+twig
    {% if params.your_attribute is defined %}
        ...
    {% endif %}
    ```

Add labels for the new tag by providing translations in `translations/custom_tags.en.yaml`:

```yaml
[[= include_file('code_samples/back_office/online_editor/custom_tags/factbox/translations/custom_tags.en.yaml') =]]
```

Now you can use the tag.
In the Back Office, create or edit a Content item that has a RichText Field Type.
In the Online Editor, click **Add**, and from the list of available tags select the FactBox tag icon.

![FactBox Tag](custom_tag_factbox.png "FactBox Tag in the Online Editor")

### Inline custom tags

You can also place custom tags inline with the following configuration:

``` yaml hl_lines="6"
[[= include_file('code_samples/back_office/online_editor/custom_tags/acronym/config/packages/custom_tags.yaml', 11, 18) =]]                # ...
```

`is_inline` is an optional key.
The default value is `false`, therefore, if it is not set, the custom tag is 
treated as a block tag.

### Use cases

#### Link tag

You can configure a custom tag with a `link` attribute that offers a basic UI with text input.
It is useful when migrating from eZ Publish to [[= product_name =]].

The configuration is:

```yaml hl_lines="30-31"
[[= include_file('code_samples/back_office/online_editor/custom_tags/linktag/config/packages/custom_tags.yaml') =]]
```

Provide your own files for the Twig template and the icon.

The tag has the `url` attribute with the `type` parameter set as `link` (lines 30-31).

Then create the `templates/themes/<your-theme>/field_type/ezrichtext/custom_tags/linktag.html.twig` template:

``` html+twig
[[= include_file('code_samples/back_office/online_editor/custom_tags/linktag/templates/themes/standard/field_type/ezrichtext/custom_tags/linktag.html.twig') =]]
```

Add labels for the tag by providing translations in `translations/custom_tags.en.yaml`:

``` yaml
[[= include_file('code_samples/back_office/online_editor/custom_tags/linktag/translations/custom_tags.en.yaml') =]]
```

Now you can use the tag.
In the Back Office, create or edit a Content item that has a RichText Field Type.
In the Online Editor's toolbar, click **Show more items**, and from the list of available tags select the Link tag icon.

![Link Tag](custom_tag_link.png "Link Tag in the Online Editor") 

#### Acronym

You can create an inline custom tag that displays a hovering tooltip with an explanation of an acronym.

``` yaml
[[= include_file('code_samples/back_office/online_editor/custom_tags/acronym/config/packages/custom_tags.yaml') =]]
```

The `explanation` attribute contains the meaning of the acronym that will be provided
while editing in the Online Editor.

Add labels for the tag by providing translations in `translations/custom_tags.en.yaml`:

``` yaml
[[= include_file('code_samples/back_office/online_editor/custom_tags/acronym/translations/custom_tags.en.yaml') =]]
```

![Adding an explanation to an Acronym custom tag](oe_custom_tag_add_acronym.png)

In the template file `acronym.html.twig` provide the explanation as attribute value
to the title of the `abbr` tag:

``` html+twig
<abbr title="{{ params.explanation }}">{{ content }}</abbr>
```

![Acronym custom tag](oe_custom_tag_acronym.png)

## Configure custom styles

You can extend the Online Editor with custom text styles.
The styles are available in the text toolbar when a section of text is selected.

There are two kinds of custom styles: block and inline.
Inline styles apply to the selected portion of text only, while block styles apply to the whole paragraph.

Start creating a custom style by providing configuration:

- a global list of custom styles, defined under the node `ezrichtext.custom_styles`,
- a list of enabled custom styles for a given `admin` SiteAccess or `admin_group` SiteAccess group, located under the node `ibexa.system.<scope>.fieldtypes.ezrichtext.custom_styles`

A sample configuration could look as follows:

``` yaml
[[= include_file('code_samples/back_office/online_editor/config/packages/custom_styles.yaml') =]]
```

!!! note

    Currently, if you define these lists for a front site SiteAccess, it has no effect.

Add labels for the new styles by providing translations in `translations/custom_styles.en.yaml`:

```yaml
[[= include_file('code_samples/back_office/online_editor/translations/custom_styles.en.yaml') =]]
```

### Rendering

The `template` key points to the template that is used to render the custom style. 
It is recommended that you use the [design engine](design_engine.md).

The template files for the front end could look as follows:

- `templates/themes/standard/field_type/ezrichtext/custom_styles/highlighted_word.html.twig`:

``` html+twig
<span {% if id is defined %}id="{{ id }}"{% endif %} class="ezstyle-{{ name }}">{% apply spaceless %}{{ content|raw }}{% endapply %}</span>
```

- `templates/themes/standard/field_type/ezrichtext/custom_styles/highlighted_block.html.twig`:

``` html+twig
<div {% if id is defined %}id="{{ id }}"{% endif %} class="{% if align is defined %}align-{{ align }}{% endif %} ezstyle-{{ name }}">{% apply spaceless %}{{ content|raw }}{% endapply %}</div>
```

Templates for Content View in the Back Office would be `templates/themes/admin/field_type/ezrichtext/custom_styles/highlighted_word.html.twig` and `templates/themes/admin/field_type/ezrichtext/custom_styles/highlighted_block.html.twig` respectively (assuming that the Back Office SiteAccess uses the default `admin` theme).

### Use cases

#### Note box

You can create a custom style that places a paragraph in a note box:

![Example of a note box custom style](oe_custom_style_note_box.png)

``` yaml
[[= include_file('code_samples/back_office/online_editor/config/packages/custom_styles_note_box.yaml') =]]
```

The `note_box.html.twig` template wraps the content of the selected text 
(`{{ content }}`) in a custom CSS class:

``` html+twig
<div class="note">{{ content }}</div>
```

``` css
.note {
    display: block;
    background-color: #faa015;
    border-left: solid 5px #353535;
    line-height: 18px;
    padding: 15px;
    color: #fff;
    font-weight: bold;
}
```

Add label for the new style by providing a translation in `translations/custom_styles.en.yaml`:

``` yaml
ezrichtext.custom_styles.note_box.label: 'Note box'
```

![Adding a Note box custom style](oe_custom_style_note_box_select.png)

!!! tip

    You can also create a similar note box with [custom classes](#note-box_1).

#### Text highlight

You can create an inline custom style that highlights a part of a text:

![Example of a custom style highlighting a portion of text](oe_custom_style_highlight.png)

``` yaml
[[= include_file('code_samples/back_office/online_editor/config/packages/custom_styles_highlight.yaml') =]]
```

The `highlight.html.twig` template wraps the content of the selected text 
(`{{ content }}`) in a custom CSS class:

``` html+twig
<span class="highlight">{{ content }}</span>
```

``` css
.highlight {
    background-color: #fcc672;
    border-radius: 25% 40% 25% 40%;
}
```

Add label for the new style by providing a translation in `translations/custom_styles.en.yaml`:

``` yaml
ezrichtext.custom_styles.highlight.label: 'Highlight'
```

![Adding a Highlight custom style](oe_custom_style_highlight_select.png)

## Configure custom data attributes and classes

You can add custom data attributes and CSS classes to the following elements 
in the Online Editor:

- `embedinline`
- `embed`
- `formatted`
- `heading`
- `embedimage`
- `ul`
- `ol`
- `li`
- `paragraph`
- `table`
- `tr`
- `td`

!!! caution "Overriding embed templates"

    If you override the default templates for `embedinline`, `embed` or `embedimage` 
    elements, for example, `@IbexaCore/default/content/embed.html.twig`,
    the data attributes and classes will not be rendered automatically.

    Instead, you can make use of the `data_attributes` and `class` properties 
    in your templates.
    With the `ibexa_data_attributes_serialize` helper you can serialize the data 
    attribute array.

### Custom data attributes

You configure custom data attributes under the `fieldtypes.ibexa_fieldtype_richtext.attributes` key.
The configuration is SiteAccess-aware.

A custom data attribute can belong to one of the following types: `choice`, 
`boolean`, `string`, or `number`.
You can also set each attribute to be `required` and set its `default_value`.

For the `choice` type, you must provide an array of available `choices`.
By adding `multiple`, you can decide whether more than one option can be selected.
It is set to `false` by default.

Use the example below to add two data attributes, `custom_attribute` and 
`another_attribute` to the Heading element in the `admin_group` SiteAccess:

``` yaml
[[= include_file('code_samples/back_office/online_editor/config/packages/custom_data_attributes.yaml') =]]
```

The configuration outputs `data-ezattribute-<attribute_name>="<value>"` in the 
corresponding HTML element.
Here, the resulting values are `data-ezattribute-custom-attribute="false"` and 
`data-ezattribute-another-attribute="attr1,attr2"`.

### Custom CSS classes

You configure custom CSS classes under the `fieldtypes.ezrichtext.classes` key.
The configuration is SiteAccess-aware.

You must provide the available `choices`.
You can also set the values for `required`, `default_value` and `multiple`.
`multiple` is set to true by default.

Use the example below to add a class choice to the Paragraph element in the `admin_group` SiteAccess:

``` yaml
[[= include_file('code_samples/back_office/online_editor/config/packages/custom_classes.yaml') =]]
```
 
!!! note "Label translations"

    If there are many custom attributes, to provide label translations for these 
    attributes, you can use the `ez_online_editor_attributes` translation extractor 
    to get a full list of all custom attributes for all elements in all scopes.

    For example:

    ``` bash
    php ./bin/console translation:extract --enable-extractor=ez_online_editor_attributes
        --dir=./templates --output-dir=./translations/ --output-format=yaml
    ```

### Use cases

#### Note box

You can create a custom class that enables you to place a paragraph element in 
a note box:

![Example of a note box custom style](oe_custom_style_note_box.png)

``` yaml
[[= include_file('code_samples/back_office/online_editor/config/packages/custom_classes.yaml', 0, 8) =]] [[= include_file('code_samples/back_office/online_editor/config/packages/custom_classes.yaml', 14, 18) =]]

```

With this class you can choose one of the following classes for each paragraph 
element: `regular`, `tip_box`, or `warning_box`.
You can then style the class by using CSS.

![Selecting a custom style for a paragraph](oe_custom_class_note_box_select.png)

!!! tip

    You can also create a similar note box with [custom styles](#note-box).

## Rearrange buttons

You can modify the order and visibility of buttons that are available in the 
Online Editor toolbar through configuration:

``` yaml
[[= include_file('code_samples/back_office/online_editor/config/packages/custom_buttons.yaml') =]]
```

For each button you can set `priority`, which defines the order of buttons in 
the toolbar.

For a full list of standard buttons, see the RichText module's [configuration file](https://github.com/ibexa/richtext/blob/main/src/bundle/Resources/config/prepend/ezpublish.yaml)

## Add CKEditor plugins

Custom CKEditor plugin must be added to the `extraPlugins` array under the 
`window.ibexa.richText.CKEditor.extraPlugins` key.
For this purpose, either in the bundle's `Resources/encore/` folder, 
or in the `encore` folder in the root directory of your project, 
create the following `ibexa.richtext.config.manager.js` file:

``` js
const path = require('path');

module.exports = (ibexaConfig, ibexaConfigManager) => {
    ibexaConfigManager.add({
        ibexaConfig,
        entryName: 'ibexa-richtext-onlineeditor-js',
        newItems: ["path_to_file"],
    });
};
```

For more information, see [CKEditor plugins documentation](https://ckeditor.com/docs/ckeditor4/latest/guide/plugin_sdk_intro.html).
