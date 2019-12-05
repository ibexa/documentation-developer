# Step 7 - Allow adding and editing the Field in Back Office

!!! tip

    You can find all files used and modified in this step on [GitHub](https://github.com/ezsystems/TweetFieldTypeBundle/tree/step7_allow_adding_and_editing_v2).

To be able to add and edit a Content item with the new Field Type using Back Office,
you will implement a `FormMapper` with `FieldValueFormMapperInterface`.
A `DataTransformer` is also needed in order to correctly transform the value object into a single input field.

## FormMapper

In `eZ/Publish/FieldType/Tweet/FormMapper.php`:

``` php
<?php
namespace EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet;

use EzSystems\EzPlatformContentForms\FieldType\FieldValueFormMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use EzSystems\EzPlatformContentForms\Data\Content\FieldData;
use eZ\Publish\Core\Repository\FieldTypeService;


class FormMapper implements FieldValueFormMapperInterface
{
    /**
     * @var FieldTypeService
     */
    private $fieldTypeService;

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
                    // Deactivate auto-initialize as you're not on the root form.
                    ->setAutoInitialize(false)
                    ->getForm()
            );
    }
}
```

Next thing is to register the `FormMapper` as a service, so the system knows to use it
to automatically add the input field to the Content Type edit form.
You can read more about [services and service container in the documentation](../../guide/service_container.md).
To register the `FormMapper` as a service, add the following lines to `Resources/config/fieldtypes.yaml`:

``` yml
    ezsystems.tweetbundle.fieldtype.eztweet.form_mapper:
        class: EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet\FormMapper
        tags:
            - {name: ezplatform.field_type.form_mapper.value, fieldType: eztweet}
        arguments: ['@ezpublish.api.service.field_type']
```

## DataTransformer

As mentioned earlier, you also need to tell the `FormMapper` how to transform the value object
into a single string which contains the URL of a given tweet.
You do this by creating an implementation of `DataTransformerInterface`.

In `Form/TweetValueTransformer.php`:

``` php
<?php
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

The next point is using the transformer in `eZ/Publish/FieldType/Tweet/FormMapper`.
This can be done with the `addModelTransformer()` method.
Remember to pass the `eZ\Publish\API\Repository\FieldType` object to it as constructor.

``` php
// (...)
    ->setAutoInitialize(false)
    ->addModelTransformer(new TweetValueTransformer($fieldType))
    ->getForm()
// (...)
```
