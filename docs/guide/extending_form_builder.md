# Extending the Form Builder

!!! enterprise

    Form Builder Bundle comes with a number of types of fields, but it is designed to be easy to extend by adding new ones.

    ## Field definitions

    Default field definitions are available in `Resources\config\default_fields.yml`.

    ### Field definition structure

    Field definitions are contained under the `fields` key. Each definition has its own key, e.g. `single_line_text`. 
    
    Each definition must contain two sections:

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

    ### Adding a new field definition

    This procedure assumes you are creating a separate Bundle to house your new type of form field.

    #### 1. Create a YAML file with field definition

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

    You can also provide additional options using the `options:` key. For example, you can make sure that the data entered in a field will not to be stored in the database, like for example in the [built-in Captcha field](https://github.com/ezsystems/ezstudio-form-builder/blob/1.1/bundle/Resources/config/default_fields.yml#L134).

    When creating a new template for the field definition, remember to add the mandatory `ezform-field` class and `field.id` as shown below: 

    ``` html
    {% extends 'EzSystemsFormBuilderBundle:fields:field.html.twig' %}
    {% block input %}
        <input type="text" class="ezform-field ..." id="{{ field.id }}" placeholder="{{ field.placeholderText }}">
    {% endblock %}
    ```

    #### 2. Modify the `DependencyInjection\TestExtension.php` class

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

    ## Validators

    ### Creating your own validators

    You can create your own validators by reproducing the following configuration:

    #### Validator configuration

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

    ## Signal slots

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

    ## Other Form Builder fields

    The following Form Builder fields require additional configuration.

    ### Date field

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

    #### Adding new date format

    If you wish to add a new date format, the `alias` in the date field config must follow this pattern:

    `d` or `D` - day of the month (1-2 digits)
    `dd` or `DD` - day of the month (2 digits)
    `m` or `M` - month of the year (1-2 digits)
    `mm` or `MM` - month (2 digits)
    `yy` or `YY` - year (2 digits)
    `yyyy` or `YYYY` - year (4 digits)

    For example:

    `d-m-yyyy` - `16-1-2017`
    `mm/dd/yy` - `01/16/17`
