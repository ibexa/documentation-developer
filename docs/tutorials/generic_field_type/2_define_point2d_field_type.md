# Step 2 - Define the Point 2D Field Type

!!! tip

    You can find all files used and modified in this step on [GitHub](https://github.com/ezsystems/generic-field-type-tutorial/tree/Step_2).

## The Type class

The Type contains logic of the Field Type: validating data, transforming from various formats, describing the validators, etc.
In this example Point 2D Field Type will extend the `eZ\Publish\SPI\FieldType\Generic\Type` class.
For more information about the Type class of a Field Type, see [Type class](../../api/field_type_type_and_value.md#type-class).

## Field Type identifier

First, create `src/FieldType/Point2D/Type.php`.
Add a `getFieldTypeIdentifier()` method to it. The new method will return the string that **uniquely** identifies your Field Type, in this case `point2d`:

```php
<?php
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

## Add a new service definition

Next, add the `ezplatform.field_type` tag to `config/services.yaml`:

```yaml
services:
    # ...
    App\FieldType\Point2D\Type:
        tags:
            - { name: ezplatform.field_type, alias: point2d }
```
