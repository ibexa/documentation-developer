# Extending eZ Platform UI

## Back-end interface

The back-end interface is produced by [the ezplatform-admin-ui Bundle](https://github.com/ezsystems/ezplatform-admin-ui)
together with [ezplatform-admin-ui-modules](https://github.com/ezsystems/ezplatform-admin-ui-modules),
which contains React modules that handle specific parts of the application.
This interface is accessible in your browser at `http://[uri_of_platform]/admin`.

## General extensibility

eZ Platform's back-end interface uses React-based modules that make each part of the UI easily extensible.
The interface uses Bootstrap, which facilitates adapting and styling the interface to your needs.

Available extensibility points:

- Menus (upcoming)
- [Universal Discovery module](#universal-discovery-module)
- [Sub-items list](#sub-items-list)
- [Multi-file upload](#multi-file-upload)

## Universal Discovery module

Universal Discovery module allows you to browse the content structure and search for content
using an interactive interface: the browse view and the search view.
The module is highly configurable. It can be extended with new tabs.

### How to use it?

With vanilla JS:

``` js
const container = document.querySelector('#react-udw');

ReactDOM.render(React.createElement(eZ.modules.UniversalDiscovery, {
    onConfirm: {Function},
    onCancel: {Function},
}), container);
```

With JSX:

``` jsx
const props = {
    onConfirm: {Function},
    onCancel: {Function}
};

<UniversalDiscoveryModule {...props} />
```

### Adding new tabs to the Universal Discovery module

The Universal Discovery module is highly customizable. It allows you to add new tabs to the module.

``` jsx
const props = {
    onConfirm: {Function},
    onCancel: {Function},
    extraTabs: [{
        id: {String},
        title: {String},
        panel: {Element}, // React component that represents content of a tab
        attrs: {Object}
    }]
};

<UniversalDiscoveryModule {...props} />
```

Each tab definition is an object containing properties:

- **id** _{String}_ - unique tab identifier (it cannot be: `browse` or `search`)
- **title** _{String}_ - tab button title/label
- **panel** _{Element}_ - any kind of React component. A panel component will receive the following props:
    - **isVisible** _{Boolean}_ - visible flag
    - **onItemSelect** _{Function}_ - a callback to be invoked when content is selected
    - **maxHeight** _{Number}_ - the maximum height of the panel container
    - **id** _{String}_ - panel identifier
    - **startingLocationId** _{Number}_ - location ID
    - **findLocationsByParentLocationId** _{Function}_ - finds locations related to the parent location
    - **findContentBySearchQuery** _{Function}_ - finds content matching a given text query
    - **contentTypesMap** _{Object}_ - content types map with content type ids as keys
    - **multiple** _{Boolean}_ - can select multiple content items flag
    - **labels** _{Object}_ - a hash containing text messages to be placed across many places in a component
- **attrs** {Object} - any optional list of props that should applied to the panel component.
It can override the panel props listed above.

### Property list

The `<UniversalDiscoveryModule />` module can handle additional properties.
There are 2 types of properties: **required** and **optional**.

#### Required properties

Without all the following properties the Universal Discovery module will not work.

**onConfirm** _{Function}_ - a callback to be invoked when a user clicks on the confirm button
in a Universal Discovery popup. The function takes one param: `content` which is an array of content items structs.

**onCancel** _{Function}_ - a callback to be invoked when a user clicks on the cancel button
in a Universal Discovery popup. It takes no extra params.

**restInfo** _{Function}_ - a config hash containing: token (_{String}_) and siteaccess (_{String}_).

#### Optional props

Optionally, Universal Discovery module can take a following list of props:

- **loadContentInfo** _{Function}_ - loads content info. It takes 3 params: `restInfo`, `contentId` and `callback`
- **loadContentTypes** _{Function}_ - loads content types data. It takes 2 params: `restInfo`, `callback`,
- **canSelectContent** _{Function}_ - checks whether a content item can be selected. It takes one param: `content` - the content struct,
- **findContentBySearchQuery** _{Function}_ - finds a content using a search query. It takes 3 params: `restInfo`, `query` and `callback`,
- **findLocationsByParentLocationId** _{Function}_ - finds sub items of a given location. It takes 3 params: `restInfo`, `parentLocationId` and `callback`,
- **title** _{String}_ - the title of Universal Discovery popup. Default value: `Find content`,
- **multiple** _{Boolean}_ - can select multiple content items flag. Default value: `true`,
- **activeTab** _{String}_ - active tab identifier. Default value: `browse`,
- **startingLocationId** _{Number}_ - location ID. Default value: `1`,
- **maxHeight** _{Number}_ - maximum height of panel container. Default value: `500`,
- **searchResultsPerPage** _{Number}_ - max amount of items visible per page in the search results. Default value: `10`,
- **extraTabs** _{Array}_ - optional, extra tabs. Each tab definition is an object containing the following properties (all of them are required):
    - **id** _{String}_ - unique tab identifier (it cannot be: `browse` or `search`),
    - **title** _{String}_ - tab button title/label,
    - **panel** _{Element}_ - any kind of React component,
    - **attrs** _{Object}_ - any optional list of props that should applied to the panel component.
})),
- **labels** _{Object}_ - a hash containing text messages to be placed across many places in a component. It contains text labels for child components:
    - **udw** _{Object}_ - a hash of text labels for Universal Discovery module,
    - **selectedContentItem** _{Object}_ - a hash of text labels for Selected Content Item component,
    - **contentMetaPreview** _{Object}_ - a hash of text labels for Content Meta Preview component,
    - **search** _{Object}_ - a hash of text labels for Search component,
    - **searchPagination** _{Object}_ - a hash of text labels for Search Pagination component,
    - **searchResults** _{Object}_ - a hash of text labels for Search Results component,
    - **searchResultsItem** _{Object}_ - a hash of text labels for Search Results Item component.
- **selectedItemsLimit** _{Number}_ - the limit of items that can be selected. Should be combined with the `multiple` attribute set to `true`. Default value is `0`, which means no limit.

## Sub-items List

The Sub-items List module is meant to be used as a part of the editorial interface of eZ Platform.
It provides an interface for listing the sub items of any location.

### How to use it?

With vanilla JS:

``` js
React.createElement(eZ.modules.SubItems, {
    parentLocationId: {Number},
    restInfo: {
        token: {String},
        siteaccess: {String}
    }
});
```

With JSX:

``` jsx
const attrs = {
    parentLocationId: {Number},
    restInfo: {
        token: {String},
        siteaccess: {String}
    }
};

<SubItemsModule {...attrs}/>
```

### Properties list

The `<SubItemsModule />` module can handle additional properties. There are 2 types of properties: **required** and **optional**. All of them are listed below.

#### Required props

Without all the following properties the Sub-items module will not work.

- **parentLocationId** _{Number}_ - parent location ID.
- **restInfo** _{Object}_ - backend config object:
    - **token** _{String}_ - CSRF token,
    - **siteaccess** _{String}_ - SiteAccess identifier.

#### Optional properties

Optionally, Sub-items module can take a following list of props:

- **loadContentInfo** _{Function}_ - loads content items info. Takes 2 params:
    - **contentIds** _{Array}_ - list of content IDs
    - **callback** _{Function}_ - a callback invoked when content info is loaded
- **loadContentTypes** _{Function}_ - loads content types. Takes one param:
    - **callback** _{Function}_ - callback invoked when content types are loaded
- **loadLocation** _{Function}_ - loads location. Takes 4 params:
    - **locationId** _{Number}_ - location ID
    - **limit** _{Number}_ - content items limit
    - **offset** _{Number}_ - items offset
    - **callback** _{Function}_ - callback invoked when location is loaded
- **updateLocationPriority** - updates item location priority. Takes 2 params:
    - **params** _{Object}_ - parameters hash containing:
        - **priority** _{Number}_ - priority value
        - **location** _{String}_ - REST location id
        - **token** _{String}_ - CSRF token
        - **siteaccess** _{String}_ - SiteAccess identifier
    - **callback** _{Function}_ - callback invoked when content location priority is updated
- **activeView** _{String}_ - active list view identifier
- **extraActions** _{Array}_ - list of extra actions. Each action is an object containing:
    - **component** _{Element}_ - React component class
    - **attrs** _{Object}_ - additional component properties
- **items** _{Array}_ - list of location sub items
- **limit** _{Number}_ - items limit count
- **offset** _{Number}_ - items limit offset
- **labels** _{Object}_ - list of module labels. Contains definitions for sub components:
    - **subItems** _{Object}_ - list of sub items module labels
    - **tableView** _{Object}_ - list of table view component labels
    - **tableViewItem** _{Object}_ - list of table item view component labels
    - **loadMore** _{Object}_ - list of load more component labels
    - **gridViewItem** _{Object}_ - list of grid item view component labels

## Multi-file Upload

The Multi-file Upload module is meant to be used as a part of editorial interface of eZ Platform.
It provides an interface to publish content based on dropped files while uploading them in the interface.

### How to use it?

With vanilla JS:

``` js
React.createElement(eZ.modules.MultiFileUpload, {
    onAfterUpload: {Function},
    adminUiConfig: {
        multiFileUpload: {
            defaultMappings: [{
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String},
                mimeTypes: [{String}, {String}, ...]
            }],
            fallbackContentType: {
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String}
            },
            locationMappings: [{Object}],
            maxFileSize: {Number}
        },
        token: {String},
        siteaccess: {String}
    },
    parentInfo: {
        contentTypeIdentifier: {String},
        contentTypeId: {Number},
        locationPath: {String},
        language: {String}
    }
});
```

With JSX:

``` jsx
const attrs = {
    onAfterUpload: {Function},
    adminUiConfig: {
        multiFileUpload: {
            defaultMappings: [{
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String},
                mimeTypes: [{String}, {String}, ...]
            }],
            fallbackContentType: {
                contentTypeIdentifier: {String},
                contentFieldIdentifier: {String},
                contentNameIdentifier: {String}
            },
            locationMappings: [{Object}],
            maxFileSize: {Number}
        },
        token: {String},
        siteaccess: {String}
    },
    parentInfo: {
        contentTypeIdentifier: {String},
        contentTypeId: {Number},
        locationPath: {String},
        language: {String}
    }
};

<MultiFileUploadModule {...attrs}/>
```

### Properties list

The `<MultiFileUpload />` module can handle additional properties.
There are 2 types of properties: **required** and **optional**. All of them are listed below.

#### Required properties

Without all the following properties the Multi-file Upload will not work.

- **onAfterUpload** _{Function}_ - a callback to be invoked just after a file has been uploaded
- **adminUiConfig** _{Object}_ - UI config object. It should keep the following structure:
    - **multiFileUpload** _{Object}_  - multi file upload module config:
        - **defaultMappings** _{Array}_ - a list of file type to content type mappings
        Sample mapping be an object and should follow the convention:
            - **contentTypeIdentifier** _{String}_ - Content Type identifier
            - **contentFieldIdentifier** _{String}_ - Content field identifier
            - **nameFieldIdentifier** _{String}_ - name field identifier
            - **mimeTypes** _{Array}_ - a list of file typers assigned to a specific content type
        - **fallbackContentType** _{Object}_ - a fallback content type definition. Should contain the following info:
            - **contentTypeIdentifier** _{String}_ - Content Type identifier
            - **contentFieldIdentifier** _{String}_ - Content Field identifier
            - **nameFieldIdentifier** _{String}_ - name Field identifier
        - **locationMappings** _{Array}_ - list of file type to content type mappings based on a location identifier
        - **maxFileSize** {Number} - maximum file size allowed for uploading. It's a number of bytes
    - **token** _{String}_ - CSRF token
    - **siteaccess** _{String}_ - SiteAccess identifier
- **parentInfo** _{Object}_ - parent location meta information:
    - **contentTypeIdentifier** _{String}_ - Content Type identifier
    - **contentTypeId** _{Number}_ - Content Type id
    - **locationPath** _{String}_ - location path string
    - **language** _{String}_ - language code identifier

#### Optional properties

Optionally, the Multi-file Upload module can take a following list of props:

- **checkCanUpload** _{Function}_ - checks whether am uploaded file can be uploaded. The callback takes 4 params:
    - **file** _{File}_ - file object,
    - **parentInfo** _{Object}_ - parent location meta information,
    - **config** _{Object}_ - Multi-file Upload module config,
    - **callbacks** _{Object}_ - error callbacks list: **fileTypeNotAllowedCallback** and **fileSizeNotAllowedCallback**.
- **createFileStruct** _{Function}_ - a function that creates a _ContentCreate_ struct. The function takes 2 params:
    - **file** _{File}_ - file object,
    - **params** _{Object}_ - params hash containing: **parentInfo** and **adminUiConfig** stored under the **config** key.
- **deleteFile** _{Function}_ - a function deleting Content created from a given file. It takes 3 params:
    - **systemInfo** _{Object}_ - hash containing information about CSRF token and siteaccess: **token** and **siteaccess**,
    - **struct** _{Object}_ - Content struct,
    - **callback** _{Function}_ - content deleted callback.
- **onPopupClose** _{Function}_ - function invoked when closing a Multi-file Upload popup. It takes one param: **itemsUploaded** - the list of uploaded items.
- **publishFile** _{Function}_ - publishes an uploaded file-based content item. Takes 3 params:
    - **data** _{Object}_ - an object containing information about:
        - **struct** _{Object}_ - the ContentCreate struct (),
        - **token** _{String}_ - CSRF token,
        - **siteaccess** _{String}_ - SiteAccess identifier,
    - **requestEventHandlers** _{Object}_ - a list of upload event handlers:
        - **onloadstart** _{Function}_ - on load start callback,
        - **upload** _{Object}_ - file upload events:
            - **onabort** _{Function}_ - on abort callback,
            - **onload** _{Function}_ - on load callback,
            - **onprogress** _{Function}_ - on progress callback,
            - **ontimeout** _{Function}_ - on timeout callback.
    - **callback** _{Function}_ - a callback invoked when an uploaded file-based content has been published.

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

    - `attributes` - contains the field's attributes. You can place here custom attributes for new fields, like in <https://github.com/ezsystems/ezstudio-form-builder/blob/master/bundle/Resources/config/default_fields.yml#L33>. There are also [four default attributes](https://github.com/ezsystems/ezstudio-form-builder/blob/master/lib/Core/Definition/FieldDefinition.php#L16-L19) that are used for every field: `LABEL_NAME`, `LABEL_HELP_TEXT`, `LABEL_ADMIN_LABEL` and `LABEL_PLACEHOLDER_TEXT`. If you wish, you can override them in your configuration.

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
