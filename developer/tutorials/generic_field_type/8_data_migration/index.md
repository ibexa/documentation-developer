# Step 8 - Data migration between field type versions

Learn how to serialize and deserialize field data to enable sorting or search.

Adding data migration enables you to change the output of the field type to fit your current needs. This process is important when a field type needs to be compared for sorting and searching purposes. Serialization allows changing objects to array by normalizing them, and then to the selected format by encoding them. In reverse, deserialization changes different formats into arrays by decoding and then denormalizing them into objects.

For more information on Serializer Component, see [Symfony documentation](https://symfony.com/doc/7.4/serializer.html).

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
    /**
     * @return array<?float, ?float>
     */
    public function normalize($object, ?string $format = null, array $context = []): array
    {
        return [
            $object->getX(),
            $object->getY(),
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Value;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Value::class => true,
        ];
    }
}
```

> **Note: Note**
>
> The `ValueDenormalizer` and `ValueNormalizer` service definitions are automatically registered by Symfony as services in `config/services.yaml`, without the need to manually define them.

## Backward compatibility

To accept old versions of the field type you need to add support for denormalization in a `src/Serializer/Point2D/ValueDenormalizer.php`:

```php
<?php
declare(strict_types=1);

namespace App\Serializer\Point2D;

use App\FieldType\Point2D\Value;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final class ValueDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $class, ?string $format = null, array $context = []): mixed
    {
        if (isset($data['x']) && isset($data['y'])) {
            // Support for old format
            $data = [$data['x'], $data['y']];
        }

        return new $class($data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $type === Value::class;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Value::class => true,
        ];
    }
}
```

## Change format on the fly

To change the format on the fly, you need to replace the constructor and class properties in `src/FieldType/Point2D/Value.php`:

```php
#[Assert\NotBlank]
private ?float $x = null;

#[Assert\NotBlank]
private ?float $y = null;

/** @param list<float|null> $coords */
public function __construct(array $coords = [])
{
    if (!empty($coords)) {
        $this->x = $coords[0];
        $this->y = $coords[1];
    }
}
```

Now you can change the internal representation format of the Point 2D field type.
