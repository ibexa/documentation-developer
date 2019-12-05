# Step 8 - Add a validation

!!! tip

    You can find all files used and modified in this step on [GitHub](https://github.com/ezsystems/TweetFieldTypeBundle/tree/step8_add_a_validation_v2).

Now you will add the option to configure a list of authors whose tweets are allowed. To achieve this, you have to:

- implement `validateValidatorConfiguration()` and `validate()` methods in the Type class
- implement an additional interface in the FormMapper
- add field definition edit view
- implement `toStorageFieldDefinition()` and `toFieldDefinition()` methods in LegacyConverter

## Implement `validateValidatorConfiguration()` and `validate()` methods in the Type class

`validateValidatorConfiguration()` will be called when an instance of the Field Type is added to a Content Type,
to ensure that the validator configuration is valid.

For the validator schema configuration, add the following to `eZ/Publish/FieldType/Tweet/Type.php`:

``` php
protected $validatorConfigurationSchema = [
    'TweetValueValidator' => [
        'authorList' => [
            'type' => 'array',
            'default' => []
        ]
    ]
];
```

For a TextLine (length validation), it means checking that both minimum and maximum lengths are positive integers,
and that minimum is lower than maximum.

When an instance of the type is added to a Content Type,
`validateValidatorConfiguration()` receives the configuration for the validators used by the Type as an array.
This method must return an array of error messages if errors are found in the configuration,
and an empty array if no errors were found.

For the TextLine Field Type included in eZ Platform, an example array passed to `validateValidatorConfiguration()` method looks like this:

``` php
[
    'StringLengthValidator' => [
        'minStringLength' => 0,
        'maxStringLength' => 100
    ]
];
```

The structure of this array depends on each Field Type implementation.
The best practice is to mimic what is done in native Field Types.

Each level one key is the name of a validator, as acknowledged by the Type.
That key contains a set of parameter name / parameter value rows. You must check that:

- all the validators in this array are known to the type
- arguments for those validators are valid and have correct values

You do not need to include mandatory validators if they don't have options.
Here is an example of what the Type expects as validation configuration:

``` php
[
    'TweetValueValidator' => [
        'authorList' => ['johndoe', 'janedoe']
    ]
];
```

The configuration says that tweets must be either by `johndoe` or by `janedoe`.
If you had not provided `TweetValueValidator` at all, it would have been ignored.

You will iterate over the items in `$validatorConfiguration` and:

- add errors for validators you don't know about
- check that provided arguments are known and valid (`TweetValueValidator` accepts a non-empty array of valid Twitter usernames)

``` php
public function validateValidatorConfiguration($validatorConfiguration)
{
    $validationErrors = [];

    foreach ($validatorConfiguration as $validatorIdentifier => $constraints) {
        // Report unknown validators
        if ($validatorIdentifier !== 'TweetValueValidator') {
            $validationErrors[] = new ValidationError("Validator '$validatorIdentifier' is unknown");
            continue;
        }

        // Validate arguments from TweetValueValidator
        foreach ($constraints as $name => $value) {
            switch ($name) {
                case 'authorList':
                    if (!is_array($value)) {
                        $validationErrors[] = new ValidationError('Invalid authorList argument');
                    }
                    foreach ($value as $authorName) {
                        if (!preg_match('/^[a-z0-9_]{1,15}$/i', $authorName)) {
                            $validationErrors[] = new ValidationError('Invalid twitter username');
                        }
                    }
                    break;
                default:
                    $validationErrors[] = new ValidationError("Validator parameter '$name' is unknown");
            }
        }
    }

    return $validationErrors;
}
```

`validate()` is the method that runs the actual validation on data:

``` php
public function validate(FieldDefinition $fieldDefinition, SPIValue $fieldValue)
{
    $errors = [];

    if ($this->isEmptyValue($fieldValue)) {
        return $errors;
    }

    // Tweet URL validation
    if (!preg_match('#^https?://twitter.com/([^/]+)/status/[0-9]+$#', $fieldValue->url, $m)) {
        $errors[] = new ValidationError(
            'Invalid Twitter status URL %url%',
            null,
            ['%url%' => $fieldValue->url]
        );

        return $errors;
    }

    $author = $m[1];
    $validatorConfiguration = $fieldDefinition->getValidatorConfiguration();
    if (!$this->isAuthorApproved($author, $validatorConfiguration)) {
        $errors[] = new ValidationError(
            'Twitter user %user% is not in the approved author list',
            null,
            ['%user%' => $m[1]]
        );
    }

    return $errors;
}

private function isAuthorApproved($author, $validatorConfiguration)
{
    return !isset($validatorConfiguration['TweetValueValidator'])
        || empty($validatorConfiguration['TweetValueValidator']['authorList'])
        || in_array($author, $validatorConfiguration['TweetValueValidator']['authorList']);
}
```

Earlier you validated the URL with a regular expression.
Now, if the configuration of the Field Type's instance contains a `TweetValueValidator` key,
you will check that the username in the status URL matches one of the valid authors.

## Implement FieldDefinitionFormMapperInterface in FormMapper

Now you need to offer a way to the user to input a list of authors (upon which the data will be validated).
To achieve this, you will add additional functionality in `FormMapper` that allows you to define the necessary input field.
This is a minimal example of `eZ/Publish/FieldType/Tweet/FormMapper.php`:

```php
<?php

namespace EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet;

use EzSystems\RepositoryForms\Data\FieldDefinitionData;
use EzSystems\RepositoryForms\FieldType\FieldDefinitionFormMapperInterface;
use EzSystems\EzPlatformContentForms\FieldType\FieldValueFormMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

class FormMapper implements FieldDefinitionFormMapperInterface, FieldValueFormMapperInterface
{
    public function mapFieldDefinitionForm(FormInterface $fieldDefinitionForm, FieldDefinitionData $data)
    {
        $fieldDefinitionForm
            ->add('authorList', TextType::class, [
                'required' => false,
                'property_path' => 'validatorConfiguration[TweetValueValidator][authorList]',
                'translation_domain' => 'eztweet_fieldtype',
                'label' => 'field_definition.eztweet.authorList'
            ]);
    }

    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data)
    {
        // (...)
    }
}
```

In this case, the `TweetValueValidator` expects `authorList` to be an array.
On the other hand, the input field has TextType, so it will return a string.
To solve this, transform data from an array to a comma-separated string and the other way using a `DataTransformer`.
Create `TweetFieldTypeBundle/Form/StringToArrayTransformer.php`:

``` php
<?php

namespace EzSystems\TweetFieldTypeBundle\Form;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * DataTransformer that transforms array into comma-separated string and vice versa
 */
class StringToArrayTransformer implements DataTransformerInterface
{
    public function transform($array)
    {
        if ($array === null) {
            return '';
        }

        return implode(',', $array);
    }

    public function reverseTransform($string)
    {
        if (empty($string)) {
            return [];
        }

        return explode(',', $string);
    }
}
```

Then, you can use this `DataTransformer` in the `FormMapper` like this:

``` php
// (...)
    public function mapFieldDefinitionForm(FormInterface $fieldDefinitionForm, FieldDefinitionData $data)
    {
        $fieldDefinitionForm
            ->add(
            // Creating from FormBuilder as you need to add a DataTransformer.
                $fieldDefinitionForm->getConfig()->getFormFactory()->createBuilder()
                    ->create('authorList', TextType::class, [
                        'required' => false,
                        'property_path' => 'validatorConfiguration[TweetValueValidator][authorList]',
                        'translation_domain' => 'eztweet_fieldtype',
                        'label' => 'field_definition.eztweet.authorList'
                    ])
                    ->addModelTransformer(new StringToArrayTransformer())
                    // Deactivate auto-initialize as you're not on the root form.
                    ->setAutoInitialize(false)
                    ->getForm()
            );
    }
// (...)
```  
Next thing is to tell the system that the `FormMapper` right now works also as `FieldDefinitionFormMapper`.
In order to do that add an extra tag definition in `Resources/config/fieldtypes.yaml`:

``` yml
    ezsystems.tweetbundle.fieldtype.eztweet.form_mapper:
        class: EzSystems\TweetFieldTypeBundle\eZ\Publish\FieldType\Tweet\FormMapper
        tags:
            - {name: ezplatform.field_type.form_mapper.value, fieldType: eztweet}
            - {name: ezplatform.field_type.form_mapper.definition, fieldType: eztweet}
        arguments: ['@ezpublish.api.service.field_type']
```

## Add field definition edit view

You have the new part of the form defined, but you still need to show it to the user.
To do that, create a file containing the view, `Resources/views/platformui/content_type/edit/eztweet.html.twig`:

``` html+twig
{% block eztweet_field_definition_edit %}
    <div class="eztweet-validator author_list{% if group_class is not empty %} {{ group_class }}{% endif %}">
        {{- form_label(form.authorList) -}}
        {{- form_errors(form.authorList) -}}
        {{- form_widget(form.authorList) -}}
    </div>
{% endblock %}
```

Register the new template in the configuration by editing the `Resources/config/ez_field_templates.yaml` file:

```yml
fielddefinition_edit_templates:
    - {template: EzSystemsTweetFieldTypeBundle:platformui/content_type/edit:eztweet.html.twig, priority: 0}
```

## Implement `toStorageFieldDefinition()` and `toFieldDefinition()` methods in LegacyConverter

The last thing to do is to make sure that validation data is properly saved into and retrieved from the database.
To achieve this, implement these two functions in `eZ/Publish/FieldType/Tweet/LegacyConverter`:

```php
<?php

public function toStorageFieldDefinition(FieldDefinition $fieldDef, StorageFieldDefinition $storageDef)
{
    $storageDef->dataText1 = json_encode(
        $fieldDef->fieldTypeConstraints->validators['TweetValueValidator']['authorList']
    );
}

public function toFieldDefinition(StorageFieldDefinition $storageDef, FieldDefinition $fieldDef)
{
    $authorList = json_decode($storageDef->dataText1);
    if (!empty($authorList)) {
        $fieldDef->fieldTypeConstraints->validators = [
            'TweetValueValidator' => [
                'authorList' => $authorList
            ],
        ];
    }
}
```

`toStorageFieldDefinition()` converts a Field definition to a legacy one using the `dataText1` field
(which in this example means converting it to JSON).
`toFieldDefinition()` converts a stored legacy field definition to an API Field definition
(which means converting it back to an array according to validation schema).

You should now be able to configure a list of authors when editing a Content Type with the Tweet Field Type.
You should also have tweets validated in accordance to this list when you create or edit Content item with this Field Type.
