# Step 8 -  Data migration between Field Type versions

!!! tip

    You can find all files used and modified in this step on [GitHub]().

Adding data migration enables you to easily change the output of the Field Type to fit your current needs.
This process is important when a Field Type needs to be compared for sorting and searching purposes.
Serialization allows changing objects to array by normalizing them, and then to the selected format by encoding them.
In reverse, deserialization changes different formats into arrays by decoding and then denormalizing them into objects.

For more information on Serializer Components follow [Symfony documentation.](https://symfony.com/doc/4.3/components/serializer.html)

## Normalization 

First you need to add support for normalization in a `src/Serializer/Point2D/ValueNormalizer.php`:

```php
<?php
declare(strict_types=1);
namespace App\Serializer\Point2D;

use App\FieldType\Point2D\Value;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class ValueNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        return [
            $object->getX(),
            $object->getY()
        ];
    }
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Value;
    }
}
```

##  Add Normalizer class

Next, add the `ValueNormalizer` class to the `config/services.yml` with a `serializer.normalizer` tag:
 
```yaml
services:
    ...
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
    public function denormalize($data, $class, $format = null, array $context = [])
    {
        if (isset($data['x']) && isset($data['y'])) {
            // Support for old format
            $data = [ $data['x'], $data['y'] ];
        }
        return new $class($data);
    }
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === Value::class;
    }
}
```

## Add Denormalizer class

Next, add the `serializer.denormalizer` class to `config/services.yml`:
 
```yaml
services:
    ...
    App\Serializer\Point2D\ValueDenormalizer:
        tags:
            - { name: serializer.denormalizer }
```

## Change format in flight

To change the format in flight you need to add to `src/FieldType/Point2D/Value.php`:

```php
<?php
public function __construct(array $coords = [])
{
    if (!empty($coords)) {
        $this->x = $coords[0];
        $this->y = $coords[1];
    }
}
```

Now you can easily change the output of the Point 2D Field Type.
