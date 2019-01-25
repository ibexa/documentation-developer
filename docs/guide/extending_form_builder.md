# Extending Form Builder

!!! enterprise

    ## Existing Form fields

    ### Captcha field

    The Captcha Form field is based on [Gregwar/CaptchaBundle](https://github.com/Gregwar/CaptchaBundle).

    See [the bundle's documentation](https://github.com/Gregwar/CaptchaBundle#options) for information about available options.

    ## Extending Form fields

    You can extend the Form Builder by adding new form fields or modifying existing ones.
    Form fields are defined in YAML configuration.

    For example, to create a Country Form field:

    ``` yaml
    ez_platform_form_builder:
        fields:
            country:
                name: 'Country'
                category: 'Default'
                thumbnail: '/bundles/ezplatformadminui/img/ez-icons.svg#input-line'
                attributes:
                    label:
                        name: 'Display label'
                        type: 'string'
                        validators:
                            not_blank:
                                message: 'You must provide label of the field'
                    help:
                        name: 'Help text'
                        type: 'string'
                validators:
                    required: ~
    ```

    Available attribute types are:

    |Type|Description|
    |----|----|
    |`string`|String|
    |`text`|Text block|
    |`integer`|Integer number|
    |`url`|URL|
    |`multiple`|Multiple choice|
    |`select`|Dropdown|
    |`checkbox`|Checkbox|
    |`location`|Content Location|
    |`radio`|Radio button|
    |`action`|Button|
    |`choices`|List of available options|

    Each type of Form field can have validators of the following types:

    - `required`
    - `min_length`
    - `max_length`
    - `min_choices`
    - `max_choices`
    - `min_value`
    - `max_value`
    - `regex`
    - `upload_size`
    - `extensions`

    New types of fields require a mapper which implements `\EzSystems\EzPlatformFormBuilder\FieldType\Field\FieldMapperInterface`:

    ``` php
    namespace AppBundle\FormBuilder\Field\Mapper;

    use EzSystems\EzPlatformFormBuilder\FieldType\Field\Mapper\GenericFieldMapper;
    use EzSystems\EzPlatformFormBuilder\FieldType\Model\Field;

    class CountryFieldMapper extends GenericFieldMapper

    {
        /**
         * {@inheritdoc}
         */
        protected function mapFormOptions(Field $field, array $constraints): array
        {
            $options = parent::mapFormOptions($field, $constraints);
            $options['label'] = $field->getAttributeValue('label');
            $options['help'] = $field->getAttributeValue('help');
            return $options;
        }
    }
    ```

    The mapper must be registered as a service:

    ``` yaml
    services:
        # ...
        AppBundle\FormBuilder\Field\Mapper\CountryFieldMapper:
            arguments:
                $fieldIdentifier: 'country'
                $formType: 'Symfony\Component\Form\Extension\Core\Type\CountryType'
            tags:
                - { name: ezplatform.form_builder.field_mapper }
    ```

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
    use EzSystems\EzPlatformFormBuilder\Definition\FieldAttributeDefinitionBuilder;
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
                FormEvents::getFieldDefinitionEventName('single_line') => 'onSingleLineFieldDefinition'
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
    
    - `\EzSystems\EzPlatformFormBuilder\Definition\FieldDefinitionFactory` in the back end
    - global variable `eZ.formBuilder.config.fieldsConfig` in the front end
    
    ## Configure email notifications
    
    To send emails you need to configure `sender_address` in `app/config/config.yml` under `swiftmailer` key.
    It acts as a sender address and a return address where all bounced messages will be returned to.
    You can learn more by visiting [Symfony Mailer Configuration Reference.](https://symfony.com/doc/3.4/reference/configuration/swiftmailer.html#sender-address)
