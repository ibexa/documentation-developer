# Step 2 - Define the Point2D Field Type

!!! tip

    You can find all files used and modified in this step on [GitHub]().

## The Type class

The Type contains logic of the Field Type: validating data, transforming from various formats, describing the validators, etc.
A generic Type class must implement `eZ\Publish\SPI\FieldType\Generic\Type` (*Generic Field Type interface*).
For more information about the Type class of a Field Type see [Type class](../../api/field_type_type_and_value/#type-class) 


## Identification method

First create `src/FieldType/Point2D/Type.php`.
Add a `getFieldTypeIdentifier()` method to it. The new method will return the string that **uniquely** identifies your generic Field Type, in this case `point2d`:

``` php
declare(strict_types=1);
namespace App\FieldType\Point2D;
use eZ\Publish\SPI\FieldType\Generic\Type as GenericType;
final class Type extends GenericType
{
    public function getFieldTypeIdentifier(): string
    {
        return 'point2d';
    }
}
```

## Add new class

Next, add the `ezplatform.field_type` class to `config/services.yml`:

``` yaml
services:
    ...
    App\FieldType\Point2D\Type:
        tags:
            - { name: ezplatform.field_type, alias: point2d }
```
