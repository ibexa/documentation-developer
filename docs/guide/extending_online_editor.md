# Extending the Online Editor

The Online Editor is based on [Alloy Editor](https://alloyeditor.com/).
Refer to [Alloy Editor documentation](https://alloyeditor.com/docs/develop/) to learn how to extend the Online Editor with new elements.
To learn how to extend the eZ Platform Back Office follow [Extending Admin UI tutorial](../tutorials/extending_admin_ui/extending_admin_ui).

!!! note

    Online Editor configuration works out of the box only if you have the Rich Text bundle enabled.
    If you do not, for example due to an upgrade from an earlier version,
    enable it according to the [installation guide](https://github.com/ezsystems/ezplatform-richtext#installation).

## Custom tags

Custom tags enable you to add more features to the Rich Text editor beyond the built-in ones.
They are configured under the `ezrichtext` key.

If you want to learn how to apply them to your installation follow [Creating a custom tag tutorial](../tutorials/extending_admin_ui/6_adding_a_custom_tag).

**Example: YouTube tag**

Preparation of the tag always starts with the configuration file that should be added to `app/Resources/config`. This is sample configuration for the YouTube tag, `custom_tags.yml`:

```yaml
ezpublish:
    system:
        default:
            fieldtypes:
                ezrichtext:
                    custom_tags: [ezyoutube]

ezrichtext:
    custom_tags:
        ezyoutube:
            # The template used for front-end rendering of the custom tag
            template: 'AppBundle:field_type/ezrichtext/custom_tag:ezyoutube.html.twig'
            # An icon for the custom tag as displayed in the Online Editor's toolbar.
            icon: '/assets/field_type/ezrichtext/custom_tag/icon/youtube-color.svg#youtube-color'
            attributes:
                title:
                    type: 'string'
                    required: true
                    default_value: ''
                video_url:
                    type: 'string'
                    required: true
                width:
                    type: 'number'
                    required: true
                    default_value: 640
                height:
                    type: 'number'
                    required: true
                    default_value: 360
                autoplay:
                    type: 'boolean'
                    default_value: false
                align:
                    type: 'choice'
                    required: false
                    default_value: 'left'
                    choices: ['left', 'center', 'right']
```

Remember to provide your own files for the template and the icon.
Each custom tag can have any number of attributes.
Supported attribute types are:
`string`, `number`, `boolean` and `choice` (which requires a list of choices provided by the `choices` key).

The configuration requires an `ezyoutube.html.twig` template for the custom tag that will be placed in `/Resources/views/field_type/ezrichtext/custom_tag`:

```html+twig
<div{% if params.align is defined %} style="text-align: {{ params.align }};"{% endif %}>
    <iframe type="text/html" width="{{ params.width }}" height="{{ params.height }}"
        src="{{ params.video_url|replace({'https://youtu.be/' : 'https://www.youtube.com/embed/'}) }}?autoplay={{ params.autoplay == 'true' ? 1 : 0 }}"
        frameborder="0"></iframe>
</div>
```

!!! tip

    Remember that if an attribute is not required, you need to check if it is defined in the template, for example:

    ```html+twig
    {% if params.your_attribute is defined %}
        ...
    {% endif %}
    ```

To ensure the new tag has labels, provide translations in `app/Resources/translations/custom_tags.en.yaml` file:

```yaml
ezrichtext.custom_tags.ezyoutube.label: Youtube
ezrichtext.custom_tags.ezyoutube.description: ''
ezrichtext.custom_tags.ezyoutube.attributes.autoplay.label: Autoplay
ezrichtext.custom_tags.ezyoutube.attributes.height.label: Height
ezrichtext.custom_tags.ezyoutube.attributes.title.label: Title
ezrichtext.custom_tags.ezyoutube.attributes.video_url.label: 'Video url'
ezrichtext.custom_tags.ezyoutube.attributes.width.label: Width
ezrichtext.custom_tags.ezyoutube.attributes.align.label: 'Align'
```

**Example: FactBox tag**

FactBox tag is a good example for showcasing possibilities of `ezcontent` property.
Each custom tag has an `ezcontent` property that contains the tag's main content.
This property is editable by a tab in a custom tag.

Create the `custom_tags.yml` configuration file that will be added to `app/Resources/config`. This is sample configuration for FactBox tag:

```yaml hl_lines="10"
ezpublish:
    system:
        admin_group:
            fieldtypes:
                ezrichtext:
                    custom_tags: [ezfactbox]

ezrichtext:
    custom_tags:
        ezfactbox:
            template: 'AppBundle:field_type/ezrichtext/custom_tag:ezfactbox.html.twig'
            icon: '/assets/field_type/ezrichtext/custom_tag/icon/factbox.svg#factbox'
            attributes:
                name:
                    type: 'string'
                    required: true
                style:
                    type: 'choice'
                    required: true
                    default_value: 'light'
                    choices: ['light', 'dark']
```

Remember to provide your own files for the template and the icon.
Line 10 points to `ezfactbox.html.twig` template described below.
Attributes listed below the custom tag can be set when adding the tag to a RichText Field.

The configuration requires an `ezfactbox.html.twig` template for the custom tag that will be placed in `/Resources/views/field_type/ezrichtext/custom_tag`:

```html+twig
<div class="ez-factbox ez-factbox--{{ params.style }}">
    <p>{{ params.name }}</p>
    <div>
        {{ content|raw }}
    </div>
</div>
```

!!! tip

    Remember that if an attribute is not required, you need to check if it is defined in the template, for example:

    ```twig
    {% if params.your_attribute is defined %}
        ...
    {% endif %}
    ```

To ensure the new tag has labels, provide translations in `app/Resources/translations/custom_tags.en.yaml` file:

```yaml
# ezfactbox
ezrichtext.custom_tags.ezfactbox.label: FactBox
ezrichtext.custom_tags.ezfactbox.description: ''
ezrichtext.custom_tags.ezfactbox.attributes.name.label: 'Name'
ezrichtext.custom_tags.ezfactbox.attributes.style.label: 'Style'
```

### Inline custom tags

Custom tags can also be placed inline with the following configuration:

``` yaml hl_lines="6"
ezrichtext:
    custom_tags:
        badge:
            template: 'AppBundle:field_type/ezrichtext/custom_tag:badge.html.twig'
            icon: '/bundles/ezplatformadminui/img/ez-icons.svg#bookmark'
            is_inline: true
            attributes:
                # ...
```

`is_inline` is an optional key.
The default value is `false`, so if it is not set, the custom tag will be treated as a block tag.

## Custom styles

You can extend the Online Editor with custom text styles.
The feature depends on [Alloy Editor styles](https://alloyeditor.com/docs/features/styles.html).
The styles are available in the text toolbar when a section of text is selected.

There are two kinds of custom styles: block and inline.
Inline styles apply to the selected portion of text only, while block styles apply to the whole paragraph.

### Back Office configuration

The sample configuration is as follows:

``` yaml
ezpublish:
    system:
        admin_group:
            fieldtypes:
                ezrichtext:
                    custom_styles: [highlighted_block, highlighted_word]

ezrichtext:
    custom_styles:
        highlighted_word:
            template: '@ezdesign/field_type/ezrichtext/custom_style/highlighted_word.html.twig'
            inline: true
        highlighted_block:
            template: '@ezdesign/field_type/ezrichtext/custom_style/highlighted_block.html.twig'
            inline: false
```

The system expects two kinds of configuration:

- a global list of custom styles, defined under the node `ezrichtext.custom_styles`,
- a list of enabled custom styles for a given Admin SiteAccess or Admin SiteAccess group, located under the node `ezpublish.system.<scope>.fieldtypes.ezrichtext.custom_styles`

!!! note

    Defining this list for a front site SiteAccess currently has no effect.

### Translations

Labels that appear for each custom style in the Online Editor need to be translated using Symfony translation system.
The translation domain is called `custom_styles`. For the code example above, you can do it in a `app/Resources/translations/custom_styles.en.yml` file:

```yaml
ezrichtext.custom_styles.highlighted_block.label: Highlighted block
ezrichtext.custom_styles.highlighted_word.label: Highlighted word
```

### Rendering

The `template` key points to the template used to render the custom style. It is recommended to use the [design engine](design_engine.md).

In the example above, the template files for the front end could be:

- `app/Resources/views/themes/standard/field_type/ezrichtext/custom_style/highlighted_word.html.twig`:

``` html+twig
<span class="ezstyle-{{ name }}">{% spaceless %}{{ content|raw }}{% endspaceless %}</span>
```

- `app/Resources/views/themes/standard/field_type/ezrichtext/custom_style/highlighted_block.html.twig`:

``` html+twig
<div class="{% if align is defined %}align-{{ align }}{% endif %} ezstyle-{{ name }}">{% spaceless %}{{ content|raw }}{% endspaceless %}</div>
```

Templates for Content View in the Back Office would be `app/Resources/views/themes/admin/field_type/ezrichtext/custom_style/highlighted_word.html.twig` and `app/Resources/views/themes/admin/field_type/ezrichtext/custom_style/highlighted_block.html.twig` respectively (assuming Admin SiteAccess uses the `admin` theme).

## Plugins configuration

If you develop your plugin, you need to add it to the CKEditor plugins by `add` method.
For more information, follow [Creating a CKEditor Plugin tutorial.](https://ckeditor.com/docs/ckeditor4/latest/guide/plugin_sdk_sample.html)
If you downloaded a plugin from the CKEditor, you need to include it in a page after AlloyEditor is loaded.

To enable your new CKEditor plugin in, define it in the RichText AlloyEditor Semantic Configuration.
The configuration is available at:

```yaml
ezrichtext:
    alloy_editor:
        extra_plugins: [plugin1, plugin2]
```

The name of a plugin needs to be the same as the one passed to `CKEDITOR.plugins.add` in the plugin source code.

Please keep in mind that if a plugin changes RichText input (in xhtml5/edit format for DocBook), the changes need to be supported by RichText Field Type.
For example, if a plugin adds some class to some element, you need to confirm that this class is stored when saving or publishing content (it could result in either XML validation error or could be omitted by RichText processor).

## Buttons configuration

Custom buttons can be added to your installation with the following configuration:

```yml hl_lines="4"
ezrichtext:
    alloy_editor:
        extra_buttons:
            paragraph: [buttonName1, buttonName2]
            embed: [buttonName1]
```

Under `extra_buttons` (line 4) specify to what toolbar you want to add a new button e.g. `paragraph`.
Next to that toolbar, add an array with names of custom buttons that you want to install e.g. `[buttonName1, buttonName2]`.

All new buttons should also be added to AlloyEditor under the same name that's in the configuration file.
For more information follow [AlloyEditor tutorial on creating a button](https://alloyeditor.com/docs/develop/create_buttons.html).
