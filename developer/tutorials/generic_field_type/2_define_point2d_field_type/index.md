# Step 2 - Define the Point 2D field type

Learn how to create the Type class which contains the logic for the field.

## The Type class

The Type contains logic of the field type: validating data, transforming from various formats, describing the validators, and more. In this example Point 2D field type extends the `Ibexa\Contracts\Core\FieldType\Generic\Type` class.

For more information about the Type class of a field type, see [Type class](../../../content_management/field_types/type_and_value/index.md#type-class).

## Field type identifier

First, create `src/FieldType/Point2D/Type.php`. Add a `getFieldTypeIdentifier()` method to it. The new method returns the string that **uniquely** identifies your field type, in this case `point2d`:

```php
<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use Ibexa\Contracts\Core\FieldType\Generic\Type as GenericType;

final class Type extends GenericType
{
    public function getFieldTypeIdentifier(): string
    {
        return 'point2d';
    }
}
```

## Add a new service definition

Next, add the `ibexa.field_type` tag to `config/services.yaml`:

```yaml
services:
    App\FieldType\Point2D\Type:
        tags:
            - { name: ibexa.field_type, alias: point2d }
```
