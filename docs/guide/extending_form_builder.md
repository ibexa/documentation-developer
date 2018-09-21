# Extending Form Builder

!!! enterprise

    You can extend the Form Builder by adding new form fields or modifying existing ones.
    Form fields are defined in YAML configuration.
    See example of the built-in Single line input:

    ``` yaml
    ez_platform_form_builder:
        fields:
            single_line:
                name: 'Single line input'
                category: 'Default'
                thumbnail: '/bundles/ezplatformadminui/img/ez-icons.svg#input-line'
                attributes:
                    label:
                        name: 'Display label'
                        type: 'string'
                        validators:
                            not_blank:
                                message: 'You must provide label of the field'
                    placeholder:
                        name: 'Placeholder'
                        type: 'string'
                    help:
                        name: 'Help text'
                        type: 'string'
                    default_value:
                        name: 'Default value'
                        type: 'string'
                validators:
                    required: ~
                    min_length: ~
                    max_length: ~
                    regex: ~
    ```

    Available attribute types are:

    - `string`
    - `choices`
    - `text`
    - `integer`
    - `url`
    - `multiple`
    - `radio`
    - `action`
    - `select`

    New types of fields require a mapper implementing `\EzSystems\EzPlatformFormBuilder\FieldType\Field\FieldMapperInterface`.
    The mapper must be registered as a service:

    ``` yaml
    services:
      AppBundle\FormBuilder\Field\Mapper\CustomFieldMapper:
        # ...
        tags:
            - { name: ezplatform.form_builder.field_mapper }
    ```

    You can find mappers for built-in fields in `vendors/ezsystems/ezplatform-form-builder/src/lib/FieldType/Field/Mapper`.

    ## Changing field and field attribute definitions dynamically

    Field or field attribute definition can be modified by subscribing to one of the following events:

    ```
    ezplatform.form_builder.field.<FIELD_ID>
    ezplatform.form_builder.field.<FIELD_ID>.<ATTRIBUTE_ID>
    ```

    The following example adds the `readonly` attribute to `single_line` field definition.

    ``` php
    namespace AppBundle\EventSubscriber;

    use EzSystems\EzPlatformFormBuilder\Event\FieldDefinitionEvent;
    use EzSystems\EzPlatformFormBuilder\Event\FieldDefinitionEvents;
    use EzSystems\EzPlatformFormBuilder\FieldType\FormBuilder\Definition\FieldAttributeDefinitionBuilder;
    use Symfony\Component\EventDispatcher\EventSubscriberInterface;

    class FieldDefinitionSubscriber implements EventSubscriberInterface
    {
        public function onFieldDefinition(FieldDefinitionEvent $event): void
        {
            $isReadOnlyAttribute = new FieldAttributeDefinitionBuilder();
            $isReadOnlyAttribute->setIdentifier('readonly');
            $isReadOnlyAttribute->setName('Field is read only');
            $isReadOnlyAttribute->setType('string');

            $definitionBuilder = $event->getDefinitionBuilder();
            $definitionBuilder->addAttribute($isReadOnlyAttribute->buildDefinition());
        }

        /**
         * {@inheritdoc}
         */
        public static function getSubscribedEvents(): array
        {
            return [
                FieldDefinitionEvents::getFieldDefinitionEventName('single_line') => 'onFieldDefinition'
            ];
        }
    }
    ```

    ``` yaml
    services:
        AppBundle\EventSubscriber\FieldDefinitionSubscriber:
            public: true
            tags:
                - kernel.event_subscriber
    ```

    ## Accessing Form field definitions

    Field definitions are accessible through:

    - `\EzSystems\EzPlatformFormBuilder\FieldType\FormBuilder\Definition\FieldDefinitionFactory` in the back end
    - global variable `eZ.formBuilder.config.fields` in the front end
