# Other extensibility

!!! enterprise

    ## Block templates

    All Landing Page blocks, both those that come out of the box and [custom ones](../cookbook/creating_landing_page_blocks_(enterprise).md), can have multiple templates. This allows you to create different styles for each block and let the editor choose them when adding the block from the UI. The templates are defined in your configuration files like in the following example, with `simplelist` and `special` being the template names:

    ``` yaml
    # app/config/block_templates.yml
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
    See [this example from the Studio Demo](https://github.com/ezsystems/ezstudio-demo-bundle/blob/master/Resources/config/default_layouts.yml#L160):

    ``` yaml
    blocks:
        collection:
            views:
                content:
                    template: eZStudioDemoBundle:blocks:collection.content.html.twig
                    name: Content List View
                    options:
                        match: [article, blog_post]
                gallery:
                    template: eZStudioDemoBundle:blocks:collection.content.html.twig
                    name: Gallery View
                    options:
                        match: [image]
    ```

    ## Extending the Form Builder

    Form Builder Bundle comes a number of types of fields, but it was designed to be easy to extend by adding new ones.

    ### Field definitions

    Default field definitions are available in `Resources\config\default_fields.yml`.

    #### Field definition structure

    Field definitions are contained under the `fields` key. Each definition has its own key, e.g. `single_line_text`. Each definition must contain two sections:

    - `identifier` - name of the definition used on the front end
    - `displayName` - name displayed in the Page mode editor in the `fields` tab

    The definition can also contain the following optional sections:

    - `validators` - defines validators that the field will use. This must contain the validator's identifier and the values that will be checked during validation, for example:

    ``` yaml
            validators:
                - { identifier: required, value: 1 }
    ```

    - `attributes` - contains the field's attributes. You can place here custom attributes for new fields. There are also four default attributes that are used for every field: `LABEL_NAME`, `LABEL_HELP_TEXT`, `LABEL_ADMIN_LABEL` and `LABEL_PLACEHOLDER_TEXT`. If you wish, you can override them in your configuration.

    - `views` - provides a list of views that will be used to display the field. At least one view must be defined, with the keys `name`, `thumbnail` and `template`, for example:

    ``` yaml
            views:
                basic:
                    name: Form Test Line Text Basic
                    thumbnail: /bundles/ezsystemsformbuilder/images/thumbnails/single_line_text/basic.svg
                    template: EzSystemsFormBuilderBundle:fields:single_line_text/basic.html.twig
    ```

    #### Adding a new field definition

    This procedure assumes you are creating a separate Bundle to house your new type of form field.

    ##### 1. Create a YAML file with field definition

    Create a YAML configuration file, e.g. `Resources\config\extended_fields.yml`, with the following code:

    ``` yaml
    fields:
        test_text:
            identifier: testLineText
            displayName: 'Test Line Text'
            validators:
                - { identifier: required, value: 1 }
            attributes:
                name: 'test line attribute'
            views:
                basic:
                    name: Form Test Line Text Basic
                    thumbnail: /bundles/ezsystemsformbuilder/images/thumbnails/single_line_text/basic.svg
                    template: EzSystemsFormBuilderBundle:fields:single_line_text/basic.html.twig
    ```

    You can also provide additional options using the `options:` key. For example, you can make sure that the data entered in a field will not to be stored in the database, like for example in the [built-in Captcha field](https://github.com/ezsystems/ezstudio-form-builder/blob/5fd44dc5419a2e969f2a17acbda794f321e5c946/bundle/Resources/config/default_fields.yml#L134).

    When creating a new template for the field definition, remember to add the mandatory `ezform-field` class and `field.id` as shown below: 

    ``` html
    {% extends 'EzSystemsFormBuilderBundle:fields:field.html.twig' %}
    {% block input %}
        <input type="text" class="ezform-field ..." id="{{ field.id }}" placeholder="{{ field.placeholderText }}">
    {% endblock %}
    ```

    ##### 2. Modify the `DependencyInjection\TestExtension.php` class

    The class must implement the` PrependExtensionInterface` interface:

    ``` php
    class TestExtension implements PrependExtensionInterface
    ```

    In the `prepend` method in `TestExtension.php` add the following lines at the end:

    ``` php
    public function prepend(ContainerBuilder $container)
        {
        ...
            $configFile = __DIR__ . '/../Resources/config/extended_fields.yml';
            $config = Yaml::parse(file_get_contents($configFile));
            $container->loadFromExtension('ez_systems_form_builder', $config);
            $container->addResource(new FileResource($configFile));    
        }
    ```

    ### Validators

    #### Creating your own validators

    You can create your own validators by reproducing the following configuration:

    ##### Validator configuration

    A validator implements the `EzSystems\FormBuilder\SPI\ValidatorInterface.php` interface and extends the abstract class `EzSystems\FormBuilder\Core\Validator\Validator.php`.

    The interface requires the implementation of the following methods:

    |Method|Returns|Parameters|Description|
    |---|---|---|---|
    |`validate`|bool|$value|Contains the logic for the validation. It returns `true` when validation is successful, or `false` when the data does not validate|
    |`getLabel`|string||Returns a string with the name of the validator that will be used in the editor
    |`getErrorMessage`|array||Returns error message(s) to appear when the `validate` method returns `false`
    |`setLimitation`|mixed $limitation|$limitation|Allows the configuration of limitations. Its default implementation is contained in the `Validator` abstract class
    |`getValueType`|string||Returns the name of the checked value type|

    Currently the abstract class `Validator` has three value types (defined in `Core\Validator\Validator.php`):

    ``` php
        const TYPE_INTEGER = 'integer';
        const TYPE_STRING = 'string';
        const TYPE_BOOL = 'bool';
    ```

    The validator must be tagged as `form_builder.field_validator`. Due to this the `Resources\config\validator_services.yml` file contains two entries, one in the `parameters` section:

    ``` yaml
    form_builder.validator.example.class: EzSystems\FormBuilder\Core\Validator\ExampleValidator
    ```

    and one in the `services` section:

    ``` yaml
    form_builder.validator.example:
            class: '%form_builder.validator.example.class%'
            tags:
                - { name: form_builder.field_validator, alias: example }
    ```

    ### Signal slots

    Whenever a form is submitted and stored in a database, `lib\Core\SignalSlot\Signal\FormSubmit` emits a signal in a `submitForm` service. You can create your own listeners, called Signal slots, to capture the FormSubmit signal.

    Below you can find an example of a custom Signal slot. It saves submission to a text file. 

    ``` php
    <?php
    namespace AppBundle\SignalSlot;
    use Symfony\Component\Filesystem\Filesystem;
    use eZ\Publish\Core\SignalSlot\Slot;
    use eZ\Publish\Core\SignalSlot\Signal;
    class HandleSubmission extends Slot
    {
        /**
         * Receive the given $signal and react on it.
         *
         * @param EzSystems\FormBuilder\Core\SignalSlot\Signal\FormSubmit $signal
         */
        public function receive(Signal $signal)
        {
            $fs = new Filesystem();
            $formId = $signal->formId;
            $submission = $signal->submission;
            $created = $submission->created->format("Y-m-d.H:i:s");
            $dataRows = [];
            foreach ($submission->fields as $field) {
                $dataRows[] = "{$field->label}: {$field->value}";
            }
            $fs->mkdir("forms/{$formId}");
            $fs->dumpFile("forms/{$formId}/{$created}.txt", implode("\n", $dataRows));
        }
    }
    ```

    It has to be registered as a tagged Symfony service, like this:

    ``` yaml
        app_bundle.handle_submission:
            class: "AppBundle\SignalSlot\HandleSubmission"
            tags:
                - { name: ezpublish.api.slot, signal: '\EzSystems\FormBuilder\Core\SignalSlot\Signal\FormSubmit' }
     
    ```

    ### Other Form Builder fields

    The following form Builder fields require additional configuration.

    #### Date field

    To make use of a datepicker in the Date field you need to add the necessary assets. The assets should be added in page head with the following code:

    ``` html
    {% javascripts
        ...
        'bundles/ezsystemsformbuilder/js/vendors/*/*.js'
    %}
        <script type="text/javascript" src="{{ asset_url }}"></script>
    {% endjavascripts %}
    ```

    ``` html
    {% stylesheets filter='cssrewrite'
        ...
        'bundles/ezsystemsformbuilder/css/vendors/*/*.css'
    %}
        <link rel="stylesheet" type="text/css" href="{{ asset_url }}">
    {% endstylesheets %}
    ```

    ##### Adding new date format

    If you wish to add a new date format, the `alias` in the date field config must follow this pattern:

    `d` or `D` - day of the month (1-2 digits)
    `dd` or `DD` - day of the month (2 digits)
    `m` or `M` - month of the year (1-2 digits)
    `mm` or `MM` - month (2 digits)
    `yy` or `YY` - year (2 digits)
    `yyyy` or `YYYY` - year (4 digits)

    for example:

    `d-m-yyyy` - `16-1-2017`
    `mm/dd/yy` - `01/16/17`

## Custom Content Type icons

The Content Type to which a Content item belongs is represented graphically using an icon near the Content item name. Essentially, the Content Types are project-specific so the icons can be easily configured and extended by integrators.

### Font icons + CSS

Icons in the PlatformUI interface are provided by an icon font. For Content Types, the idea is to expand that concept so that while generating the interface, we end up with a code similar to:

``` html
<h1 class="ez-contenttype-icon ez-contenttype-icon-folder">Folder Name</h1>
```

With such classes, the `h1` is specified to display a Content Type icon. The class `ez-contenttype-icon` makes sure the element is styled for that and gets the default Content Type icon. The second class is specific to the Content Type based on its identifier and if it's defined in one of the CSS files, the element will get the custom Content Type icon defined there.

### Adding new Content Type icons

The extensibility of Content Type icons is tackled differently depending on the use case, but it relies on the ability to embed a custom CSS file in PlatformUI with `css.yml`.

To prevent the need to configure/extend the system, we provide several pre-configured icons for very common Content Types such as:

- `product`
- `author`
- `category`
- `gallery` / `portfolio`
- `blog_post` / `blogpost` / `post`
- `blog` / `weblog`
- `news`
- `pdf`
- `document`
- `photo`
- `comment`
- `wiki`
- `wiki_page` / `wikipage`

There are three ways of choosing Content Type icons:

#### Pick an icon for a custom Content Type from existing icons

In such a case you need to pick the icon code using an icon font. In these examples we use [the Icomoon application](https://icomoon.io/app/). To ease that process and the readability of the code, we'll use ligatures in the font icon so that the CSS code for a custom Content Type could look like:

``` css
 /* in a custom CSS file included with `css.yml` */
