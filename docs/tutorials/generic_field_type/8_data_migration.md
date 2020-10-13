# Step 8 -  Data migration between Field Type versions

!!! tip

    You can find all files used and modified in this step on [GitHub](https://github.com/ezsystems/generic-field-type-tutorial/tree/Step_8).

Adding data migration enables you to easily change the output of the Field Type to fit your current needs.
This process is important when a Field Type needs to be compared for sorting and searching purposes.
Serialization allows changing objects to array by normalizing them, and then to the selected format by encoding them.
In reverse, deserialization changes different formats into arrays by decoding and then denormalizing them into objects.

For more information on Serializer Components, see [Symfony documentation.](https://symfony.com/doc/5.0/components/serializer.html)

## Normalization 

First, you need to add support for normalization in a `src/Serializer/Point2D/ValueNormalizer.php`:

```php
<?php
declare(strict_types=1);

namespace App\Serializer\Point2D;

use App\FieldType\Point2D\Value;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ValueNormalizer implements NormalizerInterface
{
    public function normalize($object, string $format = null, array $context = [])
    {
        return [
            $object->getX(),
            $object->getY()
        ];
    }
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Value;
    }
}
```

##  Add Normalizer definition

Next, add the `ValueNormalizer` service definition to the `config/services.yaml` with a `serializer.normalizer` tag:
 
```yaml
services:
    # ...
    App\Serializer\Point2D\ValueNormalizer:
        tags:
            - { name: serializer.normalizer }
```

## Backward compatibility

To accept old versions of the Field Type you need to add support for denormalization in a `src/Serializer/Point2D/ValueDenormalizer.php`:

```php
<?php
declare(strict_types=1);

namespace App\Serializer\Point2D;

use App\FieldType\Point2D\Value;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class ValueDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $class, string $format = null, array $context = [])
    {
        if (isset($data['x']) && isset($data['y'])) {
            // Support for old format
            $data = [ $data['x'], $data['y'] ];
        }
        return new $class($data);
    }
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === Value::class;
    }
}
```

## Add Denormalizer definition

Next, add the `ValueDenormalizer` service definition to `config/services.yaml` with a `serializer.denormalizer` tag:
 
```yaml
services:
    # ...
    App\Serializer\Point2D\ValueDenormalizer:
        tags:
            - { name: serializer.denormalizer }
```

## Change format on the fly

To change the format on the fly, you need to replace the constructor in `src/FieldType/Point2D/Value.php`:

```php
public function __construct(array $coords = [])
{
    if (!empty($coords)) {
        $this->x = $coords[0];
        $this->y = $coords[1];
    }
}
```

Now you can easily change the internal representation format of the Point 2D Field Type.
