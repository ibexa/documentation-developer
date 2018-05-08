# Allow adding and editing the Field in Back Office

To be able to add and edit Content Item with our Field Type using Back Office, we will implement a FormMapper with FieldValueFormMapperInterface. 
DataTransformer is also needed in order to correctly transform our Value Object into single input field.

# FormMapper
``` php
<?php
// eZ/Publish/FieldType/Tweet/FormMapper.php

namespace EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet;

use EzSystems\RepositoryForms\Data\FieldDefinitionData;
use EzSystems\RepositoryForms\FieldType\FieldValueFormMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

class FormMapper implements FieldValueFormMapperInterface
{
    public function __construct(FieldTypeService $fieldTypeService)
    {
        $this->fieldTypeService = $fieldTypeService;
    }
    
    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data)
    {
        $fieldDefinition = $data->fieldDefinition;
        $formConfig = $fieldForm->getConfig();
        $names = $fieldDefinition->getNames();
        $label = $fieldDefinition->getName($formConfig->getOption('mainLanguageCode')) ?: reset($names);
        $fieldType = $this->fieldTypeService->getFieldType($fieldDefinition->fieldTypeIdentifier);
        $fieldForm
            ->add(
                $formConfig->getFormFactory()->createBuilder()
                    ->create(
                        'value',
                        TextType::class,
                        [
                            'required' => false,
                            'label' => $label
                        ]
                    )
                    // Deactivate auto-initialize as we're not on the root form.
                    ->setAutoInitialize(false)
                    ->getForm()
            );
    }
}
```

Next thing is to register the FormMapper as a service, so the system would know to use it to automatically add the input field to the Content Type edit form. You can read more about services and service container in the documentation: https://doc.ezplatform.com/en/latest/guide/service_container/. To register the FormMapper as a service, let's add the following lines to `fieldtypes.yml`:
``` yml
// Resources/config/fieldtypes.yml

    ezsystems.tweetbundle.fieldtype.eztweet.form_mapper:
        class: EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet\FormMapper
        tags:
            - {name: ez.fieldFormMapper.value, fieldType: eztweet}
        arguments: ['@ezpublish.api.service.field_type']
```

# DataTransformer

As mentioned earlier, we also need to tell our FormMapper how to transform ValueObject into a single string which contains URL to given tweet. We do this by creating an implementation of DataTransformerInterface.

``` php
<?php
// Form/TweetValueTransformer.php
namespace EzSystems\TweetFieldTypeBundle\Form;

use Symfony\Component\Form\DataTransformerInterface;
use eZ\Publish\API\Repository\FieldType;
use eZ\Publish\Core\FieldType\Value;

class TweetValueTransformer implements DataTransformerInterface
{
    /**
     * @var FieldType
     */
    private $fieldType;

    public function __construct(FieldType $fieldType)
    {
        $this->fieldType = $fieldType;
    }

    public function transform($value)
    {
        if (!$value instanceof Value) {
            return null;
        }

        return (string) $value;
    }

    public function reverseTransform($value)
    {
        return $this->fieldType->fromHash($value);
    }
}
```

Next point will be using above transformer in our FormMapper. This is doable with addModelTransformer() method. Remember to pass eZ\Publish\API\Repository\FieldType object as constructor.

``` php
// eZ/Publish/FieldType/Tweet/FormMapper.php
// (...)
                    ->setAutoInitialize(false)
                    ->addModelTransformer(new TweetValueTransformer($fieldType))
                    ->getForm()
// (...)
```  
------------------------------------------------------------------------

⬅ Previous: [Introduce a template](6_introduce_a_template.md)

Next: [Add a validation](8_add_a_validation.md) ➡