.ez-contenttype-icon-mycontenttypeidentifier:before {
    content: "product"; /* because this icon matches the usage of such content
    items */
}
```

#### Add custom icons

If the icons we provide do not fit a custom Content Type, then a new custom icon font has to be added. To generate the icon, the Icomoon app can be used (or another icon font generation tool). Then, using a custom CSS stylesheet, this font can be included and the `ez-contenttype-icon-<content type identifier>` can be configured to use that font.

Example:

``` css
/* in a custom CSS file included with `css.yml` */
@font-face {
    font-family: 'my-icon-font';
    src:url('../../fonts/my-icon-font.eot');
    src:url('../../fonts/my-icon-font.eot?#iefix') format('embedded-opentype'),
        url('../../fonts/my-icon-font.woff') format('woff'),
        url('../../fonts/my-icon-font.ttf') format('truetype'),
        url('../../fonts/my-icon-font.svg#my-icon-font') format('svg');
    font-weight: normal;
    font-style: normal;
}
.ez-contenttype-icon-myidentifier:before {
    font-family: 'my-icon-font';
    content: "myiconcode";
}
/* repeated as many times as needed for each custom Content Type */
```

#### Completely override the icon set

The solution for this use case is very close to the previous one. A custom icon font will have to be produced, loaded with a custom CSS file, and then the `ez-contenttype-icon` style has to be changed to use that new font.

Example:

``` css
/* in a custom CSS file included with `css.yml` */
@font-face {
    font-family: 'my-icon-font';
    src:url('../../fonts/my-icon-font.eot');
    src:url('../../fonts/my-icon-font.eot?#iefix') format('embedded-opentype'),
        url('../../fonts/my-icon-font.woff') format('woff'),
        url('../../fonts/my-icon-font.ttf') format('truetype'),
        url('../../fonts/my-icon-font.svg#my-icon-font') format('svg');
    font-weight: normal;
    font-style: normal;
}
.ez-contenttype-icon:before {
    font-family: 'my-icon-font'; /* replaces ez-platformui-icomoon */
    /* no further change needed if the custom icon font uses the same
     * codes/ligatures
     */
}
```

## Custom Javascript

Custom Javascript can be added to PlatformUI using the following configuration block:

``` yaml
ez_platformui:
    system:
        default:
            javascript:
                files:
                   - '<path to js file>'
```
