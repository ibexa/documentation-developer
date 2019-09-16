# Step 4 - Creating a custom tag

eZ Platform's RichText Field contains some built-in elements you can use, such as an image or a table.
You can also add custom tags that will enable you to add additional elements to RichText Fields.

In this step you will add a custom tag which will enable you to create a special note box called a Factbox.

## Configure the custom tag

First, create a file that will contain the configuration for the custom tags.
Add file `custom_tags.yaml` to `config/packages`:

``` yaml hl_lines="5 10"
ezpublish:
    system:
        default:
            fieldtypes:
                ezrichtext:
                    custom_tags: [factbox]

ezrichtext:
    custom_tags:
        factbox:
            template: field_type/ezrichtext/custom_tag/factbox.html.twig
            icon: '/bundles/ezplatformadminui/img/ez-icons.svg#warning'
            attributes:
                name:
                    type: string
                    required: true
                style:
                    type: choice
                    required: true
                    default_value: light
                    choices: [light, dark]
```

The configuration first lists all custom tags that you have in the configuration (line 5) - in this case `factbox`.
`factbox` is then configured. Line 10 points to the template used to render the tag.
Then attributes of the custom tag are listed. These attributes can be set when adding the tag to a RichText Field.

## Create a template

Next, create the template that is referred to in the configuration.
In `templates/field_type/ezrichtext/custom_tag` add the following `factbox.html.twig` file:

``` html+twig
<div class="ez-factbox ez-factbox--{{ params.style }}">
    <p>{{ params.name }}</p>
    <div>
        {{ content|raw }}
    </div>
</div>
```

## Add labels

Finally, add labels to the custom tag's editing interface.
Provide them in a `translations/custom_tags.en.yaml` file:

``` yaml
ezrichtext.custom_tags.factbox.label: FactBox
ezrichtext.custom_tags.factbox.description: ''
ezrichtext.custom_tags.factbox.attributes.name.label: Name
ezrichtext.custom_tags.factbox.attributes.style.label: Style
ezrichtext.custom_tags.factbox.attributes.style.choices.light.label: Light style
ezrichtext.custom_tags.factbox.attributes.style.choices.dark.label: Dark style
```

## Check results

!!! tip

    If you cannot see the results or encounter an error, clear the cache and reload the application.

At this point you can go to the Back Office and start editing any Content with a RichText Field (e.g. a Folder or an Article).
When you edit the Field, you can see the new tag appear in the elements menu. Add it, provide a name and select a style.
You can now edit the content of the Factbox:

![Example of a Factbox custom tag](img/custom_tag.png "Previewing a Content item with a Factbox custom tag")
