# Extending the Online Editor

The Online Editor is based on [Alloy Editor](https://alloyeditor.com/).
Refer to [Alloy Editor documentation](https://alloyeditor.com/docs/develop/) to learn how to extend the Online Editor with new elements.

## Custom tags

Custom tags enable you to add more features to the Rich Text editor beyond the built-in ones.

Custom tags are configured under the `ezrichtext` key (here on the example of a YouTube tag):

``` yml
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

Each custom tag can have any number of attributes. Supported attribute types are:
`string`, `number`, `boolean` and `choice` (which requires a list of choices provided by the `choices` key).

The configuration requires a Twig template for the custom tag:

``` twig
<div{% if params.align is defined %} style="text-align: {{ params.align }};"{% endif %}>
    <iframe type="text/html" width="{{ params.width }}" height="{{ params.height }}"
        src="{{ params.video_url|replace({'https://youtu.be/' : 'https://www.youtube.com/embed/'}) }}?autoplay={{ params.autoplay == 'true' ? 1 : 0 }}"
        frameborder="0"></iframe>
</div>
```

!!! tip

    Remember that if an attribute is not required, you need to check if it is defined in the template, for example:

    ``` twig
    {% if params.your_attribute is defined %}
        ...
    {% endif %}
    ```

To ensure the new tag has labels, you need to provide translations in a `app/Resources/translations/custom_tags.en.yaml` file:

``` yaml
ezrichtext.custom_tags.ezyoutube.label: Youtube
ezrichtext.custom_tags.ezyoutube.description: ''
ezrichtext.custom_tags.ezyoutube.attributes.autoplay.label: Autoplay
ezrichtext.custom_tags.ezyoutube.attributes.height.label: Height
ezrichtext.custom_tags.ezyoutube.attributes.title.label: Title
ezrichtext.custom_tags.ezyoutube.attributes.video_url.label: 'Video url'
ezrichtext.custom_tags.ezyoutube.attributes.width.label: Width
ezrichtext.custom_tags.ezyoutube.attributes.align.label: 'Align'
```
